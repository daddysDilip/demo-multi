<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planupgradepay extends Model
{
	protected $table = 'planupgradepay';
    protected $fillable = ['planid', 'payamount', 'reasontochange','start_date','expiry_date','duration', 'created_at', 'updated_at', 'company_id'];
}
