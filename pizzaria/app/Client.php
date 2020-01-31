<?php

namespace App;

use App\Interfaces\ClientInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model implements ClientInterface
{
    protected $guarded = ['id'];

    public static $createRules = [
        'name' => 'required|max:255',
        'phone_number' => 'required|unique:clients|max:20',
        'address' => 'required'
    ];

    public static $updateRules = [
        'name' => 'sometimes|required|max:255',
        'phone_number' => 'sometimes|required|unique:clients|max:20',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany('App\Order');
    }
}
