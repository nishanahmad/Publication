@extends('master')
@section('title', 'Annual Rates')
@section('content')

    <div class="container col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2> Annual Rates</h2>					
                </div>
				
				@if (session('status'))
				<div class="alert alert-success">
					{{ session('status') }}
				</div>
				@endif

                @if (empty($rates))
					<p> There is no Subscription rates available.<br><br></p>				
                @else				
			</div>
				<table class="table">
					<thead>
						<tr>
							<th>Year</th>
							<th>Rate</th>
						</tr>
					</thead>
					<tbody>
						@foreach($rates as $rate)
							<tr>
								<td>{{ $rate -> year }} </td>
								<td>{{ $rate -> rate }} </td>
							</tr>
						@endforeach
					</tbody>
				</table>
                @endif
            </div>
    </div>

@endsection
