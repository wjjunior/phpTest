<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\OrderPizzaCollection;

class Order extends JsonResource
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
            'client' => $this->client->name,
            'status' => (int) $this->status,
            'arrival' => $this->arrival_time,
            'total' => (float) $this->total,
            'pizzas' => new OrderPizzaCollection($this->pizzas),
            'note' => $this->note
        ];
    }
}
