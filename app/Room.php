<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model {
	public $table="rooms";
	public $primaryKey="roomId";
	public $timestamps=false;
}
