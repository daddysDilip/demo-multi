<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emailtemplates extends Model
{
    protected $fillable = ['title', 'fromname', 'fromemail', 'subject', 'content', 'tempcode', 'status','created_at', 'updated_at', 'company_id'];
}
