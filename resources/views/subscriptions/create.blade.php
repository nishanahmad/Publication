@extends('master')
@section('title', 'New Subscription')

@section('content')
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('select[name="jamath_id"]').on('change', function() {
			var jamath = $(this).val();
			if(jamath) {
				$.ajax({
					url: '/Jamath/getMembers/'+jamath,
					type: "GET",
					dataType: "json",
					success:function(data) {
						
						$('select[name="member"]').empty();
						$.each(data, function(key, value) {
							$('select[name="member"]').append('<option value="'+ key +'">'+ value +'</option>');
						});
					}
				});
			}else{
				$('select[name="member"]').empty();
			}
		});
	});
	</script>
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
                    <legend>New Subscription</legend>
					<div class="form-group">
                        <label for="jamath_id" class="col-lg-2 control-label">Jamath</label>
                        <div class="col-lg-10">
							<select class="form-control" id="jamath_id" name="jamath_id" required>
								<option value=""></option>
								@foreach ($jamathList->all() as $jamath)
									@if(old('jamath') == $jamath -> name)
										<option  value="{{ $jamath -> id }}" selected>{{ $jamath -> name }}</option>
									@else
										<option  value="{{ $jamath -> id }}">{{ $jamath -> name }}</option>
									@endif
								@endforeach
							</select>
                        </div>
                    </div>
					<br>
					<div class="form-group">
                        <label for="member" class="col-lg-2 control-label">Member</label>
                        <div class="col-lg-10">
							<select class="form-control" id="member" name="member" required>
							</select>
                        </div>
                    </div>

					<br>
					
					<div class="form-group">
                        <label for="start_year" class="col-lg-2 control-label">Start Year</label>
                        <div class="col-lg-10">
							<select class="form-control" id="start_year" name="start_year" required value="{{old('start_year')}}">
								@foreach ($yearList->all() as $year)
									@if(old('start_year') == $year)
										<option  value="{{ $year }}" selected>{{ $year }}</option>
									@else
										<option  value="{{ $year }}">{{ $year }}</option>
									@endif
								@endforeach
							</select>
                        </div>
                    </div> 					
					
					<div class="form-group">
                        <label for="start_month" class="col-lg-2 control-label">Start Month</label>
                        <div class="col-lg-10">
							<select class="form-control" id="start_month" name="start_month" required value="{{old('start_month')}}">
								@foreach ($monthList as $number => $month)
									@if(old('start_month') == $number)
										<option  value="{{ $number }}" selected>{{ $month }}</option>
									@else
										<option  value="{{ $number }}">{{ $month }}</option>
									@endif
								@endforeach
							</select>
                        </div>
                    </div> 										
					
					<div class="form-group">
                        <label for="end_year" class="col-lg-2 control-label">End Year</label>
                        <div class="col-lg-10">
							<select class="form-control" id="end_year" name="end_year" value="{{old('end_year')}}">
								<option  value=""></option>
								@foreach ($yearList->all() as $year)
									@if(old('end_year') == $year)
										<option  value="{{ $year }}" selected>{{ $year }}</option>
									@else
										<option  value="{{ $year }}">{{ $year }}</option>
									@endif
								@endforeach
							</select>
                        </div>
                    </div> 					
					
					<div class="form-group">
                        <label for="end_month" class="col-lg-2 control-label">End Month</label>
                        <div class="col-lg-10">
							<select class="form-control" id="end_month" name="end_month" value="{{old('end_month')}}">
								<option  value=""></option>
								@foreach ($monthList as $number => $month)
									@if(old('end_month') == $number)
										<option  value="{{ $number }}" selected>{{ $month }}</option>
									@else
										<option  value="{{ $number }}">{{ $month }}</option>
									@endif
								@endforeach
							</select>
                        </div>
                    </div> 															

					<div class="checkbox" style="float:right;margin:20px;">		
						<label><input type="checkbox" name="free_copy" id="free_copy"> Free Copy</label>
					</div>


                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button class="btn btn-default">Cancel</button>
                            <button type="submit" class="btn btn-primary btn-raised">Submit</button>
                        </div>
                    </div>
					
                </fieldset>
            </form>
        </div>
    </div>
@endsection
