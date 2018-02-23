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
	
    <div class="container col-md-8 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2> Pending Payment list of {{ substr(Request::url(), -4) }}</h2>
                </div>
				
				@if (session('status'))
				<div class="alert alert-success">
					{{ session('status') }}
				</div>
				@endif

                @if (empty($mainList))
					<div align="center">
					<select name="year" id="year" onchange="document.location.href = '/Payment/pending/' + this.value">
                    <option  value="All" selected >ALL</option>
					@foreach($yearList as $year)
						@if( substr(Request::url(), -4) == $year)
							<option  value="{{ $year }}" selected >{{ $year }}</option>
						@else
							<option  value="{{ $year }}">{{ $year }}</option>
						@endif
					@endforeach		
					</select>
					</div>
					<br>	
                    <p> There is no Subscription entered for the selected year.</p>
					<br><br>
                @else				
					<div align="center">
					<select name="year" id="year" onchange="document.location.href = '/Payment/pending/' + this.value">
                    <option  value="All" selected >ALL</option>
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
					<input type="text" style ="width:15%" id="majlis" class="search-input-text textarea" placeholder="Search Jamath..." />&nbsp&nbsp&nbsp
					<br><br>
					</div>					
					<table class="table display compact cell-border" cellspacing="0" id="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Jamath</th>
                                <th>Pending Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mainList as $row)
                                <tr>
                                    <td>{{ $row['name'] }} </td>
									<td>{{ $row['majlis'] }} </td>
                                    <td>{{ $row['rate'] }} </td>
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
			$('#majlis').keyup(function(){
				table.column(1).search(this.value).draw();
			})			
		} );
	</script>	
@endsection
