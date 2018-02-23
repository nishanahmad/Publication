@extends('master')
@section('title', 'Jamath Receipt')

@section('content')
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
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
                    <legend>New Jamath Receipt</legend>
					
					<div class="form-group">
                        <label for="jamath" class="col-lg-2 control-label">Jamath</label>
                        <div class="col-lg-10">
							<select class="form-control" id="jamath" name="jamath" required>
								<option value=""></option>
								@foreach ($jamathList->all() as $jamath)
									<option  value="{{ $jamath -> name }}">{{ $jamath -> name }}</option>
								@endforeach
							</select>
                        </div>
                    </div>
					<br>
                    
					<div class="form-group">
                        <label for="amount" class="col-lg-2 control-label">Amount</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="amount"  required name="amount" value="{{old('amount')}}" pattern="[0-9]+" title="Input a valid number">
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