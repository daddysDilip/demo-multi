<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserProfile extends Authenticatable
{
    use Notifiable;
    public $table = "user_profiles";
    protected $fillable = [
        'firstname', 'lastname', 'email', 'phone', 'password', 'fax', 'address', 'country', 'state', 'city', 'zip', 'status', 'created_at', 'updated_at','company_id','activationcode'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
}
