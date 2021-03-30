<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsTranslations extends Model
{

    protected $fillable = ['newsid', 'newstitle', 'content', 'langcode', 'company_id'];

    public $timestamps = false;
}
