<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home()
    {
		if (Auth::check())
			return view('home');			
		else
			return view('auth/login');			
		
    }
	
	public function about()
	{
		return view('about');
	}

	public function contact()
	{
		return view('tickets.create');
	}
	
	public function test()
	{
		return view('tests.test');
	}	
	
}
