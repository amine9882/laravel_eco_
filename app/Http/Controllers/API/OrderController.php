<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Orderitems;
use Illuminate\Support\Facades\DB;
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
    public function show($id)
    {
        $orderitems = Orderitems::find($id);
        if($orderitems)
        {
            return response()->json([
                'status'=>200,
                'certifi'=>$orderitems,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No orderitem Found',
            ]);
        }
    }
    public function update(Request $request, $id)
    {
        $orderitems = Orderitems::find($id);
        if($orderitems)
        {
            // $order->payment_mode = "cod";
            $orderitems->purchased= "1";
            $orderitems->update();
            return response()->json([
                'status'=>200,
                'message'=>' Confirmation Successfully',
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'Confirmation Fail',
            ]);
        }
    }    

    public function  getOrderItemData($id)
    {
        $data = DB::table('orderitems')
            ->join('orders', 'orderitems.order_id', '=', 'orders.id')
            ->join('products', 'orderitems.product_id', '=', 'products.id')
            ->where('orderitems.id', $id)
            ->select('orderitems.*','orders.*',DB::raw('products.name as Product_name'))
            ->get();
            return response()->json([
                'status'=>200,
                'orders' => $data
            ]);


    }
}