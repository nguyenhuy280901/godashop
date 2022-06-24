<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use Notifiable;
    public $timestamps = FALSE;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
        'login_by',
        'social_id',
        'is_active',
        'shipping_name',
        'shipping_mobile',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the ward that owns the customer.
     */
    public function ward(){
        return $this->belongsTo('App\Models\Ward');
    }

    /**
     * Get the orders record associated with the customer.
     */
    public function orders(){
        return $this->hasMany('App\Models\Order');
    }

    /**
     * Get the comments record associated with the customer.
     */
    public function comments(){
        return $this->hasMany('App\Models\Comment', 'customer_id');
    }
}
