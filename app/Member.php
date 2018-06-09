<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $guarded = ['id'];

    public function jamath()
    {
        return $this->belongsTo('App\Jamath');
    }
	
    public function subscriptions()
    {	
		return $this->hasMany('App\Subscription')->get();
	}


    public function receipts()
    {   
        return $this->hasMany('App\Receipt')->get();
    }    

    public function pendingPayments()
    {       
        $receipts =  $this->receipts();    
        $memberSubscriptions = $this->MemberSubscriptions();    
    }        
}
