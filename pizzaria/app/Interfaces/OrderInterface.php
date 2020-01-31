<?php

namespace App\Interfaces;

use App\Order;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface OrderInterface
{
    public function getTotalAttribute(): float;
    public function getArrivalTimeAttribute(): string;
    public function client(): BelongsTo;
    public function pizzas(): BelongsToMany;
    public function addPizza(array $pedido): Order;
}
