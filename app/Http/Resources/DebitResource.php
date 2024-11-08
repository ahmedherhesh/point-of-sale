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
            'name' => 'required|string|min:2|max:254',
            'phone' => 'required|string|min:2|max:254',
            'amount' => 'required|numeric',
            'notes' => 'nullable|min:2|max:254',
            'status' => 'required|in:unpaid,paid',
            'type' => 'required|in:debit,credit',
        ];
    }
}
