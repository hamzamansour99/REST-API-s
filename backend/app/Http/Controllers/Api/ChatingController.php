<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Carbon;
use App\Models\chat;
use App\Models\message;

class ChatingController extends Controller
{
    public $successStatus = 200;
    public function PostId(Request $request){

        $validator = Validator::make($request->all(), [ 
            'user_id' => 'required',
            'driver_id' => 'required',
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
     }
        chat::insert([
        'user_id'=>$request->user_id,
        'driver_id'=>$request->driver_id,
        'created_at'=>Carbon::now()
    ]);
    $chat=chat::latest()->first();

    return response()->json(['chats'=>$chat]);


    }

    public function message(Request $request    ){

        $validator = Validator::make($request->all(), [ 
            'user_id' => 'required',
            'chat_id' => 'required',
            'chat_message' => 'required',
            'date' => 'required',
            'time' => 'required',
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
     }
        message::insert([
        'user_id'=>$request->user_id,
        'chat_id'=>$request->chat_id,
        'chat_message'=>$request->chat_message,
        'date'=>$request->date,
        'time'=>$request->time,
        'created_at'=>Carbon::now()
    ]);
    $message=message::with('User')->get()->last();
    return response()->json(['success', 'message' => $message], $this-> successStatus);
    }

    public function GetChat($id){

        $chat=message::with(['User'])
        ->get()
        ->where('chat_id',$id);
        return response()->json(['success', 'chat' => $chat], $this-> successStatus);  

    }
}
