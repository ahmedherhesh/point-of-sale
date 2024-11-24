<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DebitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'notes' => $this->notes,
            'type' => $this->type,
            'paid_amount' => $this->paid_amount,
            'left_amount' => $this->left_amount,
            'created_at' => $this->created_at->format('Y-m-d'),
            'client' => ClientResource::make($this->client),
        ];
    }
}
