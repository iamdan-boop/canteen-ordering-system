<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateOrderRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with(['products'])->whereBelongsTo(auth()->user())->get();
        return response($orders, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrderRequest $request)
    {
        $products = $request->products;
        for ($product = 0; $product < count($products); $product++) {
            $findProduct = Product::where('id', $products[$product]['id'])->first();
            if ($findProduct->quantity < $products[$product]['quantity']) {
                return response([
                    'message' => 'Out of Stocks',
                    'product' => $findProduct->name
                ], 200);
            }

            $order = Order::create([
                'user_id' => auth()->user()->id,
                'product_id' => $findProduct->id,
                'quantity' => $products[$product]['quantity'],
                'status' => 0,
                'tracking_number' => Str::orderedUuid()
            ]);
            $order->user()->associate(auth()->user()->id);
            $order->products()->attach($findProduct->id);
        }
        return response(['message' => 'Order Sucess'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
