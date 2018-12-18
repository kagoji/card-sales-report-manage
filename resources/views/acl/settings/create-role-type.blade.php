@extends('layout.master')
@section('content')
    <!--SHOW ERROR MESSAGE DIV-->
    <div class="row page_row">
        <div class="col-md-12">
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
    </div>
    <!--END ERROR MESSAGE DIV-->
    <div class="row ">
        <div class="col-sm-12">
            <div class="tabbable">
                <ul id="myTab" class="nav nav-tabs tab-bricky">
                    <li class="active">
                        <a href="{{url('/role-type/create')}}">
                            <i class="green fa fa-bell"></i> Add Role Type
                        </a>
                    </li>
                    <li class="">
                        <a href="{{url('/role-type/list')}}">
                            <i class="green clip-feed"></i> Role Type List
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <!-- PANEL FOR CREATE Category -->
                    <div id="create_role_type" class="tab-pane active">
                        <div class="row">
                            <div class="col-md-12">
                                <form role="form" class="form-horizontal" action="{{ url('/role-type/create') }}"
                                      id="category" method="post" role="form" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">
                                            <strong>Role Type Name</strong>
                                            <span class="symbol required" aria-required="true"></span>
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="role_type">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-4">
                                        </div>
                                        <div class="col-sm-4">
                                            <input class="btn btn-danger btn-squared" name="reset" value="Reset" type="reset">
                                            <input class="btn btn-success btn-squared" name="submit" value="Save" type="submit">
                                        </div>
                                        <div class="col-sm-5">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('JScript')
    <script>
        $(function () {
            $('#create_role_type').validate({
                rules: {
                    role_type: {
                        required: true
                    }
                },
                highlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
                },
                unhighlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                },
                errorElement: 'span',
                errorClass: 'help-block',
                errorPlacement: function (error, element) {
                    if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                        element.attr("placeholder",error.text());
                    }
                }
            });
        })
    </script>
@endsection