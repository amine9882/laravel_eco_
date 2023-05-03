<?php

namespace App\Http\Controllers\API;
use App\Models\Cart;
use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function placeorder(Request $request)
    {
        if(auth('sanctum')->check())

        {
           
            $validator = Validator::make($request->all(), [
                'firstname' => 'required|max:191',
                'lastname'=>'required|max:191',
                'phone'=>'required|max:191',
                'email'=>'required|max:191',
                'address'=>'required|max:191',
                'city'=>'required|max:191',
                'state'=>'required|max:191',
                'zipcode'=>'required|max:191',
                'image'=>'required|file|mimes:jpeg,png,jpg|max:2048',
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
                $user_id = auth('sanctum')->user()->id;
                $order = new Order;
                $order->user_id = $user_id;
                $order->firstname = $request->firstname;
                $order->lastname = $request->lastname;
                $order->phone = $request->phone;
                $order->email = $request->email;
                $order->address = $request->address;
                $order->city = $request->city;
                $order->state = $request->state;
                $order->zipcode = $request->zipcode;

                if($request->hasFile('image'))
                {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() .'.'.$extension;
                    $file->move('uploads/certif/', $filename);
                    $order->image = 'uploads/certif/'.$filename;
                }
                
                $order->payment_id = $request->payment_id;
                $order->payment_mode = "cod";                
                $order->tracking_no = 'aminedz'.rand(1111,9999);
                // $order->user_id = $user_id;
                // $order->firstname = $request->input('firstname');
                // $order->lastname = $request->input('lastname');
                // $order->phone = $request->input('phone');
                // $order->email = $request->input('email');
                // $order->address = $request->input('address');
                // $order->city = $request->input('city');
                // $order->state = $request->input('state');
                // $order->zipcode = $request->input('zipcode');

                // if($request->hasFile('certificate'))
                // {
                //     $file = $request->file('certificate');
                //     $extension = $file->getClientOriginalExtension();
                //     $filename = time() .'.'.$extension;
                //     $file->move('uploads/certif/', $filename);
                //     $$order->certificate = 'uploads/certif/'.$filename;
                // }
                
                // $order->payment_id = $request->payment_id;
                // $order->payment_mode = "cod";                
                // $order->tracking_no = 'aminedz'.rand(1111,9999);
                $order->save();

                $cart = Cart::where('user_id', $user_id)->get();

                $orderitems = [];
                foreach($cart as $item){
                    $orderitems[] = [
                        'product_id'=>$item->product_id,
                        'qty'=>$item->product_qty,
                        'price'=>$item->product->selling_price,
                    ];

                    $item->product->update([
                        'qty'=>$item->product->qty - $item->product_qty
                    ]);
                }

                $order->orderitems()->createMany($orderitems);
                Cart::destroy($cart);

                return response()->json([
                    'status'=>200,
                    'message'=>'Order Placed Successfully',
                ]);
            }
        }
        else
        {
            return response()->json([
                'status'=> 401,
                'message'=> 'Login to Continue',
            ]);
        }
    }

    public function validateOrder(Request $request)
    {
        if(auth('sanctum')->check())
        {
            $validator = Validator::make($request->all(), [
                'firstname' => 'required|max:191',
                'lastname'=>'required|max:191',
                'phone'=>'required|max:191',
                'email'=>'required|max:191',
                'address'=>'required|max:191',
                'city'=>'required|max:191',
                'state'=>'required|max:191',
                'zipcode'=>'required|max:191',
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
                return response()->json([
                    'status'=>200,
                    'message'=>'Form Validated Successfully',
                ]);
            }
        }
        else
        {
            return response()->json([
                'status'=> 401,
                'message'=> 'Login to Continue',
            ]);
        }
    }
}
