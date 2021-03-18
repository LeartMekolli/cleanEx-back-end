<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
    

    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'lastname' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required',
        ]);

        if($validator -> fails()){
            return response()->json(['status_code' => 400, 'message' => 'Bad Request']);
        }

        $user = new User();
        $user->name = $request->name;
        
                                            //per me e mundsi me bo increment pasi qe increment mundet vetem primary key me pas
                                            //por user_id ska me qen gjith njesoj me id, ne rast se behet delete nje data
                                            //id auto increment rritet per nje duke llogarit edhe rreshtin qe fshihet
                                            //kurse user_id merr per baz id me te lart te id-primary key ne ta moment
        $user->lastname = $request->lastname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->birthday = $request->birthday;
        $user->phoneNo = $request->phoneNo;
        $user->password = bcrypt($request->password);
        $user->created_at = now();
        $user->save();
        
       

        $currentUser = User::where('email', $request->email)->first();
        $tokenResult = $currentUser->createToken('auth')->plainTextToken;

        $credentials = request(['email', 'password']);

        if(Auth::attempt($credentials)){
        return response([
            'message'=>'You have just signed up!',
            'token'=>$tokenResult
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
                'message'=>'You must register!' //kjo mundet me u perdor per autorizim por jo ne kete rast per login
            ]);                                 // sepse nese email eshte i pa sakt atehere duhet mesazh qe
        }                                       // ky lloj email nuk eshte i regjistruar per login e jo te i thuash 
                                                // you must login - my opinion

        $user = User::where('email', $request->email)->first();
        $tokenResult = $user->createToken('auth')->plainTextToken; //cdo token ruhet ne database !?
        
        
        return response()->json([
            'status_code'=>200,
            'token'=> $tokenResult
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

    public function checkMail(Request $request){
        $validator = Validator::make($request->all(),[ //$request and $request->all()
            'email' => 'required|email'
        ]);
        if($validator -> fails()){
            return response($validator->messages(),400); //
        }

        $checkEmail = User::where('email',$request->email)->get();
        if(count($checkEmail)){
              $randomCode =rand(10000,99999);
              $details = array(
                "email" => $checkEmail[0]->email,
                "name" => $checkEmail[0]->name,
                "code" => $randomCode
              );
    
              Mail::send([], [], function ($message) use ($details) {
              //  $message->from('cleanexstarlabs@gmail.com', 'CleanEX Company');
                $message->to($details['email']);
                $message->subject('Ndrysho fjalkalimin ne ClenaEx ('.now().')');
                $message->setBody( '<html><h1 style="color:red;text-align:center;">Pershendetje '.$details['name'].'</h1><p>Kodi valid per te ndryshuar fjalkalimin</p><p><strong>Kodi: '.$details['code'].'</strong></p></html>', 'text/html' );

            });
            return response(['code' => $randomCode],200); //dergo kodin dhe statusin
        }
            
            return response(['message' => 'This email is not registered!'],400); //
        
    }
    public function changePassword(Request $request){
        //fronti ma dergon email edhe passwordin un vetem bej update passwordin e userit
        User::where('email', $request->email)->update(['password' => bcrypt($request->password)]);
        return response(['successful' => 'Your password updated!'],200);
    }
}
