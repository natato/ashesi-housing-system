<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Hostel extends Model {
	public $table="hostels";
	public $primaryKey="hostelId";
	public $timestamps=false;
}
