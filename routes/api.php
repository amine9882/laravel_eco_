<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Authcontroller;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\FrontendController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CheckoutController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\RatingController;
use App\Http\Controllers\API\UserController;



Route::post('register',[Authcontroller::class,'register'] );
Route::post('login',[Authcontroller::class,'login'] );

Route::get('/products/search', [ProductController::class, 'search']);
Route::get('getCategory', [FrontendController::class, 'category']);
Route::get('fetchproducts/{slug}',[FrontendController::class,'product']);
Route::get('viewproductdetail/{category_slug}/{product_slug}', [FrontendController::class, 'viewproduct']);

Route::post('/products/{product_id}/ratings', [RatingController::class, 'store']);
Route::get('/products/{id}/ratings',[RatingController::class, 'fatch']);
// Route::get('/products/{id}/rating',  [RatingController::class, 'getProductRating']);
// Route::get('/rating-products',[RatingController::class, 'index']);

// Route::get('/products/{product_id}/avg-rating', [ProductController::class, 'getAverageRating']);







Route::post('add-to-cart', [CartController::class, 'addtocart']);
Route::get('cart', [CartController::class, 'viewcart']);
Route::put('cart-updatequantity/{cart_id}/{scope}', [CartController::class, 'updatequantity']);
Route::delete('delete-cartitem/{cart_id}', [CartController::class, 'deleteCartitem']);

Route::post('place-order', [CheckoutController::class, 'placeorder']);
Route::post('validate-order', [CheckoutController::class, 'validateOrder']);



// home
Route::get('homefetchproducts', [HomeController::class, 'viewprod']);
Route::get('cateone', [HomeController::class, 'cate_one']);
Route::get('catetwo', [HomeController::class, 'cate_two']);
Route::get('catethree', [HomeController::class, 'cate_three']);
Route::get('catefour', [HomeController::class, 'cate_four']);
Route::get('store', [HomeController::class, 'store']);




Route::get('rating', [ProductController::class, 'rating']);

Route::get('getRecommendedProducts', [ProductController::class, 'getRecommendedProducts']);


Route::middleware(['auth:sanctum','isAPIAdmin'])->group(function () {
    Route::get('/checkingAuthenticated', function () {
        return response()->json(['message'=>'You are in', 'status'=>200], 200);
    });
    // Category
    Route::get('view-category', [CategoryController::class, 'index']);
    Route::post('store-category', [CategoryController::class, 'store']);
    Route::get('edit-category/{id}', [CategoryController::class, 'edit']);
    Route::put('update-category/{id}', [CategoryController::class, 'update']);
    Route::delete('delete-category/{id}', [CategoryController::class, 'destroy']);
    Route::get('all-category', [CategoryController::class, 'allcategory']);
     // Products
     Route::post('store-product', [ProductController::class, 'store']);
     Route::get('view-product', [ProductController::class, 'index']);
     Route::get('edit-product/{id}', [ProductController::class, 'edit']);
     Route::post('update-product/{id}', [ProductController::class, 'update']);
     // Orders
     Route::get('admin/orders', [OrderController::class, 'index']);
     Route::get('admin/orderitems', [OrderController::class, 'store']);
    //  Route::get('admin/orderitems/{id}', [OrderController::class, 'show']);
     Route::put('update-orderitems/{id}', [OrderController::class, 'update']);
     Route::get('admin/orderitems/{id}', [OrderController::class, 'getOrderItemData']);
     Route::delete('delete-item/{id}', [OrderController::class, 'destroy']);
     //Users
     Route::get('view-user', [UserController::class, 'index']);
     Route::delete('delete-user/{id}', [UserController::class, 'destroy']);

     //logout
    Route::post('logout', [AuthController::class, 'logout']);

});

Route::middleware(['auth:sanctum'])->group(function () {
    
  
    Route::post('logout', [AuthController::class, 'logout']);

});

    
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
