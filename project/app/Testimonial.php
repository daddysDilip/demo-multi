<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['review','client','designation','status'];
    public $timestamps = false;
}
