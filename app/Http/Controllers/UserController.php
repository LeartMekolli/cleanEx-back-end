<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    //
    /* public function __contructor(){
        $this->middleware('auth:sanctum');
    } */


    public function show(){
        //get function for users
        // Get the currently authenticated user... Auth::user(); 
        // Get the currently authenticated user's ID... Auth::id();
        
        if(Auth::user()){
            $response = [
                'name' => Auth::user()->name,
                'lastname' => Auth::user()->lastname,
                'username' => Auth::user()->username,
                'email' => Auth::user()->email,
                'birthday' => Auth::user()->birthday,
                'email_verified_at' => Auth::user()->email_verified_at,
                'phoneNo' => Auth::user()->phoneNo
            ];

            return response($response,200);
        }
        return response(['message'=>'You need login!'],400);
    }

    public function update(Request $request){
        //delete user service/services - in this case we will not delete user service but
        //we will change deleted future to true
        if(Auth::user()){
            //cili servisim eshte tentu te fshihet ose eshte tentu te largohet nga fronti
            //id e cilit servis ne kete rast ne vend destroy ktu duhet me qene update or edit action
            //me an te dates se postimit mundemi me gjet cili postim eshte.
            $created_at = $request->created_at; // YYYY-MM-DD ose dicka tjeter
        
        }
    }

    public function edit(Request $request){
        //edit user details
    }
    
}
