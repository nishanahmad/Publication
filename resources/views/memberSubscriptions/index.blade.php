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
					<select name="year" id="year" onchange="document.location.href = '/MemberSubscriptions/index/' + this.value">
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
					<select name="year" id="year" onchange="document.location.href = '/MemberSubscriptions/index/' + this.value">
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
                                <th>Name</th>
                                <th>Jamath</th>
                                <th>Subscription Type</th>
								<th>Year</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mainList as $row)
                                <tr>
                                    <td>{{ $row['name'] }} </td>
									<td>{{ $row['majlis'] }} </td>
                                    <td>{{ $row['type'] }} </td>
									<td>{{ $row['year'] }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
    </div>

@endsection
