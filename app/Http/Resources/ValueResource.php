<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ValueResource extends JsonResource
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
            'register_id' => $this->register_id,
            'name' => $this->name,
            'value' => $this->value,
            'min' => $this->min,
            'max' => $this->max,
            'status' => $this->status
        ];
    }
}
