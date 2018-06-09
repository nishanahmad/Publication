@extends('master')
@section('title', 'New Member')

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
                    <legend>Create new member</legend>
                    
                    <div class="form-group">
                        <label for="code" class="col-lg-2 control-label">Code</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="code" name="code" value="{{old('code')}}" required>
                        </div>
                    </div>					
					<div class="form-group">
                        <label for="name" class="col-lg-2 control-label">Name</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" required>
                        </div>
                    </div>
					
					<div class="form-group">
                        <label for="jamath" class="col-lg-2 control-label">Jamath</label>
                        <div class="col-lg-10">
							<select class="form-control" id="jamath_id" name="jamath_id" required value="{{old('jamath_id')}}">
								<option value=""></option>
								@foreach ($jamathList->all() as $jamath)
									@if(old('jamath_id') == $jamath -> id)
										<option  value="{{ $jamath -> id }}" selected>{{ $jamath -> name }}</option>
									@else
										<option  value="{{ $jamath -> id }}">{{ $jamath -> name }}</option>
									@endif
								@endforeach
							</select>
                        </div>
					</div>
					
					<div class="form-group">
                        <label for="address1" class="col-lg-2 control-label">Address 1</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="address1" name="address1" value="{{old('address1')}}">
                        </div>
                    </div>					
					
					<div class="form-group">
                        <label for="address2" class="col-lg-2 control-label">Address 2</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="address2" name="address2" value="{{old('address2')}}">
                        </div>
                    </div>										
					
					<div class="form-group">
                        <label for="place" class="col-lg-2 control-label">Place</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="place" name="place" value="{{old('place')}}">
                        </div>
                    </div>															
					
					<div class="form-group">
                        <label for="district" class="col-lg-2 control-label">District</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="district" name="district" value="{{old('district')}}">
                        </div>
                    </div>																				
					
					<div class="form-group">
                        <label for="pin_code" class="col-lg-2 control-label">Pin Code</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="pin_code" name="pin_code" value="{{old('pin_code')}}">
                        </div>
                    </div>																									

					<div class="form-group">
                        <label for="rms" class="col-lg-2 control-label">RMS</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="rms" name="rms" value="{{old('rms')}}">
                        </div>
                    </div>	
					
					<div class="form-group">
                        <label for="landline" class="col-lg-2 control-label">Landline</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="landline" name="landline" value="{{old('landline')}}">
                        </div>
                    </div>						
					
                    <div class="form-group">
                        <label for="mobile" class="col-lg-2 control-label">Mobile</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="mobile" name="mobile" value="{{old('mobile')}}" >
                        </div>
                    </div>					

                    <div class="form-group">
                        <label for="email" class="col-lg-2 control-label">Email</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="email" name="email" value="{{old('email')}}" >
                        </div>
                    </div>					
					
                    <div class="form-group">
                        <label for="ref_name" class="col-lg-2 control-label">Ref Name</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="ref_name" name="ref_name" value="{{old('ref_name')}}" >
                        </div>
                    </div>										
					
                    <div class="form-group">
                        <label for="ref_phone" class="col-lg-2 control-label">Ref Phone</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="ref_phone" name="ref_phone" value="{{old('ref_phone')}}" >
                        </div>
                    </div>															
					
                    </div>					
					<br>
					
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