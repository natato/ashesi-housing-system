<?php 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Occupant extends Model {
	public $table="occupants";
	public $primaryKey="occupantId";
	public $timestamps=false;
	public $incrementing=false;
}
