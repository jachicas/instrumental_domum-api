<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CarShopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $total_sale = $this->saleDetails->sum->total;
        return [
            'total_sale' => $total_sale,
            'items' => $this->saleDetails->map(fn ($sD) => [
                'id' => $sD->id,
                'product' => [
                    'id' => $sD->product->id,
                    'name' => $sD->product->name,
                    'product_type' => $sD->product->productType->name,
                    'brand' => $sD->product->brand->name,
                    'price' => $sD->product->price
                ],
                'quantity' => $sD->quantity,
                'total' => $sD->total,
                'with_discount' => $sD->with_discount
            ])
        ];
    }
}
