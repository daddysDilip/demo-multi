<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class TicketPriority extends Model
{
	use Notifiable;
    public $table = "ticketpriority";

    protected $fillable = ['name', 'priority'];
}
