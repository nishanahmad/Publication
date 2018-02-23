<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReceiptFormRequest;
use App\MemberSubscription;
use App\Receipt;
use App\Member;
use App\Majlis;
use App\Subscription;
use App\SubscriptionType;
include(app_path() . '/libraries/SmsClass.php');

class ReceiptController extends Controller
{
	
	public function __construct()
    {
        $this->middleware('auth');
		//$this->middleware('admin', ['only' => ['create']]);
    } 		
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
	
    public function unApprovedList()
    {
		$mainList = array();
		$memberIds = array();
		$memberDetails = array();
		$receipts = Receipt::where('magazine',Auth::user()->magazine_type)
							 ->where('accepted',0)
							 ->get();
		foreach($receipts as $receipt)
		{
			$memberIds[] = 	$receipt -> member_id;
		}
		
		$members = Member::whereIn('id',$memberIds) -> get();		

		foreach($members as $member)
		{
			$memberDetails[$member -> id] = array('name'=> $member->name,'majlis'=>$member->majlis,'mobile'=>$member->mobile); 
		}
		foreach($receipts as $receipt)
		{
			if(Auth::user()->majlis == $memberDetails[$receipt -> member_id]['majlis'] || Auth::user()->admin)
				$mainList[$receipt -> id] = array('receipt_number' => $receipt -> receipt_number,
												  'name' => $memberDetails[$receipt -> member_id]['name'],
												  'mobile' => $memberDetails[$receipt -> member_id]['mobile'],
												  'majlis' => $memberDetails[$receipt -> member_id]['majlis'],
												  'type' => $receipt -> type,
												  'year' => $receipt -> year,
												  'amount' => $receipt -> amount
												  );
		}
	
		return view('receipts.unApprovedList',compact('mainList'));
    }	
	
    public function approve()
    {
		$mainArray = array();
		foreach($_POST as $key => $value)
		{
			$stringSplit = explode('-',$key);
			if(isset($stringSplit[0]) && isset($stringSplit[1]))
			{
				$label = $stringSplit[0];
				$id = $stringSplit[1]; 
				if(array_key_exists($stringSplit[1],$_POST))
				{
					$mainArray[$id][$label] = $_POST[$label.'-'.$id];
				}						
			}
		}
		//var_dump($mainArray);
		$approve = Receipt::whereIn('Id', array_keys($mainArray))->update(array('accepted' => 1));
		
		foreach($mainArray as $id => $subArray)
		{
			$mobile = null;
			$name = null;
			$receipt_number = null;
			
			foreach($subArray as $label => $value)
			{
				if($label == 'mobile')
					$mobile = $value;
				if($label == 'name')
					$name = $value;
				if($label == 'receipt_number')	
					$receipt_number = $value;
			}
			//sendSMS($mobile,$name,$receipt_number);	
		}
    }		

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$majlisList = array();
		$memberList = array();
	
		$userMajlis = Majlis::where('name',Auth::user()->majlis)->first();
		
		$typeList = SubscriptionType::where('magazine',Auth::user()->magazine_type)
					  ->distinct('type')
					  ->orderBy('type')
					  ->pluck('type')
					  ->toArray();

		//Only admin can access sponsorship details
		if(!Auth::user()-> admin)
		{
			if(($key = array_search('Sponsorship', $typeList)) !== false)
				unset($typeList[$key]);					
		}	

					  
		$yearList = Subscription::distinct('year')
					  ->orderBy('year')
					  ->pluck('year');	
		 
		
		if(Auth::user()->admin)
			$majlisList = Majlis::all();
		  else
			$majlisList = Majlis::where('name',$userMajlis->name)->get();		
		
		return view('receipts.create',compact('typeList','yearList','majlisList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReceiptFormRequest $request)
    {	
		// Check if subscription plan exist
		try 
		{
			$subcription = Subscription::where('magazine',Auth::user()-> magazine_type)
							->where('type',$request->get('type'))
							->where('year',$request->get('year'))
							->firstorFail();
		}
		catch (ModelNotFoundException $e) 
		{
			return redirect()->back()->with('status', 'Error!!!  Please contact admin <br><br> The subscription rate of <b>"'.$request->get("type").'"</b> for <b>'. $request->get("year"). '</b> is not finalised.');					
		}	

		// Check if Member subscription exist		
		try 
		{
			$memberSubcription = MemberSubscription::where('subscription_id',$subcription->id)
							->where('member_id',$request->get('member'))
							->firstorFail();		
		}					
		catch (ModelNotFoundException $e) 
		{
			return redirect()->back()->with('status', 'Error!!!<br><br> <b>"'.$request->get('type').'"</b> subscription  for <b>'.$request->get('year').'</b> is not found for the selected member.<br>To add new subscription, <b><u><a href="/MemberSubscriptions/create">Click here</a></b></u>');							
		}
		
        $receipt = new Receipt(array(
            'receipt_number' => $request->get('receipt_no'),
            //'majlis' => $request->get('majlis'),
            'member_id' => $request->get('member'),
            'amount' => $request->get('amount'),
            'year' => $request->get('year'),
            'magazine' => Auth::user()-> magazine_type,
            'type' => $request->get('type'),
			'accepted' => 0
        ));
		try{
			$receipt -> save();
			return redirect()->back()->with('status', 'Success!!!<br><br> Receipt inserted successfully!');								
		}	
		catch(\Illuminate\Database\QueryException $e){
			return redirect()->back()->with('status', 'Error!!! Please contact admin with the following error detail :<br><br>'.$e->getMessage());								
		}				
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
