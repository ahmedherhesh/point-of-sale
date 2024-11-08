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
            'name' => $this->name,
            'phone' => $this->phone,
            'amount' => $this->amount,
            'notes' => $this->notes,
            'status' => $this->status,
            'type' => $this->type == 'debit' ? 'دين' : 'مدين',
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
