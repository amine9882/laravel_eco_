<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Orderitems;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return response()->json([
            'status' => 200,
            'orders' => $orders,
        ]);
    }
    public function store()
    {
        $orderitems = Orderitems::all();
        return response()->json([
            'status' => 200,
            'orderitems' =>$orderitems
        ]);
    }
}