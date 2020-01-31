<?php

namespace App\Interfaces;

use Illuminate\Http\JsonResponse;

interface OrderControllerInterface
{
    public function addPizzaToOrder(Request $request, int $id): JsonResponse;
    public function removePizzaFromOrder(Request $request, int $id): JsonResponse;
}
