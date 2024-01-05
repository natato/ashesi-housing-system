<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\Semester;
use App\Year;
class SemesterController extends Controller
{
  
	public function addYear(Request $request){
		$yearnumber=$request->input("year_number");
		if(empty($yearnumber) ){
			 return response()->json(['status' => 'fail','message'=>'Invalid Year value' ],401);
		}
		else{
			Year::insert(
				array(
					"year_number"=>$yearnumber
				)
			);
			return response()->json(['status' => 'success' ],200);
		}
	}
	public function getYears(Request $request){
		$years=Year::all();
		if($years)
			return response()->json($years,200);
         return response()->json(['status' => 'fail','message'=>'No data' ],401);
	}
	public function getYear(Request $request){
		$year_id=$request->input("year_id");
		$year=Year::find($year_id);
		if($year)
			return response()->json($year,200);
         return response()->json(['status' => 'fail','message'=>'Invalid Year Id' ],401);
	}
	public function editYear(Request $request){
		$year_id=$request->input("year_id");
		$year_number=$request->input("new_year");
		$years=Year::all()->pluck("year_id");
		$valid_years=array();
		foreach($years as $y){
			array_push($valid_years,$y);
		}
		if(empty($year_id) || !in_array($year_id,$valid_years)){
			return response()->json(['status' => 'fail','message'=>'Invalid Year Id' ],401);
		}
		else if(empty($year_number)){
			return response()->json(['status'=>'fail','message'=>'Invalid Year value'],401);
		}
		else{
			$year=Year::find($year_id);
			$year->year_number=$year_number;
			$year->save();
			return response()->json($year,200);
		}
	}
	public function deleteYear(Request $request){
		$year_id=$request->input("year_id");
		$years=Year::all()->pluck("year_id");
		$valid_years=array();
		foreach($years as $y){
			array_push($valid_years,$y);
		}
		if(empty($year_id) || !in_array($year_id,$valid_years)){
			return response()->json(['status' => 'fail','message'=>'Invalid Year Id' ],401);
		}
		else{
			$year=Year::where("year_id",$year_id)->delete();
			return response()->json(["status"=>"success"],200);
		}
	}

	public function addSemester(Request $request){
		$semester_name=$request->input("semester_name");
		$description=$request->input("description");
		if(empty($semester_name) ){
			 return response()->json(['status' => 'fail','message'=>'Invalid Semester name' ],401);
		}
		else if(empty($description) ){
			 return response()->json(['status' => 'fail','message'=>'Invalid description' ],401);
		}
		else{
			Semester::insert(
				array(
					"semester_name"=>$semester_name,
					"Description"=>$description
				)
			);
			return response()->json(['status' => 'success' ],200);
		}
	}
	public function getSemesters(Request $request){
		$semesters=Semester::all();
		if($semesters)
			return response()->json($semesters,200);
         return response()->json(['status' => 'fail','message'=>'No data' ],401);
	}
	public function getSemester(Request $request){
		$semester_id=$request->input("semester_id");
		$semester=Semester::find($semester_id);
		if($semester)
			return response()->json($semester,200);
         return response()->json(['status' => 'fail','message'=>'Invalid Semester id' ],401);
	}
	public function editSemester(Request $request){
		$semester_id=$request->input("semester_id");
		$semester_name=$request->input("new_semester_name");
		$description=$request->input("new_description");
		$semesters=Semester::all()->pluck("semester_id");
		$valid_semesters=array();
		foreach($semesters as $s){
			array_push($valid_semesters,$s);
		}
		if(empty($semester_id) || !in_array($semester_id,$valid_semesters)){
			return response()->json(['status' => 'fail','message'=>'Invalid Semester id' ],401);
		}
		else if(empty($semester_name)){
			return response()->json(['status'=>'fail','message'=>'Invalid Semester name'],401);
		}
		else if(empty($description)){
			return response()->json(['status'=>'fail','message'=>'Invalid Description'],401);
		}
		else{
			$semester=Semester::find($semester_id);
			$semester->semester_name=$semester_name;
			$semester->Description=$description;
			$semester->save();
			return response()->json($semester,200);
		}
	}
	public function deleteSemester(Request $request){
		$semester_id=$request->input("semester_id");
		$semesters=Semester::all()->pluck("semester_id");
		$valid_semesters=array();
		foreach($semesters as $s){
			array_push($valid_semesters,$s);
		}
		if(empty($semester_id) || !in_array($semester_id,$valid_semesters)){
			return response()->json(['status' => 'fail','message'=>'Invalid Semester id' ],401);
		}
		else{
			$year=Semester::where("semester_id",$semester_id)->delete();
			return response()->json(["status"=>"success"],200);
		}
	}

}
