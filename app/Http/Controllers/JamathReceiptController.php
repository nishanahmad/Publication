<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use App\JamathReceipt;
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
		if(Auth::user()->admin)
			$jamathReceipts = JamathReceipt::all();
		else
			$jamathReceipts = JamathReceipt::where('jamath_id',Auth::user()->jamath_id)->get();

		$jamaths = JamathReceipt::with('jamath');		
		return view('jamathReceipts.index',compact('jamathReceipts','jamaths'));        
    }


    public function create()
    {
		$jamathList = Jamath::all();
		
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