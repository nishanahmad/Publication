<nav class="navbar navbar-default">
    <div align="center" style="font-size:30px;">{{Auth::user()->magazine_type}}</div>
	<div class="container-fluid">
		
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-left">
                <li class="active"><a href="/">Home</a></li>
                <li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Members 
					<span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
					<li><a href="/members/create">New Member</a></li>
					<li><a href="/members/index">List Members</a></li>
					</ul>
				</li>
                <li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Subscriptions 
					<span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
					<li><a href="/MemberSubscriptions/create">New Subscription</a></li>
					<li><a href="/MemberSubscriptions/index/<?php echo date("Y");?>">List Subscriptions</a></li>
					</ul>
				</li>								
                <li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Receipts 
					<span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
					<li><a href="/Receipts/create">New Member Receipt</a></li>
					<li><a href="/JamathReceipts/create">New Jamath Receipt</a></li>
					<li><a href="/Receipts/index/<?php echo date("Y");?>">List Receipts</a></li>
					<li><a href="/Receipts/approve">Verify & send SMS</a></li>
					</ul>
				</li>												
                <li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Annual Rates 
					<span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
					<li><a href="/subscriptions/update">Update Rates</a></li>
					<li><a href="/subscriptions/index/<?php echo date("Y");?>"">List Rates</a></li>
					</ul>
				</li>				
                <li><a href="/Payment/jamathPending">Pending Payment</a></li>				
			</ul>				
			<ul class="nav navbar-nav navbar-right">                
				<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} 
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
						<li><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
							Logout
						</a>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							{{ csrf_field() }}
						</form>
						</li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>