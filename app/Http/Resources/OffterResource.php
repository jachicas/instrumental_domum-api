<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OffterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $discount = $this->discount / 100;
        $rest = ($this->product->price) * $discount;
        $result = $this->product->price - $rest;
        return [
            'id' => $this->id,
            'product' => [
                'name' => $this->product->name,
                'product_type' => $this->product->productType->name,
                'price' => $this->product->price
            ],
            'discount' => $this->discount . '%',
            'status' => $this->status,
            'start' => $this->start,
            'finish' => $this->finish,
            'new_price' => $result,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
