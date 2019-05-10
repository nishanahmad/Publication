<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReceiptFormRequest;
use App\Receipt;
use App\Member;
use App\Jamath;
use App\Subscription;
use App\AnnualRate;
include(app_path() . '/libraries/SmsClass.php');

class ReceiptController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
		//$this->middleware('admin', ['only' => ['create']]);
    } 		

	
    public function index()
    {
		$receipts = Receipt::all();
		
		return view('receipts.index',compact('receipts'));
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


    public function create($memberId = null,$urlYear = null)
    {
		if($memberId != null)
			$urlMember = Member::where('id',$memberId)->firstOrFail();

		$jamathList = array();
		$memberList = array();
	
		$userJamath = Jamath::where('name',Auth::user()->jamath_id)->first();
					  
		$yearList = AnnualRate::distinct('year')
					  ->orderBy('year')
					  ->pluck('year');	
		 
		
		if(Auth::user()->admin)
			$jamathList = Jamath::all()->sortby('name');
		  else
			$jamathList = Jamath::where('id',$userJamath->id)->get();		
		
		return view('receipts.create',compact('yearList','jamathList','urlMember','urlYear'));
    }


    public function store(ReceiptFormRequest $request)
    {	
		// Check if subscription plan exist
		$year = $request->get('year');
		$subscriptions =  Subscription::where(function($query) use ($year){
								$query->where('start_year', '<=' , $year)
								->where('end_year', null);
								})
								->orWhere(function($query) use ($year){
								$query->where('start_year', '<=' , $year)
								->where('end_year', '>=' ,$year);
								})
								->get();
		if($subscriptions -> count() <=0)							
			return redirect()->back()->with('status', 'Error!!! <br><br> The subscription for the member for <b>'. $year. '</b> is not found.');					
		
		else
		{
			$receipt = new Receipt(array(
				'receipt_number' => $request->get('receipt_no'),
				'member_id' => $request->get('member'),
				'amount' => $request->get('amount'),
				'year' => $request->get('year'),
				'accepted' => 0,
				'date' => date('Y-m-d', strtotime($request->get('date'))),				
				'remarks' => $request->get('remarks')
			));
			try{
				$receipt -> save();
				return redirect('Payment/memberPending/'.$receipt->member->jamath->id.'/'.$receipt->year)->with('status', 'Receipt inserted successfully!!!');								
			}	
			catch(\Illuminate\Database\QueryException $e){
				return redirect()->back()->with('status', 'Error!!! Please contact admin with the following error detail :<br><br>'.$e->getMessage());								
			}							
		}
    }

	
    public function show($id)
    {
		$receipt = Receipt::where('id',$id)->firstOrFail();     
		
		return view('receipts.show',compact('receipt'));		
    }

	
    public function edit($id)
    {
		$receipt = Receipt::where('id',$id)->firstOrFail();     
		$jamathList = Jamath::all()->sortby('name');
		$yearList = AnnualRate::distinct('year')
					  ->orderBy('year')
					  ->pluck('year');			
		
		return view('receipts.edit',compact('receipt','jamathList','yearList'));		
    }


    public function update(Request $request, $id)
    {
        $receipt = Receipt::where('id',$id)->firstOrFail(); 

		$receipt -> receipt_number = $request->get('receipt_no');
		$receipt -> amount = $request->get('amount');
		$receipt -> year = $request->get('year');
		$receipt ->date = $request->get('date');
		$receipt -> remarks = $request->get('remarks');		
		
		try{
			$receipt -> save();
			return redirect('Receipt/'.$receipt -> id)->with('status', 'Success!!!<br><br> Receipt updated successfully!');								
		}	
		catch(\Illuminate\Database\QueryException $e){
			return redirect()->back()->with('status', 'Error!!! Please contact admin with the following error detail :<br><br>'.$e->getMessage());								
		}									
    }

	
    public function destroy($id)
    {
		$receipt = Receipt::whereId($id)->firstOrFail();
		$receipt -> delete();	

		return redirect('Receipts/index');
    }
}
