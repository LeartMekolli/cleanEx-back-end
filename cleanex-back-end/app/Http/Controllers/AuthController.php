<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'lastname' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|unique:users|email',
            'password' => 'required',
        ]);

        if($validator -> fails()){
            return response()->json(['status_code' => 400, 'message' => 'Bad Request']);
        }

        $user = new User();
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->birthday = $request->birthday;
        $user->phoneNo = $request->phoneNo;
        $user->password = bcrypt($request->password);
        $user->save();

        $currentUser = User::where('email', $request->email)->first();
        $tokenResult = $currentUser -> createToken('auth')->plainTextToken;

        $credentials = request(['email', 'password']);

        if(Auth::attempt($credentials)){
        return response()->json([
            'status_code'=>200,
            'message'=>'You have just signed up!',
            'token'=>$tokenResult
        ]);
        }
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator -> fails()){
            return response()->json(['status_code' => 400, 'message' => 'Bad Request']);
        }

        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials)){
            return response()->json([
                'status_code'=>500,
                'message'=>'You must log in!'
            ]);
        }

        $user = User::where('email', $request->email)->first();
        $tokenResult = $user -> createToken('auth')->plainTextToken;

        return response()->json([
            'status_code'=>200,
            'token'=> $tokenResult
        ]);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status_code'=>200,
            'message'=>'You have been logged out!'
        ]);
    }  
}
