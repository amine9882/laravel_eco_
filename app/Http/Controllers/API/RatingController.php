<?php

namespace App\Http\Controllers\API;
use App\Models\Product;
use App\Models\Rating;
use App\Models\User;
use App\Models\Orderitems;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{
    public function store(Request $request, Product $product,$product_id)
    {
        
        $validatedData = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'string|max:191',

        ]);

            if(auth('sanctum')->check())
            {
                    $user_id = auth('sanctum')->user()->id;
                    $product_id = $request->product_id;
               
                    // $purchased = Orderitems::where('user_id', $user_id)
                    // ->where('product_id', $product_id)
                    // ->where('purchased', '1')
                    // ->exists();
                    // $orders = DB::table('orders')
                    // ->join('orderitems', 'orders.id', '=', 'orderitems.order_id')
                    // ->select('orders.*', 'orderitems.product_id')
                    // ->where('orders.user_id', '=', $user_id)
                    // ->get();

                    $exists = DB::table('Orderitems')
                    ->where('user_id', $user_id)
                    ->where('product_id', $product_id)
                    ->where('purchased', '1')
                    ->exists();
                    if (!$exists) {
                        return response()->json([
                            'status'=>403,
                            'message' => 'You must purchase this product before rating it.'
                        ]);
                    }
                    else
                    {
                    $rating = new Rating();

                    $rating->rating = $validatedData['rating'];
                    $rating->comment = $validatedData['comment'];
                    $rating->user_id = $user_id;
                    $rating->product_id = $product_id;
                    $rating->save();
                    

                return response()->json([
                    'status'=>200,
                    'message' => 'Rating saved successfully'

                ]);
                }

        }
        else
        {
                return response()->json([
                    'status'=>404,
                    'message'=>'Rating Not Found',
                ]);
        }

       

       
    }
   
}

