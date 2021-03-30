<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
	use Notifiable;

    public $table = "company";
    
    protected $fillable = ['comapany_name', 'username', 'company_logo', 'company_email', 'company_phone', 'storeurl', 'addressline1', 'addressline2', 'planid', 'country', 'state', 'city', 'pincode', 'status', 'language', 'default_language', 'created_at', 'updated_at'];

}
