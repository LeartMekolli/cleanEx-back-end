<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use App\Models\Detail;


class AuthController extends Controller
{
  
    //confirm_email in register part
    public function register_confirm_email(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            
        ]);

        if($validator -> fails()){
            return response()->json($validator->messages(),400);
        }

        $current_user = User::where('email', $request->email)->first();
        
        if($current_user == null){
            $code = rand(10000,99999);
            $message_content = [
                'title'=>'Për të përfunduar regjistrimin vërteto llogarinë',
                'content' => 'Kodi: ',
                'code' => $code
            ];
            $response = [
                'message'=>'Your code has been send in your email',
                'successful'=>'Please confirm this account',
                'code' => $code

            ];
             
            $email_content = new SendEmail($message_content);
            Mail::to($request->email)->send($email_content);
            return response()->json($response,200);
        }
        
        return response()->json(['error'=>'This email registered!'],400);
       
    }
   
    public function register(Request $request){

        $validator = Validator::make($request->all(),[
            'email' => 'required|unique:users',
            'password' => 'required',
        ]);

        if($validator -> fails()){
            return response()->json($validator->messages(),400);
        }
        $new_user = new User();
        $new_user->email = $request->email;
        $new_user->password = bcrypt($request->password);
        $new_user->created_at = now();
        $new_user->active = 1;

        $new_user->save();

        $token_result = $new_user->createToken('auth')->plainTextToken;

        $credentials = request(['email', 'password']);

        if(Auth::attempt($credentials)){
            return response([
                'success'=>'You have just signed up!',
                'token'=>$token_result
            ],200);
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

        //ne rast se validimi behet ne front atehere ne back nuk ka nevoj per validim por per kontroll
        //nese email gjendet ne database personit ne fjale i kontrollohet a i ka dhene email edhe passin sakt
        
        $credentials = request(['email', 'password']);
        
        if(!Auth::attempt($credentials)){
            return response()->json([
                'status_code'=>500,
                'message'=>'Your email or password is not correct!' //kjo mundet me u perdor per autorizim por jo ne kete rast per login
            ]);                                 // sepse nese email eshte i pa sakt atehere duhet mesazh qe
        }                                       // ky lloj email nuk eshte i regjistruar per login e jo te i thuash 
                                                // you must login - my opinion

        $user = User::where('email', $request->email)->first();
        $token_result = $user->createToken('auth')->plainTextToken; //cdo token ruhet ne database !?
        
        
        return response()->json([
            'status_code'=>200,
            'token'=> $token_result
        ]);

    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete(); // ??  
        // $user->tokens()->delete(); user perkates i fshihen te gjitha tokenet ne database keshtu qe del nga sistemi komplet
        return response()->json([
            'status_code'=>200,
            'message'=>'You have been logged out!'
        ]);
    }  
   
    public function change_password_confirm_email(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            
        ]);

        if($validator -> fails()){
            return response()->json($validator->messages(),400);
        }

        $current_user = User::where('email', $request->email)->first();
        
        if($current_user != null){
            $code = rand(10000,99999);
            $message_content = [
                'title'=>'Për të ndërruar fjalkalimin vërteto llogarinë ',
                'content' => 'Kodi: ',
                'code' => $code
            ];
            $response = [
                'message'=>'Your code has been send in your email',
                'successful'=>'Please confirm this account',
                'code' => $code

            ];
             
            $email_content = new SendEmail($message_content);
            Mail::to($request->email)->send($email_content);
            return response()->json($response,200);
        }
        
        return response()->json(['error'=>'This email is not registered!'],400);
       
    }
    public function change_password(Request $request){
        //fronti ma dergon email edhe passwordin un vetem bej update passwordin e userit
        User::where('email', $request->email)->update(['password' => bcrypt($request->password),'updated_at'=>now()]);
        return response(['successful' => 'Your password updated!'],200);
    }
       
  public function get_all_users() {
    $users = User::get()->toJson(JSON_PRETTY_PRINT);
    return response($users, 200);
  }
  public function get_user($id) {
    if (User::where('id', $id)->exists()) {
        $user = User::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
        return response($user, 200);
      } else {
        return response()->json([
          "message" => "User not found"
        ], 404);
      }
  }
 /* public function updateUser(Request $request, $id)
{
        $user = User::findOrFail($id);
        $user->update($request->all());
        $request->user()->fill([
        'password' => Hash::make($request->newPassword)
        ])->save();
        return response()->json([
            "message" => "Password updated successfully"
        ], 200);
    } */
    public function update_detail(Request $request, $id)
    {
        $detail = Detail::findOrFail($id);
        $detail->update($request->all());
         return response()->json([
            "message" => "Details updated successfully"
        ], 200);
        
    }

}

