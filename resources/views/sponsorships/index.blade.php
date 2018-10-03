@extends('master')
@section('title', 'Sponsorships')
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
			<h2> Sponsorships</h2>
		</div>
		
		@if (session('status'))
		<div class="alert alert-success">
			{{ session('status') }}
		</div>
		@endif

		@if (empty($sponsorships))
			<p> No Sponsorships found.</p>
		@else
			
			<div align="center">
			<br>
			<input type="text" style ="width:10%" id="code" class="search-input-text textarea" placeholder="Search code..." />&nbsp&nbsp&nbsp
			<input type="text" style ="width:10%" id="name" class="search-input-text textarea" placeholder="Search name..." />&nbsp&nbsp&nbsp
			<input type="text" style ="width:10%" id="jamath" class="search-input-text textarea" placeholder="Search Jamath..." />&nbsp&nbsp&nbsp
			<input type="text" style ="width:10%" id="year" class="search-input-text textarea" placeholder="Search year..." />&nbsp&nbsp&nbsp
			<br><br>
			</div>
			<table class="table display compact cell-border" cellspacing="0" id="table" style="width:70%">
				<thead>
					<tr>
						<th>Id</th>							
						<th>Jamath</th>
						<th>Member Name</th>
						<th>Member Code</th>							
						<th>Amount</th>
						<th>Year</th>
						<th>Remarks</th>
					</tr>
				</thead>
				<tbody>
					@foreach($sponsorships as $sponsorship)
						 <tr style ="word-break:break-word;;font-size:15px">
							<td><a href="/sponsorship/{{ $sponsorship -> id }}">{{ $sponsorship -> id }}</a></td>
							<td>{{ $sponsorship -> jamath -> name }} </td>
							@if(isset($sponsorship -> member))
								<td>{{ $sponsorship -> member -> code }} </td>
								<td><a href="/member/{{ $sponsorship -> member -> id }}">{{ $sponsorship -> member -> name }}</a></td>
							@else
								<td></td>		
								<td></td>		
							@endif	
							<td>{{ $sponsorship -> amount }} </td>
							<td>{{ $sponsorship -> year }} </td>
							<td>{{ $sponsorship -> remarks }} </td>
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
			$('#year').keyup(function(){
				table.column(5).search(this.value).draw();
			})									
		} );
  </script>	
@endsection