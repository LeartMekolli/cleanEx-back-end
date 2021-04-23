<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Carbon;

class UserController extends Controller
{

    public function show(){


        $user = User::where('id',Auth::user()->id)->first();

        if($user->detail_id == null){
            return response()->json(['message'=>'You do not have any details!'],404);
        }

        $response = [
            "first_name" => $user->detail->first_name,
            "last_name" => $user->detail->last_name,
            "gender" => $user->detail->gender->gender_type,
            "email" => $user->email,
            "phone_number" => $user->detail->phone_number,
            "age" => Carbon::parse($user->detail->birthday)->age,
            "country" => $user->detail->region->city->country->country_name,
            "city" => $user->detail->region->city->city_name,
            "region" => $user->detail->region->region_name,
            "street_number" => $user->detail->street_number,
            "postal_code" => $user->detail->postal_code

        ];

        return response($response,200);
        
    }
    public function update(Request $request){
        
            // bledari te dhenat mbrapa pervec nr te telefonit tjerat duhet me i kontrollu mos me i len te zbrazeta
            User::where('id',Auth::user()->id)->update([
                
                //image
                //birthday
                //adressa?
                'updated_at' => now(),
            ]);

            return response(['message'=>'Your details successfuly updated!'],200);
        
        
    } 


    //useri kur te fshihet duhet me i bo deleted-ne database edhe komentet 
    //dmth ne database delete feature e bone 1 or true edhe per services 
    //deleteUser or create another table which will store deleted users.
  //Ne rast se i njejti email hap perseri account dhe tenton ta mbyll ka me pas problem shkaku qe
    //email eshte unique dhe te paren here behet _example@gmail.com update dhe perseri nuk mundet me u be njejt update.
    public function delete_user(){ 
       
            
  
            User::where('id',Auth::user()->id)->update([ 
              // 'email' => '_'.Auth::user()->email,
                
            ]); 
        //    Comment::where('id',Auth::user()->id)->delete();

            foreach (Auth::user()->post as $item) {
                $item->active = 0;
            }
            return response(['message'=>'Your account permanently deleted!'],200);
        
    }





        //check user if user's details is empty or not
    //if it is empty he/she cant create new posts, if it is not empty he/she can create a post

    public function check_user_details(){

        $user = User::where('id',Auth::user()->id)->first();
         //   $check_user_details = User::where([['id','=',Auth::user()->id],['detail_id','=',null]])->count();

   
       if($user->detail_id == null){
           return response(['error'=>'If you do not have any details in your profile, you can not create post!'],404);
       }

       $response = [
        "first_name" => $user->detail->first_name,
        "last_name" => $user->detail->last_name,
        "gender" => $user->detail->gender->gender_type,
        "email" => $user->email,
        "phone_number" => $user->detail->phone_number,
        "country" => $user->detail->region->city->country->country_name,
       ];
       return response($response,200);
    }

}
