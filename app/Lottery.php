<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
    public $table="lottery";
	public $primaryKey="ID";
	public $timestamps=false;
	public function lotteryDetails(){
		return $this->hasMany('App\LotteryDetails','lotteryId','ID');
	}
}
