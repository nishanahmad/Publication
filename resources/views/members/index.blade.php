@extends('master')
@section('title', 'Members')
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
			<h2> Members list</h2>
		</div>
		
		@if (session('status'))
		<div class="alert alert-success">
			{{ session('status') }}
		</div>
		@endif

		@if (empty($members))
			<p> No member found for your majlis</p>
		@else
			
			<div align="center">
			<br>
			<input type="text" style ="width:10%" id="code" class="search-input-text textarea" placeholder="Search code..." />&nbsp&nbsp&nbsp
			<input type="text" style ="width:10%" id="name" class="search-input-text textarea" placeholder="Search name..." />&nbsp&nbsp&nbsp
			<input type="text" style ="width:10%" id="majlis" class="search-input-text textarea" placeholder="Search Jamath..." />
			<br><br>
			</div>
			<table class="table display compact cell-border" cellspacing="0" id="table">
				<thead>
					<tr>
						<th style ="width:8%">Code</th>							
						<th style ="width:20%">Name</th>
						<th style ="width:14%">Jamath</th>
						<th>Address 1</th>
						<th>Address 2</th>
						<th>Place</th>
						<th style ="width:10%">Mobile</th>
					</tr>
				</thead>
				<tbody>
					@foreach($members as $member)
						 <tr style ="word-break:break-word;;font-size:15px">
							<td><a href="/member/{{ $member['id'] }}">{{ $member['code'] }} </a></td>
							<td>{{ $member['name'] }} </td>
							<td>{{ $member['majlis'] }} </td>
							<td>{{ $member['address1'] }} </td>
							<td>{{ $member['address2'] }} </td>
							<td>{{ $member['place'] }} </td>
							<td>{{ $member['mobile'] }} </td>
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
				table.column(0).search(this.value).draw();
			})
			$('#name').keyup(function(){
				table.column(1).search(this.value).draw();
			})
			$('#majlis').keyup(function(){
				table.column(2).search(this.value).draw();
			})			
		} );
  </script>	
@endsection