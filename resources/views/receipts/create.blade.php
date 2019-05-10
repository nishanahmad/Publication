@extends('master')
@section('title', 'New Receipt')

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
							console.log(data);
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
			
			$('select[name="member"]').on('change', function() {
				var member = $(this).val();
				if(member) {
					$.ajax({
						url: '/member/getCode/'+member,
						type: "GET",
						dataType: "json",
						success:function(data) {
							$('#code').val(data);
						},
						error: function (xhr, ajaxOptions, thrownError) {
							console.warn(xhr.responseText)							
						}

					});
				}else{
					$('#code').empty();
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
						{!! session('status') !!}
					</div>
				@else
					<div class="alert alert-danger">
						{!! session('status') !!}
					</div>					
				@endif
			@endif

			<input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <fieldset>
                    <legend>New Receipt</legend>
                    <div class="form-group">
                        <label for="receipt_no" class="col-lg-2 control-label">Receipt Number</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="receipt_no"  name="receipt_no" value="{{old('receipt_no')}}">
                        </div>
                    </div>					
					<div class="form-group">
                        <label for="jamath_id" class="col-lg-2 control-label">Jamath</label>
                        <div class="col-lg-10">
							<select class="form-control" id="jamath_id" name="jamath_id" required>
								<option value=""></option>
								@foreach ($jamathList->all() as $jamath)
									@if(isset($urlMember) && $urlMember -> jamath -> id == $jamath -> id)
										<option selected value="{{ $jamath -> id }}">{{ $jamath -> name }}</option>
									@else
										<option value="{{ $jamath -> id }}">{{ $jamath -> name }}</option>
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
							@if(isset($urlMember))
								<option  selected value="{{ $urlMember -> id }}">{{ $urlMember -> name }}</option>
							@endif		
							</select>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label for="code" class="col-lg-2 control-label">Member Code</label>
                        <div class="col-lg-10">
							@if(isset($urlMember))
								<input type="text" readonly class="form-control" id="code" name="code" value="{{ $urlMember -> code }}">
							@else
								<input type="text" readonly class="form-control" id="code" name="code">								
							@endif
							
                        </div>
                    </div>					
					
                    <div class="form-group">
                        <label for="amount" class="col-lg-2 control-label">Amount</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="amount"  required name="amount" value="{{old('amount')}}" pattern="[0-9]+" title="Input a valid number">
                        </div>
                    </div>
					
					
					<div class="form-group">
                        <label for="year" class="col-lg-2 control-label">Year</label>
                        <div class="col-lg-10">
							<select class="form-control" id="year" name="year" required value="{{old('year')}}">
							<option  value=""></option>								
								@foreach ($yearList->all() as $year)
									@if($urlYear == $year)
										<option  value="{{ $year }}" selected>{{ $year }}</option>
									@else
										<option  value="{{ $year }}">{{ $year }}</option>
									@endif
								@endforeach
							</select>
                        </div>
                    </div> 					

					<div class="form-group">
                        <label for="date" class="col-lg-2 control-label">Payment Date</label>
                        <div class="col-lg-10">
                            <input type="date" class="form-control" id="date"  name="date" value="{{old('date')}}">
                        </div>
                    </div>
					
                    <div class="form-group">
                        <label for="remarks" class="col-lg-2 control-label">Remarks</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="remarks" name="remarks" value="{{old('remarks')}}">
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