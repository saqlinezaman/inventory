<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userRegistration(Request $request){
       try {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);

        $user =User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password')

        ]);

        return response()->json([
            'status' => 'success',
            'massage' => 'User Created Successfully',
            'data' => $user
        ]);

       } catch (Exception $e) {
       return response()->json([
            'status' => 'failed',
            'massage' => $e->getMessage()
        ]);
       }
    }
}
