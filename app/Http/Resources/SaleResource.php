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
        return [
            'id' => $this->id,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'last_name' => $this->user->last_name,
                'created_at' => $this->user->created_at,
                'updated_at' => $this->user->updated_at
            ],
            'employee' => [
                'id' => $this->employee->id,
                'name' => $this->employee->name,
                'last_name' => $this->employee->last_name,
                'rol' => $this->employee->getRoleNames()[0],
                'created_at' => $this->employee->created_at,
                'updated_at' => $this->employee->updated_at,
            ],
            'payment_method' => $this->payment_method,
            'status' => $this->status,
            'created_at' => $this->employee->created_at,
            'updated_at' => $this->employee->updated_at
        ];
    }
}
