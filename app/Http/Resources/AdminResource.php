<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $role = $this->getRoleNames();
        return [
            'role' => $role[0],
            'id' => $this->id,
            'name' => $this->name,
            'last_name' => $this->last_name,
            'dui' => $this->dui,
            'nit' => $this->nit,
            'email' => $this->email,
            'phone' => $this->phone,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
