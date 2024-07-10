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
        $decodedValue = $this->value;
        if ($this->name === 'envm.window_tamper.activations') {
            $decodedValue = json_decode($this->value, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $decodedValue = $this->value;
            }
        }
        if ($this->name === 'envm.door_tamper.activations') {
            $decodedValue = json_decode($this->value, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $decodedValue = $this->value;
            }
        }
        return [
            'register_id' => $this->register_id,
            'name' => $this->name,
            'value' => $decodedValue,
            'min' => $this->min,
            'max' => $this->max,
            'status' => $this->status
        ];
    }
}
