<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderPizza extends JsonResource
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
            'pizza' => $this->name,
            'size' => $this->pivot->size,
            'qty' => (int) $this->pivot->qty,
            'price' => (float) $this->{$this->pivot->size}
        ];
    }
}
