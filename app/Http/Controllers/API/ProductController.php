<?php

namespace App\Http\Controllers\API;
use App\Models\Cart;

use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{

    public function index()
    {
        $products = Product::all();
        return response()->json([
            'status'=>200,
            'products'=>$products
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id'=>'required|max:191',
            'slug'=>'required|max:191',
            'name'=>'required|max:191',
            'brand'=>'required|max:20',
            'selling_price'=>'required|max:20',
            'original_price'=>'required|max:20',
            'qty'=>'required|max:4',
            'image'=>'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
            ]);
        }
        else
        {
            $product = new Product;
            $product->category_id = $request->input('category_id');
            $product->slug = $request->input('slug');
            $product->name = $request->input('name');
            $product->description = $request->input('description');

	    

            $product->brand = $request->input('brand');
            $product->selling_price = $request->input('selling_price');
            $product->original_price = $request->input('original_price');
            $product->qty = $request->input('qty');

            if($request->hasFile('image'))
            {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() .'.'.$extension;
                $file->move('uploads/product/', $filename);
                $product->image = 'uploads/product/'.$filename;
            }

            $product->featured = $request->input('featured') == true ? '1':'0';
            $product->popular = $request->input('popular') == true ? '1':'0';
            $product->status = $request->input('status') == true ? '1':'0';
            $product->save();

            return response()->json([
                'status'=>200,
                'message'=>'Product Added Successfully',
            ]);
        }
    }

    public function edit($id)
    {
        $product = Product::find($id);
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

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_id'=>'required|max:191',
            'slug'=>'required|max:191',
            'name'=>'required|max:191',
	        
            'brand'=>'required|max:20',
            'selling_price'=>'required|max:20',
            'original_price'=>'required|max:20',
            'qty'=>'required|max:4',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages(),
            ]);
        }
        else
        {
            $product = Product::find($id);
            if($product)
            {
                $product->category_id = $request->input('category_id');
                $product->slug = $request->input('slug');
                $product->name = $request->input('name');
                $product->description = $request->input('description');
                $product->brand = $request->input('brand');
                $product->selling_price = $request->input('selling_price');
                $product->original_price = $request->input('original_price');
                $product->qty = $request->input('qty');

                if($request->hasFile('image'))
                {
                    $path = $product->image;
                    if(File::exists($path))
                    {
                        File::delete($path);
                    }
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() .'.'.$extension;
                    $file->move('uploads/product/', $filename);
                    $product->image = 'uploads/product/'.$filename;
                }

                $product->featured = $request->input('featured');
                $product->popular = $request->input('popular');
                $product->status = $request->input('status');
                $product->update();

                return response()->json([
                    'status'=>200,
                    'message'=>'Product Updated Successfully',
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>404,
                    'message'=>'Product Not Found',
                ]);
            }
        }
    }

    // public function getAverageRating($product_id)
    // {
       
        
    //     $product_rating_average = Rating::where('product_id',$product_id)->avg('rating');
        
    //     if( $product_rating_average!==null){
    //         return response()->json([
    //             'status'=>200,
    //             'average_rating' => $product_rating_average
    //         ]);
    //     }
    //     else if($product_rating_average === null)
    //     {
    //         return response()->json([
    //             'status'=>403,
    //             'average_rating' => 0,
    //         ]);
    //     }

       
    // }
    
    public function rating()
    {
        $rating = Rating::where('rating', '>=', 4)->take(8)->get();;
        
        return response()->json([
            'status' => 200,
            'Rating' =>$rating
        ]);
    }
    // public function trending()
    // {
    //     $products = Product::all();
    //     foreach ($products as $product) {
    //         $rating_sum = $product->ratings()->sum('rating');
    //         $order_items_count = $product->order_items()->sum('quantity');
    //         $product->trending_score = ($rating_sum * $order_items_count) / 10;
    //     }
    //     $trending_products = $products->sortByDesc('trending_score')->take(10);
    //     return $trending_products;
    // }

    public function getRecommendedProducts()
    {
        // $popularProducts = DB::table('orderitems')
        // ->join('ratings', 'orderitems.product_id', '=', 'ratings.product_id')
        // ->select('orderitems.product_id', DB::raw('AVG(ratings.rating) as average_rating'), DB::raw('COUNT(*) as count'))
        // ->groupBy('orderitems.product_id')
        // ->orderByDesc('count')
        // ->orderByDesc('average_rating')
        // ->take(10)
        // ->get();

        // return response()->json([
        //     'popular_products' => $popularProducts
        // ]);

        $popularProducts = DB::table('orderitems')
        ->join('ratings', 'orderitems.product_id', '=', 'ratings.product_id')
        ->join('products', 'orderitems.product_id', '=', 'products.id')
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->select('products.id','products.category_id',DB::raw('categories.slug as category_slug'),'products.slug', 'products.name', 'products.description','products.brand','products.selling_price','products.original_price','products.qty', 'products.image', DB::raw('AVG(ratings.rating) as average_rating'), DB::raw('COUNT(orderitems.product_id) as count'))
        ->groupBy('products.id')
        ->orderByDesc('count')
        ->orderByDesc('average_rating')
        ->take(10)
        ->get();
        return response()->json([
            'status'=>200,
            'popular_products' => $popularProducts
        ]);
       
    }
    public function search(Request $request)
{
    $query = $request->input('query');

    $products = Product::where('name', 'LIKE', '%'.$query.'%')
        ->leftJoin('ratings', 'products.id', '=', 'ratings.product_id')
        ->select('products.*', DB::raw('AVG(ratings.rating) as rating_avg'))
        ->groupBy('products.id')
        ->get();
    if($products)
    {
        return response()->json([
            'status'=>200,
            'data' => $products
        ]);
    }
    elseif($products === null)
    {
        return response()->json([
            'status'=>404,
            'message'=>'No Product Found',
        ]);

    }
   
}

}