<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\AccessHelper;
use App\Http\Requests\TableStoreRequest;
use App\Http\Resources\TableResource;
use App\Models\Table;
use Illuminate\Http\JsonResponse;

class TableController extends Controller
{
    public function index(): JsonResponse
    {
        $tables = Table::with('status')
            ->get();
        return response()->json(TableResource::collection($tables));
    }

    public function store(TableStoreRequest $request): JsonResponse
    {
        if ($response = AccessHelper::denyIfNotAdmin($request, 'Somente administradorores podem atualizar as mesas')) {
            return $response;
        }

        try {
            $table = Table::create($request->validated());
            return response()->json(new TableResource($table), 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao cadastrar mesa',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(TableStoreRequest $request, int $id): JsonResponse
    {
        $denied = AccessHelper::denyIfNotAdmin($request, 'Somente administradores podem atualizar as mesas');
        if ($denied) {
            return $denied;
        }
        try {
            $table = Table::find($id);

            if (!$table) {
                $response = response()->json(['message' => 'Mesa não encontrada'], 404);
            } else {
                $table->update($request->validated());
                $response = response()->json(new TableResource($table), 200);
            }
        } catch (\Exception $e) {
            $response = response()->json([
                'message' => 'Erro ao atualizar mesa',
                'error' => $e->getMessage(),
            ], 500);
        }

        return $response;
    }


    public function destroy(int $id): JsonResponse
    {
        try {
            $table = Table::find($id);

            if (!$table) {
                return response()->json(['message' => 'Mesa não encontrada'], 404);
            }
            $table->delete();
            return response()->json(['message' => 'Mesa deletada com sucesso'], 204);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao deletar mesa',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
