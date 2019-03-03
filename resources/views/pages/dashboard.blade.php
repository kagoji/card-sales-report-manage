@extends('layout.master')
@section('content')
<div class="row">
	<!--SHOW ERROR MESSAGE DIV-->
		<div class="col-md-8">
			@if ($errors->count() > 0 )
				<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<h6>The following errors have occurred:</h6>
					<ul>
						@foreach( $errors->all() as $message )
							<li>{{ $message }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			@if (Session::has('message'))
				<div class="alert alert-success" role="alert">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					{{ Session::get('message') }}
				</div>
			@endif
			@if (Session::has('errormessage'))
				<div class="alert alert-danger" role="alert">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					{{ Session::get('errormessage') }}
				</div>
			@endif
		</div>

	<!--END ERROR MESSAGE DIV-->
	<h4 class="page-title">Comming Soon...</h4>
</div>
@stop