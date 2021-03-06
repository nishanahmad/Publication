<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
    protected $guarded = ['id'];

    public function member()
    {
        return $this->belongsTo('App\Member');
    }
	
    public function jamath()
    {
        return $this->belongsTo('App\Jamath');
    }	
}
