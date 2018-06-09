@extends('master')
@section('title', 'View Member')
@section('content')
<div class="container col-md-8 col-md-offset-2">
	<div class="well well bs-component">
		<div class="content">
			<h2 class="header">{{ $member->name }}</h2>
			<p> <strong>{{ $member->majlis }}</strong></p>
                    <div class="form-group">
                        <label for="code" class="col-lg-2 control-label">Code</label>
                        <div class="col-lg-10">
                            <input type="text" readonly class="form-control" id="code" name="code" value="{{ $member -> code }}" required>
                        </div>
                    </div>					
					
					<div class="form-group">
                        <label for="address1" class="col-lg-2 control-label">Address 1</label>
                        <div class="col-lg-10">
                            <input type="text" readonly class="form-control" id="address1" name="address1" value="{{ $member -> address1 }}" required>
                        </div>
                    </div>					
					
					<div class="form-group">
                        <label for="address2" class="col-lg-2 control-label">Address 2</label>
                        <div class="col-lg-10">
                            <input type="text" readonly class="form-control" id="address2" name="address2" value="{{ $member -> address2 }}">
                        </div>
                    </div>										
					
					<div class="form-group">
                        <label for="place" class="col-lg-2 control-label">Place</label>
                        <div class="col-lg-10">
                            <input type="text" readonly class="form-control" id="place" name="place" value="{{ $member -> place }}">
                        </div>
                    </div>															
					
					<div class="form-group">
                        <label for="district" class="col-lg-2 control-label">District</label>
                        <div class="col-lg-10">
                            <input type="text" readonly class="form-control" id="district" name="district" value="{{ $member -> district }}">
                        </div>
                    </div>																				
					
					<div class="form-group">
                        <label for="pin_code" class="col-lg-2 control-label">Pin Code</label>
                        <div class="col-lg-10">
                            <input type="text" readonly class="form-control" id="pin_code" name="pin_code" value="{{ $member -> pin_code }}">
                        </div>
                    </div>																									

					<div class="form-group">
                        <label for="rms" class="col-lg-2 control-label">RMS</label>
                        <div class="col-lg-10">
                            <input type="text" readonly class="form-control" id="rms" name="rms" value="{{ $member -> rms }}">
                        </div>
                    </div>	
					
					<div class="form-group">
                        <label for="landline" class="col-lg-2 control-label">Landline</label>
                        <div class="col-lg-10">
                            <input type="text" readonly class="form-control" id="landline" name="landline" value="{{ $member -> landline }}">
                        </div>
                    </div>						
					
                    <div class="form-group">
                        <label for="mobile" class="col-lg-2 control-label">Mobile</label>
                        <div class="col-lg-10">
                            <input type="text" readonly class="form-control" id="mobile" name="mobile" value="{{ $member -> mobile }}" >
                        </div>
                    </div>					

                    <div class="form-group">
                        <label for="email" class="col-lg-2 control-label">Email</label>
                        <div class="col-lg-10">
                            <input type="text" readonly class="form-control" id="email" name="email" value="{{ $member -> email }}" >
                        </div>
                    </div>					
					
                    <div class="form-group">
                        <label for="ref_name" class="col-lg-2 control-label">Ref Name</label>
                        <div class="col-lg-10">
                            <input type="text" readonly class="form-control" id="ref_name" name="ref_name" value="{{ $member -> ref_name }}" >
                        </div>
                    </div>										
					
                    <div class="form-group">
                        <label for="ref_phone" class="col-lg-2 control-label">Ref Phone</label>
                        <div class="col-lg-10">
                            <input type="text" readonly class="form-control" id="ref_phone" name="ref_phone" value="{{ $member -> ref_phone }}" >
                        </div>
                    </div>															
					

					<br>			
			<a href="{!! action('MembersController@edit', $member->id) !!}" class="btn btn-info pull-left">Edit</a>
			<form method="post" action="{!! action('MembersController@destroy', $member->id) !!}" class="pull-left">
				<input type="hidden" name="_token" value="{!! csrf_token() !!}">
				<div>
					<button type="submit" class="btn btn-warning">Delete</button>
				</div>
			</form>
			<div class="clearfix"></div>
		</div>
	<div class="well well bs-component">
		@foreach($errors->all() as $error)
			<p class="alert alert-danger">{{ $error }}</p>
		@endforeach

		@if(session('status'))
			<div class="alert alert-success">
			{{ session('status') }}
			</div>
		@endif
		<ul class="nav nav-tabs">
		  <li class="active"><a data-toggle="tab" href="#menu1">Payment Details</a></li>
		  <li><a data-toggle="tab" href="#menu2">Receipts</a></li>
		</ul>

		<div class="tab-content">
		  <div id="menu1" class="tab-pane fade in active">
			<h3>Payment Details</h3>
				<table class="table">
					<thead>
						<tr>
							<th>Year</th>
							<th>Rate</th>
							<th>Paid</th>
							<th>Pending Amount</th>
						</tr>
					</thead>
					<tbody>
						@foreach($pendingMap as $year => $rate)
							<tr>
								<td>{{ $year }}</td>
								<td>{{ $rate }}</td>
								<td>{{ $paidMap[$year] }}</td>
								<td>{{ $rate - $paidMap[$year] }}</td>
							</tr>
						@endforeach				
					</tbody>
				</table>		  
		  </div>
		  <div id="menu2" class="tab-pane fade">
			<h3>Receipts</h3>
				<table class="table">
					<thead>
						<tr>
							<th>Receipt No.</th>
							<th>Year</th>
							<th>Amount</th>
						</tr>
					</thead>
					<tbody>
					@foreach($receipts as $receipt)
						<tr>
							<td>{{ $receipt->receipt_number }}</td>
							<td>{{ $receipt->year }}</td>
							<td>{{ $receipt->amount }}</td>
						</tr>
					@endforeach
					</tbody>
				</table>			
		  </div>
		</div>			
	</div>
</div>
@endsection
