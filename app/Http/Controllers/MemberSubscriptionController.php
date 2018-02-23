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

class MemberSubscriptionController extends Controller
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
		
		$subscriptions =  Subscription::where('magazine',Auth::user()->magazine_type)
							->where('year',$year)
							->get();
		
		foreach($subscriptions as $subscription)
		{
			$subscriptionIds[] = $subscription -> id;
			$subsciptionsDetail[$subscription -> id] = array('type'=>$subscription -> type,'year'=>$subscription -> year);
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
				$mainList[$memberSubscription->id]['name'] = $membersDetail[$memberSubscription->member_id]['name'];
				$mainList[$memberSubscription->id]['majlis'] = $membersDetail[$memberSubscription->member_id]['majlis'];				
				$mainList[$memberSubscription->id]['type'] = $subsciptionsDetail[$memberSubscription->subscription_id]['type'];
				$mainList[$memberSubscription->id]['year'] = $year;				
			}	
			else
			{
				if($membersDetail[$memberSubscription->member_id]['majlis'] == Auth::user()->majlis && $subsciptionsDetail[$memberSubscription->subscription_id]['type'] != 'Sponsorship')
				{
					$mainList[$memberSubscription->id]['name'] = $membersDetail[$memberSubscription->member_id]['name'];
					$mainList[$memberSubscription->id]['majlis'] = $membersDetail[$memberSubscription->member_id]['majlis'];				
					$mainList[$memberSubscription->id]['type'] = $subsciptionsDetail[$memberSubscription->subscription_id]['type'];
					$mainList[$memberSubscription->id]['year'] = $year;									
				}	
			}	

		}			

		return view('memberSubscriptions.index',compact('mainList','yearList'));
    }

    public function create()
    {
		$majlisList = array();
		$memberList = array();
	
		$userMajlis = Majlis::where('name',Auth::user()->majlis)->first();
		$typeList = SubscriptionType::where('magazine',Auth::user()->magazine_type)
					  ->distinct('type')
					  ->orderBy('type')
					  ->pluck('type');		
		$yearList = Subscription::where('magazine',Auth::user()->magazine_type)
						->distinct('year')
						->orderBy('year','desc')
						->pluck('year');
		 
		
		if(Auth::user()->admin)
			$majlisList = Majlis::all();
		  else
			$majlisList = Majlis::where('name',$userMajlis->name)->get();
				
		return view('memberSubscriptions.create',compact('majlisList','typeList','yearList'));
    }
	

	

    public function store(MemberSubscriptionFormRequest $request)
    {
		try 
		{
			$subcription = Subscription::where('magazine',Auth::user()-> magazine_type)
							->where('type',$request->get('type'))
							->where('year',$request->get('year'))
							->firstorFail();
		}
		catch (ModelNotFoundException $e) 
		{
			return redirect()->back()->with('status', 'Error!!!  Please contact admin <br> The subscription rate of <b>"'.$request->get("type").'"</b> for <b>'. $request->get("year"). '</b> is not finalised.');					
		}

        $memberSubscription = new MemberSubscription(array(
            'subscription_id' => $subcription -> id,
			'member_id' => $request->get('member')
        ));					
		try
		{
			$memberSubscription ->renew = 1;
			$memberSubscription ->jan = 1;
			$memberSubscription ->feb = 1;
			$memberSubscription ->mar = 1;
			$memberSubscription ->apr = 1;
			$memberSubscription ->may = 1;
			$memberSubscription ->jun = 1;
			$memberSubscription ->july = 1;
			$memberSubscription ->aug = 1;
			$memberSubscription ->sep = 1;
			$memberSubscription ->oct = 1;
			$memberSubscription ->nov = 1;
			$memberSubscription ->dec = 1;
			
			$memberSubscription ->save();	
			return redirect()->back()->with('status', 'Success!!! The subscription plan for the selected year is inserted.');					
		}
		catch(\Illuminate\Database\QueryException $e)
		{
			if($e->getMessage())
			{
				if (strpos($e->getMessage(), '1062') !== false) 
					return redirect()->back()->with('status', 'Duplicate error. Same subscription for the selected year is already found in the database!');
				else
					return redirect()->back()->with('status', 'Error!!! Please contact admin -- '.$e->getMessage());													
			}
			else
				return redirect()->back()->with('status', 'Error!!! Please contact admin -- '.$e->getMessage());									
		}
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
