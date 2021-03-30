<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shippingmethod extends Model
{
    protected $fillable = ['shippingtype', 'tempcode', 'status', 'created_at', 'updated_at'];
}
