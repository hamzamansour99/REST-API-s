<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Validator;
use App\Models\ContactUs; 

class ContactUsController extends Controller
{
    public $successStatus = 200;
    public function Contact(Request $request){

        $validator = Validator::make($request->all(), [ 
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'message' => 'required'
        ]);

        if ($validator->fails()) { 
             return response()->json(['error'=>$validator->errors()], 401);            
 }
         
        $Data = ContactUs::create(['name'=>$request->name,
                                   'email'=>$request->email,
                                   'subject'=>$request->subject,
                                   'message'=>$request->message,
                                   'created_at'=>Carbon::now()
        ]);

        $Data=ContactUs::all();

        return response()->json(['Contact-info' => $Data], $this-> successStatus); 
        




    }
}
