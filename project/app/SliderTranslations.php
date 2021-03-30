<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SliderTranslations extends Model
{

    protected $fillable = ['sliderid', 'title', 'text', 'langcode', 'company_id'];

    public $timestamps = false;
}
