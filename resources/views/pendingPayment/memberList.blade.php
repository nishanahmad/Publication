@extends('master')
@section('title', 'Pending')
@section('content')
	<style>
	.dataTables_filter { display: none; }
	</style>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js" type="text/javascript"></script>
	
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="/css/glow_box.css">
	
    <div class="container col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2> Pending Payment of {{$jamath->name}}</h2>
                </div>
				
				@if (session('status'))
				<div class="alert alert-success">
					{{ session('status') }}
				</div>
				@endif

                @if (empty($pendingMap))
					<br>	
                    <p> There is no Subscription entered for {{$jamath->name}}</p>
					<br><br>
                @else				
					<div align="center">
					<br>
					<input type="text" style ="width:15%" id="name" class="search-input-text textarea" placeholder="Search Name..." />&nbsp&nbsp&nbsp
					<br><br>
					</div>					
					<table class="table display compact cell-border" cellspacing="0" id="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Subscription Amount</th>
								<th>Paid Amount</th>
								<th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($members as $member)
                                <tr>
                                    <td><a href="{{ URL::to('member/'.$member->id)}}">{{ $member->name }}</a></td>
                                    <td>{{ $pendingMap[$member->id] }} </td>
									<td>{{ $paidMap[$member->id] }} </td>
									<td>{{ $pendingMap[$member->id] - $paidMap[$member->id] }} </td>
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
		} );
	</script>	
@endsection
