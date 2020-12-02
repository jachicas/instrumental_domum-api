<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CarShopItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product' => [
                'id' => $this->product->id,
                'name' => $this->product->name,
                'product_type' => $this->product->productType->name,
                'brand' => $this->product->brand->name,
                'price' => $this->product->price,
            ],
            'quantity' => $this->quantity,
            'total' => $this->total,
            'with_discount' => $this->with_discount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
