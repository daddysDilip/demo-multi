<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PickUpLocationTranslations extends Model
{
    protected $table = "pickup_location_translations";

    protected $fillable = ['plocationgid', 'address', 'langcode', 'company_id'];

    public $timestamps = false;
}
