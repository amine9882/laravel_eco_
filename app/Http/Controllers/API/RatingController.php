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
            'comment' => 'string|max:191',

        ]);

            if(auth('sanctum')->check())
            {
            $user_id = auth('sanctum')->user()->id;
            $product_id = $request->product_id;
           
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
        else
        {
                return response()->json([
                    'status'=>404,
                    'message'=>'Rating Not Found',
                ]);
        }
    }
    // public function getProductRating($id)
    // {   
    //         $product = Product::where('id',$id)->first();
    //         if($product)
    //         {
    //             $rating = Rating::where('product_id',$product->id)->get();
    //             if($rating)
    //             {
    //                 $rating = [
    //                     'average_rating' => $rating->avg('rating'),
    //                     'total_reviews' => $rating->count(),
    //                 ];
                
    //                 return response()->json([
    //                     'status'=>200,
    //                     'rating_data'=>[
    //                         'rating'=>$rating,
    //                     ]
    //                 ]);
    //             }
    //             else
    //         {
    //             return response()->json([
    //                 'status'=>400,
    //                 'message'=>'No Product rating'
    //             ]);
    //         }
    //         }
    //         else
    //         {
    //             return response()->json([
    //                 'status'=>404,
    //                 'message'=>'No Such product Found'
    //             ]);
    //         }
    // }

    // public function index()
    // {
    //     $ratingProducts = Rating::with('product')->get();
    //     $ratingProducts =[
    //         'average_rating' => $rating->avg('rating'),
    //         'total_reviews' => $rating->count(),
    //     ];
    //     return response()->json($ratingProducts);
    // }
    public function fatch(Request $request, $id) {
        $product = Product::findOrFail($id);
        $rating = $product->ratings()->avg('value');
        return response()->json(['rating' => $rating]);
        // $ratings = $product->ratings;
        // return response()->json($ratings);
    }    
}

