<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArchiveCategory extends Model
{
    protected $table = 'archive_categories';

    protected $fillable = ['categoryId','mainid', 'subid', 'role','name', 'slug','featured','feature_image','status','metatitle','metadec','metakey'];

    public $timestamps = false;

    public static $withoutAppends = false;

    public function getMainidAttribute($mainid)
    {
        if ($mainid != ""){
            return Category::where('id',$mainid)->first();
        }
        return $mainid;
    }
    public function getSubidAttribute($subid)
    {
        if(self::$withoutAppends){
            return $subid;
        }

        return Category::where('id',$subid)->first();

    }

}
