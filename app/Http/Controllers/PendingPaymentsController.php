<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\MemberSubscriptionFormRequest;
use Illuminate\Support\Facades\Auth;
use App\MemberSubscription;
use App\Member;
use App\Majlis;
use App\Subscription;
use App\SubscriptionType;
use App\Receipt;

class PendingPaymentsController extends Controller
{
    
	public function __construct()
    {
        $this->middleware('auth');
		//$this->middleware('admin', ['only' => ['create']]);
    } 	
	
    public function index($year)
    {
		$subscriptionIds = array();
		$subsciptionsDetail = array();
		$memberIds = array();
		$membersDetail = array();
		$mainList = array();
		
		$yearList = Subscription::where('magazine',Auth::user()->magazine_type)
						->distinct('year')
						->orderBy('year')
						->pluck('year');
		
		if($year != 'All')
			$subscriptions =  Subscription::where('magazine',Auth::user()->magazine_type)->where('year',$year)->get();			
		else
			$subscriptions =  Subscription::where('magazine',Auth::user()->magazine_type)->get();						
		
		foreach($subscriptions as $subscription)
		{
			$subscriptionIds[] = $subscription -> id;
			$subsciptionsDetail[$subscription -> id] = array('type'=>$subscription -> type,'year'=>$subscription -> year, 'rate'=> $subscription -> rate);
		}
		
		$memberSubscriptions = MemberSubscription::whereIn('subscription_id',$subscriptionIds)->get();
		foreach($memberSubscriptions as $memberSubscription)
		{
			$memberIds[] = $memberSubscription->member_id;
		}
		
		$members = Member::whereIn('id',$memberIds)->get();
		foreach($members as $member)
		{
			$membersDetail[$member -> id] = array('name'=>$member -> name,'majlis'=>$member -> majlis);
		}	
		
		foreach($memberSubscriptions as $memberSubscription)
		{
			if(Auth::user()->admin)    // insert members of all majlis for admin
			{
				$mainList[$memberSubscription->member_id]['name'] = $membersDetail[$memberSubscription->member_id]['name'];
				$mainList[$memberSubscription->member_id]['majlis'] = $membersDetail[$memberSubscription->member_id]['majlis'];				
				if(isset($mainList[$memberSubscription->member_id]['rate']))
					$mainList[$memberSubscription->member_id]['rate'] = $mainList[$memberSubscription->member_id]['rate'] + $subsciptionsDetail[$memberSubscription->subscription_id]['rate'];				
				else
					$mainList[$memberSubscription->member_id]['rate'] =  $subsciptionsDetail[$memberSubscription->subscription_id]['rate'];				
			}	
			else
			{
				if($membersDetail[$memberSubscription->member_id]['majlis'] == Auth::user()->majlis && $subsciptionsDetail[$memberSubscription->subscription_id]['type'] != 'Sponsorship')
				{
					$mainList[$memberSubscription->member_id]['name'] = $membersDetail[$memberSubscription->member_id]['name'];
					$mainList[$memberSubscription->member_id]['majlis'] = $membersDetail[$memberSubscription->member_id]['majlis'];				
					if(isset($mainList[$memberSubscription->member_id]['rate']))
						$mainList[$memberSubscription->member_id]['rate'] = $mainList[$memberSubscription->member_id]['rate'] + $subsciptionsDetail[$memberSubscription->subscription_id]['rate'];				
					else
						$mainList[$memberSubscription->member_id]['rate'] =  $subsciptionsDetail[$memberSubscription->subscription_id]['rate'];				
				}	
			}	
		}		

		if($year != 'All')
		{
			$receipts = Receipt::groupBy('member_id')
						->selectRaw('sum(amount) as sum, member_id')
						->where('year',$year)
						->pluck('sum','member_id');				
		}	
		else
		{
			$receipts = Receipt::groupBy('member_id')
						->selectRaw('sum(amount) as sum, member_id')
						->pluck('sum','member_id');							
		}	

	
 		foreach($receipts as $member => $amount)
		{
			if(isset($mainList[$member]))
				$mainList[$member]['rate'] = $mainList[$member]['rate'] - $amount;								
				
		}
		return view('pendingPayment',compact('mainList','yearList')); 
    }

    public function show($id)
    {
        //
    }
}
