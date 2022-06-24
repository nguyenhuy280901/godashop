<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    public $timestamps = FALSE;
    protected $keyType = 'string';

    /**
     * Get the customers record associated with the ward.
     */
    public function customers(){
        return $this->hasMany('App\Models\Customer');
    }

    /**
     * Get the province that owns the district.
     */
    public function district(){
        return $this->belongsTo('App\Models\District');
    }
}
