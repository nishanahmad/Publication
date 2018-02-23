<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TicketFormRequest;
use App\SubscriptionType;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
	public function test()
    {
		$typeList = SubscriptionType::where('magazine',Auth::user()->magazine_type)
			  ->distinct('type')
			  ->orderBy('type')
			  ->pluck('type')
			  ->toArray();		
		dd($typeList);	  
		if(($key = array_search('Sponsorship', $typeList)) !== false) {
			unset($typeList[$key]);
		//dd($typeList);	
}

    }
}