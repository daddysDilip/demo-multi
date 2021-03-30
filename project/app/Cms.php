<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cms extends Model
{
    protected $fillable = ['name', 'title', 'slug', 'description','menudisplay', 'tempcode', 'status','metatitle','metadec','metakey','created_at', 'updated_at', 'company_id'];
}
