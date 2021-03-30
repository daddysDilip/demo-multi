<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['countryname', 'sortname', 'phonecode','status'];
    public $timestamps = false;
}
