<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class CompanyTransection extends Model
{
	use Notifiable;

    public $table = "company_transation";
    
    protected $fillable = ['comapany_name', 'CompanyId', 'transection_id', 'transection_data', 'ErrorCode', 'description', 'Status'];

}
