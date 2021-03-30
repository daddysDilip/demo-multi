<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslations extends Model
{

    protected $fillable = ['mainid', 'subid', 'role','name', 'slug','featured','feature_image','status'];

    public $timestamps = false;

}
