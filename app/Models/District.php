<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public $timestamps = FALSE;
    protected $keyType = 'string';

    /**
     * Get the wards record associated with the district.
     */
    public function wards(){
        return $this->hasMany('App\Models\Ward');
    }

    /**
     * Get the province that owns the district.
     */
    public function province(){
        return $this->belongsTo('App\Models\Province');
    }
}
