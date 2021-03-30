<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscountTranslations extends Model
{
    protected $fillable = ['discountid', 'title', 'description', 'langcode', 'company_id'];

    public $timestamps = false;
}
