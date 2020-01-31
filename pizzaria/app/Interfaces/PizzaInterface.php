<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface PizzaInterface
{
    public function orders(): BelongsToMany;
}
