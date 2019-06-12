<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::all();

        return $orders;
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        return Order::create($request->all());
    }


    public function show(Order $order)
    {
        return $order;
    }


    public function edit(Order $order)
    {
        //
    }


    public function update(Request $request, Order $order)
    {
        $result = Order::findOrFail($order);
        $result->update($request->all());

        return $result;
    }


    public function destroy(Order $order)
    {
        Order::find($order)->delete();

        return response()->json("ok", 200);
    }
}
