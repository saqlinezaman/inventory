<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\otpMail;
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
    }// end method

    public function logout()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'User logout successfully',
        ],200)->cookie('token', '', -1);
    }// end method

    public function sendOtp(Request $request){
        $email = $request->input('email');
        $otp = rand(1000,9999);

        $count = User::where('email',$email)->count();

        if($count == 1){
            Mail::to($email)->send(new otpMail($otp));
            User::where('email',$email)->update([
                'otp' => $otp ]);

            return response()->json([
                'status' => 'success',
                'message' => "4 digit {$otp} OTP sent to your email",
            ],200);
        }else{
            return response()->json([
                'status' => 'failed',
                'message' => 'Unauthorized email',
            ],404);
        }
    }

}
