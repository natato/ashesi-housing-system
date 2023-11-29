<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomAssignment extends Model {
	public $table="room_assignment";
	public $primaryKey="roomAssignmentId";
	public $incrementing=true;
	public $timestamps=false;
	public function semester_room_assignment(){
		return $this->hasOne('App\SemesterRoomAssignment','room_assignment_id','roomAssignmentId');
	}
}
