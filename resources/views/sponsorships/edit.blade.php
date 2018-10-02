@extends('master')
@section('title', 'Edit Member Receipt')

@section('content')
    <div class="container col-md-8 col-md-offset-2">
        <div class="well well bs-component">
            <form class="form-horizontal" method="post">
			@foreach ($errors->all() as $error)
				<p class="alert alert-danger">{{ $error }}</p>
			@endforeach
			@if (session('status'))
				<div class="alert alert-success">
					{{ session('status') }}
				</div>
			@endif

			<input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <fieldset>
                    <legend>Edit Receipt</legend>
                    
					<div class="form-group">
						<label for="receipt_no" class="col-lg-2 control-label">Receipt Number</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="receipt_no"  name="receipt_no" value="{{$receipt -> receipt_no}}">
						</div>
					</div>
					
					<div class="form-group">
						<label for="jamath_id" class="col-lg-2 control-label">Jamath</label>
						<div class="col-lg-10">
							<input type="text" readonly class="form-control" id="jamath_id"  name="jamath_id" value="{{$receipt -> member -> jamath -> name}}">
						</div>
					</div>

					<div class="form-group">
                        <label for="member" class="col-lg-2 control-label">Member</label>
                        <div class="col-lg-10">
							<input type="text" readonly class="form-control" id="member"  name="member" value="{{$receipt -> member -> name}}">
                        </div>
                    </div>
					
					<div class="form-group">
						<label for="amount" class="col-lg-2 control-label">Amount</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="amount" name="amount" value="{{$receipt -> amount}}">
						</div>
					</div>		

					<div class="form-group">
                        <label for="year" class="col-lg-2 control-label">Year</label>
                        <div class="col-lg-10">
							<select class="form-control" id="year" name="year" required>
								@foreach ($yearList->all() as $year)
									@if( $receipt -> year == $year)
										<option  value="{{ $year }}" selected>{{ $year }}</option>
									@else
										<option  value="{{ $year }}">{{ $year }}</option>
									@endif
								@endforeach
							</select>
                        </div>
                    </div> 					
				
				<div class="form-group">
					<label for="remarks" class="col-lg-2 control-label">Remarks</label>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="remarks" name="remarks" value="{{$receipt -> remarks}}">
					</div>
				</div>							
					
					<br>
					
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="submit" class="btn btn-primary btn-raised">Update</button>
                        </div>
                    </div>
					
                </fieldset>
            </form>
        </div>
    </div>
@endsection