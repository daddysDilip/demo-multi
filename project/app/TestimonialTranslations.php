<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestimonialTranslations extends Model
{

    protected $fillable = ['testimonialid', 'review', 'designation', 'langcode', 'company_id'];

    public $timestamps = false;
}
