<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleDetailResource extends JsonResource
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
            'sale' => [
                'id' => $this->sale->id,
                'user' => [
                    'id' => $this->sale->user->id,
                    'name' => $this->sale->user->name,
                    'last_name' => $this->sale->user->last_name,
                    'email' => $this->sale->user->email,
                    'created_at' => $this->sale->user->created_at,
                    'updated_at' => $this->sale->user->updated_at
                ],
                'payment_method' => $this->sale->payment_method,
                'status' => $this->sale->status,
                'created_at' => $this->sale->created_at,
                'updated_at' => $this->sale->updated_at
            ],
            'product' => [
                'id' => $this->product->id,
                'name' => $this->product->name,
                'product_type' => $this->product->productType->name,
                'brand' => $this->product->brand->name,
                'status' => $this->product->status,
                'quantity' => $this->product->quantity,
                'price' => $this->product->price,
                'created_at' => $this->product->created_at,
                'updated_at' => $this->product->updated_at
            ],
            'quantity' => $this->quantity,
            'total' => $this->total,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
