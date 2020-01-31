<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Order;

class Pizza extends Model
{
    protected $guarded = ['id'];

    public static $createRules = [
        'name' => 'required|max:255',
        'description' => 'required|string',
        'price_small' => 'between:0,99.99',
        'price_medium' => 'between:0,99.99',
        'price_large' => 'between:0,99.99',
    ];

    public static $updateRules = [
        'name' => 'sometimes|required|max:255',
        'description' => 'sometimes|required|string',
        'price_small' => 'between:0,99.99',
        'price_medium' => 'between:0,99.99',
        'price_large' => 'between:0,99.99',
    ];
    
    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
