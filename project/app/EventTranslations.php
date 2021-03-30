<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventTranslations extends Model
{

    protected $fillable = ['eventid', 'eventname', 'description', 'langcode', 'company_id'];

    public $timestamps = false;
}
