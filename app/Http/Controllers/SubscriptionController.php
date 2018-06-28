<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\SubscriptionFormRequest;
use Illuminate\Support\Facades\Auth;
use App\Member;
use App\Jamath;
use App\Subscription;
use App\AnnualRate;

class SubscriptionController extends Controller
{
    
	public function __construct()
    {
        $this->middleware('auth');
		//$this->middleware('admin', ['only' => ['create']]);
    } 	
	
    public function index($year)
    {
		$membersDetail = array();
		$mainList = array();
		
		$yearList = AnnualRate::distinct('year')
						->orderBy('year')
						->pluck('year');

		$subscriptions =  Subscription::where(function($query) use ($year){
								$query->where('start_year', '<=' , $year)
								->where('end_year', null);
								})
								->orWhere(function($query) use ($year){
								$query->where('start_year', '<=' , $year)
								->where('end_year', '>=' ,$year);
								})
								->get();
		
		$members = Member::all();
		$jamaths = Member::with('jamath');
		
		foreach($subscriptions as $subscription)
		{
			if(Auth::user()->admin)    // insert members of all majlis for admin
			{
				$mainList[$subscription->id]['id'] = $subscription->id;
				$mainList[$subscription->id]['code'] = $subscription->member->code;									
				$mainList[$subscription->id]['name'] = $subscription->member->name;
				$mainList[$subscription->id]['jamath'] = $subscription->member->jamath->name;
				
				if($subscription -> start_month != null && $subscription -> start_year == $year)				
					$mainList[$subscription->id]['start_month'] = date("F", strtotime("2001-" . $subscription -> start_month . "-01"));
				else
					$mainList[$subscription->id]['start_month'] = 'January';
				
				if($subscription -> end_month != null && $subscription -> end_year == $year)				
				{
					$mainList[$subscription->id]['end_month'] =  date("F", strtotime("2001-" . $subscription -> end_month . "-01"));
				}
				else
					$mainList[$subscription->id]['end_month'] = null;
			}	
			else
			{
				if($subscription->member->jamath->id == Auth::user()->jamath_id)
				{
					$mainList[$subscription->id]['id'] = $subscription->id;				
					$mainList[$subscription->id]['code'] = $subscription->member->code;					
					$mainList[$subscription->id]['name'] = $subscription->member->name;
					$mainList[$subscription->id]['jamath'] = $subscription->member->jamath->name;
					
					if($subscription -> start_month != null && $subscription -> start_year == $year)				
						$mainList[$subscription->id]['start_month'] = date("F", strtotime("2001-" . $subscription -> start_month . "-01"));
					else
						$mainList[$subscription->id]['start_month'] = 'January';
					
					if($subscription -> end_month != null && $subscription -> end_year == $year)				
					{
						$mainList[$subscription->id]['end_month'] =  date("F", strtotime("2001-" . $subscription -> end_month . "-01"));
					}
					else
						$mainList[$subscription->id]['end_month'] = null;
				}	
			}	
		}
		
		return view('subscriptions.index',compact('mainList','yearList'));
		
    }

    public function create()
    {
		$jamathList = array();
		$memberList = array();
	
		$userJamath = Jamath::where('id',Auth::user()->jamath_id)->first();
		$yearList = AnnualRate::distinct('year')
						->orderBy('year','desc')
						->pluck('year');
		
		$monthList = array();
		for($monthNumber = 1; $monthNumber <=12; $monthNumber++)
		{
			$monthList[$monthNumber] = date("F", strtotime("2001-" . $monthNumber . "-01"));			
		}
		
		if(Auth::user()->admin)
			$jamathList = Jamath::all();
		  else
			$jamathList = Jamath::where('id',$userJamath->id)->get();
				
		return view('subscriptions.create',compact('jamathList','yearList','monthList'));
    }
	

	

    public function store(Request $request)
    {
        $subscription = new Subscription(array(
			'member_id' => $request->get('member'),
			'start_year' => $request->get('start_year'),
			'start_month' => $request->get('start_month'),
			'end_year' => $request->get('end_year'),
			'end_month' => $request->get('end_month')
        ));					
		try
		{	
			$subscription ->save();	
			return redirect()->back()->with('status', 'Success!!! The subscription successfully added.');					
		}
		catch(\Illuminate\Database\QueryException $e)
		{
			return redirect()->back()->with('status', 'Error!!! Please contact admin -- '.$e->getMessage());									
		}
    }


    public function show($id)
    {
		$subscription = Subscription::whereId($id)->firstOrFail();
		$member = $subscription -> member;
		
		return view('subscriptions.show', compact('member','subscription'));
    }


    public function edit($id)
    {
		$subscription = Subscription::whereId($id)->firstOrFail();
		
		$yearList = AnnualRate::distinct('year')
						->orderBy('year','desc')
						->pluck('year');
		
		$monthList = array();
		for($monthNumber = 1; $monthNumber <=12; $monthNumber++)
		{
			$monthList[$monthNumber] = date("F", strtotime("2001-" . $monthNumber . "-01"));			
		}		
		
		return view('subscriptions.edit', compact('subscription','yearList','monthList'));        
    }


    public function update($id , Request $request)
    {
		$subscription = Subscription::whereId($id)->firstOrFail();
		$subscription->start_month = $request->get('start_month');
		$subscription->start_year = $request->get('start_year');
		$subscription->end_month = $request->get('end_month');
		$subscription->end_year = $request->get('end_year');

		$subscription->save();
		return redirect('Subscription/'.$id)->with('status', 'Subscription data has been successfully updated!');        
    }


    public function destroy($id)
    {
        //
    }
}
