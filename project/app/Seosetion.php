<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seosetion extends Model
{	

	protected $table = 'seo_section';


    protected $fillable = ['metatitle', 'metakey', 'metadec', 'slug','created_at','updated_at'];
}
