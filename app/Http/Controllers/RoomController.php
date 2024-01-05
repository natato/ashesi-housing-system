<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\Room;
use App\Hostel;
class RoomController extends Controller
{
  
	public function addRoom(Request $request){
		$hostelId=$request->input("hostelid");
		$roomName=$request->input("roomName");
		$description=$request->input("description");
		$gender=$request->input("gender");
		$capacity=$request->input("capacity");
		$gender_vals=array("male","female");
		$hostels=Hostel::all()->pluck("hostelId");
		$valid_hostels=array();
		foreach($hostels as $vh){
			array_push($valid_hostels,$vh);
		}
		if(empty($hostelId) || !in_array($hostelId,$valid_hostels)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Hostel Id' ],401);
		}
		else if(empty($roomName)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Room name' ],401);
		}
		else if(empty($description)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Room description' ],401);
		}
		else if(empty($gender) || !in_array($gender, $gender_vals)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Gender value' ],401);
		}
		else if(empty($capacity) || $capacity<=0){
			 return response()->json(['status' => 'fail','message'=>'Invalid Capacity value' ],401);
		}
		else{
			Room::insert(
				array(
					"hostelId"=>$hostelId,
					"roomName"=>$roomName,
					"roomDescription"=>$description,
					"gender"=>$gender,
					"capacity"=>$capacity,
					"current_no_of_beds"=>0,
					"status"=>"active",
					"isDeleted"=>0,
					"no_of_reserved_beds"=>0,
					"no_of_beds_not_reserved"=>0

				)
			);
			 return response()->json(['status' => 'success' ],200);

		}
	}
	public function getRooms(Request $request){
		$rooms=Room::all();
		if($rooms)
			return response()->json($rooms,200);
         return response()->json(['status' => 'fail','message'=>'No data' ],401);
	}
	public function getRoom(Request $request){
		$roomid=$request->input("roomid");
		$rooms=Room::all()->pluck("roomId");
		$valid_rooms=array();
		foreach($rooms as $r){
			array_push($valid_rooms, $r);
		}
		if(empty($roomid) || !in_array($roomid, $valid_rooms)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Room id' ],401);
		}
		else{
			$room = Room::find($roomid);
			return response()->json($room,200); 
		}
	}
	public function editRoomName(Request $request){
		$roomid=$request->input("roomid");
		$roomName=$request->input("newRoomName");
		$rooms=Room::all()->pluck("roomId");
		$valid_rooms=array();
		foreach($rooms as $r){
			array_push($valid_rooms, $r);
		}
		if(empty($roomid) || !in_array($roomid, $valid_rooms)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Room id' ],401);
		}
		else if(empty($roomName)){
			return response()->json(['status' => 'fail','message'=>'Invalid Room name' ],401);
		}
		else{
			$room = Room::find($roomid);
			$room->roomName=$roomName;
			$room->save();
			return response()->json($room,200); 
		}

	}
	public function editRoomDescription(Request $request){
		$roomid=$request->input("roomid");
		$roomDescription=$request->input("newRoomDescription");
		$rooms=Room::all()->pluck("roomId");
		$valid_rooms=array();
		foreach($rooms as $r){
			array_push($valid_rooms, $r);
		}
		if(empty($roomid) || !in_array($roomid, $valid_rooms)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Room id' ],401);
		}
		else if(empty($roomDescription)){
			return response()->json(['status' => 'fail','message'=>'Invalid Room description' ],401);
		}
		else{
			$room = Room::find($roomid);
			$room->roomDescription=$roomDescription;
			$room->save();
			return response()->json($room,200); 
		}
	}
	public function editCurrentNoOfBeds(Request $request){
		$roomid=$request->input("roomid");
		$currentNoOfBeds=$request->input("currentNoOfBeds");
		$rooms=Room::all()->pluck("roomId");
		$valid_rooms=array();
		foreach($rooms as $r){
			array_push($valid_rooms, $r);
		}
		if(empty($roomid) || !in_array($roomid, $valid_rooms)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Room id' ],401);
		}
		else if(empty($currentNoOfBeds) || $currentNoOfBeds<0){
			return response()->json(['status' => 'fail','message'=>'Invalid Value for Current No of beds' ],401);
		}
		else{
			$room = Room::find($roomid);
			$room->current_no_of_beds=$currentNoOfBeds;
			$room->save();
			return response()->json($room,200); 
		}
	}
	public function editStatus(Request $request){
		$roomid=$request->input("roomid");
		$newStatus=$request->input("newStatus");
		$rooms=Room::all()->pluck("roomId");
		$status_vals=array("active","inactive","reserved for freshmen");
		$valid_rooms=array();
		foreach($rooms as $r){
			array_push($valid_rooms, $r);
		}
		if(empty($roomid) || !in_array($roomid, $valid_rooms)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Room id' ],401);
		}
		else if(empty($newStatus) || !in_array($newStatus, $status_vals)){
			return response()->json(['status' => 'fail','message'=>'Invalid Status value' ],401);
		}
		else{
			$room = Room::find($roomid);
			$room->status=$newStatus;
			$room->save();
			return response()->json($room,200); 
		}
	}
	public function editGender(Request $request){
		$roomid=$request->input("roomid");
		$newGender=$request->input("newGender");
		$rooms=Room::all()->pluck("roomId");
		$gender_vals=array("male","female");
		$valid_rooms=array();
		foreach($rooms as $r){
			array_push($valid_rooms, $r);
		}
		if(empty($roomid) || !in_array($roomid, $valid_rooms)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Room id' ],401);
		}
		else if(empty($newGender) || !in_array($newGender, $gender_vals)){
			return response()->json(['status' => 'fail','message'=>'Invalid Gender value' ],401);
		}
		else{
			$room = Room::find($roomid);
			$room->gender=$newGender;
			$room->save();
			return response()->json($room,200); 
		}
	}
	public function editCapacity(Request $request){
		$roomid=$request->input("roomid");
		$newCapacity=$request->input("newCapacity");
		$rooms=Room::all()->pluck("roomId");
		$valid_rooms=array();
		foreach($rooms as $r){
			array_push($valid_rooms, $r);
		}
		if(empty($roomid) || !in_array($roomid, $valid_rooms)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Room id' ],401);
		}
		else if(empty($newCapacity)|| $newCapacity<=0 ){
			return response()->json(['status' => 'fail','message'=>'Invalid Capacity value' ],401);
		}
		else{
			$room = Room::find($roomid);
			$room->capacity=$newCapacity;
			$room->save();
			return response()->json($room,200); 
		}
	}
	public function editNoofBedsreserved(Request $request){
		$roomid=$request->input("roomid");
		$newNoOfBedsReserved=$request->input("newNoOfBedsReserved");
		$rooms=Room::all()->pluck("roomId");
		$valid_rooms=array();
		foreach($rooms as $r){
			array_push($valid_rooms, $r);
		}
		if(empty($roomid) || !in_array($roomid, $valid_rooms)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Room id' ],401);
		}
		else if($newNoOfBedsReserved < 0 ){
			return response()->json(['status' => 'fail','message'=>'Invalid value for No of Beds reserved' ],401);
		}
		else{
			$room = Room::find($roomid);
			$room->no_of_reserved_beds=$newNoOfBedsReserved;
			$room->save();
			return response()->json($room,200); 
		}
	}

	public function deleteRoom(Request $request){
		$roomid=$request->input("roomid");
		$rooms=Room::all()->pluck("roomId");
		$valid_rooms=array();
		foreach($rooms as $r){
			array_push($valid_rooms, $r);
		}
		if(empty($roomid) || !in_array($roomid, $valid_rooms)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Room id' ],401);
		}
		else{
			Room::where("roomId",$roomid)->delete();
			return response()->json(["status"=>"success"],200);
		}
	}

}
