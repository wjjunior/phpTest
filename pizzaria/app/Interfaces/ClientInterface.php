<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Relations\HasMany;

interface ClientInterface
{
    public function orders(): HasMany;
}
