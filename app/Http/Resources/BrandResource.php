<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
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
            'name' => $this->name,
            'products' => $this->products->map(fn ($product) => [
                'id' => $product->id,
                'name' => $product->name,
                'product_type' => $product->productType->name,
                'status' => $product->status,
                'quantity' => $product->quantity,
                'price' => $product->price,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ]),
            'image' => $this->image,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
