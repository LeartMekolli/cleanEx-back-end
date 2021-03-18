<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Comment;

class UserController extends Controller
{
    public function show(){

        if(Auth::user()){

            $user = [
                'name' => Auth::user()->name,
                'lastname' => Auth::user()->lastname,
                'username' => Auth::user()->username,
                'email' => Auth::user()->email,
                'phoneNo' => Auth::user()->phoneNo,
                'birthday' => Auth::user()->birthday,

            ];

            

            return response($user,200);
        }
        
        return response(['message'=>'You must login'],400);
    }
    public function update(Request $request){
        if(Auth::user()){
            // bledari te dhenat mbrapa pervec nr te telefonit tjerat duhet me i kontrollu mos me i len te zbrazeta
            User::where('id',Auth::user()->id)->update([
                'name'=> $request->name,
                'lastname' => $request->lastname,
                'phoneNo' => $request->phoneNo,
                'updated_at' => now(),
            ]);

            return response(['message'=>'Your details successfuly updated!'],200);
        }
        return response(['message'=>'You must login'],400);
    } 


    //useri kur te fshihet duhet me i bo deleted-ne database edhe komentet 
    //dmth ne database delete feature e bone 1 or true edhe per services 
    
    public function deleteUser(){ //deleteUser or create another table which will store deleted users.

        if(Auth::user()){
            
    //Ne rast se i njejti email hap perseri account dhe tenton ta mbyll ka me pas problem shkaku qe
    //email eshte unique dhe te paren here behet _example@gmail.com update dhe perseri nuk mundet me u be njejt update.
            User::where('id',Auth::user()->id)->update([ 
              // 'email' => '_'.Auth::user()->email,
                
            ]); 
            Comment::where('id',Auth::user()->id)->delete();

            foreach (Auth::user()->service as $item) {
                $item->deleted = 1;
            }
            return response(['message'=>'Your account permanently deleted!'],200);
        }
        return response(['message'=>'You must login'],400);
    }

}
