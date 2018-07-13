@extends('master')
@section('title', 'View Jamath Receipt')
@section('content')
<div class="container col-md-8 col-md-offset-2">
	<div class="well well bs-component">
		<div class="content">
			<h2 class="header">Receipt Id - {{ $receipt->id }}</h2>

				<div class="form-group">
					<label for="jamath" class="col-lg-2 control-label">Jamath</label>
					<div class="col-lg-10">
						<input type="text" readonly class="form-control" id="jamath" name="jamath" value="{{ $receipt -> jamath -> name }}">
					</div>
				</div>					
				
				<div class="form-group">
					<label for="year" class="col-lg-2 control-label">Year</label>
					<div class="col-lg-10">
						<input type="text" readonly class="form-control" id="year" name="year" value="{{ $receipt -> year }}">
					</div>
				</div>										
				
				<div class="form-group">
					<label for="amount" class="col-lg-2 control-label">Amount</label>
					<div class="col-lg-10">
						<input type="text" readonly class="form-control" id="amount"   name="amount" value="{{ $receipt -> amount }}">
					</div>
				</div>
				
				<div class="form-group">
					<label for="date" class="col-lg-2 control-label">Payment Date</label>
					<div class="col-lg-10">
						<input type="date" readonly class="form-control" id="date"   name="date" value="{{ $receipt -> date }}">
					</div>
				</div>					
				
				<div class="form-group">
					<label for="remarks" class="col-lg-2 control-label">Remarks</label>
					<div class="col-lg-10">
						<input type="text" readonly class="form-control" id="remarks"  name="remarks" value="{{ $receipt -> remarks }}">
					</div>
				</div>		
				
			<a href="{!! action('JamathReceiptController@edit', $receipt->id) !!}" class="btn btn-info pull-left">Edit</a>
			<form method="post" action="{!! action('JamathReceiptController@destroy', $receipt->id) !!}" class="pull-left">
				<input type="hidden" name="_token" value="{!! csrf_token() !!}">
				<div>
					<button type="submit" class="btn btn-warning">Delete</button>
				</div>
			</form>				
			<div class="clearfix"></div>				
        </div>
    </div>
	
@endsection