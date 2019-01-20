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
                    Sales Commission
                    <div class="panel-tools">
                        <a class="btn btn-xs btn-link panel-collapse collapses" data-toggle="tooltip" data-placement="top" title="Show / Hide" href="#">
                        </a>
                        <a class="btn btn-xs btn-link panel-close red-tooltip" data-toggle="tooltip" data-placement="top" title="Close" href="#">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="panel-body">

                        <div class="row">
                            <form method="get" action="{{url('/sales/manage-reports/zone-summary')}}">
                                <div class="col-md-2">
                                    <div class="form-group ">
                                        <label for="form-field-23">
                                            Reported Year<span class="symbol required"></span>
                                        </label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="history_year" min="2017" step="1" value="{{(isset($_GET['history_year']))?$_GET['history_year']:date('Y')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label for="form-field-23">
                                            Month<span class="symbol required"></span>
                                        </label>
                                        <div class="input-group">
                                            <select class="form-control" name="history_month">
                                                <option value=''>--Select Month--</option>
                                                <option {{(isset($_GET['history_month']) && ($_GET['history_month'] == 1)) ? 'selected':''}} value='1'>Janaury</option>
                                                <option {{(isset($_GET['history_month']) && ($_GET['history_month'] == 2)) ? 'selected':''}} value='2'>February</option>
                                                <option {{(isset($_GET['history_month']) && ($_GET['history_month'] == 3)) ? 'selected':''}} value='3'>March</option>
                                                <option {{(isset($_GET['history_month']) && ($_GET['history_month'] == 4)) ? 'selected':''}} value='4'>April</option>
                                                <option {{(isset($_GET['history_month']) && ($_GET['history_month'] == 5)) ? 'selected':''}} value='5'>May</option>
                                                <option {{(isset($_GET['history_month']) && ($_GET['history_month'] == 6)) ? 'selected':''}} value='6'>June</option>
                                                <option {{(isset($_GET['history_month']) && ($_GET['history_month'] == 7)) ? 'selected':''}} value='7'>July</option>
                                                <option {{(isset($_GET['history_month']) && ($_GET['history_month'] == 8)) ? 'selected':''}} value='8'>August</option>
                                                <option {{(isset($_GET['history_month']) && ($_GET['history_month'] == 9)) ? 'selected':''}} value='9'>September</option>
                                                <option {{(isset($_GET['history_month']) && ($_GET['history_month'] == 10)) ? 'selected':''}} value='10'>October</option>
                                                <option {{(isset($_GET['history_month']) && ($_GET['history_month'] == 11)) ? 'selected':''}} value='11'>November</option>
                                                <option {{(isset($_GET['history_month']) && ($_GET['history_month'] == 12)) ? 'selected':''}} value='12'>December</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label for="form-field-23">
                                            Zone<span class="symbol required"></span>
                                        </label>
                                        <div class="input-group">
                                            <select name="sales_zone" class="form-control transaction_list">
                                                <option value="0"> Select Cost</option>
                                                @if(!empty($sales_zone_list) && count($sales_zone_list)>0)
                                                    @foreach ($sales_zone_list as $key => $list){

                                                    <option {{(isset($_GET['sales_zone']) && ($_GET['sales_zone'] == $list->id)) ? 'selected':''}} value="{{$list->id}}">{{$list->zone_name}}</option>

                                                    @endforeach
                                                @endif

                                            </select>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1" style="margin-top:22px;">
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary" data-toggle1="tooltip" title="View Report" value="View">
                                    </div>
                                </div>

                            </form>
                            @if(isset($zone_summery_list)&& count($zone_summery_list))
                                @php
                                    $response_data = \Request::getQueryString();
                                @endphp
                                <div class="col-md-3" style="margin-top:22px;">
                                    <a href="{{url('/sales/manage-reports/zone-summary/pdf?'.$response_data)}}" class="btn btn-green tooltips pull-right" data-toggle1="tooltip" title="" style="margin-left:10px;" data-original-title="Sales Zone Summary PDF Download"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                                    <a target="_blank" href="{{url('/sales/manage-reports/zone-summary/print?'.$response_data)}}" class="btn btn-green tooltips pull-right" data-toggle1="tooltip" title="" style="margin-left:10px;" data-original-title="Sales Zone Summary Print"><i class="fa fa-print" aria-hidden="true"></i></a>
                                </div>
                            @endif
                        </div>

                </div>
            </div>
            @if(isset($zone_summery_list))
            <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="clip-users-2"></i>
                        Sales Zone Summary Report
                    </div>
                    <div class="panel-body">
                        <div class="row text-center">
                            <h4 class="page-title">Southeast Bank Ltd.</h4>
                            <p>Card Division, Head Office, Dhaka</p>
                            <p>{{isset($zone_info->id)? $zone_info->zone_name:''}}</p>
                        </div>
                        <div class="table-responsive" style="overflow-x:auto; min-width: 100%;">
                            <table class="table table-bordered table-hover" id="sample-table-1">
                                <thead>
                                <tr>
                                    <th rowspan="2">SL</th>
                                    <th rowspan="2">Name of Employee</th>
                                    <th rowspan="2">Designation</th>
                                    <th rowspan="2">Date of Joining</th>
                                    <th rowspan="2">Basic Pay</th>
                                    <th colspan="3" class="text-center">Allowances</th>
                                    <th rowspan="2">Total</th>
                                    <th rowspan="2">Account No.</th>
                                </tr>
                                <tr>
                                    <th>Commission</th>
                                    <th>Mobile Bill</th>
                                    <th>Cash Reward</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if (isset($zone_summery_list) && count($zone_summery_list)>0)
                                    @foreach ($zone_summery_list as $key => $summery_list)
                                        <tr>
                                            <td>{{ ($key+1) }}</td>
                                            <td>{{ $summery_list->report_ExecutiveName  }}</td>
                                            <td>{{ $summery_list->report_DesigCode  }}</td>
                                            <td>{{ $summery_list->report_dateOfjoining  }}</td>
                                            <td>{{ $summery_list->report_basic_pay_amount  }}</td>
                                            <td>{{ $summery_list->total_commission_amount  }}</td>
                                            <td>{{ $summery_list->report_mobile_allowance  }}</td>
                                            <td>{{ $summery_list->cash_reward_amount  }}</td>
                                            <td>{{ $summery_list->grand_total_amount }}</td>
                                            <td>{{ $summery_list->report_sales_persons_account_no }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="11">
                                            <div class="alert alert-success" role="alert">
                                                <h4>No Data Available !</h4>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>

                        </div>
                    </div>
            </div>
            @endif
        </div>
    </div>
@stop

@section('JScript')
    <script>
        $(function () {
            var site_url = $('.site_url').val();
            // content delete
            $('.sales_commission_delete').on('click', function (e) {
                e.preventDefault();
                var id = $(this).data('commission_id');
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
                                    url: site_url+'/sales/settings-commission/ajax/view?action=delete&commission_id='+id,
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