<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TableResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = [
            'name' => $this->name,
            'capacity' => $this->capacity,
        ];

        if (!$request->isMethod('post') && $this->status) {
            $data['status'] = [
                'slug' => $this->status->slug,
                'label' => $this->status->label,
            ];
        }

        return $data;
    }

}
