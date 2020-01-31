<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
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

    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
