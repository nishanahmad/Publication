@extends('master')
@section('title', 'New Subscription')

@section('content')
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('select[name="majlis"]').on('change', function() {
				var majlis = $(this).val();
				if(majlis) {
					$.ajax({
						url: '/Majlis/getMembers/'+majlis,
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
                        <label for="majlis" class="col-lg-2 control-label">Jamath</label>
                        <div class="col-lg-10">
							<select class="form-control" id="majlis" name="majlis" required>
								<option value=""></option>
								@foreach ($majlisList->all() as $majlis)
									@if(old('majlis') == $majlis -> name)
										<option  value="{{ $majlis -> name }}" selected>{{ $majlis -> name }}</option>
									@else
										<option  value="{{ $majlis -> name }}">{{ $majlis -> name }}</option>
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
                        <label for="type" class="col-lg-2 control-label">Type</label>
                        <div class="col-lg-10">
							<select class="form-control" id="type" name="type" required value="{{old('type')}}">
								@foreach ($typeList->all() as $type)
									@if(old('type') == $type)
										<option  value="{{ $type }}" selected>{{ $type }}</option>
									@else
										<option  value="{{ $type }}">{{ $type }}</option>
									@endif
								@endforeach
							</select>
                        </div>
                    </div> 
					
					<div class="form-group">
                        <label for="year" class="col-lg-2 control-label">Year</label>
                        <div class="col-lg-10">
							<select class="form-control" id="year" name="year" required value="{{old('year')}}">
								@foreach ($yearList->all() as $year)
									@if(old('year') == $year)
										<option  value="{{ $year }}" selected>{{ $year }}</option>
									@else
										<option  value="{{ $year }}">{{ $year }}</option>
									@endif
								@endforeach
							</select>
                        </div>
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