<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\Hostel;
class HostelController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function addHostel(Request $request){
        $hostelName=$request->input("hostelname");
        $description=$request->input("description");
        $no_of_rooms=$request->input("no_of_rooms");
        if(empty($hostelName)){
            return response()->json(['status' => 'fail','message'=>'No Hostel name' ],401);
        }
        else if(empty($description)){
            return response()->json(['status' => 'fail','message'=>'No description' ],401);
        }
        else if(empty($no_of_rooms) || $no_of_rooms<=0){
            return response()->json(['status' => 'fail','message'=>'Invalid number of rooms value' ],401);
        }
        else{
            Hostel::insert(
                array(
                    "hostelName"=>$hostelName,
                    "hostelDescription"=>$description,
                    "current_no_of_rooms"=>$no_of_rooms,
                    "status"=>"active",
                    "isDeleted"=>0
                )
            );
             return response()->json(['status' => 'success' ],200);
        }
     
    }
    public function getHostels(){
        $hostels=Hostel::all();
        if($hostels)
              return response()->json($hostels,200);
         return response()->json(['status' => 'fail','message'=>'No data' ],401); 
    }
    public function getHostel(Request $request){
        $id=$request->input("hostelid");
         if(empty($id) || $id<=0){
            return response()->json(['status' => 'fail','message'=>'Invalid Hostel id' ],401);
        }
        else{
            $hostel=Hostel::find($id);
            if($hostel)
                return response()->json($hostel,200);
             return response()->json(['status' => 'fail','message'=>'No data' ],401);
        }    
    }
    public function editHostelName(Request $request){
        $id=$request->input("hostelid");
        $hostelName=$request->input("hostelname");
        if(empty($id) || $id<=0){
            return response()->json(['status' => 'fail','message'=>'Invalid Hostel id' ],401);
        }
        else if(empty($hostelName)){
            return response()->json(['status' => 'fail','message'=>'No Hostel name' ],401);
        }
        else{
            $hostel=Hostel::find($id);
            if($hostel){
                $hostel->hostelName=$hostelName;
                $hostel->save();
                $hostel=Hostel::find($id);
                return response()->json($hostel,200);
            }
            return response()->json(['status' => 'fail','message'=>'No data' ],401);
        } 
    }
    public function editHostelDescription(Request $request){
        $id=$request->input("hostelid");
        $hostelDescription=$request->input("hosteldescription");
        if(empty($id) || $id<=0){
            return response()->json(['status' => 'fail','message'=>'Invalid Hostel id' ],401);
        }
        else if(empty($hostelDescription)){
            return response()->json(['status' => 'fail','message'=>'No Hostel description' ],401);
        }
        else{
            $hostel=Hostel::find($id);
            if($hostel){
                $hostel->hostelDescription=$hostelDescription;
                $hostel->save();
                $hostel=Hostel::find($id);
                return response()->json($hostel,200);
            }
            return response()->json(['status' => 'fail','message'=>'No data' ],401);
        }    
    }
    public function editNumberOfRooms(Request $request){
        $id=$request->input("hostelid");
        $no_of_rooms=$request->input("no_of_rooms");
        if(empty($id) || $id<=0){
            return response()->json(['status' => 'fail','message'=>'Invalid Hostel id' ],401);
        }
        else if(empty($no_of_rooms) || $no_of_rooms<=0){
            return response()->json(['status' => 'fail','message'=>'Invalid number of rooms value' ],401);
        }
        else{
            $hostel=Hostel::find($id);
            if($hostel){
                $hostel->current_no_of_rooms=$no_of_rooms;
                $hostel->save();
                $hostel=Hostel::find($id);
                return response()->json($hostel,200);
            }
            return response()->json(['status' => 'fail','message'=>'No data' ],401);
        }    
    }

}
