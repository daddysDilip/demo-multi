<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class TicketReply extends Model
{
	use Notifiable;
    public $table = "ticket_reply";
    public $timestamps = false;
    
    protected $fillable = ['ticketid', 'userid', 'content', 'timestamp', 'replyid', 'files', 'hash'];
}
