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
                    Sales Person
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
                        <a class="btn btn-primary sales_person"  data-action="add"><i class="fa fa-plus"></i>
                            Add</a>
                    </div>
                    <div class="table-responsive" style="overflow-x:auto; min-width: 100%;">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Sales Executive CODE</th>
                                <th>Executive Name</th>
                                <th>Designation CODE</th>
                                <th>Zone</th>
                                <th>Date Of Joining</th>
                                <th>Mobile No.</th>
                                <th>Account No.</th>
                                <th>Target</th>
                                <th>Basic</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (isset($SalesPerson_list) && count($SalesPerson_list)>0)
                                @php
                                    $page=isset($_GET['page'])? ($_GET['page']-1):0;
                                @endphp
                                @foreach ($SalesPerson_list as $key => $SalesPerson)
                                    <tr>
                                        <td>{{ ($key+1+($perPage*$page)) }}</td>
                                        <td>{{ $SalesPerson->salesExecutiveCode }}</td>
                                        <td>{{ $SalesPerson->salesExecutiveName }}</td>
                                        <td>{{ $SalesPerson->salesDesigCode }}</td>
                                        <td>{{ $SalesPerson->sales_persons_zone_name }}</td>
                                        <td>{{ $SalesPerson->dateOfJoining }}</td>
                                        <td>{{ $SalesPerson->sales_persons_mobile_no }}</td>
                                        <td>{{ $SalesPerson->sales_persons_account_no }}</td>
                                        <td>{{ $SalesPerson->sales_persons_target }}</td>
                                        <td>{{ $SalesPerson->sales_persons_basic }}</td>
                                        <td>{{ ($SalesPerson->sales_persons_status==1)?'Active':'In-active' }}</td>
                                        <td style="width:18%">
                                            <div class="btn-group">
                                                <a  class="btn btn-xs btn-info tooltips sales_person"  data-action="edit" data-person_id="{{$SalesPerson->id}}" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil fa fa-white"></i></a>
                                                @if($SalesPerson->sales_persons_status==1)
                                                <a  class="btn btn-xs btn-danger tooltips sales_person_action"  data-action="block" data-person_id="{{$SalesPerson->id}}" data-placement="top" data-original-title="Block"><i class="clip-user-block fa fa-white"></i></a>
                                                @else
                                                    <a  class="btn btn-xs btn-success tooltips sales_person_action"  data-action="active" data-person_id="{{$SalesPerson->id}}" data-placement="top" data-original-title="Active"><i class="clip-user-plus fa fa-white"></i></a>
                                                @endif
                                                <a  class="btn btn-xs btn-bricky tooltips sales_person_delete" data-person_id="{{$SalesPerson->id}}" data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="12">
                                        <div class="alert alert-success" role="alert">
                                            <h4>No Data Available !</h4>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>

                    </div>
                    {{isset($pagination)?$pagination:''}}
                </div>
            </div>
        </div>
    </div>
    <div id="sales_person" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                &times;
            </button>
            <h4 class="modal-title">Sales Person</h4>
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
            $('.sales_person_delete').on('click', function (e) {
                e.preventDefault();
                var id = $(this).data('person_id');
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
                                    url: site_url+'/sales/settings-person-sales/ajax/view?action=delete&person_id='+id,
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


            //Status Change
            $('.sales_person_action').on('click', function (e) {
                e.preventDefault();
                var id = $(this).data('person_id');
                var action = $(this).data('action');
                bootbox.dialog({
                    message: "Are you sure you want to Change Status ?",
                    title: "<i class='fa fa-exchange'></i> Status Change !",
                    buttons: {
                        success: {
                            label: "No",
                            className: "btn-success btn-squared",
                            callback: function() {
                                $('.bootbox').modal('hide');
                            }
                        },
                        danger: {
                            label: "Change!",
                            className: "btn-danger btn-squared",
                            callback: function() {
                                $.ajax({
                                    type: 'GET',
                                    url: site_url+'/sales/settings-person-sales/ajax/view?action='+action+'&person_id='+id,
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