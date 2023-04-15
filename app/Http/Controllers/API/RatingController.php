<?php

namespace App\Http\Controllers\API;
use App\Models\Product;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request, Product $product,$product_id)
    {
        // dd($product_id,$product);
        
        $validatedData = $request->validate([
            'rating' => 'required|integer|between:1,5',
        ]);

            if(auth('sanctum')->check())
            {
            $user_id = auth('sanctum')->user()->id;
            $product_id = $request->product_id;
           
            $rating = new Rating();
            $rating->rating = $validatedData['rating'];
            $rating->user_id = $user_id;
            $rating->product_id = $product_id;
            $rating->save();
             

        return response()->json([
            'status'=>200,
            'message' => 'Rating saved successfully'

        ]);
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
