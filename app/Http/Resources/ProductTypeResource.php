<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $url = url("assets/{$this->image}");

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
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at
            ]),
            'image' => $url,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
