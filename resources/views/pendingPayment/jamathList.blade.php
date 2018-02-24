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
                    <h2> Jamath Wise Pending Payment</h2>
                </div>
				
				@if (session('status'))
				<div class="alert alert-success">
					{{ session('status') }}
				</div>
				@endif

                @if (empty($jamathList))
					<br>	
                    <p> There is no detail available.</p>
					<br><br>
                @else				
					<div align="center">
					<br>
					<input type="text" style ="width:15%" id="jamath" class="search-input-text textarea" placeholder="Search Jamath..." />&nbsp&nbsp&nbsp
					<br><br>
					</div>					
					<table class="table display compact cell-border" cellspacing="0" id="table">
                        <thead>
                            <tr>
                                <th>Jamath</th>
                                <th style="width:20%">Pending Amount</th>
								<th style="width:20%">Bulk Paid</th>
								<th style="width:20%">Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jamathList as $jamath)
                                <tr>
									<td><a href="/Payment/memberPending/{{ $jamath -> name }}">{{ $jamath -> name }} </td>
									<td>{{ $pendingMap[$jamath -> name] }} </td>
									<td>{{ $unaccountedMap[$jamath -> name] }} </td>
									<td>{{ $pendingMap[$jamath -> name] - $unaccountedMap[$jamath -> name]}}</td>
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
			$('#jamath').keyup(function(){
				table.column(0).search(this.value).draw();
			})			
		} );
	</script>	
@endsection
