<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['eventname', 'eventimage', 'eventdate', 'description', 'status', 'tempcode','created_at', 'updated_at','metatitle','metadec','metakey'];
}
