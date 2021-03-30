<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticketfiles extends Model
{
	public $timestamps = false;

    protected $fillable = ['ticketid', 'filename', 'filetype', 'extension', 'filesize', 'replyid', 'timestamp', 'userid'];
}
