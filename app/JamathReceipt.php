<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JamathReceipt extends Model
{
    protected $guarded = ['id'];
	
    public function jamath()
    {
        return $this->belongsTo('App\Majlis');
    }	
}
