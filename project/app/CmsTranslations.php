<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CmsTranslations extends Model
{

    protected $fillable = ['cmsid', 'cmsid', 'title', 'description', 'langcode', 'company_id'];

    public $timestamps = false;
}
