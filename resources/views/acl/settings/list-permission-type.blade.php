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
                <li class="">
                    <a href="{{url('/permission-type/create')}}">
                        <i class="green fa fa-bell"></i> Add Permission Type
                    </a>
                </li>
                <li class="active">
                    <a href="{{url('/permission-type/list')}}">
                        <i class="green clip-feed"></i> Permission Type List
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <!-- PANEL FOR Category LIST -->
                <div id="list_role_type" class="tab-pane active">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="sample-table-1">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if (isset($permission_type_list) && count($permission_type_list)>0)
                                    @foreach ($permission_type_list as $key => $permission_type)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $permission_type->permission_type }}</td>
                                        <td style="width:18%">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-purple"><i class="fa fa-wrench"></i> Action</button><button data-toggle="dropdown" class="btn btn-purple dropdown-toggle"><span class="caret"></span></button><ul class="dropdown-menu" role="menu">
                                                    {{--<li>
                                                        <a href="{{url('/category/edit/'.$role_type->id)}}">
                                                            <i class="fa fa-pencil"></i> Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="category-delete" data-category-id="{{$role_type->id}}">
                                                            <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                                                        </a>
                                                    </li>--}}
                                                </ul>
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
                <!-- END PANEL FOR Category LIST -->
                <div class="text-center">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('JScript')
<script>
    $(function () {
        var site_url = $('.site_url').val();

        //series status change
        $('.is_series-change').on('click', function (e) {
            e.preventDefault();
            var series_status = $(this).data('series');
            var id = $(this).data('category-id');

            if(series_status == 0) {
                bootbox.dialog({
                    message: "Are you sure you want to change this series to 'NO'?",
                    title: "<i class='glyphicon glyphicon-eye-close'></i> Series(No) !",
                    buttons: {
                        danger: {
                            label: "No!",
                            className: "btn-danger btn-squared",
                            callback: function() {
                                $('.bootbox').modal('hide');
                            }
                        },
                        success: {
                            label: "Yes!",
                            className: "btn-success btn-squared",
                            callback: function() {
                                $.ajax({
                                    type: 'GET',
                                    url: site_url+'/category/change/status/'+id+'/'+series_status
                                }).done(function(response){
                                    bootbox.alert(response,
                                        function(){
                                            location.reload(true);
                                        }
                                    );

                                }).fail(function(response){
                                    bootbox.alert(response);
                                })
                            }
                        }
                    }
                });
            } else {
                bootbox.dialog({
                    message: "Are you sure you want to change this series to 'YES' ?",
                    title: "<i class='glyphicon glyphicon-eye-open'></i> Series(Yes) !",
                    buttons: {
                        danger: {
                            label: "No!",
                            className: "btn-danger btn-squared",
                            callback: function() {
                                $('.bootbox').modal('hide');
                            }
                        },
                        success: {
                            label: "Yes!",
                            className: "btn-success btn-squared",
                            callback: function() {
                                $.ajax({
                                    type: 'GET',
                                    url: site_url+'/category/change/status/'+id+'/'+series_status
                                }).done(function(response){
                                    bootbox.alert(response,
                                        function(){
                                            location.reload(true);
                                        }
                                    );
                                }).fail(function(response){
                                    bootbox.alert(response);
                                })
                            }
                        }
                    }
                });
            }
        });

        // category delete
        $('.category-delete').on('click', function (e) {
            e.preventDefault();
            var id = $(this).data('category-id');
            bootbox.dialog({
                message: "Are you sure you want to delete this category ?",
                title: "<i class='glyphicon glyphicon-trash'></i> Delete !",
                buttons: {
                    success: {
                        label: "No",
                        className: "btn-success btn-squared",
                        callback: function() {
                            $('.bootbox').modal('hide');
                        }
                    },
                    danger: {
                        label: "Delete!",
                        className: "btn-danger btn-squared",
                        callback: function() {
                            $.ajax({
                                type: 'GET',
                                url: site_url+'/category/delete/'+id,
                            }).done(function(response){
                                bootbox.alert(response,
                                    function(){
                                        location.reload(true);
                                    }
                                );
                            }).fail(function(response){
                                bootbox.alert(response);
                            })
                        }
                    }
                }
            });
        });
    })
</script>
@endsection