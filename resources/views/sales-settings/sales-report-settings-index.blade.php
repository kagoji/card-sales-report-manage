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
                    Sales Report Settings
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
                        <a class="btn btn-primary report_settings"  data-action="add"><i class="fa fa-plus"></i>
                            Add</a>
                    </div>
                    <div class="table-responsive" style="overflow-x:auto; min-width: 100%;">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Settings Name</th>
                                <th>Settings Value</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (isset($SalesSettings_list) && count($SalesSettings_list)>0)
                                @php
                                    $page=isset($_GET['page'])? ($_GET['page']-1):0;
                                @endphp
                                @foreach ($SalesSettings_list as $key => $SalesSettings)
                                    <tr>
                                        <td>{{ ($key+1+($perPage*$page)) }}</td>
                                        <td>{{ $SalesSettings->field_name }}</td>
                                        <td>{{ $SalesSettings->field_value }}</td>
                                        <td style="width:18%">
                                            <div class="btn-group">
                                                <a  class="btn btn-xs btn-info tooltips report_settings"  data-action="edit" data-report_settings_id="{{$SalesSettings->id}}" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil fa fa-white"></i></a>
                                                <a  class="btn btn-xs btn-bricky tooltips report_settings_delete" data-report_settings_id="{{$SalesSettings->id}}" data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></a>
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
    <div id="report_settings" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                &times;
            </button>
            <h4 class="modal-title">Sales Report Settings</h4>
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
            $('.report_settings_delete').on('click', function (e) {
                e.preventDefault();
                var id = $(this).data('report_settings_id');
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
                                    url: site_url+'/sales/settings-sales-report/ajax/view?action=delete&report_settings_id='+id,
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