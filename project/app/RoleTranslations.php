<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleTranslations extends Model
{
    protected $fillable = ['roleid', 'role', 'langcode', 'company_id'];

    public $timestamps = false;
}
