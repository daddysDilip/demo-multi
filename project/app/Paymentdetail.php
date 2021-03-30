<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Paymentdetail extends Model
{
	use Notifiable;
    public $table = "paymentdetail";
    protected $fillable = ['comapany_name', 'planupgradid','created_at', 'updated_at'];
}
