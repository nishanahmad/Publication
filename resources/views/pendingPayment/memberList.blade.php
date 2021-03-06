@extends('master')
@section('title', 'Pending')
@section('content')
	<style>
	.dataTables_filter { display: none; }
	</style>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js" type="text/javascript"></script>
	<script>
	$(document).ready(function () {          
		setTimeout(function() {
			$('#successMessage').slideUp("slow");
		}, 3000);
	});
	</script>
	
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="/css/glow_box.css">
	
    <div class="container col-md-6 col-md-offset-3">
			@if (session('status'))
			<div class="alert alert-success" id="successMessage">
				{{ session('status') }}
			</div>
			@endif
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2> Pending Payment of {{$jamath->name}}</h2>
                </div>
				
                @if (empty($pendingMap))
					<br>	
                    <p> There is no Subscription entered for {{$jamath->name}}</p>
					<br><br>
                @else		

					<div align="center">
					<select name="year" id="year" onchange="document.location.href = '/Payment/memberPending/{{$jamath->id}}/' + this.value">
                    @foreach($yearList as $year)
						@if( substr(Request::url(), -4) == $year)
							<option  value="{{ $year }}" selected >{{ $year }}</option>
						@else
							<option  value="{{ $year }}">{{ $year }}</option>
						@endif
					@endforeach		
					</select>
					</div>
					
					<div align="center">
					<br>
					<input type="text" style ="width:15%" id="name" class="search-input-text textarea" placeholder="Search Name..." />&nbsp&nbsp&nbsp
					<input type="text" style ="width:15%" id="code" class="search-input-text textarea" placeholder="Search Code..." />
					<br><br>
					</div>					
					<table class="table display compact cell-border" cellspacing="0" id="table">
                        <thead>
                            <tr>
                                <th style="width:35%">Name</th>
								<th style="width:15%">Code</th>
                                <th>Subscr Amount</th>
								<th>Paid Amount</th>
								<th>Balance</th>
								<th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($members as $member)
                                <tr>
                                    <td><a href="{{ URL::to('member/'.$member->id)}}">{{ $member->name }}</a></td>
                                    <td>{{ $member->code }} </td>
									<td>{{ $pendingMap[$member->id] }} </td>
									<td>{{ $paidMap[$member->id] }} </td>
									<td>{{ $pendingMap[$member->id] - $paidMap[$member->id] }} </td>
									<td><a href="{{ URL::to('Receipts/create/'.$member->id.'/'.substr(Request::url(), -4))}}" class="btn btn-info" style="margin:0px 0px;padding:4px 15px;">Add Receipt</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
    </div>
	<script>
		$(document).ready(function() {
		 
			// DataTable
			var table = $('#table').DataTable({
				"paging" : false
			});
		 
			// Apply the search
			$('#name').keyup(function(){
				table.column(0).search(this.value).draw();
			})			
			$('#code').keyup(function(){
				table.column(1).search(this.value).draw();
			})						
		} );
	</script>	
@endsection
