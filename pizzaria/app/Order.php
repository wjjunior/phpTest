<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pizza;

class Order extends Model
{
    protected $guarded = ['id'];
    
    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function pizzas()
    {
        return $this->belongsToMany(Pizza::class);
    }
}
