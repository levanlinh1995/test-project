<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'sku' => $this->sku,
            'product_name' => $this->product_name,
            'price' => $this->price,
            'qty' => $this->qty,
            'unit' => $this->unit,
            'status' => $this->status,
        ];
    }
}
