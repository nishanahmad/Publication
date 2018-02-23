<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MemberFormRequest;
use Illuminate\Support\Facades\Auth;
use App\Member;
use App\Majlis;
use App\Subscription;

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
			$members = Member::where('majlis',Auth::user()->majlis)->get();
		return view('members.index',compact('members'));
    }
	
    public function create()
    {
		$majlisList = Majlis::all();
		return view('members.create',compact('majlisList'));
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
			'majlis' => $request->get('majlis')
        ));
			
		$member->save();

        return redirect()->back()->with('status', 'Member has been created!');
    }
	
    public function show($id)
    {
		$member = Member::whereId($id)->firstOrFail();
		$majlis = $member -> majlis;
		
		$subscriptions = $member->subscriptions();
		$receipts = $member->receipts();
		$mainList = array();
		
		foreach($subscriptions as $subscription)
		{
			if(isset($mainList[$subscription['type']][$subscription['year']]['rate']))
				$mainList[$subscription['type']][$subscription['year']]['rate'] = $mainList[$subscription['type']][$subscription['year']]['rate'] + $subscription['amount'];			
			else
			{
				$mainList[$subscription['type']][$subscription['year']]['rate'] = $subscription['rate'];
				$mainList[$subscription['type']][$subscription['year']]['paid'] = 0;				
			}		
		}
		
		foreach($receipts as $receipt)
		{
			$mainList[$receipt['type']][$receipt['year']]['paid'] = $mainList[$receipt['type']][$receipt['year']]['paid'] + $receipt['amount'];			
		}
	
		return view('members.show', compact('member','mainList','receipts'));
    }	
	
    public function edit($id)
    {
		$member = Member::whereId($id)->firstOrFail();
		$majlisList = Majlis::all();
		return view('members.edit', compact('member','majlisList'));
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
	
    public function membersAjax($majlis)
    {
		$memberList = array();
		$members = Member::where('majlis',$majlis)->get();
		foreach($members->all() as $member)
			$memberList[$member['id']] = $member->name;

        return ($memberList);
    }	
}