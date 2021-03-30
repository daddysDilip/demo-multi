<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = ['code', 'title', 'amounttype', 'discount', 'minprice', 'maxprice','description','image', 'startdate', 'enddate','tempcode', 'status','created_at', 'updated_at', 'company_id'];
}
