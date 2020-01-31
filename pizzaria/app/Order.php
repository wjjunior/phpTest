<?php

namespace App;

use App\Interfaces\OrderInterface;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Pizza;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model implements OrderInterface
{
    protected $guarded = ['id'];

    protected $appends = ['total', 'arrival_time'];

    public static $createRules = [
        'client_id' => 'required|exists:clients,id',
        'delivery_time' => 'required|numeric|min:1',
        'delivery_price' => 'between:0,99.99',
        'status' => 'in:0,1,2,3',
        'pedido' => 'required|array',
        'pedido.*.pizza_id' => 'required|exists:pizzas,id',
        'pedido.*.size' => 'required|in:small,medium,large',
        'pedido.*.qty' => 'required|numeric|between:0,99|integer',
        'note' => 'string'
    ];

    public static $updateRules = [
        'delivery_time' => 'sometimes|required|numeric|min:1',
        'delivery_price' => 'between:0,99.99',
        'status' => 'in:0,1,2,3',
        'note' => 'string'
    ];

    public function getTotalAttribute(): float
    {
        $total = $this->pizzas->reduce(function ($total, $item) {
            return $total + ($item->{$item->pivot->size} * $item->pivot->qty);
        }, 0);
        return round($total + $this->delivery_price, 2);
    }

    public function getArrivalTimeAttribute(): string
    {
        return Carbon::now()->addMinutes($this->delivery_time)->format('H:i');
    }

    public function addPizza(array $pedido): Order
    {
        foreach ($pedido as $pedido) {
            $pizza = Pizza::findOrFail($pedido['pizza_id']);
            $orderPizza = $this->pizzas()->where([['pizza_id', $pizza->id], ['size', $pedido['size']]])->first();

            if ($orderPizza) {
                $orderPizza->pivot->qty += $pedido['qty'];
                $orderPizza->pivot->save();
                return $this;
            }

            $this->pizzas()->save($pizza, ['size' => $pedido['size'], 'qty' => $pedido['qty']]);
        }
        return $this;
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo('App\Client');
    }

    public function pizzas(): BelongsToMany
    {
        return $this->belongsToMany(Pizza::class)->withPivot('size', 'qty');;
    }
}
