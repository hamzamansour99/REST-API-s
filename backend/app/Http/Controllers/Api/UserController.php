<?php
 
namespace App\Http\Controllers\Api;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash; 
 
class UserController extends Controller
{
    public $successStatus = 200;
 /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('Capstone')-> accessToken; 
            $success['id'] = $user->id;
            $success['role'] =  $user->role;
            return response()->json(['success' => $success], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }
 
 /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
    
        $validator = Validator::make($request->all(), [ 
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'community_type'=>'required',
            'community_name'=>'required'

        ]);
        if ($validator->fails()) { 
             return response()->json(['error'=>$validator->errors()], 401);            
 }
   
        $user = User::create(['first_name'=>$request->first_name,
                              'last_name'=>$request->last_name,
                              'email'=>$request->email,
                              'role'=>$request->role,
                              'password' => bcrypt($request->password),
                              'community_type'=>$request->community_type,
                              'community_name'=>$request->community_name,
                              'created_at'=>Carbon::now()
    ]); 
        $success['token'] =  $user->createToken('Capstone')-> accessToken; 
        $success['first_name'] = $user->first_name;
        $success['last_name'] =  $user->last_name;
        $success['role'] =  $user->role;
        $success['id'] =  $user->id;

 return response()->json(['success'=>$success], $this-> successStatus); 
    }
 
 /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function userDetails($id) 
    { 
        
        $user=User::with('Car')->get()->where('id',$id);
         
        return response()->json(['success', 'user' => $user], $this-> successStatus);  

    }

    public function UpdateUser(Request $request,$id){

        $old_img=User::where('id',$id)->first();
        $user_image=$request->file('image');

        if($old_img->image===null && $user_image){
            
                $name_gen=hexdec(uniqid());
                $img_ext=strtolower($user_image->getClientOriginalExtension());
                $img_name=$name_gen.'.'.$img_ext;
                $up_location='image/users/';
                $last_img=$up_location.$img_name;
                $user_image->move($up_location,$img_name);
    
                $user=User::find($id)->update([ 'first_name'=>$request->first_name,
                'last_name'=>$request->last_name,
                'email'=>$request->email,
                'role'=>$request->role,
                'community_type'=>$request->community_type,
                'community_name'=>$request->community_name,
                'image'=>$last_img,
                'created_at'=>Carbon::now()
    ]);
                        
        
        }

        elseif($old_img->image!=null && $user_image){

                $name_gen=hexdec(uniqid());
                $img_ext=strtolower($user_image->getClientOriginalExtension());
                $img_name=$name_gen.'.'.$img_ext;
                $up_location='image/users/';
                $last_img=$up_location.$img_name;
                $user_image->move($up_location,$img_name);
                unlink($old_img->image);
    
                $user=User::find($id)->update([ 'first_name'=>$request->first_name,
                'last_name'=>$request->last_name,
                'email'=>$request->email,
                'role'=>$request->role,
                'community_type'=>$request->community_type,
                'community_name'=>$request->community_name,
                'image'=>$last_img,
                'created_at'=>Carbon::now()
    ]);
        }
          

        else{
            $user=User::find($id)->update([ 'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'email'=>$request->email,
            'role'=>$request->role,
            'community_type'=>$request->community_type,
            'community_name'=>$request->community_name,
            'created_at'=>Carbon::now()
]);
        }          
    
$user=User::where('id',$id)->get();
 return response()->json(['UPDATED SUCCESSFULLY','user'=>$user]);

    }
    public function ChangePassword(Request $request,$id){
 ;
    $validator = Validator::make($request->all(), [
                                'old_password'=>'required',
                                'password'=>'required',
                                'confirm_password' => 'required|same:password']);

    $hashedPassword=User::where('id',$id)->first()->password;
    
    $old_password=$request->old_password;
    
    if(Hash::check($old_password,$hashedPassword)){

        $user=User::find($id)->update(['password' => bcrypt($request->password)]);
        
        return response()->json([' PASSWORD UPDATED SUCCESSFULLY']);  
    }
    else{
        return response()->json([' CURRENT PASSWORD INVALID']);
 
    }
    }
    
    
    public function logout(){
    auth()->user()->token()->revoke();

    return response()->json(['message' => 'Successfully logged out'],200);
}

    
}