<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Client;
use App\Http\Resources\Client as ClientResource;
use App\Http\Resources\ClientCollection;
use App\Http\Resources\OrderCollection;
use App\Interfaces\ClientControllerInterface;
use App\Interfaces\ControllerInterface;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller implements ControllerInterface, ClientControllerInterface
{
    /**
     * Display a listing of clients.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(new ClientCollection(Client::paginate()), Response::HTTP_OK);
    }

    /**
     * Store a newly created client in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request, Client::$createRules);
        return response()->json(new ClientResource(Client::create($request->all())), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return response()->json(new ClientResource(Client::findOrfail($id)), Response::HTTP_CREATED);
    }

    /**
     * Update the specified client in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $this->validate($request, Client::$updateRules);
        $client = Client::findOrFail($id);
        $client->update($request->all());
        return response()->json(new ClientResource($client), Response::HTTP_OK);
    }

    /**
     * Remove the specified client from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Display a list of client's orders
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showClientOrders(int $id): JsonResponse
    {
        $client = Client::findOrFail($id);
        return response()->json(new OrderCollection($client->orders), Response::HTTP_OK);
    }
}
