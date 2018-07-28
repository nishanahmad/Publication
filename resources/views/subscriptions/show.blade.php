@extends('master')
@section('title', 'View Subscription')
@section('content')

<div class="container col-md-8 col-md-offset-2">
	<div class="well well bs-component">
		@if (session('status'))
			<div class="alert alert-success">
				{{ session('status') }}
			</div>
		@endif	
		<div class="content">
			<h2 class="header">SubId - {{ $subscription->id }}</h2>
                    <div class="form-group">
                        <label for="code" class="col-lg-2 control-label">Code</label>
                        <div class="col-lg-10">
                            <input type="text" readonly class="form-control" id="code" name="code" value="{{ $subscription -> member -> code }}" required>
                        </div>
                    </div>					
					
					<div class="form-group">
                        <label for="name" class="col-lg-2 control-label">Name</label>
                        <div class="col-lg-10">
                            <input type="text" readonly class="form-control" id="name" name="name" value="{{ $subscription -> member -> name }}" required>
                        </div>
                    </div>					
					
					<div class="form-group">
                        <label for="jamath" class="col-lg-2 control-label">Jamath</label>
                        <div class="col-lg-10">
                            <input type="text" readonly class="form-control" id="jamath" name="jamath" value="{{ $subscription ->member ->jamath ->name }}">
                        </div>
                    </div>										
					
					<div class="form-group">
                        <label for="startDate" class="col-lg-2 control-label">Start On</label>
                        <div class="col-lg-10">
                            <input type="text" readonly class="form-control" id="startDate" name="startDate" value="{{ date('F', strtotime('2001-' . $subscription -> start_month . '-01')) .' , '. $subscription -> start_year }}">
                        </div>
                    </div>															
					
					<div class="form-group">
                        <label for="endDate" class="col-lg-2 control-label">End On</label>
                        <div class="col-lg-10">
							@if (isset($subscription -> end_month))
								<input type="text" readonly class="form-control" id="endDate" name="endDate" value="{{ date('F', strtotime('2001-' . $subscription -> end_month . '-01')) .' , '. $subscription -> end_year }}">
							@else
								<input type="text" readonly class="form-control" id="endDate" name="endDate" value="">
							@endif
                        </div>
                    </div>		

					<div class="checkbox" style="float:right;margin:20px;">		
						@if ($subscription -> free_copy)
							<label><input type="checkbox" checked disabled name="free_copy" id="free_copy"> Free Copy</label>
						@else
							<label><input type="checkbox" disabled name="free_copy" id="free_copy"> Free Copy</label>
						@endif
					</div>					
						

					<br>			
			<a href="{!! action('SubscriptionController@edit', $subscription->id) !!}" class="btn btn-info pull-left">Edit</a>
			<form method="post" action="{!! action('SubscriptionController@destroy', $subscription->id) !!}" class="pull-left">
				<input type="hidden" name="_token" value="{!! csrf_token() !!}">
				<div>
					<button type="submit" class="btn btn-warning">Delete</button>
				</div>
			</form>
			<div class="clearfix"></div>
		</div>
</div>
@endsection