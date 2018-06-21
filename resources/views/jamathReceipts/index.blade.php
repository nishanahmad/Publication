@extends('master')
@section('title', 'Jamath Receipts')
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
			<h2> Jamath Receipts list</h2>
		</div>
		
		@if (session('status'))
		<div class="alert alert-success">
			{{ session('status') }}
		</div>
		@endif

		@if (empty($jamathReceipts))
			<p> No receipts found</p>
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
						<th style ="width:20%">Jamath</th>
						<th style ="width:14%">Amount</th>
						<th style ="width:8%">Year</th>													
						<th>Remarks</th>
					</tr>
				</thead>
				<tbody>
					@foreach($jamathReceipts as $receipt)
						 <tr style ="word-break:break-word;;font-size:15px">
							<td>{{ $receipt->jamath_id }} </td>
							<td>{{ $receipt->amount }} </td>
							<td>{{ $receipt->year }} </td>
							<td>{{ $receipt->remarks }} </td>
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