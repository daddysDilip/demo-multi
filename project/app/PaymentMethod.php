<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paymentmethod extends Model
{
    protected $fillable = ['paymentname', 'paymenttype', 'image', 'tempcode', 'status', 'created_at', 'updated_at'];
}
