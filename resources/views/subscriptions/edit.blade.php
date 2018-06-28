@extends('master')
@section('title', 'Edit Subscription')

@section('content')
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

    <div class="container col-md-8 col-md-offset-2">
        <div class="well well bs-component">
            <form class="form-horizontal" method="post">
			@foreach ($errors->all() as $error)
				<p class="alert alert-danger">{!! $error !!}</p>
			@endforeach
			
			@if(session('status'))
				@if (strpos(session('status'), 'Success') !== false)
					<div class="alert alert-success">
						{{ session('status') }}
					</div>
				@else
					<div class="alert alert-danger">
						{{ session('status') }}
					</div>					
				@endif
			@endif

			<input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <fieldset>
                    <legend>Edit Subscription</legend>
					<div class="form-group">
                        <label for="member" class="col-lg-2 control-label">Member</label>
                        <div class="col-lg-10">
							<input type="text" readonly class="form-control" id="member" name="member" value="{{ $subscription -> member -> name }}">
                        </div>
                    </div>

					<br>
					
					<div class="form-group">
                        <label for="jamath_id" class="col-lg-2 control-label">Jamath</label>
                        <div class="col-lg-10">
							<input type="text" readonly class="form-control" id="jamath" name="jamath" value="{{ $subscription -> member -> jamath -> name }}">
                        </div>
                    </div>

					<br>
					
					<div class="form-group">
                        <label for="start_year" class="col-lg-2 control-label">Start Year</label>
                        <div class="col-lg-10">
							<select class="form-control" id="start_year" name="start_year" required>
								<option  value="{{ $subscription -> start_year }}" selected>{{ $subscription -> start_year }}</option>
								@foreach ($yearList->all() as $year)
									<option  value="{{ $year }}">{{ $year }}</option>
								@endforeach
							</select>
                        </div>
                    </div> 					
					
					<div class="form-group">
                        <label for="start_month" class="col-lg-2 control-label">Start Month</label>
                        <div class="col-lg-10">
							<select class="form-control" id="start_month" name="start_month" required>
								<option  value="{{ $subscription -> start_month }}" selected>{{ date('F', strtotime('2001-' . $subscription -> start_month . '-01')) }}</option>
								@foreach ($monthList as $number => $month)
									<option  value="{{ $number }}">{{ $month }}</option>
								@endforeach
							</select>
                        </div>
                    </div> 										
					
					<div class="form-group">
                        <label for="end_year" class="col-lg-2 control-label">End Year</label>
                        <div class="col-lg-10">
							<select class="form-control" id="end_year" name="end_year">
								<option  value="{{ $subscription -> end_year }}" selected>{{ $subscription -> end_year }}</option>
								@foreach ($yearList->all() as $year)
									<option  value="{{ $year }}">{{ $year }}</option>
								@endforeach
							</select>
                        </div>
                    </div> 					
					
					<div class="form-group">
                        <label for="end_month" class="col-lg-2 control-label">End Month</label>
                        <div class="col-lg-10">
							<select class="form-control" id="end_month" name="end_month">
								@if(isset($subscription -> end_month))
									<option  value="{{ $subscription -> end_month }}" selected>{{ date('F', strtotime('2001-' . $subscription -> end_month . '-01')) }}</option>
								@else
									<option  value="" selected></option>
								@endif
								@foreach ($monthList as $number => $month)
									<option  value="{{ $number }}">{{ $month }}</option>
								@endforeach
							</select>
                        </div>
                    </div> 															
					

                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="submit" class="btn btn-primary btn-raised">Submit</button>
                        </div>
                    </div>
					
                </fieldset>
            </form>
        </div>
    </div>
@endsection
