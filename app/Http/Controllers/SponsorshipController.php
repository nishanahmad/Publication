<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReceiptFormRequest;
use App\Sponsorship;
use App\Member;
use App\Jamath;
use App\AnnualRate;


class SponsorshipController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
		//$this->middleware('admin', ['only' => ['create']]);
    } 		

	
    public function index()
    {
		$sponsorships = Sponsorship::all();
		
		return view('sponsorships.index',compact('sponsorships'));
    }
	
    public function create()
    {
		$userJamath = Jamath::where('name',Auth::user()->jamath_id)->first();
					  
		$yearList = AnnualRate::distinct('year')
					  ->orderBy('year')
					  ->pluck('year');	
		 
		
		if(Auth::user()->admin)
			$jamathList = Jamath::all();
		  else
			$jamathList = Jamath::where('id',$userJamath->id)->get();		
		
		return view('sponsorships.create',compact('yearList','jamathList'));
    }


    public function insert(Request $request)
    {	
		$sponsorship = new Sponsorship(array(
			'jamath_id'=> $request->get('jamath_id'),
			'member_id' => $request->get('member'),
			'amount' => $request->get('amount'),
			'year' => $request->get('year'),
			'remarks' => $request->get('remarks')
		));
		try{
			$sponsorship -> save();
			return redirect()->back()->with('status', 'Success!!!<br><br> Sponsorship inserted successfully!');								
		}	
		catch(\Illuminate\Database\QueryException $e){
			return redirect()->back()->with('status', 'Error!!! Please contact admin with the following error detail :<br><br>'.$e->getMessage());								
		}							
    }

	
    public function show($id)
    {
		$sponsorship = Sponsorship::where('id',$id)->firstOrFail();     
		
		return view('sponsorships.show',compact('sponsorship'));		
    }

	
    public function edit($id)
    {
		/*
		$receipt = Receipt::where('id',$id)->firstOrFail();     
		$jamathList = Jamath::All();
		$yearList = AnnualRate::distinct('year')
					  ->orderBy('year')
					  ->pluck('year');			
		
		return view('receipts.edit',compact('receipt','jamathList','yearList'));		
		*/
    }


    public function update(Request $request, $id)
    {
		/*
        $receipt = Receipt::where('id',$id)->firstOrFail(); 

		$receipt -> receipt_number = $request->get('receipt_no');
		$receipt -> amount = $request->get('amount');
		$receipt -> year = $request->get('year');
		$receipt -> remarks = $request->get('remarks');		
		
		try{
			$receipt -> save();
			return redirect('Receipt/'.$receipt -> id)->with('status', 'Success!!!<br><br> Receipt updated successfully!');								
		}	
		catch(\Illuminate\Database\QueryException $e){
			return redirect()->back()->with('status', 'Error!!! Please contact admin with the following error detail :<br><br>'.$e->getMessage());								
		}
		*/
    }

	
    public function destroy($id)
    {
		$sponsorship = Sponsorship::whereId($id)->firstOrFail();
		$sponsorship -> delete();	

		return redirect('sponsorships/index');
    }
}
