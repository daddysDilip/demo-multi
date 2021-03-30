<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = ['statename', 'countryid','status'];
    public $timestamps = false;
}
