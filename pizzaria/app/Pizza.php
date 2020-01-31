<?php

namespace App;

use App\Interfaces\PizzaInterface;
use Illuminate\Database\Eloquent\Model;
use App\Order;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pizza extends Model implements PizzaInterface
{
    protected $guarded = ['id'];

    public static $createRules = [
        'name' => 'required|max:255',
        'description' => 'required|string',
        'small' => 'between:0,99.99',
        'medium' => 'between:0,99.99',
        'large' => 'between:0,99.99',
    ];

    public static $updateRules = [
        'name' => 'sometimes|required|max:255',
        'description' => 'sometimes|required|string',
        'small' => 'between:0,99.99',
        'medium' => 'between:0,99.99',
        'large' => 'between:0,99.99',
    ];
    
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }
}
