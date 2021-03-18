<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\City;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller
{

    // nje metod per me i dergu te dhenat e job list, country list edhe te dhenat tjera te user
    /* public function getCities(){
        $cities = City::select('id','city')->orderBy('id')->get();
        return response($cities,200);
    } */
    public function getJobs(){
        $jobs = Job::select('id','name')->orderBy('id')->get();
        return response($jobs,200);
    }


    //
    public function createService(Request $request){
       // return response()->json($request, 200);
        $authenticatedUser = Auth()->user()->id;

        $service = new Service();
        $service->user_id = $authenticatedUser;
        $service->job_id = $request->job_id; //job_id from $request->job_id nga fronti 
        $service->job_description = $request->description;
        $service->price = $request->price;
        $service->created_at = now();
        $service->status = 1;
        $service->save();

        return response()->json(['message'=>'Service created successfully!'], 200);
    }

    public function getServices(){ //getAll services 
        $services = Service::where([['deleted','=',0],['status','=',1]])->orderBy('created_at', 'DESC')->get(); 
        
        $response = array(count($services));

        for ($i=0; $i < count($services); $i++) { 
            $response[$i] = [
                "id" => $services[$i]->id,
                "user" => [
                    "name"=> $services[$i]->user->name,
                    "lastname"=> $services[$i]->user->lastname,
                    "email"=> $services[$i]->user->email,   
                    "phoneNo" => $services[$i]->user->phoneNo
                ],
                "job"=> $services[$i]->job->name,
                "payment_id"=> null,
                "job_description"=> $services[$i]->job_description,
                "price"=> $services[$i]->price,
                "created_at"=> $services[$i]->created_at,
                "updated_at"=> $services[$i]->updated_at
            ]; 
         
        }
        return response($response,200);
      /*   return response()->json([                                                       
            'message'=>'All posts!',                                                    
            'posts'=>$services                                        
        ],200);   */                                                   
    }

    public function getServicesById($id){  //getServices by specific Id

        $service = Service::where([['id','=',$id],['deleted','=',0],['status','=',1]])->get(); 
        
        if(count($service) == 1){

            $response = [
            "id" => $service[0]->id,
            "user" => [
                "name"=> $service[0]->user->name,
                "lastname"=> $service[0]->user->lastname,
                "email"=> $service[0]->user->email,   
                "phoneNo" => $service[0]->user->phoneNo
            ],
            "job"=> $service[0]->job->name,
            "payment_id"=> null,
            "job_description"=> $service[0]->job_description,
            "price"=> $service[0]->price,
            "created_at"=> $service[0]->created_at,
            "updated_at"=> $service[0]->updated_at
            ];
            return response()->json($response, 200); 
        }
        
        return response()->json(['message'=>'This service not found'],404);                                     
    }                                                 
    
// ketu te gjithe te dhenat nuk duhet me ja dergu,  ne vend user_id duhet me ja dergu te dhenat si emer mbiemer 
//ne vend te job_id duhet me dergu emrin e punes
 //payment nuk duhet me dergu hiq ne front, deleted nuk duhet me dergu
     //created_at duhet me dergu, updated_at ndoshta
    // getServicesById duhet me kontrollu statusin edhe deleted per me i postu ktu (OK)

    public function deleteServiceById($id){
        $createdByUser = Service::where('id', $id)->first()->user_id;
        $authenticatedUser = Auth()->user()->id;
        if ($authenticatedUser === $createdByUser){
            $deletedService = Service::where('id', $id)->update([
                'deleted' => 1,
                'updated_at'=>now()
            ]);
            return response()->json([
                'message' => 'Service successfuly deleted'
            ], 200);
        }
        return response()->json([
                'message'=>'You cannot delete this post!'
            ], 401);
        
    }
    public function updateServiceById(Request $request, $id){
        $createdByUser = Service::where('id', $id)->first()->user_id;
        $authenticatedUser = Auth()->user()->id;
        if ($authenticatedUser === $createdByUser){
            $updatedService = Service::where('id', $id)->update([
                'job_description'=>$request->description,
                'price'=>$request->price,
                'updated_at'=>now()
            ]);
            return response()->json([
                'message'=>'Service has been updated!'
            ], 200);
        }
        return response()->json([
            'message'=>'You cannot update this post!'
        ], 401);
        
    }




    //--user services
    public function getUserServices(){
        
        $userServices = Service::where([['user_id','=',Auth()->user()->id],['deleted','=',0]])->get();
        if(count($userServices)!=0){
            return response()->json(['user_services'=>$userServices],200);
        }

        return response()->json(['user_services'=>'Services not found!'],404);
    }
}






