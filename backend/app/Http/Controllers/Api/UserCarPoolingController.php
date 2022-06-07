<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Carbon;
use App\Models\UserCarPooling;
use App\Helpers\Helper;
use App\Models\User;

class UserCarPoolingController extends Controller
{
    public $successStatus = 200;
    public function AddCarPooling(Request $request){

        $pooling_id = Helper::IDGenerator(new UserCarPooling, 'pooling_id', 5, 'POL');

        $validator = Validator::make($request->all(), [ 
            'seats' => 'required',
            'required_date' => 'required',
            'required_time' => 'required',
            'current_longitude' => 'required',
            'current_latitude' => 'required',
            'destination_longitude' => 'required',
            'destination_latitude' => 'required',

        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
     }
    
     UserCarPooling::insert(['pooling_id'=>$pooling_id,
        'seats'=>$request->seats,
        'required_date'=>$request->required_date,
        'required_time'=>$request->required_time,
        'comment'=>$request->comment,
        'current_longitude'=>$request->current_longitude,
        'current_latitude'=>$request->current_latitude,
        'destination_longitude'=>$request->destination_longitude,
        'destination_latitude'=>$request->destination_latitude,
        'user_id'=>$request->user_id,
        'created_at'=>Carbon::now()
    ]);
     
     $OwnerCarPooling=UserCarPooling::latest()->first();
 
 return response()->json(['Pooling-info'=>$OwnerCarPooling]);


    }

    public function GetUserCarPooling($id) 
    { 
        
        $user=User::with('UserCarPooling')->get()->where('id',$id);
   
         
        return response()->json(['success','user' => $user], $this-> successStatus);  

    }

    public function UpdateUserCarPooling(Request $request,$pooling_id){

        $OwnerCarPooling=UserCarPooling::where('pooling_id',$pooling_id)->update([ 
            'seats'=>$request->seats,
            'required_date'=>$request->required_date,
            'required_time'=>$request->required_time,
            'comment'=>$request->comment,
            'current_longitude'=>$request->current_longitude,
            'current_latitude'=>$request->current_latitude,
            'destination_longitude'=>$request->destination_longitude,
            'destination_latitude'=>$request->destination_latitude,
            'user_id'=>$request->user_id,
            'created_at'=>Carbon::now()
]);

$OwnerCarPooling=UserCarPooling::where('pooling_id',$pooling_id)->get();
return response()->json(['UPDATED SUCCESSFULLY','UserCarPooling'=>$OwnerCarPooling]);

    }


    public function DeleteUserCarPooling($pooling_id){

        $UserCarPooling = UserCarPooling::where('pooling_id',$pooling_id)->first();
        $last=$UserCarPooling->pooling_id;
        if($last){
            $UserCarPooling->delete(); 
            return response()->json(['pooling'=>$last,'DELETED SUCCESSFULLY']);
        }
        
        else{
            return response()->json(error);
        }
            
         
        // return 'hello';

    }
}
