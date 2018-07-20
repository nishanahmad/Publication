@extends('master')
@section('title', 'Member Receipts')
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
			<h2> Member Receipts</h2>
		</div>
		
		@if (session('status'))
		<div class="alert alert-success">
			{{ session('status') }}
		</div>
		@endif

		@if (empty($receipts))
			<p> No receipts found.</p>
		@else
			
			<div align="center">
			<br>
			<input type="text" style ="width:10%" id="code" class="search-input-text textarea" placeholder="Search code..." />&nbsp&nbsp&nbsp
			<input type="text" style ="width:10%" id="name" class="search-input-text textarea" placeholder="Search name..." />&nbsp&nbsp&nbsp
			<input type="text" style ="width:10%" id="jamath" class="search-input-text textarea" placeholder="Search Jamath..." />&nbsp&nbsp&nbsp
			<input type="text" style ="width:10%" id="year" class="search-input-text textarea" placeholder="Search year..." />&nbsp&nbsp&nbsp
			<input type="text" style ="width:10%" id="receipt" class="search-input-text textarea" placeholder="Search ReceiptNo..." />
			<br><br>
			</div>
			<table class="table display compact cell-border" cellspacing="0" id="table" style="width:70%">
				<thead>
					<tr>
						<th>Id</th>							
						<th>Member Code</th>							
						<th>Name</th>
						<th>Jamath</th>
						<th>Amount</th>
						<th>Year</th>
						<th>Receipt No.</th>						
						<th>Remarks</th>
					</tr>
				</thead>
				<tbody>
					@foreach($receipts as $receipt)
						 <tr style ="word-break:break-word;;font-size:15px">
							<td><a href="/receipt/{{ $receipt -> id }}">{{ $receipt -> id }}</a></td>
							<td>{{ $receipt -> member -> code }} </td>
							<td><a href="/member/{{ $receipt -> member -> id }}">{{ $receipt -> member -> name }}</a></td>
							<td>{{ $receipt -> member -> jamath -> name }} </td>
							<td>{{ $receipt -> amount }} </td>
							<td>{{ $receipt -> year }} </td>
							<td>{{ $receipt -> receipt_number }} </td>
							<td>{{ $receipt -> remarks }} </td>
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
			$('#receipt').keyup(function(){
				table.column(6).search(this.value).draw();
			})						
		} );
  </script>	
@endsection