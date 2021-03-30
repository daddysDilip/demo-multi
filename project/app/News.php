<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = ['newstitle', 'content', 'newsimage', 'tempcode', 'status','created_at', 'updated_at'];
}
