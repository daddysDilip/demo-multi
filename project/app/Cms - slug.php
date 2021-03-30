<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cms extends Model
{
    protected $fillable = ['name', 'title', 'slug', 'description', 'metatitle', 'metadescription', 'tempcode', 'status','created_at', 'updated_at', 'company_id'];
	
	/**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($cms) {
            $cms->update(['slug' => $cms->name]);
        });
    }
	
	 public function setSlugAttribute($value)
    {
        if (static::whereSlug($slug = str_slug($value))->exists()) {

            $slug = $this->incrementSlug($slug);
        }
        $this->attributes['slug'] = $slug;
    }
	
	/**
     * Increment slug
     *
     * @param   string $slug
     * @return  string
     **/
    public function incrementSlug($slug)
    {
        // get the slug of the latest created post
		
        $max = static::whereName($this->name)->latest('id')->skip(1)->value('slug');

        if (is_numeric($max[-1])) {
            return pred_replace_callback('/(\d+)$/', function ($mathces) {
                return $mathces[1] + 1;
            }, $max);
        }

        return "{$slug}-2";
    }
}
