<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buytheme extends Model
{
    protected $fillable = ['themeid', 'payment','paid','created_at','updated_at','company_id'];
}
