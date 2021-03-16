<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller
{
    public function createService(Request $request){
        $authenticatedUser = Auth()->user()->id;

        $service = new Service();
        $service->user_id = $authenticatedUser;
        $service->job_id = 1;
        $service->job_description = $request->description;
        $service->price = $request->price;
        $service->created_at = DB::raw('NOW()');
        $service->save();

        return response()->json(['message'=>'Service created successfully!'], 200);
    }

    public function getServices(){
        $services = Service::orderBy('created_at', 'DESC')->get();
        return response()->json([
            'status_code'=>200,
            'message'=>'All posts!',
            'posts'=>$services
        ]);
    }

    public function getServicesById($id){
        $service = Service::where('id', $id)->first();
        return response()->json([
            'service'=>$service
        ], 200);
    }

    public function deleteServiceById($id){
        $createdByUser = Service::where('id', $id)->first()->user_id;
        $authenticatedUser = Auth()->user()->id;
        if ($authenticatedUser === $createdByUser){
            $deletedService = Service::where('id', $id)->delete();
            return response()->json([
                'message' => 'Service deleted'
            ], 200);
        }else {
            return response()->json([
                'message'=>'You cannot delete this post!'
            ], 401);
        }
    }
    public function updateServiceById(Request $request, $id){
        $createdByUser = Service::where('id', $id)->first()->user_id;
        $authenticatedUser = Auth()->user()->id;
        if ($authenticatedUser === $createdByUser){
            $updatedService = Service::where('id', $id)->update([
                'job_description'=>$request->description,
                'price'=>$request->price
            ]);
            return response()->json([
                'message'=>'Service has been updated!'
            ], 200);
        }else{
            return response()->json([
                'message'=>'You cannot delete this post!'
            ], 401);
        }
    }
}
