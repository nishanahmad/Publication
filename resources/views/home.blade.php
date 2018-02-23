@extends('master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard
					@foreach ($errors->all() as $error)
						<p class="alert alert-danger">{{ $error }}</p>
					@endforeach
					@if (session('status'))
						<div class="alert alert-danger">
							{{ session('status') }}
						</div>
					@endif
				</div>
            </div>
        </div>
    </div>
</div>
@endsection
