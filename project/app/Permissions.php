<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    protected $table = 'permissions';

    protected $fillable = ['menuid', 'roleid','company_id'];

    public $timestamps = false;
}
