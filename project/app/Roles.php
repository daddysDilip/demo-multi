<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $fillable = ['role', 'tempcode', 'updated_at','created_at','company_id'];
}
