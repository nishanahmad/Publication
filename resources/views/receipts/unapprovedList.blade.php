@extends('master')
@section('title', 'Verify & SMS')
@section('content')
	<form class="form-horizontal" method="post">
    <div class="container col-md-8 col-md-offset-1">
            <div class="panel panel-default">
				@if (session('status'))
				<div class="alert alert-success">
					{{ session('status') }}
				</div>
				@endif

                @if (empty($mainList))
                    <p> There is no receipts pending approval.</p>
                @else			
					<input type="hidden" name="_token" value="{!! csrf_token() !!}">
					<fieldset>					
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="submit" class="btn btn-primary btn-raised">Verify & Send SMS</button>
                        </div>
                    </div>
					
					<table class="table">
						<thead>
							<tr>
								<th></th>							
								<th>Receipt No.</th>
								<th>Name</th>
								<th>Mobile</th>
								<th>Majlis</th>
								<th>Type</th>
								<th>Year</th>
								<th>Amount</th>
							</tr>
						</thead>
						<tbody>
							@foreach($mainList as $id => $receipts)
								<tr>
									<td><input type="checkbox" name="{{ $id }}" id="{{ $id }}" value="1"></td>								
									@foreach($receipts as $key => $receipt)
									<td>{{ $receipt }} </td>
									<input type="text" name="{{ $key.'-'.$id }}" hidden value="{{ $receipt }}">
									@endforeach
								</tr>
							@endforeach
						</tbody>
					</table>					
                @endif
            </fieldset>				
			</div>				
		</div>
		</form>

@endsection
