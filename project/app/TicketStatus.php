<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class TicketStatus extends Model
{
	use Notifiable;
    public $table = "ticketstatus";

    protected $fillable = ['id', 'name'];
}
