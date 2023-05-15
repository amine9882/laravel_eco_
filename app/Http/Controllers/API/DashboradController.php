<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Orderitems;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboradController extends Controller
{
    public function NumberOfUsers()
    {
        $count = DB::table('users')->count();
        return response()->json([
            'status'=>200,
            'nb_users' => $count
        ]);
    }
    public function NumberOfProduct()
    {
        $Product = DB::table('Products')->count();
        return response()->json([
            'status'=>200,
            'nb_Product' => $Product
        ]);
    }
    public function NumberOfOrders()
    {
        $orders = DB::table('orderitems')
        ->where('purchased','=','1')
        ->count();
        return response()->json([
            'status'=>200,
            'nb_orders' => $orders
        ]);
    }

    public function NumberOfNonOrders()
    {
        $orders = DB::table('orderitems')
        ->where('purchased','=','0')
        ->count();
        return response()->json([
            'status'=>200,
            'non_confirme' => $orders
        ]);
    }
    public function getOrderItemsPerLast7Days(Request $request)
    {
        // Calculate the date range for the last 7 days
        $startDate = Carbon::now()->subDays(6)->startOfDay();
        $endDate = Carbon::now()->endOfDay();
        
        // Fetch the number of order items per day
        $orderItems = Orderitems::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
           
        // Prepare the data for the chart
        $data = [];
        foreach ($orderItems as $orderItem) {
            $data[] = [
                
                'date' => $orderItem->date,
                'count' => $orderItem->count,
            ];
        }
        
        return response()->json($data);
    }
    
}
