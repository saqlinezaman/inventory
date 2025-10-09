<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // User Registration
    public function userRegistration(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]);

            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'User Created Successfully',
                'data' => $user
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ]);
        }
    } // end method


    // User Login
    public function userLogin(Request $request)
    {
        $count = User::where('email', $request->input('email'))
                    ->where('password', $request->input('password'))
                    ->select('id', 'email')
                    ->first();

        if ($count !== null) {
            $token = JWTToken::CreateToken($request->input('email'),$count->id);

            return response()->json([
                'status' => 'success',
                'message' => 'User login successfully',
                'token' => $token
            ],200)->cookie('token', $token, 60 * 24 * 30);
            
        } else {
             return response()->json([
                'status' => 'failed',
                'message' => 'unauthorized'
            ],200);
        }
    } // end method

    public function dashboard(Request $request)
    {
       $user = $request->header('email');
       return response()->json([
        'status' => 'success',
        'message' => 'User login successfully',
        'user' => $user
       ],200);
    }
}
