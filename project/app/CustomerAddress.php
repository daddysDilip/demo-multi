<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CustomerAddress extends Authenticatable
{
    use Notifiable;
    public $table = "address";
    protected $fillable = [
        'customerid', 'billing_firstname', 'billing_lastname', 'billing_email', 'billing_phone', 'billing_address', 'billing_country', 'billing_state', 'billing_city', 'billing_zip', 'shipping_firstname', 'shipping_lastname', 'shipping_email', 'shipping_phone', 'shipping_address', 'shipping_country', 'shipping_state', 'shipping_city', 'shipping_zip', 'shipping_info','company_id'
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
