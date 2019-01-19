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
                    Report History
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
                        <a class="btn btn-primary report_history"  data-action="add"><i class="fa fa-plus"></i>
                            Add</a>
                    </div>
                    <div class="table-responsive" >
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>UserName</th>
                                <th>Reporting Month</th>
                                <th>Generate Date</th>
                                <th>Lock</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (isset($history_list) && count($history_list)>0)
                                @php
                                    $page=isset($_GET['page'])? ($_GET['page']-1):0;
                                @endphp
                                @foreach ($history_list as $key => $history)
                                    <tr>
                                        <td>{{ ($key+1+($perPage*$page)) }}</td>
                                        <td>{{ $history->history_title }}</td>
                                        <td>{{ $history->name }}</td>
                                        <td>{{ date('F', strtotime("2012-$history->history_month-01"))}},{{ date('Y', strtotime("$history->history_year-01-01"))}}</td>
                                        <td>{{ $history->history_date}}</td>
                                        <td>
                                            @if($history->history_lock_status==0)
                                                <span class="label label-info btn-squared">NO</span>
                                            @else
                                                <span class="label label-success btn-squared">Yes</span>
                                            @endif
                                        </td>
                                        <td style="width:18%">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-purple"><i class="fa fa-wrench"></i> Action</button><button data-toggle="dropdown" class="btn btn-purple dropdown-toggle"><span class="caret"></span></button><ul class="dropdown-menu" role="menu">
                                                    <li><a class="report_history"  data-action="edit" data-history_id="{{$history->id}}" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil fa fa-white"></i> Edit</a></li>
                                                    <li>
                                                        @if($history->history_lock_status == 1)
                                                            <a class="status-change"
                                                               data-publish-status="0" data-history_id="{{ $history->id}}" title="Click for un-lock">
                                                                <i class="fa fa-unlock"></i>Un Lock
                                                            </a>
                                                        @else
                                                            <a class="status-change " title="Click for Lcck"
                                                               data-publish-status="1" data-history_id="{{ $history->id}}">
                                                                <i class="fa fa-lock"></i> Lock
                                                            </a>
                                                        @endif
                                                    </li>
                                                    <li>
                                                        <a class="history_id_delete" data-history_id="{{$history->id}}">
                                                            <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                                                        </a>
                                                    </li>
                                                </ul>
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
    <div id="report_history" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                &times;
            </button>
            <h4 class="modal-title">Report History</h4>
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
            $('.history_id_delete').on('click', function (e) {
                e.preventDefault();
                var history_id = $(this).data('history_id');
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
                                    url: site_url+'/report-history/ajax/view?action=delete&history_id='+history_id,
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