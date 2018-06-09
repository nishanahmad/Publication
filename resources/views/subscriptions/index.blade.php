@extends('master')
@section('title', 'View all Subscriptions')
@section('content')

    <div class="container col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2> Subscription list of {{ substr(Request::url(), -4) }}</h2>					
                </div>
				
				@if (session('status'))
				<div class="alert alert-success">
					{{ session('status') }}
				</div>
				@endif

                @if (empty($mainList))
					<div align="center">
					<select name="year" id="year" onchange="document.location.href = '/Subscriptions/index/' + this.value">
                    @foreach($yearList as $year)
						@if( substr(Request::url(), -4) == $year)
							<option  value="{{ $year }}" selected >{{ $year }}</option>
						@else
							<option  value="{{ $year }}">{{ $year }}</option>
						@endif
					@endforeach		
					</select>
					</div>
					<br><br>
					<p> There is no Subscription entered for the selected year.<br><br></p>				
                @else				
					<div align="center">
					<select name="year" id="year" onchange="document.location.href = '/Subscriptions/index/' + this.value">
                    @foreach($yearList as $year)
						@if( substr(Request::url(), -4) == $year)
							<option  value="{{ $year }}" selected >{{ $year }}</option>
						@else
							<option  value="{{ $year }}">{{ $year }}</option>
						@endif
					@endforeach		
					</select>
					</div>
					<table class="table">
                        <thead>
                            <tr>
								<th style="text-align:center">SubId</th>
								<th>Member Code</th>
                                <th>Name</th>
                                <th>Jamath</th>
								<th>Start Month</th>
								<th>End Month</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mainList as $row )
                                <tr>
									<td style="text-align:center"><a href="{{ URL::to('Subscription/'.$row['id'])}}">{{ $row['id'] }}</a></td>
									<td>{{ $row['code'] }} </td>
                                    <td>{{ $row['name'] }} </td>
									<td>{{ $row['jamath'] }} </td>
									<td>{{ $row['start_month'] }} </td>
									<td>{{ $row['end_month'] }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
    </div>

@endsection
