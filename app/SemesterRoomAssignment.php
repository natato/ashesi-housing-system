<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SemesterRoomAssignment extends Model
{
    public $table="semester_room_assignments";
    public $primaryKey="semester_room_assignment_id";
    public $timestamps=false;
}
