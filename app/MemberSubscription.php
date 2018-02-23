<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberSubscription extends Model
{
    protected $fillable = [
        'member_id', 'subscription_id','renew','jan','feb','mar','apr','may','jun','july','aug','sep','oct','nov','dec'
    ];
	
    public function member()
    {
        return $this->belongsTo('App\Member');
    }	

    public function subscription()
    {
        return $this->belongsTo('App\Subscription');
    }	    

    public static function insertBulk($subscriptions)
    {	
    	$newMemberSubscriptions = array();
        
        foreach($subscriptions as $subscription)
        {
			$oldSubscription = Subscription::where('magazine',$subscription['magazine'])
								->where('type',$subscription['type'])	
								->where('year',$subscription['year'] - 1)	
								->first();
			$newSubscription = Subscription::where('magazine',$subscription['magazine'])
								->where('type',$subscription['type'])	
								->where('year',$subscription['year'])	
								->first();    	
			if(isset($oldSubscription))
			{	
				$oldMemberSubscriptions = MemberSubscription::where('subscription_id',$oldSubscription->id)->get();						    	
				foreach($oldMemberSubscriptions as $oldMemberSubscription)
				{
					if($oldMemberSubscription -> renew == 1)
					{
						$newMemberSubscription = new MemberSubscription(array(
							'subscription_id' => $newSubscription->id,
							'member_id' => $oldMemberSubscription->member_id,	
							'renew' => 1,
							'jan' => 1,
							'feb' => 1,
							'mar' => 1,
							'apr' => 1,
							'may' => 1,
							'jun' => 1,
							'july' => 1,
							'aug' => 1,
							'sep' => 1,
							'oct' => 1,
							'nov' => 1,
							'dec' => 1
							));
						array_push($newMemberSubscriptions,$newMemberSubscription->toArray());						
					}	
				}
			}	
        }
        return $newMemberSubscriptions;
    }	    
}