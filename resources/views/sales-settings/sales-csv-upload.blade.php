@extends('layout.master')
@section('content')
<div class="row">
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
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="clip-users-2"></i>
				Users
				<div class="panel-tools">
					<a class="btn btn-xs btn-link panel-collapse collapses" data-toggle="tooltip" data-placement="top" title="Show / Hide" href="#">
					</a>
					<a class="btn btn-xs btn-link panel-close red-tooltip" data-toggle="tooltip" data-placement="top" title="Close" href="#">
						<i class="fa fa-times"></i>
					</a>
				</div>
			</div>
			<div class="panel-body panel-scroll" style="height:300px">
				<form role="form" class="form-horizontal" action="{{ url('/sales/settings-csv-sales') }}"
					  id="" method="post" role="form" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<div class="form-group col-md-12">
						<label class="col-md-4 control-label">
							<strong>Upload Type</strong>
							<span class="symbol required" aria-required="true"></span>
						</label>
						<div class="col-md-8">
							<select class="form-control" name="upload_type" required>
								<option>Please Select upload type</option>
								<option value="sales_person">Sales Person List</option>
								<option value="commission_list">Commission List</option>
								<option value="sales_transaction_report">Sales Transaction</option>
							</select>
						</div>
					</div>
					<div class="form-group col-md-12">
						<label  class="col-sm-4 control-label">
							Browse .csv file
						</label>
						<div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="input-group">
								<div class="form-control uneditable-input">
									<i class="fa fa-file fileupload-exists"></i>
									<span class="fileupload-preview"></span>
								</div>
								<div class="input-group-btn">
									<div class="btn btn-light-grey btn-file">
										<span class="fileupload-new"><i class="fa fa-folder-open-o"></i> Select file</span>
										<span class="fileupload-exists"><i class="fa fa-folder-open-o"></i> Change</span>
										<input type="file" name="csv_file" class="file-input">
									</div>
									<a href="#" class="btn btn-light-grey fileupload-exists" data-dismiss="fileupload">
										<i class="fa fa-times"></i> Remove
									</a>

									<input type="submit" value="Upload" name="file_upload" class="btn btn-light-grey fileupload-exists" >
								</div>
							</div>
						</div>
					</div>

					<div class="form-group col-md-12">

						<div class=" pull-right">
							<input class="btn btn-danger btn-squared" name="reset" value="Reset" type="reset">
							<input class="btn btn-success btn-squared" name="submit" value="Upload" type="submit">
						</div>

					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@stop