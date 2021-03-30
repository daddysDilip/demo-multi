<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Contactus extends Model
{
	 use Notifiable;
    public $table = "contactus";
    protected $fillable = ['name', 'phone', 'email', 'message', 'status','created_at', 'updated_at', 'company_id'];
}
