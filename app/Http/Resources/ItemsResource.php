<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Milon\Barcode\DNS1D;

class ItemsResource extends JsonResource
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
            'title' => $this->title,
            'stock' => $this->stock,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
            'code' => $this->code,
            'barcode' => DNS1D::getBarcodeHTML($this->code, 'CODABAR', 1.5, 40) . $this->code,
            'image' => $this->image,
        ];
    }
}
