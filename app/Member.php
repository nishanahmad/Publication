<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $guarded = ['id'];

    public function majlis()
    {
        return $this->belongsTo('App\Majlis');
    }
	
    public function house()
    {
        return $this->belongsTo('App\House');
    }	
	
    public function subscriptions()
    {	
        $membersubscriptions = $this->hasMany('App\MemberSubscription')->get();
        $ids = array();
        foreach($membersubscriptions as $membersubscription)
        {
            array_push($ids,$membersubscription -> subscription_id);
        }
        $subscriptions = Subscription::whereIn('id',$ids)
                            ->where('magazine',Auth::user()-> magazine_type)
                            ->get();
        return $subscriptions;                            
	}


    public function receipts()
    {   
        $allReceipts = $this->hasMany('App\Receipt')->get();
        $ids = array();
        foreach ($allReceipts as $receipt) 
        {
            array_push($ids,$receipt -> id);       
        }    
        $filteredReceipts = Receipt::whereIn('id',$ids)
                    ->where('magazine',Auth::user()-> magazine_type)
                    ->get();
        return $filteredReceipts;     
    }    

    public function pendingPayments()
    {       
        $receipts =  $this->receipts();    
        $memberSubscriptions = $this->MemberSubscriptions();    
    }        
}
