<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
//use Hash;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use App\User;
class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function login(Request $request)
    {
        $email=$request->input("email");
        $password=$request->input("password");
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $user=User::where("email",$email)->first();
            if($user && Hash::check($password,$user->password)){
               
                return response()->json($user,200); 
            }
            else{
                return response()->json(['status' => 'fail','message'=>'Invalid email or password' ],401);
            }
        }
        else{
            return response()->json(['status' => 'fail','message'=>'Invalid email or password' ],401);
        }
      
    }
    public function addUser(Request $request){
        $name=$request->input("name");
        $email=$request->input("email");
        $role=$request->input("role");
        $password=$request->input("password");
        $roles=array("admin","hostel manager","sle");
        if(empty($name)){
            return response()->json(['status' => 'fail','message'=>'No name' ],401);
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return response()->json(['status' => 'fail','message'=>'Invalid email' ],401);
        }
        else if(!in_array($role,$roles)){
            return response()->json(['status' => 'fail','message'=>'Invalid role' ],401);
        }
        else if(empty($password)){
            return response()->json(['status' => 'fail','message'=>'No password' ],401);
        }
        else{
            $password=Hash::make($password);
             User::insert(
                array(
                    'name'=>$name,
                    'email'=>$email,
                    'role'=>$role,
                    'password'=>$password,
                    'image'=>' '
                )
            );
            return response()->json(['status' => 'success' ],200);
        }

       
    }
    public function getUsers(){
        $users=User::all();
        if($users)
            return response()->json($users,200);
         return response()->json(['status' => 'fail','message'=>'No data' ],401);
    }

    public function getUser(Request $request){
        $id=$request->input('id');
        $user=User::find($id);
        if($user){
             return response()->json($user,200); 
        }
        else{
            return response()->json(['status' => 'fail','message'=>'Wrong Id' ],401);
        }
    }
    public function editUserName(Request $request){
        $name=$request->input("name");
        $id=$request->input("id");
        $user=User::find($id);
        if($user){
            $user->name=$name;
            $user->save();
            return response()->json($user,200); 
        }
        else{
             return response()->json(['status' => 'fail','message'=>'Wrong Id' ],401);
        }
    }
    public function editUserRole(Request $request){
        $role=$request->input("role");
        $id=$request->input("id");
        $roles=array("admin","hostel manager","sle");
        $user=User::find($id);
        if($user){
            if(!in_array($role,$roles)){
                return response()->json(['status' => 'fail','message'=>'Invalid role' ],401);
            }
            else{
                $user->role=$role;
                $user->save();
                return response()->json($user,200); 
            }
        }
        else{
             return response()->json(['status' => 'fail','message'=>'Wrong Id' ],401);
        }
    }
    public function editUserPassword(Request $request){
        $newpassword=$request->input("newpassword");
        $id=$request->input("id");
        $user=User::find($id);
        if($user){
            if(empty($newpassword)){
                return response()->json(['status' => 'fail','message'=>'No password' ],401);
            }
            else{
                 $user->password=Hash::make($newpassword);
                $user->save();
                return response()->json($user,200);    
            }
        }
        else{
             return response()->json(['status' => 'fail','message'=>'Wrong Id' ],401);
        }
    }
    public function deleteUser(Request $request){
        $id=$request->input("id");
        $users=User::all()->pluck("id");
        $valid_users=array();
        foreach($users as $u){
            array_push($valid_users,$u);
        }
        if(empty($id) || !in_array($id, $valid_users)){
              return response()->json(['status' => 'fail','message'=>'Invalid User id' ],401);
        }
        else{
            User::where("id",$id)->delete();
             return response()->json(['status' => 'success' ],200);
        }    
    }
}
