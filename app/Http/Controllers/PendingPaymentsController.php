<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use App\Member;
use App\Jamath;
use App\Subscription;
use App\AnnualRate;
use App\Receipt;
use App\JamathReceipt;

class PendingPaymentsController extends Controller
{
    
	public function __construct()
    {
        $this->middleware('auth');
		//$this->middleware('admin', ['only' => ['create']]);
    } 	
	
    public function jamathIndex($year)
    {
		$pendingMap = array();
		$year = (integer)$year;
		$totalPending = 0;		
		
		$yearList = AnnualRate::distinct('year')
					  ->orderBy('year')
					  ->pluck('year');	
					  
		$annualRate = AnnualRate::where('year',$year) ->first();
		$rate = $annualRate -> rate;

		
		$subscriptions =  Subscription::where(function($query) use ($year){
								$query->where('start_year', '<=' , $year)
								->where('end_year', null);
								})
								->orWhere(function($query) use ($year){
								$query->where('start_year', '<=' , $year)
								->where('end_year', '>=' ,$year);
								})
								->get();				
		
		foreach($subscriptions as $subscription)
		{
			if(isset($pendingMap[$subscription->member->jamath->id]))
			{
				if($subscription -> start_year == $year && $subscription -> end_year == $year)
				{	
					$months = $subscription -> end_month - $subscription -> start_month + 1;
					if($months >= 10)
						$pendingMap[$subscription->member->jamath->id] = $pendingMap[$subscription->member->jamath->id] + $rate;
					else
						$pendingMap[$subscription->member->jamath->id] = $pendingMap[$subscription->member->jamath->id] + 30 * $months;
				}
					
				else if($subscription -> start_year == $year && $subscription -> end_year != $year)
				{
					$months = 12 - $subscription -> start_month + 1;
					if($months >= 10)
						$pendingMap[$subscription->member->jamath->id] = $pendingMap[$subscription->member->jamath->id] + $rate;
					else
						$pendingMap[$subscription->member->jamath->id] = $pendingMap[$subscription->member->jamath->id] + 30 * $months;
				}					
				else if($subscription -> start_year != $year && $subscription -> end_year == $year)
				{
					$months = $subscription -> end_month;
					if($months >= 10)
						$pendingMap[$subscription->member->jamath->id] = $pendingMap[$subscription->member->jamath->id] + $rate;								
					else
						$pendingMap[$subscription->member->jamath->id] = $pendingMap[$subscription->member->jamath->id] + 30 * $months;
				}
				else
					$pendingMap[$subscription->member->jamath->id] = $pendingMap[$subscription->member->jamath->id] + $rate;														
			}
				
			else
			{
				if($subscription -> start_year == $year && $subscription -> end_year == $year)
				{
					$months = $subscription -> end_month - $subscription -> start_month + 1;
					if($months >= 10)
						$pendingMap[$subscription->member->jamath->id] = $rate;
					else
						$pendingMap[$subscription->member->jamath->id] = $months * 30;
				}
				else if($subscription -> start_year == $year && $subscription -> end_year != $year)
				{
					$months = 12 - $subscription -> start_month + 1;
					if($months >= 10)
						$pendingMap[$subscription->member->jamath->id] = $rate ;		
					else
						$pendingMap[$subscription->member->jamath->id] = $months * 30;		
				}	
				else if($subscription -> start_year != $year && $subscription -> end_year == $year)
				{
					$months = $subscription -> end_month;
					if($months >= 10)
						$pendingMap[$subscription->member->jamath->id] = $rate;
					else
						$pendingMap[$subscription->member->jamath->id] = $months * 30;							
				}
				else
					$pendingMap[$subscription->member->jamath->id] = $rate;													
			}				
		}

		foreach($pendingMap as $jamathId => $amount)
			$totalPending = $totalPending + $amount;
		
		$receipts = Receipt::where('year',$year) -> get();
		foreach($receipts as $receipt)
		{
			if(isset($memberReceiptMap[$receipt->member->jamath_id]))
				$memberReceiptMap[$receipt->member->jamath_id] = $memberReceiptMap[$receipt->member->jamath_id] + $receipt -> amount;
			else
				$memberReceiptMap[$receipt->member->jamath_id] = $receipt -> amount;
		}

		$jamathReceiptMap = array();
		$jamathReceipts = JamathReceipt::where('year',$year) -> get();
		foreach($jamathReceipts as $jamathReceipt)
		{
			if(isset($jamathReceiptMap[$jamathReceipt -> jamath_id]))
				$jamathReceiptMap[$jamathReceipt -> jamath_id] = $jamathReceiptMap[$jamathReceipt -> jamath_id] + $jamathReceipt -> amount;
			else
				$jamathReceiptMap[$jamathReceipt -> jamath_id] = $jamathReceipt -> amount;
		}

		$totalPaid = 0;
		foreach($jamathReceiptMap as $jamathId => $amount)
			$totalPaid = $totalPaid + $amount;		
		
		$jamathList = Jamath::All();
		foreach($jamathList as $jamath)
		{
			if(!isset($pendingMap[$jamath -> id]))
				$pendingMap[$jamath -> id] = 0;
			if(!isset($memberReceiptMap[$jamath -> id]))
				$memberReceiptMap[$jamath -> id] = 0;			
			if(!isset($jamathReceiptMap[$jamath -> id]))
				$jamathReceiptMap[$jamath -> id] = 0;			
		}
		return view('pendingPayment/jamathList',compact('pendingMap','jamathReceiptMap','memberReceiptMap','jamathList','totalPending','totalPaid','yearList')); 
	}
	
