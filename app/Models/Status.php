<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public $timestamps = FALSE;

    /**
     * Get the orders record associated with the status.
     */
    public function orders(){
        return $this->hasMany('App\Models\Order');
    }
}
