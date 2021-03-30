<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Themes extends Model
{
    protected $fillable = ['themename', 'themeurl', 'themecontent', 'themeprice', 'paid', 'themeimage','created_at', 'updated_at'];
}
