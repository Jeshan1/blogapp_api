<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use function App\Helper\apiResponse;
use function App\Helper\handleException;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        return handleException(function() use($request){
            $data = [
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>$request->password
            ];

            if ($data) {
                User::create([
                    'name'=>$data['name'],
                    'email'=>$data['email'],
                    'password'=>Hash::make($data['password'])
                ]);
                
                return apiResponse($data,"User registered Successfully",201);
            }

            return apiResponse([],"Some thing went wrong",400,"Some error occured when regisering user.");
        });
        
    }

    public function login(LoginRequest $request){
        return handleException(function() use($request){
            $data = $request->only('email','password');
            if (Auth::attempt($data)) {
                $user = Auth::user();
                $token = $user->createToken('authtoken')->plainTextToken;
                return response()->json([
                    'message'=>"User logged in successfully",
                    'statusCode'=>200,
                    'token'=>$token,
                    'user'=>$user
                ]);
    
            }
            return apiResponse([],"User Unauthorized",401);
        });

       
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return apiResponse([],"Logged Out Successfully.",200);
    }

    public function send_reset_password_email(Request $request){
        $request->validate([
            'email'=>'required|email'
        ]);

        $email = $request->email;
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json([
                'message'=>"User does not exist",
                'status'=>"error"
            ]);
        }

        $token = Str::random(60);

        PasswordReset::create([
            'email'=>$email,
            'token'=>$token,
            'created_at'=>Carbon::now()
        ]);

        Mail::send('reset',['token'=>$token], function(Message $message) use($email){
            $message->subject('Reset Password link');
            $message->to($email);
        });

        return response()->json([
             'message'=>'Password Reset Email Sent... Check Your Email',
            'status'=>'success'
        ],200);
        
    }

    public function reset_password(Request $request,$token){
        //delete password reset token if more than 2 minutes hold
        // $formatted = Carbon::now()->subMinutes(15)->toDateTimeString();
        // PasswordReset::where('created_at','<',$formatted)->delete();

        $request->validate([
            'password'=>'required|confirmed'
        ]);

        $passwordreset = PasswordReset::where('token',$token)->first();

        if (!$passwordreset) {
            return response()->json([
                'message'=>"Invalid user",
                'status'=>'error'
            ]);
        }

        $user = User::where('email',$passwordreset->email)->first();

        $user->password = Hash::make($request->password);
        $user->save();

        //password reset token delete
        PasswordReset::where('email',$user->email)->delete();

        return response()->json([
            "message"=>"Your password changed successfully",
            "status"=>"success"
        ]);

    }
}
