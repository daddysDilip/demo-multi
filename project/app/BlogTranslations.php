<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogTranslations extends Model
{

    protected $fillable = ['blogid', 'title', 'details', 'langcode', 'company_id'];

    public $timestamps = false;
}
