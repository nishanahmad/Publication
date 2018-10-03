@extends('master')
@section('title', 'View Sponsorship')

@section('content')
<div class="container col-md-8 col-md-offset-2">
	<div class="well well bs-component">
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

			<fieldset>
				<legend>View Sponsorship</legend>
				<div class="form-group">
					<label for="jamath_id" class="col-lg-2 control-label">Jamath</label>
					<div class="col-lg-10">
						<input type="text" readonly class="form-control" id="jamath"  name="jamath" value="{{$sponsorship -> jamath -> name}}">
					</div>
				</div>
				<br>
				@if(isset($sponsorship -> member))
				<div class="form-group">
					<label for="member" class="col-lg-2 control-label">Member</label>
					<div class="col-lg-10">
						<input type="text" readonly class="form-control" id="member"  name="member" value="{{$sponsorship -> member -> name}}">
					</div>
				</div>
				@endif
				<div class="form-group">
					<label for="amount" class="col-lg-2 control-label">Amount</label>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="amount" readonly name="amount" value="{{$sponsorship -> amount}}">
					</div>
				</div>
				
				
				<div class="form-group">
					<label for="year" class="col-lg-2 control-label">Year</label>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="amount" readonly name="year" value="{{$sponsorship -> year}}">
					</div>
				</div> 					
				
				<div class="form-group">
					<label for="remarks" class="col-lg-2 control-label">Remarks</label>
					<div class="col-lg-10">
						<input readonly type="text" class="form-control" id="remarks" name="remarks" value="{{$sponsorship -> remarks}}">
					</div>
				</div>					
				<br/><br/>
			
				
			</fieldset>
			<a href="{!! action('SponsorshipController@edit', $sponsorship->id) !!}" class="btn btn-info pull-left">Edit</a>
			<form method="post" action="{!! action('SponsorshipController@destroy', $sponsorship->id) !!}" class="pull-left">
			<input type="hidden" name="_token" value="{!! csrf_token() !!}">
				<div>
					<button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure you want to delete? The action cannot be undone')">Delete</button>
				</div>
			</form>		
			<div class="clearfix"></div>				
	</div>
</div>
@endsection