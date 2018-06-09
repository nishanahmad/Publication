<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AnnualRate;
use App\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnnualRateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); //->except(['index'])
		$this->middleware('admin') ->except(['index']) ; 
    } 	

	
    public function index()
    {	
		//$yearList = AnnualRate::distinct('year')
		//					->orderBy('year')
		//					->pluck('year');
		
		$rates =  AnnualRate::All();
		
		return view('rates.index',compact('yearList','rates'));         
    }


    public function create()
    {
		$yearList = array(date("Y")-1,date("Y")+0,date("Y")+1);
		$typeList = SubscriptionType::where('magazine',Auth::user()->magazine_type)->get();
		return view('subscriptions.create',compact('typeList','yearList'));
    }


    public function store(Request $request)
    {
		$typeList = SubscriptionType::where('magazine',Auth::user()->magazine_type)->get();
		$subscriptions = array();
		foreach($typeList as $type)
		{
			$subscription = new Subscription(array(
			'magazine' => Auth::user()->magazine_type,
			'type' => $type->type,
			'year' => $request->get('year'),	
			'rate' => $request->get($type->type),
			));
			array_push($subscriptions,$subscription->toArray());
		}			

		DB::beginTransaction();

		try
		{
			Subscription::insert($subscriptions); // Bulk insert			
		}
		catch(\Illuminate\Database\QueryException $e)
		{
			DB::rollback();
			if($e->getMessage())
			{
				if (strpos($e->getMessage(), '1062') !== false) 
					return redirect()->back()->with('status', 'Duplicate error. Subscription rates for the selected year is already found in the database!');
				else
					return redirect()->back()->with('status', 'Error!!! Please contact admin -- '.$e->getMessage());					
			}	
			else
				return redirect()->back()->with('status', 'Error!!! Something went wrong please contact admin');								
		}
		try
		{
			$newMemberSubscriptions = MemberSubscription::insertBulk($subscriptions);
			MemberSubscription::insert($newMemberSubscriptions);
		}
		catch(\Illuminate\Database\QueryException $e)
		{
			DB::rollback();
			return redirect()->back()->with('status', 'Error!!! Please contact admin -- '.$e->getMessage());								
		}		
		DB::commit();
		return redirect()->back()->with('status', 'Successfully updated the subscription rates for the new year!');					
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
