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
        foreach($this->sales as $sale){
            $sale->item->title;
        }
        return [
            'id' =>  $this->id,
            'customer_name' =>  $this->customer_name,
            'customer_phone' =>  $this->customer_phone,
            'discount' =>  $this->discount,
            'sales' => $this->sales,
        ];
    }
}
