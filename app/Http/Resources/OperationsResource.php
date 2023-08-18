<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OperationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        foreach ($this->sales as $sale) {
            $sale->item->title;
        }
        return [
            'id' =>  $this->id,
            'customer_name' =>  $this->customer_name,
            'customer_phone' =>  $this->customer_phone,
            'price' =>  $this->price,
            'sale_price' =>  $this->sale_price,
            'discount' =>  $this->discount,
            'profits' => $this->sale_price - ($this->price + $this->discount),
            'created_at' =>  $this->created_at->format('Y-m-d'),
            'sales' => $this->sales,
        ];
    }
}
