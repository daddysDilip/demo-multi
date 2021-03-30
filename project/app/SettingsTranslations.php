<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingsTranslations extends Model
{

    protected $fillable = ['pagesettingsid', 'contact', 'langcode', 'company_id'];

    public $timestamps = false;
}
