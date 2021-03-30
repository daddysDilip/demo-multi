<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['title', 'content', 'ticketstatus', 'priority', 'last_reply_timestamp', 'created_by', 'modified_by', 'status', 'tempcode', 'timestamp', 'created_at', 'updated_at', 'company_id'];
}
