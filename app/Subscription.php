<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $guarded = ['id'];

    public function member()
    {
        return $this->belongsTo('App\Member');
    }
}
