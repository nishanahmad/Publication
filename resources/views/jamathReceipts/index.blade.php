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
			<input type="text" style ="width:10%" id="jamath" class="search-input-text textarea" placeholder="Search Jamath..." />&nbsp&nbsp&nbsp
			<input type="text" style ="width:10%" id="year" class="search-input-text textarea" placeholder="Search Year..." />
			<br><br>
			</div>
			<h2>Jamath Receipts</h2>
			<table class="table display compact cell-border" cellspacing="0" id="table" style="width:75%">
				<thead>
					<tr>
						<th style ="width:5%">Receipt Id</th>
						<th style ="width:10%">Payment Date</th>
						<th style ="width:20%">Jamath</th>
						<th style ="width:8%">Year</th>													
						<th style ="width:14%">Amount</th>
						<th>Remarks</th>
					</tr>
				</thead>
				<tbody>
					@foreach($jamathReceipts as $receipt)
						 <tr style ="word-break:break-word;;font-size:15px">
							<td><a href="/JamathReceipt/{{ $receipt->id }}">{{ $receipt->id }} </a></td>
							@if(isset($receipt->date))
								<td>{{ date("d-m-Y",strtotime($receipt->date)) }}</td>
							@else
								<td></td>
							@endif							
							<td>{{ $receipt->jamath->name }} </td>
							<td>{{ $receipt->year }} </td>
							<td>{{ $receipt->amount }} </td>
							<td>{{ $receipt->remarks }} </td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<br/><br/>
			<h2>Jamath Sponsorships</h2>
			<table class="table display compact cell-border" cellspacing="0" id="table2" style="width:75%">
				<thead>
					<tr>
						<th style ="width:5%">Sponsorship Id</th>
						<th style ="width:10%">Payment Date</th>
						<th style ="width:20%">Jamath</th>
						<th style ="width:8%">Year</th>													
						<th style ="width:14%">Amount</th>
						<th>Remarks</th>
					</tr>
				</thead>
				<tbody>
					@foreach($sponsorships as $receipt)
						 <tr style ="word-break:break-word;;font-size:15px">
							<td><a href="/sponsorship/{{ $receipt->id }}">{{ $receipt->id }} </a></td>
							@if(isset($receipt->date))
								<td>{{ date("d-m-Y",strtotime($receipt->date)) }}</td>
							@else
								<td></td>
							@endif	
							@if(isset($receipt->jamath))
								<td>{{ $receipt->jamath->name }} </td>
							@else
								<td></td>
							@endif								
							<td>{{ $receipt->year }} </td>
							<td>{{ $receipt->amount }} </td>
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
		 
			var table = $('#table').DataTable({
				"paging" : false
			});

			var table2 = $('#table2').DataTable({
				"paging" : false
			});
			
			// Apply the search
			$('#jamath').keyup(function(){
				table.column(2).search(this.value).draw();
				table2.column(2).search(this.value).draw();				
			})
			$('#year').keyup(function(){
				table.column(3).search(this.value).draw();
				table2.column(3).search(this.value).draw();				
			})			
		} );
  </script>	
@endsection