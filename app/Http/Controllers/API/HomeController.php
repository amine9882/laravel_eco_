<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;



class HomeController extends Controller
{
    public function viewprod()
    {
        $product = Product::all()->take(12);
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
    public function store()
    {
        $cate = DB::table('products')
        ->leftJoin('ratings', 'products.id', '=', 'ratings.product_id')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->select('products.id','products.category_id',DB::raw('categories.slug as category_slug'),'products.slug', 'products.name', 'products.description','products.brand','products.selling_price','products.original_price','products.qty', 'products.image', DB::raw('AVG(ratings.rating) as average_rating'))
        ->take(12)
        ->groupBy('products.id')
        ->get();
        return response()->json([
            'status'=>200,
            'cate' => $cate
        ]);
    }
   
    public function cate_one()
    {
        $cate_one = DB::table('products')
        ->leftJoin('ratings', 'products.id', '=', 'ratings.product_id')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->select('products.id','products.category_id',DB::raw('categories.slug as category_slug'),'products.slug', 'products.name', 'products.description','products.brand','products.selling_price','products.original_price','products.qty', 'products.image', DB::raw('AVG(ratings.rating) as average_rating'))
        ->where('products.category_id','=','1')
        ->groupBy('products.id')
        ->get();
        return response()->json([
            'status'=>200,
            'cate_one' => $cate_one
        ]);
    }
    public function cate_two()
    {
        $cate_two = DB::table('products')
        ->leftJoin('ratings', 'products.id', '=', 'ratings.product_id')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->select('products.id','products.category_id',DB::raw('categories.slug as category_slug'),'products.slug', 'products.name', 'products.description','products.brand','products.selling_price','products.original_price','products.qty', 'products.image', DB::raw('AVG(ratings.rating) as average_rating'))
        ->where('products.category_id','=','2')
        ->groupBy('products.id')
        ->get();
        return response()->json([
            'status'=>200,
            'cate_two' => $cate_two
        ]);
    }
    public function cate_three()
    {
        $cate_three = DB::table('products')
        ->leftJoin('ratings', 'products.id', '=', 'ratings.product_id')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->select('products.id','products.category_id',DB::raw('categories.slug as category_slug'),'products.slug', 'products.name', 'products.description','products.brand','products.selling_price','products.original_price','products.qty', 'products.image', DB::raw('AVG(ratings.rating) as average_rating'))
        ->where('products.category_id','=','3')
        ->groupBy('products.id')
        ->get();
        return response()->json([
            'status'=>200,
            'cate_three' => $cate_three
        ]);
    }
    public function cate_four()
    {
        $cate_four = DB::table('products')
        ->leftJoin('ratings', 'products.id', '=', 'ratings.product_id')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->select('products.id','products.category_id',DB::raw('categories.slug as category_slug'),'products.slug', 'products.name', 'products.description','products.brand','products.selling_price','products.original_price','products.qty', 'products.image', DB::raw('AVG(ratings.rating) as average_rating'))
        ->where('products.category_id','=','4')
        ->groupBy('products.id')
        ->get();
        return response()->json([
            'status'=>200,
            'cate_four' => $cate_four
        ]);
    }
}

