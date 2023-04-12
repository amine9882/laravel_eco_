<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function viewprod()
    {
        $product = Product::all();
        if($product)
        {
            return response()->json([
                'status'=>200,
                'product'=>$product,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Product Found',
            ]);
        }
    }
}
