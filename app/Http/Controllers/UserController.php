<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Detail;
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


}
