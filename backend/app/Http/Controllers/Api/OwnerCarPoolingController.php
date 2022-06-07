<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Carbon;
use App\Models\OwnerCarPooling;
use App\Helpers\Helper;
use App\Models\User;

class OwnerCarPoolingController extends Controller
{
    public $successStatus = 200;
    public function AddCarPooling(Request $request){

        $pooling_id = Helper::IDGenerator(new OwnerCarPooling, 'pooling_id', 5, 'POL');

        $validator = Validator::make($request->all(), [ 
            'car_capacity' => 'required',
            'required_date' => 'required',
            'required_time' => 'required',
            'current_longitude' => 'required',
            'current_latitude' => 'required',
            'destination_longitude' => 'required',
            'destination_latitude' => 'required',
            'car_id' => 'required|unique:owner_car_poolings,car_id',
            'smoking'=> 'required|boolean',
            'ac'=> 'required|boolean',
            'only_girls'=> 'required|boolean',

        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
     }
    
         OwnerCarPooling::insert(['pooling_id'=>$pooling_id,
        'car_id'=>$request->car_id,
        'car_capacity'=>$request->car_capacity,
        'required_date'=>$request->required_date,
        'required_time'=>$request->required_time,
        'comment'=>$request->comment,
        'smoking'=>$request->smoking,
        'ac'=>$request->ac,
        'only_girls'=>$request->only_girls,
        'current_longitude'=>$request->current_longitude,
        'current_latitude'=>$request->current_latitude,
        'destination_longitude'=>$request->destination_longitude,
        'destination_latitude'=>$request->destination_latitude,
        'user_id'=>$request->user_id,
        'created_at'=>Carbon::now()
    ]);
     
     $OwnerCarPooling=OwnerCarPooling::latest()->first();
 
 return response()->json(['Pooling-info'=>$OwnerCarPooling]);


    }
    public function GetOwnerCarPooling($id) 
    { 
        
        $user=User::with('OwnerCarPooling')->get()->where('id',$id);
   
         
        return response()->json(['success','user' => $user], $this-> successStatus);  

    }

    public function UpdateOwnerCarPooling(Request $request,$pooling_id){

        $OwnerCarPooling=OwnerCarPooling::where('pooling_id',$pooling_id)->update([ 
        'car_capacity'=>$request->car_capacity,
        'required_date'=>$request->required_date,
        'required_time'=>$request->required_time,
        'comment'=>$request->comment,
        'smoking'=>$request->smoking,
        'ac'=>$request->ac,
        'only_girls'=>$request->only_girls,
        'current_longitude'=>$request->current_longitude,
        'current_latitude'=>$request->current_latitude,
        'destination_longitude'=>$request->destination_longitude,
        'destination_latitude'=>$request->destination_latitude,
        'user_id'=>$request->user_id,
        'car_id'=>$request->car_id,
        'created_at'=>Carbon::now()
]);

$OwnerCarPooling=OwnerCarPooling::where('pooling_id',$pooling_id)->get();
return response()->json(['UPDATED SUCCESSFULLY','OwnerCarPooling'=>$OwnerCarPooling]);

    }


    public function DeleteOwnerCarPooling($pooling_id){

        $OwnerCarPooling = OwnerCarPooling::where('pooling_id',$pooling_id)->first();
        $last=$OwnerCarPooling->pooling_id;
        if($last){
            $OwnerCarPooling->delete(); 
            return response()->json(['pooling'=>$last,'DELETED SUCCESSFULLY']);
        }
        
        else{
            return response()->json(error);
        }
            
         
        // return 'hello';

    }
}
