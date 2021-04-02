<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Service;
use App\Models\Post;
use App\Models\Country;
use App\Models\City;
use App\Models\Region;
use App\Models\Gender;

//use Illuminate\Support\Carbon;
class PostController extends Controller
{
    public function get_countries(){
        $countries = Country::select('id','country_name')->orderBy('id')->get();
        return response($countries,200);
    }

    public function get_cities(Request $request){
        $citites = City::select('id','city_name')->where('country_id','=',$request->country_id)->get();
        return response($citites,200);
    }
   
    public function get_regions(Request $request){
        $regions = Region::select('id','region_name')->where('city_id','=',$request->city_id)->get();
        return response($regions,200);
    }

    public function get_genders(){
        $genders = Gender::all();
        return response($genders,200);
    }

    public function get_services(){ //merri punet nga databaza
        $services = Service::select('id','name')->orderBy('id')->get();
        return response($services,200);
    }


    //
    public function create_post(Request $request){

        $authenticated_user = Auth()->user()->id;

        $post = new Post();
        $post->user_id = $authenticated_user;
        $post->service_id = $request->service_id; //service_id from $request->service_id nga fronti 
        $post->payment_id = 1;
        $post->location = $request->location;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->price = $request->price;
        $post->payment_status = 1; // 1 is true and 0 false; mos ndoshta paymnet_id ma mir me qene ne payment table
        $post->save();

        return response()->json(['message'=>'Post created successfully!'], 200);
    }

    public function get_posts(){ //getAll posts 
        $posts = Post::where([['active','=',1],['payment_status','=',1]])->orderBy('created_at', 'DESC')->get(); 
        
        $response = array(count($posts));

        for ($i=0; $i < count($posts); $i++) { 
            $response[$i] = [
                "id" => $posts[$i]->id,
                "service"=> $posts[$i]->service->name,
                "title"=> $posts[$i]->title,
                "location"=> $posts[$i]->location,
                "price"=> $posts[$i]->price
            ]; 
         
        }
        return response($response,200);
                                                     
    }
    
    public function get_post_by_id($id){  // by specific Id

        $post = Post::where([['id','=',$id],['active','=',1],['payment_status','=',1]])->get(); 
        
        if(count($post) == 1){

            $response = [
                "id" => $post[0]->id,
                "user_details" => [
                    "first_name"=> $post[0]->user->detail->first_name,
                    "last_name"=> $post[0]->user->detail->last_name,
                    "email"=> $post[0]->user->email,   
                    "phone_number" => $post[0]->user->detail->phone_number,
                    "gender" => $post[0]->user->detail->gender
                //    "age" => Carbon::parse($posts[$i]->user->detail->birthday)->age
                ],
                "service"=> $post[0]->service->name,
              //  "payment_id"=> null,
                "content"=> $post[0]->content,
                "title"=> $post[0]->title,
                "location"=> $post[0]->location,
                "price"=> $post[0]->price,
                "created_at"=> $post[0]->created_at,
                "updated_at"=> $post[0]->updated_at
            ];
            return response()->json($response, 200); 
        }
        
        return response()->json(['message'=>'This post not found'],404);                                     
    }                                                 

    public function delete_post_by_id($id){
        
        $request_post_id = Post::where([['id','=',$id],['active','=',0]])->get();
        if(count($request_post_id)==1){
            return response()->json([
                'message'=>'This post do not exist!'
            ], 404);
        }
        $created_by_user = $request_post_id->first()->user_id;
        
        $authenticated_user = Auth()->user()->id;
        if ($authenticated_user === $created_by_user){
            $deleted_post = Post::where('id', $id)->update([
                'active' => 0,
                'updated_at'=>now()
            ]);
            return response()->json([
                'message' => 'Post successfuly deleted'
            ], 200);
        }
        return response()->json([
                'message'=>'You cannot delete this post!'
            ], 401);
        
    }
    public function update_post_by_id(Request $request, $id){
        $created_by_user = Post::where('id', $id)->first()->user_id;
        $authenticated_user = Auth()->user()->id;
        if ($authenticated_user === $created_by_user){
            $updated_post = Post::where('id', $id)->update([
            //    'location'=>$request->location,
            //    'title'=>$request->title,
            //    'content'=>$request->content,
                'price' => $request->price,
                'updated_at'=>now()
            ]);
            return response()->json([
                'message'=>'Post has been updated!'
            ], 200);
        }
        return response()->json([
            'message'=>'You cannot update this post!'
        ], 401);
        
    }

    //--user posts
    public function get_user_posts(){
        
        $user_posts = Post::where('user_id',Auth()->user()->id)->get();
        if(count($user_posts)!=0){
            return response()->json(['user_posts'=>$user_posts],200);
        }

        return response()->json(['user_posts'=>'Posts not found!'],404);
    }


    //date difference 
    //first_date->diff(second_date)


}
