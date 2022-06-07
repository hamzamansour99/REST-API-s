<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Models\Car;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth; 
use App\Models\User;

class CarController extends Controller
{
    
    public $successStatus = 200;
    function save(Request $request){

        $car_id = Helper::IDGenerator(new Car, 'car_id', 5, 'CAR');

        $car_image=$request->file('image');
        $name_gen=hexdec(uniqid());
        $img_ext=strtolower($car_image->getClientOriginalExtension());
        $img_name=$name_gen.'.'.$img_ext;
        $up_location='image/cars/';
        $last_img=$up_location.$img_name;
        $car_image->move($up_location,$img_name);


        $validator = Validator::make($request->all(), [ 
            'active' => 'required',
            'car_number' => 'required',
            'type' => 'required',
            'category' => 'required',
            'owner_id' => 'required',
            'zip' => 'required',
            'country' => 'required',
            'state' => 'required',

        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
     }
    
         Car::insert(['car_id'=>$car_id,
        'active'=>$request->active,
        'car_number'=>$request->car_number,
        'type'=>$request->type,
        'category'=>$request->category,
        'owner_id'=>$request->owner_id,
        'zip'=>$request->zip,
        'country'=>$request->country,
        'state'=>$request->state,
        'image'=>$last_img,
        'user_id'=>$request->user_id,
        'created_at'=>Carbon::now()
    ]);
     
     $Car=Car::latest()->first();
 
 return response()->json(['success'=>$Car]);

    }

    public function UpdateCar(Request $request,$car_id){

        $old_img=Car::where('car_id',$car_id)->first();
        $car_image=$request->file('image');
        
        if($car_image){
            $name_gen=hexdec(uniqid());
            $img_ext=strtolower($car_image->getClientOriginalExtension());
            $img_name=$name_gen.'.'.$img_ext;
            $up_location='image/cars/';
            $last_img=$up_location.$img_name;
            $car_image->move($up_location,$img_name);
    
            unlink($old_img->image);
 
            $Car=Car::where('car_id',$car_id)->update([ 
            'active'=>$request->active,
            'car_number'=>$request->car_number,
            'type'=>$request->type,
            'category'=>$request->category,
            'owner_id'=>$request->owner_id,
            'zip'=>$request->zip,
            'country'=>$request->country,
            'state'=>$request->state,
            'image'=>$last_img,
            'user_id'=>$request->user_id,
            'created_at'=>Carbon::now()
]);
        }
        else{

            $Car=Car::where('car_id',$car_id)->update([ 
                'active'=>$request->active,
                'car_number'=>$request->car_number,
                'type'=>$request->type,
                'category'=>$request->category,
                'owner_id'=>$request->owner_id,
                'zip'=>$request->zip,
                'country'=>$request->country,
                'state'=>$request->state,
                'user_id'=>$request->user_id,
                'created_at'=>Carbon::now()
    ]);
        }

$Car=Car::where('car_id',$car_id)->get();
return response()->json(['UPDATED SUCCESSFULLY','car'=>$Car]);

    }

    public function ActiveCars(Request $request,$user_id){
        
    if ( Auth::check()) {
        $Active_Cars=Car::where('user_id',$user_id)->where('active','=','True')->get('car_id');
        return response()->json(['ACTIVE CARS','car'=>$Active_Cars]);
    }}
}
