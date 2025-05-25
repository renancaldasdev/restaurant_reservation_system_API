<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Http\Requests\ReservationStoreRequest;
use App\Http\Requests\ReservationUpdateRequest;
use App\Models\Reservation;
use App\Models\ReservationStatus;
use App\Models\Table;
use App\Models\TableStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function index(): JsonResponse
    {
        $reservations = Reservation::with('status')->where('user_id', auth()->id())->get();
        return response()->json($reservations);
    }

    public function store(ReservationStoreRequest $request): JsonResponse
    {
        try {
            $table = Table::find($request->input('table_id'));

            if ($table->status->slug != TableStatus::findBySlugOrFail(TableStatus::SLUG_AVAILABLE)->slug) {
                return response()->json(['message' => 'Mesa já reservada!'], 409);
            }

            DB::beginTransaction();

            $reservation = new Reservation(
                [
                    'user_id' => auth()->id(),
                    'table_id' => $request->input('table_id'),
                    'number_of_guests' => $request->input('number_of_guests'),
                    'reservation_date' => $request->input('reservation_date'),
                ]
            );

            $statusReservation = ReservationStatus::findBySlugOrFail(ReservationStatus::SLUG_PENDING);
            $reservation->reservation_status_id = $statusReservation->id;
            $reservation->save();

            $statusTable = TableStatus::findBySlugOrFail(TableStatus::SLUG_PENDING);
            $table->status_id = $statusTable->id;
            $table->save();

            DB::commit();

            return response()->json(['message' => 'Mesa reservada para o dia e hora às ' . DateHelper::formatToBrazilian($reservation['reservation_date'])], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function cancelReservation(int $id): JsonResponse
    {
        try {
            $reservation = Reservation::find($id);

            if (!$reservation || $reservation->reservation_status_id === ReservationStatus::findBySlugOrFail(ReservationStatus::SLUG_CANCELLED)->id) {
                return response()->json(['message' => 'Não foi possível realizar o cancelamento'], 404);
            }

            DB::beginTransaction();

            $reservation->reservation_status_id = ReservationStatus::findBySlugOrFail(ReservationStatus::SLUG_CANCELLED)->id;
            $reservation->save();

            $table = Table::find($reservation->table_id);
            $table->status_id = TableStatus::findBySlugOrFail(TableStatus::SLUG_AVAILABLE)->id;
            $table->save();

            DB::commit();
            return response()->json(['message' => 'Reserva cancelada'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }

    }
}
