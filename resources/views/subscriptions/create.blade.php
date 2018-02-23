@extends('master')
@section('title', 'Annual Rates')

@section('content')
    <div class="container col-md-8 col-md-offset-2">
        <div class="well well bs-component">
            <form class="form-horizontal" method="post">
			@foreach ($errors->all() as $error)
				<p class="alert alert-danger">{{ $error }}</p>
			@endforeach

			@if(session('status'))
				@if (strpos(session('status'), 'Success') !== false)
					<div class="alert alert-success">
						{{ session('status') }}
					</div>
				@else
					<div class="alert alert-danger">
						{{ session('status') }}
					</div>					
				@endif
			@endif

			<input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <fieldset>
                    <legend>Update Rates</legend>
					<div class="form-group">
                        <label for="year" class="col-lg-2 control-label">Year</label>
                        <div class="col-lg-10">
							<select class="form-control" id="year" name="year" require>
								@foreach ($yearList as $year)
									<option  value="{{ $year }}">{{ $year }}</option>
								@endforeach
							</select>
                        </div>
                    </div>	
					<div class="form-group">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Subsciption Type</th>
									<th>Rate</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($typeList->all() as $type)
								<tr>
									<td class="col-md-2">{{ $type->type }}</td>
									<td class="col-md-2"><input type="text" name="{{$type->type}}" required></td>
								</tr>
								@endforeach
							</tbody>
						</table>						
					</div>				
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
