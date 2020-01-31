<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Pizza;
use App\Http\Resources\Pizza as PizzaResource;
use App\Http\Resources\PizzaCollection;
use App\Interfaces\ControllerInterface;
use Illuminate\Http\JsonResponse;

class PizzaController extends Controller implements ControllerInterface
{
    /**
     * Display a listing of pizzas.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(new PizzaCollection(Pizza::paginate()), Response::HTTP_OK);
    }

    /**
     * Store a newly created pizza in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, Pizza::$createRules);
        return response()->json(new PizzaResource(Pizza::create($request->all())), Response::HTTP_CREATED);
    }

    /**
     * Display the specified pizza.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return response()->json(new PizzaResource(Pizza::findOrfail($id)), Response::HTTP_CREATED);
    }

    /**
     * Update the specified pizza in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $this->validate($request, Pizza::$updateRules);
        $pizza = Pizza::findOrFail($id);
        $pizza->update($request->all());
        return response()->json(new PizzaResource($pizza), Response::HTTP_OK);
    }

    /**
     * Remove the specified pizza from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $pizza = Pizza::findOrFail($id);
        $pizza->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
