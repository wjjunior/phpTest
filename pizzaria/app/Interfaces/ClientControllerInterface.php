<?php

namespace App\Interfaces;

use Illuminate\Http\JsonResponse;

interface ClientControllerInterface
{
    public function showClientOrders(int $id): JsonResponse;
}
