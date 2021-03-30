<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Themeplans extends Model
{
    protected $fillable = ['themeid', 'planid'];
    public $timestamps = false;
}
