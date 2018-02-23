@extends('master')
@section('title', 'Pending')
@section('content')

    <div class="container col-md-8 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2> Annual rates of {{ substr(Request::url(), -4) }}</h2>
                </div>
				
				@if (session('status'))
				<div class="alert alert-success">
					{{ session('status') }}
				</div>
				@endif

                @if (empty($subscriptions))
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
					<br><br>
					</div>
					<p> There is no rate updated for the selected year.<br><br></p>
                    
                @else				
					<div align="center">
					<select name="year" id="year" onchange="document.location.href = '/subscriptions/index/' + this.value">
                    <option  value="All" selected >ALL</option>
					@foreach($yearList as $year)
						@if( substr(Request::url(), -4) == $year)
							<option  value="{{ $year }}" selected >{{ $year }}</option>
						@else
							<option  value="{{ $year }}">{{ $year }}</option>
						@endif
					@endforeach		
					</select>
					<table class="table">
                        <thead>
                            <tr>
                                <th>Subscription Type</th>
                                <th>Year</th>
                                <th>Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subscriptions as $subscription)
                                <tr>
                                    <td>{{ $subscription -> type }} </td>
									<td>{{ $subscription -> year }} </td>
                                    <td>{{ $subscription -> rate }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>					
					</div>
                @endif
            </div>
    </div>

@endsection
