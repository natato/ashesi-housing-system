<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    public $table="year";
    public $primaryKey="year_id";
    public $timestamps=false;
}
