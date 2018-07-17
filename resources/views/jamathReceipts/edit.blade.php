@extends('master')
@section('title', 'View Jamath Receipt')
@section('content')
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
<div class="container col-md-8 col-md-offset-2">
	<div class="well well bs-component">
		<div class="content">
			<h2 class="header">Receipt Id - {{ $receipt->id }}</h2>

				<div class="form-group">
					<label for="jamath_id" class="col-lg-2 control-label">Jamath</label>
					<div class="col-lg-10">
						<select class="form-control" id="jamath_id" name="jamath_id" required value="{{ $receipt -> jamath_id }}">
							@foreach ($jamathList->all() as $jamath)
								@if($jamath -> id == $receipt -> jamath_id)
									<option selected value="{{ $jamath -> id }}">{{ $jamath -> name }}</option>
								@else
									<option value="{{ $jamath -> id }}">{{ $jamath -> name }}</option>
								@endif
							@endforeach
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label for="year" class="col-lg-2 control-label">Year</label>
					<div class="col-lg-10">
						<select class="form-control" id="year" name="year" required value="{{ $receipt -> year }}">
							@foreach ($yearList->all() as $year)
								@if($receipt -> year == $year)
									<option  value="{{ $year }}" selected>{{ $year }}</option>
								@else
									<option  value="{{ $year }}">{{ $year }}</option>
								@endif
							@endforeach
						</select>
					</div>
				</div> 										
				
				<div class="form-group">
					<label for="amount" class="col-lg-2 control-label">Amount</label>
					<div class="col-lg-10">
						<input type="text"  class="form-control" id="amount"   name="amount" value="{{ $receipt -> amount }}">
					</div>
				</div>
				
				<div class="form-group">
					<label for="date" class="col-lg-2 control-label">Payment Date</label>
					<div class="col-lg-10">
						<input type="date"  class="form-control" id="date"   name="date" value="{{ $receipt -> date }}">
					</div>
				</div>					
				
				<div class="form-group">
					<label for="remarks" class="col-lg-2 control-label">Remarks</label>
					<div class="col-lg-10">
						<input type="text"  class="form-control" id="remarks"  name="remarks" value="{{ $receipt -> remarks }}">
					</div>
				</div>		
				
				<div class="form-group">
					<div class="col-lg-10 col-lg-offset-2">
						<button type="submit" class="btn btn-primary btn-raised">Update</button>
					</div>
				</div>

				<div class="clearfix"></div>				
        </div>
    </div>
	
@endsection