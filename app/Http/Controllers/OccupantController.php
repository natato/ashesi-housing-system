<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\Occupant;
class OccupantController extends Controller
{
	public function addOccupant(Request $request){
		$gender=$request->input("gender");
		$genders=array("male","female");
		if(!$this->validate($request,[
			'occupantid'=>'required | max:8 | min:8',
			'firstname'=>'required',
			'lastname'=>'required',
			'email'=>'required | email',
			'remarks'=>'required',
			'gender'=>'required'
		])){
			return response()->json(['status' => 'fail','message'=>'Add required parameters' ],401);
		}
		else if(!in_array($gender,$genders)){
			return response()->json(['status' => 'fail','message'=>'Invalid Gender value' ],401);
		}
		else{
			$occupantid=$request->input('occupantid');
			$firstname=$request->input('firstname');
			$lastname=$request->input('lastname');
			$email=$request->input('email');
			$remarks=$request->input('remarks');
			$c=Occupant::find($occupantid);
			if($c==null){
				Occupant::insert(
					array(
						'occupantId'=>$occupantid,
						'firstname'=>$firstname,
						'lastname'=>$lastname,
						'email'=>$email,
						'remarks'=>$remarks,
						'isDeleted'=>0,
						'gender'=>$gender,
						'image'=>''
					)
				);
			}
			else{
				return response()->json(['status' => 'fail','message'=>'Occupant Id alraedy exists' ],401);
			}
			return response()->json(['status' => 'success' ],200);
		}
	}
	public function getOccupants(Request $request){
		$occupants=Occupant::all();
		if($occupants)
			return response()->json($occupants,200);
         return response()->json(['status' => 'fail','message'=>'No data' ],401);
	}
	public function getOccupant(Request $request){
		$occupantid=$request->input("occupantid");
		$occupant=Occupant::find($occupantid);
		if($occupant)
			return response()->json($occupant,200);
         return response()->json(['status' => 'fail','message'=>'Invalid Occupant Id' ],401);
	}
	public function editFirstName(Request $request){
		$occupantid=$request->input("occupantid");
		$occupants=Occupant::all()->pluck("occupantId");
		$valid_occupants=array();
		$firstname=$request->input("firstname");
		foreach($occupants as $ocp){
			array_push($valid_occupants,$ocp);
		}
		if(empty($occupantid) || !in_array($occupantid,$valid_occupants)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Occupant Id' ],401);
		}
		else if(empty($firstname)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Firstname value' ],401);
		}
		else{
			$occupant=Occupant::find($occupantid);
			$occupant->firstname=$firstname;
			$occupant->save();
			return response()->json($occupant,200);
		}
	}
	public function editLastName(Request $request){
		$occupantid=$request->input("occupantid");
		$occupants=Occupant::all()->pluck("occupantId");
		$valid_occupants=array();
		$lastname=$request->input("lastname");
		foreach($occupants as $ocp){
			array_push($valid_occupants,$ocp);
		}
		if(empty($occupantid) || !in_array($occupantid,$valid_occupants)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Occupant Id' ],401);
		}
		else if(empty($lastname)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Lastname value' ],401);
		}
		else{
			$occupant=Occupant::find($occupantid);
			$occupant->lastname=$lastname;
			$occupant->save();
			return response()->json($occupant,200);
		}
	}
	public function editEmail(Request $request){
		$occupantid=$request->input("occupantid");
		$occupants=Occupant::all()->pluck("occupantId");
		$valid_occupants=array();
		$email=$request->input("email");
		foreach($occupants as $ocp){
			array_push($valid_occupants,$ocp);
		}
		if(empty($occupantid) || !in_array($occupantid,$valid_occupants)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Occupant Id' ],401);
		}
		else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Email value' ],401);
		}
		else{
			$occupant=Occupant::find($occupantid);
			$occupant->email=$email;
			$occupant->save();
			return response()->json($occupant,200);
		}
	}
	public function editRemarks(Request $request){
		$occupantid=$request->input("occupantid");
		$occupants=Occupant::all()->pluck("occupantId");
		$valid_occupants=array();
		$remarks=$request->input("remarks");
		foreach($occupants as $ocp){
			array_push($valid_occupants,$ocp);
		}
		if(empty($occupantid) || !in_array($occupantid,$valid_occupants)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Occupant Id' ],401);
		}
		else if(empty($remarks)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Remarks value' ],401);
		}
		else{
			$occupant=Occupant::find($occupantid);
			$occupant->remarks=$remarks;
			$occupant->save();
			return response()->json($occupant,200);
		}
	}
	public function editStatus(Request $request){
		$occupantid=$request->input("occupantid");
		$occupants=Occupant::all()->pluck("occupantId");
		$valid_occupants=array();
		$status=$request->input("status");
		$valid_status=array("active","inactive");
		foreach($occupants as $ocp){
			array_push($valid_occupants,$ocp);
		}
		if(empty($occupantid) || !in_array($occupantid,$valid_occupants)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Occupant Id' ],401);
		}
		else if(!in_array($status,$valid_status)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Status value' ],401);
		}
		else{
			$occupant=Occupant::find($occupantid);
			$occupant->status=$status;
			$occupant->save();
			return response()->json($occupant,200);
		}
	}
	public function editIsDeleted(Request $request){
		$occupantid=$request->input("occupantid");
		$occupants=Occupant::all()->pluck("occupantId");
		$valid_occupants=array();
		$is_deleted=$request->input("is_deleted");
		$valid_is_deleted=array(0,1);
		foreach($occupants as $ocp){
			array_push($valid_occupants,$ocp);
		}
		if(empty($occupantid) || !in_array($occupantid,$valid_occupants)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Occupant Id' ],401);
		}
		else if(empty($is_deleted) || !in_array($is_deleted,$valid_is_deleted)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Deleted value' ],401);
		}
		else{
			$occupant=Occupant::find($occupantid);
			$occupant->isDeleted=$is_deleted;
			$occupant->save();
			return response()->json($occupant,200);
		}
	}
	public function editGender(Request $request){
		$occupantid=$request->input("occupantid");
		$occupants=Occupant::all()->pluck("occupantId");
		$valid_occupants=array();
		$gender=$request->input("gender");
		$valid_gender=array("male","female");
		foreach($occupants as $ocp){
			array_push($valid_occupants,$ocp);
		}
		if(empty($occupantid) || !in_array($occupantid,$valid_occupants)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Occupant Id' ],401);
		}
		else if(empty($gender) || !in_array($gender,$valid_gender)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Gender value' ],401);
		}
		else{
			$occupant=Occupant::find($occupantid);
			$occupant->gender=$gender;
			$occupant->save();
			return response()->json($occupant,200);
		}
	}
	public function editPhoneNumber(Request $request){
		$occupantid=$request->input("occupantid");
		$occupants=Occupant::all()->pluck("occupantId");
		$valid_occupants=array();
		$phone_number=$request->input("phone_number");
		foreach($occupants as $ocp){
			array_push($valid_occupants,$ocp);
		}
		if(empty($occupantid) || !in_array($occupantid,$valid_occupants)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Occupant Id' ],401);
		}
		else if(!preg_match('/^[0-9]{10}+$/', $phone_number)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Phone Number value' ],401);
		}
		else{
			$occupant=Occupant::find($occupantid);
			$occupant->telephone=$phone_number;
			$occupant->save();
			return response()->json($occupant,200);
		}
	}
	public function editImageLink(Request $request){
		$occupantid=$request->input("occupantid");
		$occupants=Occupant::all()->pluck("occupantId");
		$valid_occupants=array();
		$image_link=$request->input("image_link");
		foreach($occupants as $ocp){
			array_push($valid_occupants,$ocp);
		}
		if(empty($occupantid) || !in_array($occupantid,$valid_occupants)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Occupant Id' ],401);
		}
		else if(empty($image_link)){
			 return response()->json(['status' => 'fail','message'=>'Invalid Image Link value' ],401);
		}
		else{
			$occupant=Occupant::find($occupantid);
			$occupant->image=$image_link;
			$occupant->save();
			return response()->json($occupant,200);
		}
	}

}
