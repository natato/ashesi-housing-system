<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    public $table="comments";
	public $primaryKey="id";
	public $timestamps=false;
	public $incrementing=true;
}
