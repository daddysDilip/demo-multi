<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class SampleEmailtemplates extends Model
{
	use Notifiable;
    public $table = "sample_emailtemplates";
    protected $fillable = ['type','title', 'fromname', 'fromemail', 'label','subject', 'content'];
}
