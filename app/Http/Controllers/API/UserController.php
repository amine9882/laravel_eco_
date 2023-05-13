<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    public function index()
    {
        $user = User::all()->take(12);
        if($user)
        {
            return response()->json([
                'status'=>200,
                'user'=>$user,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No user Found',
            ]);
        }
    }
    public function destroy($id)
    {
        $User_delete = User::find($id);
        if($User_delete)
        {
            $User_delete->delete();
            return response()->json([
                'status'=>200,
                'message'=>'User Deleted Successfully',
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No User ID Found',
            ]);

        }
        
    }
}
