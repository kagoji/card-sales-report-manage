@extends('layout.master')
@section('content')
    <div class="row">
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
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="clip-users-2"></i>
                    Role Type
                    <div class="panel-tools">
                        <a class="btn btn-xs btn-link panel-collapse collapses" data-toggle="tooltip" data-placement="top" title="Show / Hide" href="#">
                        </a>
                        <a class="btn btn-xs btn-link panel-close red-tooltip" data-toggle="tooltip" data-placement="top" title="Close" href="#">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="panel-body">

                    <div class="add_item pull-right" style="margin-bottom: 10px;">
                        <a class="btn btn-primary" data-toggle="modal" href="#create_role_type"><i class="fa fa-plus"></i>
                            Add Item</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="sample-table-1">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Role Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (isset($role_list) && count($role_list)>0)
                                @foreach ($role_list as $key => $role_type)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $role_type->name }}</td>
                                        <td style="width:18%">
                                            <div class="btn-group">
                                                <a href="#" class="btn btn-xs btn-bricky tooltips" data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4">
                                        <div class="alert alert-success" role="alert">
                                            <h4>No Data Available !</h4>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        {{isset($pagination)?$pagination:''}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="clip-users-2"></i>
                    Permission Type
                    <div class="panel-tools">
                        <a class="btn btn-xs btn-link panel-collapse collapses" data-toggle="tooltip" data-placement="top" title="Show / Hide" href="#">
                        </a>

                        <a class="btn btn-xs btn-link panel-close red-tooltip" data-toggle="tooltip" data-placement="top" title="Close" href="#">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="add_item pull-right" style="margin-bottom: 10px;">
                        <a class="btn btn-success" data-toggle="modal" href="#create_permission_type"><i class="fa fa-plus"></i>
                            Add Item</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" >
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Permission Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (isset($permission_list) && count($permission_list)>0)
                                @foreach ($permission_list as $key => $permission_type)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $permission_type->name }}</td>
                                        <td style="width:18%">
                                            <div class="btn-group">
                                                <a href="#" class="btn btn-xs btn-bricky tooltips" data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4">
                                        <div class="alert alert-success" role="alert">
                                            <h4>No Data Available !</h4>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        {{isset($pagination)?$pagination:''}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="create_role_type" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                &times;
            </button>
            <h4 class="modal-title">Role Type Add</h4>
        </div>
        <form role="form" class="form-horizontal" action="{{ url('/role-type/create') }}"
              id="" method="post" role="form" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">

                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group col-md-8">
                            <label class="col-sm-5 control-label">
                                <strong>Type Name</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="name">
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-light-grey">
                Close
            </button>
            <button type="submit" class="btn btn-blue">
                Save changes
            </button>
        </div>
        </form>
    </div>

    <div id="create_permission_type" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                &times;
            </button>
            <h4 class="modal-title">Role Type Add</h4>
        </div>
        <form role="form" class="form-horizontal" action="{{ url('/permission-type/create') }}"
              id="" method="post" role="form" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">

                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group col-md-8">
                            <label class="col-sm-5 control-label">
                                <strong>Type Name</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="name">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-light-grey">
                    Close
                </button>
                <button type="submit" class="btn btn-blue">
                    Save changes
                </button>
            </div>
        </form>
    </div>
@stop