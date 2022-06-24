<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    public $timestamps = FALSE;
    protected $keyType = 'string';

    /**
     * Get the districts record associated with the province.
     */
    public function districts(){
        return $this->hasMany('App\Models\District');
    }

    /**
     * Get the tranport record associated with the province.
     */
    public function transport(){
        return $this->hasOne('App\Models\Transport');
    }
}
