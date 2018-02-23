<?php

namespace App\Http\Middleware;

use Closure;
use App\Member;
use Illuminate\Support\Facades\Auth;

class CheckMajlis
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		$member = Member::whereId($request->route()->parameter('id'))->firstOrFail();
		$majlis = $member -> majlis;
        
		if (Auth::user() &&  (Auth::user()->majlis == $majlis || Auth::user()->admin)) {
			return $next($request);
        }

		return redirect('/') ->with('status', 'Insufficient privilege to carry out the request. Please contact admin');
    }

}