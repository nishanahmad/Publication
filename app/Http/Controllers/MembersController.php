<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MemberFormRequest;
use Illuminate\Support\Facades\Auth;
use App\Member;
use App\Jamath;
use App\Subscription;
use App\AnnualRate;

class MembersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
		$this->middleware('admin', ['only' => ['create']]);
		$this->middleware('checkMajlis', ['only' => ['show','edit']]);
    } 	

    public function index()
    {
		if(Auth::user()->admin)
			$members = Member::all();
		else
			$members = Member::where('jamath_id',Auth::user()->jamath_id)->get();
		$jamaths = Member::with('jamath');		
		return view('members.index',compact('members','jamaths'));
    }
	
    public function create()
    {
		$jamathList = Jamath::all();
		return view('members.create',compact('jamathList'));
    }
	
    public function insert(MemberFormRequest $request)
    {
        $member = new Member(array(
			'code' => $request->get('code'),		
            'name' => $request->get('name'),
			'address1' => $request->get('address1'),			
			'address2' => $request->get('address2'),
			'place' => $request->get('place'),
			'district' => $request->get('district'),
			'pin_code' => $request->get('pin_code'),
			'rms' => $request->get('rms'),
			'landline' => $request->get('landline'),
			'mobile' => $request->get('mobile'),
			'email' => $request->get('email'),			
			'ref_name' => $request->get('ref_name'),			
			'ref_phone' => $request->get('ref_phone'),			
			'jamath_id' => $request->get('jamath_id')
        ));
			
		$member->save();

        return redirect()->back()->with('status', 'Member has been created!');
    }
	
    public function show($id)
    {
		$subscriptionIds = array();
		$pendingMap = array();
		$paidMap = array();		
		$member = Member::whereId($id)->firstOrFail();
		$jamath = $member -> jamath;
		
		$subscriptionsMember = $member->subscriptions();
		foreach($subscriptionsMember as $subscription)
		{
			$subscriptionIds[] = $subscription->id;
		}		
		
		$receipts = $member->receipts();
		$annualRates = AnnualRate::All();
		
		foreach($annualRates as $rate)
		{
			$year = $rate->year;
			$rate = $rate->rate;

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
				if(in_array($subscription->id, $subscriptionIds))
				{
					if(isset($pendingMap[$year]))
					{
						if($subscription -> start_year == $year && $subscription -> end_year == $year)
							$pendingMap[$year] = $pendingMap[$year] + $rate * ($subscription -> end_month - $subscription -> start_month + 1)/12;
						else if($subscription -> start_year == $year && $subscription -> end_year != $year)
							$pendingMap[$year] = $pendingMap[$year] + $rate * (12 - $subscription -> start_month + 1)/12;		
						else if($subscription -> start_year != $year && $subscription -> end_year == $year)
							$pendingMap[$year] = $pendingMap[$year] + $rate * ($subscription -> end_month)/12;							
						else
							$pendingMap[$year] = $pendingMap[$subscription->member->jamath->id] + $rate;													
					}
						
					else
					{
						if($subscription -> start_year == $year && $subscription -> end_year == $year)
							$pendingMap[$year] = $rate * ($subscription -> end_month - $subscription -> start_month + 1)/12;
						else if($subscription -> start_year == $year && $subscription -> end_year != $year)
							$pendingMap[$year] = $rate * (12 - $subscription -> start_month + 1)/12;		
						else if($subscription -> start_year != $year && $subscription -> end_year == $year)
							$pendingMap[$year] = $rate * ($subscription -> end_month)/12;							
						else
							$pendingMap[$year] = $rate;													
					}									
				}
			}
			
			foreach($receipts as $receipt)
			{
				if($year == $receipt->year)
				{
					if(isset($paidMap[$year]))
						$paidMap[$year] = $paidMap[$year] + $receipt -> amount;			
					else
						$paidMap[$year] = $receipt -> amount;								
				}
			}			
		}
	
		$jamaths = Member::with('jamath');			
		
		foreach($pendingMap as $year => $rate)
		{
			if(!isset($paidMap[$year]))
				$paidMap[$year] = 0;			
		}
		
		return view('members.show', compact('member','pendingMap','paidMap','receipts','jamaths'));
    }	
	
    public function edit($id)
    {
		$member = Member::whereId($id)->firstOrFail();
		$jamathList = Jamath::all();
		return view('members.edit', compact('member','jamathList'));
    }		
	
    public function update($id , MemberFormRequest $request)
    {
		$member = Member::whereId($id)->firstOrFail();
		$member->code = $request->get('code');
		$member->name = $request->get('name');
		$member->address1 = $request->get('address1');
		$member->address2 = $request->get('address2');
		$member->place = $request->get('place');
		$member->district = $request->get('district');
		$member->pin_code = $request->get('pin_code');
		$member->rms = $request->get('rms');
		$member->landline = $request->get('landline');
		$member->mobile = $request->get('mobile');
		$member->email = $request->get('email');			
		$member->ref_name = $request->get('ref_name');
		$member->ref_phone = $request->get('ref_phone');
		$member->majlis = $request->get('majlis');		

		$member->save();
		return redirect()->back()->with('status', 'Member has been successfully updated!');
    }			
	
    public function destroy($id)
    {
		$member = Member::whereId($id)->firstOrFail();
		$member -> delete();
		return redirect('members/index');
    }			
	
    public function membersAjax($jamath_id)
    {
		$memberList = array();
		$memberList[0] = '';
		$members = Member::where('jamath_id',$jamath_id) ->get();
		foreach($members->all() as $member)
			$memberList[$member['id']] = $member->name;

        return ($memberList);
    }	
}