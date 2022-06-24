<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    public $timestamps = FALSE;

    /**
     * Get the province that owns the transport.
     */
    public function province(){
        return $this->belongsTo('App\Models\Province');
    }
}
