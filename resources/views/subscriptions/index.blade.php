@extends('master')
@section('title', 'View all Subscriptions')
@section('content')
	<style>
	.dataTables_filter { display: none; }
	</style>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js" type="text/javascript"></script>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="/css/glow_box.css">

	<div align="center">	
	<div class="panel panel-default" style="width:95%">
		<div class="panel-heading">
			<h2> Subscriptions list</h2>
		</div>
		
		@if (session('status'))
		<div class="alert alert-success">
			{{ session('status') }}
		</div>
		@endif

		@if (empty($subscriptions))
			<p> No subscriptions found.</p>
		@else
			
			<div align="center">
			<br>
			<input type="text" style ="width:10%" id="code" class="search-input-text textarea" placeholder="Search code..." />&nbsp&nbsp&nbsp
			<input type="text" style ="width:10%" id="name" class="search-input-text textarea" placeholder="Search name..." />&nbsp&nbsp&nbsp
			<input type="text" style ="width:10%" id="jamath" class="search-input-text textarea" placeholder="Search Jamath..." />
			<input type="text" style ="width:10%" id="start" class="search-input-text textarea" placeholder="Start Date..." />
			<input type="text" style ="width:10%" id="end" class="search-input-text textarea" placeholder="End Date..." />
			<br><br>
			</div>
			<table class="table display compact cell-border" cellspacing="0" id="table" style="width:60%">
				<thead>
					<tr>
						<th style="text-align:center">SubId</th>					
						<th>Member Code</th>							
						<th>Name</th>
						<th>Jamath</th>
						<th>Starts On</th>
						<th>Ends On</th>
					</tr>
				</thead>
				<tbody>
					@foreach($subscriptions as $subscription )
						 <tr style ="word-break:break-word;;font-size:15px">
							<td style="text-align:center"><a href="{{ URL::to('Subscription/'.$subscription->id)}}">{{ $subscription->id }}</a></td>
							<td>{{ $subscription -> member -> code }} </td>
							<td><a href="/member/{{ $subscription -> member -> id }}">{{ $subscription -> member -> name }}</a></td>
							<td>{{ $subscription -> member -> jamath -> name }} </td>
							<td>{{ $monthNames[$subscription -> start_month] . ' , ' .  $subscription -> start_year }} </td>
							@if (isset($subscription -> end_month))
								<td>{{ $monthNames[$subscription -> end_month] . ' , ' .  $subscription -> end_year }} </td>
							@else
								<td></td>
							@endif
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
			$('#code').keyup(function(){
				table.column(1).search(this.value).draw();
			})
			$('#name').keyup(function(){
				table.column(2).search(this.value).draw();
			})
			$('#jamath').keyup(function(){
				table.column(3).search(this.value).draw();
			})
			$('#start').keyup(function(){
				table.column(4).search(this.value).draw();
			})				
			$('#end').keyup(function(){
				table.column(5).search(this.value).draw();				
			})								
		} );
  </script>	
@endsection
