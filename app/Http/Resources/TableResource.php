<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'capacity' => $this->capacity,
                'status' => $this->status ? [
                    'slug' => $this->status->slug,
                    'label' => $this->status->label,
                ] : null,];
        }
    }
}
