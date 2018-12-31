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
                    Sales Config
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
                        <a class="btn btn-primary sales_config"  data-action="add"><i class="fa fa-plus"></i>
                            Add</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="sample-table-1">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Design. Code</th>
                                <th>Design. Title</th>
                                <th>Target</th>
                                <th>Basic</th>
                                <th>Mobile Bill</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (isset($SalesConfig_list) && count($SalesConfig_list)>0)
                                @php
                                    $page=isset($_GET['page'])? ($_GET['page']-1):0;
                                @endphp
                                @foreach ($SalesConfig_list as $key => $SalesConfig)
                                    <tr>
                                        <td>{{ ($key+1+($perPage*$page)) }}</td>
                                        <td>{{ $SalesConfig->designationCode}}</td>
                                        <td>{{ $SalesConfig->designationTitle}}</td>
                                        <td>{{ $SalesConfig->config_target}}</td>
                                        <td>{{ $SalesConfig->config_basic }}</td>
                                        <td>{{ $SalesConfig->config_mobile_bill }}</td>
                                        <td style="width:18%">
                                            <div class="btn-group">
                                                <a href="#" class="btn btn-xs btn-info tooltips sales_config"  data-action="edit" data-config_id="{{$SalesConfig->id}}" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil fa fa-white"></i></a>
                                                <a  class="btn btn-xs btn-bricky tooltips sales_config_delete" data-config_id="{{$SalesConfig->id}}" data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7">
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
    <div id="sales_config" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                &times;
            </button>
            <h4 class="modal-title">Sales Config Add</h4>
        </div>

            <div class="modal-body">

            </div>

    </div>
@stop

@section('JScript')
    <script>
        $(function () {
            var site_url = $('.site_url').val();
            // content delete
            $('.sales_config_delete').on('click', function (e) {
                e.preventDefault();
                var id = $(this).data('config_id');
                bootbox.dialog({
                    message: "Are you sure you want to delete ?",
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
                                    url: site_url+'/sales/settings-config-sales/ajax/view?action=delete&config_id='+id,
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