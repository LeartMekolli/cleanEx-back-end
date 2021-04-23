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
        $services = Service::select('id','service_name')->orderBy('id')->get();
        return response($services,200);
    }


    
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

    /**
     * Queries mysql
     * @param param is value of string wich is going be split and return in string again
     * @return string
     */
    private function get_like_query($param){
        $array = explode(",",$param);
        
        $query = ' and ( location like ';

        foreach ($array as $item) {
            $query = $query .'"%'.$item.'%"';
            if(next($array)!=null){
                $query = $query .' or location like ';
            }
        }
        $query = $query.')';
        return $query;
    }


    /**
     * Queries mysql
     * @param check_statement default value is empty string
     * @return string
     */
    private function get_queries($check_statement = ''){
        $select_query = 'select details.first_name, details.last_name ,services.service_name, services.icon 
        ,location, title, content, price, posts.created_at from posts, users, details, services 
        where posts.user_id = users.id and users.detail_id = details.id and 
        posts.service_id = services.id and posts.payment_status = 1 and 
        posts.active = 1 '.$check_statement;

        return $select_query;
    }


    /**
     * Service query mysql
     * @param  service_name $service name 
     * @return string
     */
    private function get_service_query($service_name){
        $array = explode(",",$service_name);
        
        $query = ' and ( services.service_name like ';

        foreach ($array as $item) {
            $query = $query .'"%'.$item.'%"';
            if(next($array)!=null){
                $query = $query .' or services.service_name like ';
            }
        }
        $query = $query.')';
        return $query;
    }


    /**
     * Price query mysql
     * @param price this parameters is coming as string min-max price 
     * @return string
     */
    private function get_price_query($price){
        $price_array = explode("-",$price);
        $min_price = (int)$price_array[0];
        $max_price = (int)$price_array[1];
        $string = ' and ( posts.price between '.$min_price.' and '.$max_price.') ';
        return $string;

    }


    public function get_posts_by_queries(Request $request){
        
        //location
        //price
        //service
        $posts;
        
        if($request->location == null && $request->service == null && $request->price == null){ 
            $posts = DB::select($this->get_queries());

        }elseif($request->location != null && $request->service == null && $request->price == null){
            $like_query = $this->get_like_query($request->location); 
            $posts = DB::select($this->get_queries($like_query));      

        }elseif($request->location != null && $request->service != null && $request->price == null){
            $like_query = $this->get_like_query($request->location); 
            $service_query = $this->get_service_query($request->service);
            $posts = DB::select($this->get_queries($like_query.$service_query));

        }elseif($request->location != null && $request->service == null && $request->price != null){
            $like_query = $this->get_like_query($request->location); 
            $price_query = $this->get_price_query($request->price);
            $posts = DB::select($this->get_queries($like_query.$price_query));
            
        }elseif($request->location != null && $request->service != null && $request->price != null){
            $like_query = $this->get_like_query($request->location); 
            $service_query = $this->get_service_query($request->service);
            $price_query = $this->get_price_query($request->price);
            $posts = DB::select($this->get_queries($like_query.$service_query.$price_query));

        }elseif($request->location == null && $request->service != null && $request->price != null){
            $service_query = $this->get_service_query($request->service);
            $price_query = $this->get_price_query($request->price);
            $posts = DB::select($this->get_queries($service_query.$price_query));

        }elseif($request->location == null && $request->service == null && $request->price != null){
            $price_query = $this->get_price_query($request->price);
            $posts = DB::select($this->get_queries($price_query));           

        }else{
            $service_query = $this->get_service_query($request->service);
            $posts = DB::select($this->get_queries($service_query));           

        }
        
        if(count($posts)==0){
            return response(['posts'=>'Not found'],404);
        }
        return response($posts,200);

   
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
                "service"=> $post[0]->service->service_name,
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
