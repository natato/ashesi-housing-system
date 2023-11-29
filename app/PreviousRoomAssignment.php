<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreviousRoomAssignment extends Model
{
    public $table="previousroomassignment";
	public $primaryKey="previousroomassignmentid";
	public $incrementing=true;
	public $timestamps=true;
}
