<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Order;

use App\Http\Resources\Order as OrderResource;
use App\Http\Resources\OrderCollection;
use App\Interfaces\ControllerInterface;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller implements ControllerInterface
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(new OrderCollection(Order::paginate()), Response::HTTP_OK);
    }

    /**
     * Store a newly created order in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, Order::$createRules);
        $order = Order::create($request->except(['pedido']));
        $order->addPizza($request->pedido);

        return response()->json(new OrderResource($order), Response::HTTP_CREATED);
    }

    /**
     * Display the specified order.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return response()->json(new OrderResource(Order::findOrfail($id)), Response::HTTP_CREATED);
    }

    /**
     * Update the specified order in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $this->validate($request, Order::$updateRules);
        $order = Order::findOrFail($id);
        $order->update($request->all());
        return response()->json(new OrderResource($order), Response::HTTP_OK);
    }

    /**
     * Remove the specified order from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Add one or more pizzas to order
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function addPizzaToOrder(Request $request, int $id): JsonResponse
    {
        $this->validate($request, [
            'pedido' => 'required|array',
            'pedido.*.pizza_id' => 'required|exists:pizzas,id',
            'pedido.*.size' => 'required|in:small,medium,large',
            'pedido.*.qty' => 'required|numeric|between:0,99|integer',
        ]);
        $order = Order::findOrFail($id);
        $order->addPizza($request->pedido);
        return response()->json(new OrderResource($order), Response::HTTP_OK);
    }

    /**
     * Remove pizza from order
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function removePizzaFromOrder(Request $request, int $id): JsonResponse
    {
        $this->validate($request, [
            'pizza_id' => 'required|exists:pizzas,id',
            'size' => 'required|in:small,medium,large',
            'qty' => 'required|numeric|between:0,99|integer'
        ]);
        $order = Order::findOrFail($id);
        $orderPizza = $order->pizzas()->where([['pizza_id', $request->pizza_id], ['size', $request->size]])->firstOrFail();
        $orderPizza->pivot->qty -= $request->qty;
        if ($orderPizza->pivot->qty < 0) {
            $orderPizza->delete();
        } else {
            $orderPizza->pivot->save();
        }
        return response()->json(new OrderResource($order), Response::HTTP_OK);
    }
}
