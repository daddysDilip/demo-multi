<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plans extends Model
{
    protected $fillable = ['plantype', 'plantitle', 'description', 'planamount', 'product_limit', 'status','created_at', 'updated_at'];
}
