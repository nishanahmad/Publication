<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use App\JamathReceipt;
use App\Sponsorship;
use App\Jamath;
use App\AnnualRate;

class JamathReceiptController extends Controller
{
	
	public function __construct()
    {
        $this->middleware('auth');
		$this->middleware('admin', ['only' => ['create']]);
    } 	


    public function index()
    {
		$jamathReceipts = JamathReceipt::orderBy('id', 'DESC')->get();
		$sponsorships = Sponsorship::where('member_id', 0)
						->orWhere('member_id', null)
						->get();
		
		$jamaths = JamathReceipt::with('jamath');		
		return view('jamathReceipts.index',compact('jamathReceipts','sponsorships','jamaths'));        
    }


    public function create()
    {
		$jamathList = Jamath::all()->sortby('name');
		
		$yearList = AnnualRate::distinct('year')
					  ->orderBy('year')
					  ->pluck('year');	
					  
		return view('jamathReceipts.create',compact('jamathList','yearList'));
    }

	
    public function store(Request $request)
    {		
        $jamathReceipt = new JamathReceipt(array(
            'jamath_id' => $request->get('jamath_id'),
            'amount' => $request->get('amount'),
			'year' => $request->get('year'),
			'date' => date('Y-m-d', strtotime($request->get('date'))),
			'remarks' => $request->get('remarks')
        ));
		try{
			$jamathReceipt -> save();
			return redirect()->back()->with('status', 'Success!!!<br><br> Receipt inserted successfully!');								
		}	
		catch(\Illuminate\Database\QueryException $e){
			return redirect()->back()->with('status', 'Error!!! Please contact admin with the following error detail :<br><br>'.$e->getMessage());								
		}
    }


    public function show($id)
    {
		$receipt = JamathReceipt::whereId($id)->firstOrFail();
        return view('jamathReceipts.show', compact('receipt'));
    }


    public function edit($id)
    {
		$jamathList = Jamath::all()->sortby('name');
		
		$yearList = AnnualRate::distinct('year')
					  ->orderBy('year')
					  ->pluck('year');	
					  
		$receipt = JamathReceipt::whereId($id)->firstOrFail();

        return view('jamathReceipts.edit', compact('receipt','yearList','jamathList'));
    }


    public function update(Request $request, $id)
    {
		$jamathReceipt = JamathReceipt::whereId($id)->firstOrFail();
		$jamathReceipt->jamath_id = $request->get('jamath_id');
		$jamathReceipt->year = $request->get('year');
		$jamathReceipt->amount = $request->get('amount');
		$jamathReceipt->date = $request->get('date');
		$jamathReceipt->remarks = $request->get('remarks');

		$jamathReceipt->save();
		return redirect('JamathReceipt/'.$id)->with('status', 'Receipt successfully updated!');
    }


    public function destroy($id)
    {
		$jamathReceipt = JamathReceipt::whereId($id)->firstOrFail();
		$jamathReceipt -> delete();	

		return redirect('JamathReceipts/index');
    }
}