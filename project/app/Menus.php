<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
	
	use Notifiable;
    public $table = "menus";
	
   protected $fillable = ['name', 'path', 'menuorder', 'menuicon','parentid', 'tempcode', 'status','created_at', 'updated_at', 'company_id'];
}
