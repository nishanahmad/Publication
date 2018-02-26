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
use App\JamathReceipt;

class PendingPaymentsController extends Controller
{
    
	public function __construct()
    {
        $this->middleware('auth');
		//$this->middleware('admin', ['only' => ['create']]);
    } 	
	
    public function jamathIndex()
    {
		$subscriptions = Subscription::All();
		foreach($subscriptions as $subscription)
			$rateMap[$subscription['id']] = $subscription['rate'];
		
		$members = Member::All();
		foreach($members as $member)
			$memberMap[$member['id']] = $member['majlis']; 

		$memberSubscriptions = MemberSubscription::All();
		foreach($memberSubscriptions as $memberSubscription)
		{
			if(isset($pendingMap[$memberMap[$memberSubscription['member_id']]]))
				$pendingMap[$memberMap[$memberSubscription['member_id']]] = $pendingMap[$memberMap[$memberSubscription['member_id']]] + $rateMap[$memberSubscription['subscription_id']];
			else
				$pendingMap[$memberMap[$memberSubscription['member_id']]] = $rateMap[$memberSubscription['subscription_id']];
		}		
		
		$receipts = Receipt::All();
		foreach($receipts as $receipt)
		{
			$subscription = Subscription::where('magazine',$receipt['magazine'])
							   ->where('year',$receipt['year'])
							   ->where('type',$receipt['type'])
							   ->pluck('id');
			if(isset($paidMap[$memberMap[$receipt['member_id']]]))
				$paidMap[$memberMap[$receipt['member_id']]] = $paidMap[$memberMap[$receipt['member_id']]] + $rateMap[$subscription[0]];
			else
				$paidMap[$memberMap[$receipt['member_id']]] = $rateMap[$subscription[0]];			
		}

		$jamathReceipts = JamathReceipt::All();
		foreach($jamathReceipts as $jamathReceipt)
		{
			if(isset($unaccountedMap[$jamathReceipt['jamath']]))
				$unaccountedMap[$jamathReceipt['jamath']] = $unaccountedMap[$jamathReceipt['jamath']] + $jamathReceipt['amount'];
			else
				$unaccountedMap[$jamathReceipt['jamath']] = $jamathReceipt['amount'];
		}

		$jamathList = Majlis::All();
		foreach($jamathList as $jamath)
		{
			if(!isset($pendingMap[$jamath -> name]))
				$pendingMap[$jamath -> name] = 0;
			if(!isset($paidMap[$jamath -> name]))
				$paidMap[$jamath -> name] = 0;			
			if(!isset($unaccountedMap[$jamath -> name]))
				$unaccountedMap[$jamath -> name] = 0;			
		}
								
		return view('pendingPayment/jamathList',compact('pendingMap','unaccountedMap','paidMap','jamathList')); 
	}
	
    public function memberIndex($jamath)
    {
		$members = Member::where('majlis',$jamath)->get();
		foreach($members as $member)
			$memberMap[$member['id']] = $member['name'];			

			
		$subscriptions = Subscription::All();
		foreach($subscriptions as $subscription)
			$rateMap[$subscription['id']] = $subscription['rate'];
					
		$memberSubscriptions = MemberSubscription::whereIn('member_id',array_keys($memberMap))->get();
		foreach($memberSubscriptions as $memberSubscription)
		{
			if(isset($pendingMap[$memberSubscription['member_id']]))
				$pendingMap[$memberSubscription['member_id']] = $pendingMap[$memberSubscription['member_id']] + $rateMap[$memberSubscription['subscription_id']];
			else
				$pendingMap[$memberSubscription['member_id']] = $rateMap[$memberSubscription['subscription_id']];
		}		
		
		$receipts = Receipt::whereIn('member_id',array_keys($memberMap))->get();
		foreach($receipts as $receipt)
		{
			$subscription = Subscription::where('magazine',$receipt['magazine'])
							   ->where('year',$receipt['year'])
							   ->where('type',$receipt['type'])
							   ->pluck('id');
							   
			if(isset($paidMap[$receipt['member_id']]))
				$paidMap[$receipt['member_id']] = $paidMap[$receipt['member_id']] + $rateMap[$subscription[0]];
			else
				$paidMap[$receipt['member_id']] = $rateMap[$subscription[0]];
		}
		
		foreach($members as $member)
		{
			if(!isset($paidMap[$member -> id]))
				$paidMap[$member -> id] = 0;			
		}
			$memberMap[$member['id']] = $member['name'];					
		
		return view('pendingPayment/memberList',compact('pendingMap','memberMap','paidMap','jamath')); 		
	}		


    public function show($id)
    {
        //
    }
}
