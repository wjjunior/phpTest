<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Pizza extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'price_small' => (float) $this->price_small,
            'price_medium' => (float) $this->price_medium,
            'price_large' => (float) $this->price_large,
            'created_at' => (string) $this->created_at
        ];
    }
}
