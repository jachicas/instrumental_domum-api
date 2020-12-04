<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $total_sale = $this->saleDetails->map(function ($sD) {
            return $sD->total;
        })->sum();
        $money_back = $request->money_to_pay - $total_sale;
        return [
            'id' => $this->id,
            'money_back' => $money_back,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'last_name' => $this->user->last_name,
                'created_at' => $this->user->created_at,
                'updated_at' => $this->user->updated_at
            ],
            'sale' => $this->saleDetails->map(function ($saleDetail) {
                return $saleDetail;
            }),
            'payment_method' => $this->payment_method,
            'total' => $this->total,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
