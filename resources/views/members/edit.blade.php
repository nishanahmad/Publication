@extends('master')
@section('title', 'Edit Member')

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
                    <legend>Edit member</legend>
                    
                    <div class="form-group">
                        <label for="code" class="col-lg-2 control-label">Code</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="code" name="code" value="{{ $member -> code }}" required>
                        </div>
                    </div>					
					<div class="form-group">
                        <label for="name" class="col-lg-2 control-label">Name</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="name" name="name" value="{{ $member -> name }}" required>
                        </div>
                    </div>

					<div class="form-group">
                        <label for="majlis" class="col-lg-2 control-label">Jamath</label>
                        <div class="col-lg-10">
							<input type="text" readonly class="form-control" id="majlis" name="majlis" value="{{ $member -> majlis }}" >
                        </div>
                    </div>					

					
					<div class="form-group">
                        <label for="address1" class="col-lg-2 control-label">Address 1</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="address1" name="address1" value="{{ $member -> address1 }}" required>
                        </div>
                    </div>					
					
					<div class="form-group">
                        <label for="address2" class="col-lg-2 control-label">Address 2</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="address2" name="address2" value="{{ $member -> address2 }}">
                        </div>
                    </div>										
					
					<div class="form-group">
                        <label for="place" class="col-lg-2 control-label">Place</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="place" name="place" value="{{ $member -> place }}">
                        </div>
                    </div>															
					
					<div class="form-group">
                        <label for="district" class="col-lg-2 control-label">District</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="district" name="district" value="{{ $member -> district }}">
                        </div>
                    </div>																				
					
					<div class="form-group">
                        <label for="pin_code" class="col-lg-2 control-label">Pin Code</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="pin_code" name="pin_code" value="{{ $member -> pin_code }}">
                        </div>
                    </div>																									

					<div class="form-group">
                        <label for="rms" class="col-lg-2 control-label">RMS</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="rms" name="rms" value="{{ $member -> rms }}">
                        </div>
                    </div>	
					
					<div class="form-group">
                        <label for="landline" class="col-lg-2 control-label">Landline</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="landline" name="landline" value="{{ $member -> landline }}">
                        </div>
                    </div>						
					
                    <div class="form-group">
                        <label for="mobile" class="col-lg-2 control-label">Mobile</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="mobile" name="mobile" value="{{ $member -> mobile }}" >
                        </div>
                    </div>					

                    <div class="form-group">
                        <label for="email" class="col-lg-2 control-label">Email</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="email" name="email" value="{{ $member -> email }}" >
                        </div>
                    </div>					
					
                    <div class="form-group">
                        <label for="ref_name" class="col-lg-2 control-label">Ref Name</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="ref_name" name="ref_name" value="{{ $member -> ref_name }}" >
                        </div>
                    </div>										
					
                    <div class="form-group">
                        <label for="ref_phone" class="col-lg-2 control-label">Ref Phone</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="ref_phone" name="ref_phone" value="{{ $member -> ref_phone }}" >
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