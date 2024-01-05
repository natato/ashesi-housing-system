<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\Occupant;
use App\RoomAssignment;
use App\SemesterRoomAssignment;
use App\Room;
use App\Semester;
use App\Year;
use DB;
class RoomAssignmentController extends Controller
{
	public function addRoomAssignment(Request $request){
		$occupants=Occupant::all()->pluck("occupantId");
		$valid_occupants=array();
		$occupantid=$request->input('occupantid');
		foreach($occupants as $ocp){
			array_push($valid_occupants,$ocp);
		}
		$rooms=Room::all()->pluck("roomId");
		$valid_rooms=array();
		$roomid=$request->input('roomid');
		foreach($rooms as $r){
			array_push($valid_rooms,$r);
		}
		$semesters=Semester::all()->pluck("semester_id");
		$valid_semesters=array();
		$semester_id=$request->input('semester_id');
		foreach($semesters as $s){
			array_push($valid_semesters,$s);
		}
		$years=Year::all()->pluck("year_id");
		$valid_years=array();
		$year_id=$request->input('year_id');
		foreach($years as $y){
			array_push($valid_years,$y);
		}
		if(!$this->validate($request,[
			'occupantid'=>'required | max:8 | min:8',
			'roomid'=>'required',
			'keynumber'=>'required',
			'date_moved_in'=>'required | date',
			'remarks'=>'required',
			'semester_id'=>'required',
			'year_id'=>'required',
		])){
			return response()->json(['status' => 'fail','message'=>'Add required parameters' ],401);
		}
		else if(!in_array($occupantid,$valid_occupants)){
			return response()->json(['status' => 'fail','message'=>'Invalid Occupant id' ],401);
		}
		else if(!in_array($roomid,$valid_rooms)){
			return response()->json(['status' => 'fail','message'=>'Invalid Room id' ],401);
		}
		else if(!in_array($semester_id,$valid_semesters)){
			return response()->json(['status' => 'fail','message'=>'Invalid Semester id' ],401);
		}
		else if(!in_array($year_id,$valid_years)){
			return response()->json(['status' => 'fail','message'=>'Invalid Semester id' ],401);
		}
		else{
			$keynumber=$request->input('keynumber');
			$date_moved_in=$request->input('date_moved_in');
			$remarks=$request->input('remarks');
			RoomAssignment::insert(
				array(
					'occupantId'=>$occupantid,
					'roomId'=>$roomid,
					'keyNumber'=>$keynumber,
					'date_moved_in'=>$date_moved_in,
					'remarks'=>$remarks,
					'isDeleted'=>0,
					'current'=>1,
					'archived'=>0,
					'status'=>"active"
				)
			);
			$r=Room::find($roomid);
			$current_no_of_beds=$r->current_no_of_beds+1;
			$r->current_no_of_beds=$current_no_of_beds;
			$r->save();
			$Id=RoomAssignment::where("occupantId","=",$occupantid)->
				where("roomId","=",$roomid)->
				where("date_moved_in","=",$date_moved_in." 00:00:00")->
				select("roomAssignmentId")->first();
			$roomAssignmentId=$Id->roomAssignmentId;
			SemesterRoomAssignment::insert(
				array(
					'room_assignment_id'=>$roomAssignmentId,
					'semester_id'=>$semester_id,
					'year_id'=>$year_id
				)
			);
			return response()->json(['status' => 'success' ],200);
		}
	}
	public function getCurrentRoomAssignments(Request $request){
		$roomassignments=RoomAssignment::join("rooms","room_assignment.roomId","=","rooms.roomId")
			->join("occupants","room_assignment.occupantId","=","occupants.occupantId")
			->where("room_assignment.current",1)
			->where("room_assignment.archived",0)
			->select("rooms.roomId","rooms.roomName","occupants.firstname","occupants.occupantId","occupants.lastname","occupants.telephone","room_assignment.*")
			->orderByRaw(DB::raw("FIELD(rooms.roomName,occupants.firstname,occupants.lastname) ASC"))
			->get();
		if($roomassignments)
			return response()->json($roomassignments,200);
         return response()->json(['status' => 'fail','message'=>'No data' ],401);
	}
	public function getOccupantRoomAssignment(Request $request){
		$occupantid=$request->input("occupantid");
		if(!$this->validate($request,[
			'occupantid'=>'required | max:8 | min:8',
		])){
			return response()->json(['status' => 'fail','message'=>'Add required parameters' ],401);
		}
		$roomassignments=RoomAssignment::join("rooms","room_assignment.roomId","=","rooms.roomId")
			->join("occupants","room_assignment.occupantId","=","occupants.occupantId")
			->where("room_assignment.current",1)
			->where("room_assignment.archived",0)
			->where("room_assignment.occupantId",$occupantid)
			->select("rooms.roomId","rooms.roomName","occupants.firstname","occupants.occupantId","occupants.lastname","occupants.telephone","room_assignment.*")
			->orderByRaw(DB::raw("FIELD(rooms.roomName,occupants.firstname,occupants.lastname) ASC"))
			->first();
		if($roomassignments)
			return response()->json($roomassignments,200);
         return response()->json(['status' => 'fail','message'=>'Invalid Occupant Id' ],401);
	}
	public function getRoomAssignment(Request $request){
		$roomassignment_id=$request->input("roomassignment_id");
		$roomassignments=RoomAssignment::all()->pluck("roomAssignmentId");
		$valid_roomassignments=array();
		foreach($roomassignments as $ra){
			array_push($valid_roomassignments,$ra);
		}
		if(!in_array($roomassignment_id,$valid_roomassignments)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Room Assignment Id' ],401);
		}
		else{
			$roomassignment=RoomAssignment::find($roomassignment_id);
			return response()->json($roomassignment,200);
		}
	}
	public function editRoomAssignment(Request $request){
		$roomassignment_id=$request->input("roomassignment_id");
		$roomassignments=RoomAssignment::all()->pluck("roomAssignmentId");
		$valid_roomassignments=array();
		foreach($roomassignments as $ra){
			array_push($valid_roomassignments,$ra);
		}
		$occupants=Occupant::all()->pluck("occupantId");
		$valid_occupants=array();
		$occupantid=$request->input('occupantid');
		foreach($occupants as $ocp){
			array_push($valid_occupants,$ocp);
		}
		$rooms=Room::all()->pluck("roomId");
		$valid_rooms=array();
		$roomid=$request->input('roomid');
		foreach($rooms as $r){
			array_push($valid_rooms,$r);
		}
		$semesters=Semester::all()->pluck("semester_id");
		$valid_semesters=array();
		$semester_id=$request->input('semester_id');
		foreach($semesters as $s){
			array_push($valid_semesters,$s);
		}
		$years=Year::all()->pluck("year_id");
		$valid_years=array();
		$year_id=$request->input('year_id');
		foreach($years as $y){
			array_push($valid_years,$y);
		}
		if(!$this->validate($request,[
			'roomassignment_id'=>'required',
			'occupantid'=>'required | max:8 | min:8',
			'roomid'=>'required',
			'keynumber'=>'required',
			'date_moved_in'=>'required | date',
			'remarks'=>'required',
			'semester_id'=>'required',
			'year_id'=>'required'
		])){
			return response()->json(['status' => 'fail','message'=>'Add required parameters' ],401);
		}
		else if(!in_array($roomassignment_id,$valid_roomassignments)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Room Assignment Id' ],401);
		}
		else if(!in_array($occupantid,$valid_occupants)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Occupant Id' ],401);
		}
		else if(!in_array($roomid,$valid_rooms)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Room Id' ],401);
		}
		else if(!in_array($semester_id,$valid_semesters)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Semester Id' ],401);
		}
		else if(!in_array($year_id,$valid_years)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Year Id' ],401);
		}
		else{
			$date_moved_in=$request->input("date_moved_in");
			$roomassignment=RoomAssignment::find($roomassignment_id);
			$sra=SemesterRoomAssignment::where("room_assignment_id",$roomassignment->roomAssignmentId)
			->select("semester_room_assignments.*")
			->first();
			$sra->semester_id=$semester_id;
			$sra->year_id=$year_id;
			$sra->save();
			$roomassignment->occupantId=$occupantid;
			$roomassignment->roomId=$roomid;
			$roomassignment->keyNumber=$request->input("keynumber");
			$roomassignment->remarks=$request->input("remarks");
			$roomassignment->date_moved_in=$date_moved_in;
			$roomassignment->isDeleted=0;
			$roomassignment->status="active";
			$roomassignment->archived=0;
			$roomassignment->current=1;
			$roomassignment->save();
			return response()->json($roomassignment,200);
		}
	}
	public function editSettings(Request $request){
		$roomassignment_id=$request->input("roomassignment_id");
		$roomassignments=RoomAssignment::all()->pluck("roomAssignmentId");
		$valid_roomassignments=array();
		foreach($roomassignments as $ra){
			array_push($valid_roomassignments,$ra);
		}
		$isDeleted=$request->input("isDeleted");
		$archived=$request->input("archived");
		$current=$request->input("current");
		$valid_settings=array(0,1);
		$status=$request->input("status");
		$valid_status=array("active","inactive");
		if(!$this->validate($request,[
			'roomassignment_id'=>'required',
			'status'=>'required',
			'isDeleted'=>'required',
			'archived'=>'required',
			'current'=>'required'
		])){
			return response()->json(['status' => 'fail','message'=>'Add required parameters' ],401);
		}
		else if(!in_array($roomassignment_id,$valid_roomassignments)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Room Assignment Id' ],401);
		}
		else if(!in_array($status,$valid_status)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Status value' ],401);
		}
		else if(!in_array($isDeleted,$valid_settings)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Deleted value' ],401);
		}
		else if(!in_array($archived,$valid_settings)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Archived value' ],401);
		}
		else if(!in_array($current,$valid_settings)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Current value' ],401);
		}
		else{
			$ra=RoomAssignment::find($roomassignment_id);
			$ra->status=$status;
			$ra->isDeleted=$isDeleted;
			$ra->archived=$archived;
			$ra->current=$current;
			$ra->save();
			return response()->json($ra,200);
		}
	}
	public function deleteRoomAssignment(Request $request){
		$id=$request->input("roomassignment_id");
		$ra=RoomAssignment::find($id);
		if($ra==null){
			 return response()->json(['status' => 'fail','message'=>'Invalid Room Assignment  Id' ],401);
		}
		$room=Room::find($ra->roomId);
		$no_of_beds=$room->current_no_of_beds;
		$room->current_no_of_beds=$no_of_beds-1;
		$room->save();
		RoomAssignment::where('roomAssignmentId','=',$id)->delete();
		SemesterRoomAssignment::where("room_assignment_id","=",$id)->delete();
		return response()->json(['status' => 'success' ],200);
	}
	public function getPreviousRoomAssignments(Request $request){
		$semesters=Semester::all()->pluck("semester_id");
		$valid_semesters=array();
		$semester_id=$request->input('semester_id');
		foreach($semesters as $s){
			array_push($valid_semesters,$s);
		}
		$years=Year::all()->pluck("year_id");
		$valid_years=array();
		$year_id=$request->input('year_id');
		foreach($years as $y){
			array_push($valid_years,$y);
		}
		if(!$this->validate($request,[
			'semester_id'=>'required',
			'year_id'=>'required'
		])){
			return response()->json(['status' => 'fail','message'=>'Add required parameters' ],401);
		}
		else if(!in_array($semester_id,$valid_semesters)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Semester Id' ],401);
		}
		else if(!in_array($year_id,$valid_years)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Year Id' ],401);
		}
		else{
			$pra=RoomAssignment::join("semester_room_assignments","room_assignment.roomAssignmentId","=","semester_room_assignments.room_assignment_id")
				->join("occupants","room_assignment.occupantId","=","occupants.occupantId")
				->join("rooms","room_assignment.roomId","=","rooms.roomId")
				->select("rooms.roomName","occupants.firstname","occupants.lastname","occupants.telephone","room_assignment.*")
				->where("room_assignment.current","=",0)
				->where("room_assignment.archived","=",1)
				->where("room_assignment.status","=","inactive")
				->where("room_assignment.isDeleted","=",1)
				->where("semester_room_assignments.semester_id","=",$semester_id)
				->where("semester_room_assignments.year_id","=",$year_id)
				->get();
			if(count($pra)>0)
				return response()->json($pra,200);
			 return response()->json(['status' => 'fail','message'=>'No data' ],401);
		}
	}

}