    public function memberIndex($jamathId,$year)
    {
		$memberIds = array();
		$pendingMap = array();
		$jamath = Jamath::where('id',$jamathId)->firstOrFail();
		$members = Member::where('jamath_id',$jamathId)->get();
		foreach($members as $member)
			$memberIds[] = $member->id;
		
		$annualRate = AnnualRate::where('year',$year) ->first();
		$rate = $annualRate -> rate;
		
		$subscriptions =  Subscription::where(function($query) use ($year){
								$query->where('start_year', '<=' , $year)
								->where('end_year', null);
								})
								->orWhere(function($query) use ($year){
								$query->where('start_year', '<=' , $year)
								->where('end_year', '>=' ,$year);
								})
								->get();				
		
		foreach($subscriptions as $subscription)
		{
			if(in_array($subscription->member->id, $memberIds))
			{
				if(isset($pendingMap[$subscription->member_id]))
				{
					if($subscription -> start_year == $year && $subscription -> end_year == $year)
					{
						$months = $subscription -> end_month - $subscription -> start_month + 1;
						if($months >= 10)
							$pendingMap[$subscription->member_id] = $pendingMap[$subscription->member_id] + $rate;	
						else
							$pendingMap[$subscription->member_id] = $pendingMap[$subscription->member_id] + $months * 30;	
					}
					else if($subscription -> start_year == $year && $subscription -> end_year != $year)
					{
						$months = 12 - $subscription -> start_month + 1;
						if($months >= 10)
							$pendingMap[$subscription->member_id] = $pendingMap[$subscription->member_id] + $rate;			
						else
							$pendingMap[$subscription->member_id] = $pendingMap[$subscription->member_id] + $months * 30;			
					}
					else if($subscription -> start_year != $year && $subscription -> end_year == $year)
					{
						$months = $subscription -> end_month;
						if($months >= 10)
							$pendingMap[$subscription->member_id] = $pendingMap[$subscription->member_id] + $rate;							
						else
							$pendingMap[$subscription->member_id] = $pendingMap[$subscription->member_id] + $months * 30;							
					}
					else
						$pendingMap[$subscription->member_id] = $pendingMap[$subscription->member_id] + $rate;													
				}
					
				else
				{
					if($subscription -> start_year == $year && $subscription -> end_year == $year)
					{
						$months = $subscription -> end_month - $subscription -> start_month + 1;
						if($months >= 10)
							$pendingMap[$subscription->member_id] = $rate;
						else
							$pendingMap[$subscription->member_id] = $months * 30;
					}
					else if($subscription -> start_year == $year && $subscription -> end_year != $year)
					{
						$months = 12 - $subscription -> start_month + 1;
						if($months >= 10)
							$pendingMap[$subscription->member_id] = $rate;		
						else
							$pendingMap[$subscription->member_id] = $months * 30;		
					}
					else if($subscription -> start_year != $year && $subscription -> end_year == $year)
					{
						$months = $subscription -> end_month;
						if($months >= 10)
							$pendingMap[$subscription->member_id] = $rate;
						else
							$pendingMap[$subscription->member_id] = $months * 30;							
					}
					else
						$pendingMap[$subscription->member_id] = $rate;													
				}									
			}
		}
		
		$receipts = Receipt::whereIn('member_id',$memberIds)
					->where('year',$year)
					->get();

		foreach($receipts as $receipt)
		{					   
			if(isset($paidMap[$receipt->member_id]))
				$paidMap[$receipt->member_id] = $paidMap[$receipt->member_id] + $receipt->amount;
			else
				$paidMap[$receipt->member_id] = $receipt->amount;
		}

		foreach($members as $member)
		{
			if(!isset($pendingMap[$member -> id]))
				$pendingMap[$member -> id] = 0;
			if(!isset($paidMap[$member -> id]))
				$paidMap[$member -> id] = 0;			
			if(!isset($unaccountedMap[$member -> id]))
				$unaccountedMap[$member -> id] = 0;			
		}
		
		$yearList = AnnualRate::distinct('year')
					  ->orderBy('year')
					  ->pluck('year');	
					  
		return view('pendingPayment/memberList',compact('pendingMap','paidMap','jamath','members','yearList')); 		
	}		
	
}
