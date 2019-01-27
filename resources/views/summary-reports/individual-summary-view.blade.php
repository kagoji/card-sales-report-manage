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
                    Sales Report
                    <div class="panel-tools">
                        <a class="btn btn-xs btn-link panel-collapse collapses" data-toggle="tooltip" data-placement="top" title="Show / Hide" href="#">
                        </a>
                        <a class="btn btn-xs btn-link panel-close red-tooltip" data-toggle="tooltip" data-placement="top" title="Close" href="#">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="panel-body" >

                        <div class="row">
                            <form method="get" action="{{url('/sales/manage-reports/individual-summary')}}">
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

                                <div class="col-md-2">
                                    <div class="form-group ">
                                        <label for="form-field-23">
                                            Executive Code<span class="symbol required"></span>
                                        </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="executivecode"  value="{{(isset($_GET['executivecode']))?$_GET['executivecode']:''}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1" style="margin-top:22px;">
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary" data-toggle1="tooltip" title="View Report" value="View">
                                    </div>
                                </div>

                            </form>
                            @if(isset($sales_person_summary->id))
                                @php
                                    $response_data = \Request::getQueryString();
                                @endphp
                                <div class="col-md-3" style="margin-top:22px;">
                                    <a href="{{url('/sales/manage-reports/individual-summary/pdf?'.$response_data)}}" class="btn btn-green tooltips pull-right" data-toggle1="tooltip" title="" style="margin-left:10px;" data-original-title="Sales Individual Summary PDF Download"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                                    <a target="_blank" href="{{url('/sales/manage-reports/individual-summary/print?'.$response_data)}}" class="btn btn-green tooltips pull-right" data-toggle1="tooltip" title="" style="margin-left:10px;" data-original-title="Sales Individual Summary Print"><i class="fa fa-print" aria-hidden="true"></i></a>
                                </div>
                            @else
                                <div class="col-md-4 all_individual_report" style="margin-top:22px;" data-toggle="modal" data-target="#all_individual_report">
                                    <a class="btn btn-info">
                                        <i class="fa fa-download"></i>
                                        | All Individual Report
                                    </a>
                                </div>
                            @endif
                        </div>

                </div>
            </div>
            @if(isset($sales_person_summary->id))
            <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="clip-users-2"></i>
                        Individual Summary Report
                    </div>
                    <div class="panel-body">
                        <div class="box-body" style="height: 500px;overflow-y: scroll;">

                            <section class="pg">
                                <div class="top-header">
                                    <p style="text-align: center; font-size: 13px;"> Southeast Bank Ltd. <br/> Card Division, Head Office, Dhaka <br /> <?php echo isset($sales_person_summary->report_zone_name)?$sales_person_summary->report_zone_name:''; ?></p>
                                </div>
                                <p> Commission for the Month of: <?php $month =str_pad($sales_person_summary->report_month,2,'0',STR_PAD_LEFT); $report_date= "$sales_person_summary->report_year-$month-01"; echo date('F-Y',strtotime($report_date)); //echo date('F-Y');?> </p>
                                <p> Name of the Sales Executive: <?php echo isset($sales_person_summary->report_ExecutiveName)?$sales_person_summary->report_ExecutiveName:''; ?> </p>
                                <p> Date of Joining: <?php echo isset($sales_person_summary->report_dateOfjoining)?$sales_person_summary->report_dateOfjoining:''; ?> </p>
                                <p> Designation: <?php echo isset($sales_person_summary->report_DesigTitle)?$sales_person_summary->report_DesigTitle:''; ?> (Minimum Target: <?php echo isset($sales_person_summary->report_sales_persons_target)?$sales_person_summary->report_sales_persons_target:''; ?>)</p>
                                <p> Observation Period: <?php echo (isset($sales_person_summary->report_observation_status)&&($sales_person_summary->report_observation_status==1))?'YES':'NO'; ?> </p>
                                <p> Sales Code:<?php echo isset($sales_person_summary->report_ExecutiveCode)?$sales_person_summary->report_ExecutiveCode:''; ?> </p> <br/>

                                <table style="margin-bottom: 55px; font-weight: bold">
                                    <tr>
                                        <td>Card Sale (6 Months)</td>
                                        <td>Dec: 14, Nov: 18, Oct: 27, Sep: 12, Aug: 19, Jul: 22</td>
                                    </tr>
                                    <tr>
                                        <td>Packages (2018)</td>
                                        <td>02, Month: December, July</td>
                                    </tr>
                                </table>

                                <table id="reports" class="table table-bordered table-hover dataTable" >
                                    <thead>
                                    <tr>
                                        <th>Sl.</th>
                                        <th style="width: 120px">Customer ID</th>
                                        <th style="width: 200px">Card Product</th>
                                        <th style="width: 200px">Customer Name</th>
                                        <th>Mobile</th>
                                        <th>Creation Date</th>
                                        <th style="text-align: right;">Commission</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1;
                                    if(isset($sales_person_transaction) && count($sales_person_transaction)>0 ){
                                    foreach($sales_person_transaction as $key => $transaction ){
                                    ?>
                                    <tr>
                                        <td><?php echo $key+1; ?></td>
                                        <td><?php echo isset($transaction->customer_id )?$transaction->customer_id :''; ?></td>
                                        <td><?php echo isset($transaction->tran_prd_name)?$transaction->tran_prd_name:''; ?></td>
                                        <td><?php echo isset($transaction->customer_name)?$transaction->customer_name:''; ?></td>
                                        <td><?php echo isset($transaction->customer_mobile)?$transaction->customer_mobile:''; ?></td>
                                        <td><?php echo isset($transaction->created_at )? date('Ymd',strtotime($transaction->created_at)):''; ?></td>
                                        <td style="text-align: right;"><?php echo isset($transaction->tran_commission_amount)?$transaction->tran_commission_amount:''; ?></td>
                                    </tr>

                                    <?php      }
                                    }

                                    ?>
                                    </tbody>
                                </table>
                                <br/>
                                <span style="text-align: center;" class="content">
             <table align="center" class="detail" cellspacing="0" cellpadding="0" border="0" >
               <tr>
                  <td style="border: none;">
                   <table class="details">
                      <tr>
                          <td> Basic Card: </td>
                          <td><?php echo isset($sales_person_summary->basic_card_count)?$sales_person_summary->basic_card_count:0; ?></td>
                      </tr>
                      <tr>
                          <td>Supplementary Card: </td>
                          <td> <?php echo isset($sales_person_summary->supplementary_card_count )?$sales_person_summary->supplementary_card_count :0; ?></td>
                      </tr>
                       <tr>
                          <td>Travel  Card: </td>
                          <td> <?php echo isset($sales_person_summary->travel_card_count )?$sales_person_summary->travel_card_count:0; ?></td>
                      </tr>
                       <tr>
                          <td>Virtual  Card: </td>
                          <td> <?php echo isset($sales_person_summary->virtual_card_count)?$sales_person_summary->virtual_card_count:0; ?></td>
                      </tr>

                       <tr>
                          <td> Total Cards:  </td>
                          <td><?php echo isset($sales_person_summary->total_card_count )?$sales_person_summary->total_card_count:0; ?></td>
                        </tr>
                        <tr>
                          <td> Commission Range 1:  </td>
                          <td><?php echo isset($sales_person_summary->to_target_commission_amount )?$sales_person_summary->to_target_commission_amount :0; ?> </td>
                        </tr>
                        <tr>
                          <td> Commission Range 2:  </td>
                          <td><?php echo isset($sales_person_summary->after_target_commission_amount)?$sales_person_summary->after_target_commission_amount:0; ?> </td>
                        </tr>
                       <tr>
                          <td> Commission Supplementary:  </td>
                          <td><?php echo isset($sales_person_summary->supply_card_commission_amount)?$sales_person_summary->supply_card_commission_amount:0; ?> </td>
                        </tr>

                    </table>
                  </td>
                  <td style="border: none;">
                    <table class="details">

                        <tr>
                          <td> Commission Travel Card:  </td>
                          <td><?php echo isset($sales_person_summary->travel_card_commission_amount)?$sales_person_summary->travel_card_commission_amount:0; ?> </td>
                        </tr>
                        <tr>
                          <td> Commission Virtual Card:  </td>
                          <td><?php echo isset($sales_person_summary->virtual_card_commission_amount)?$sales_person_summary->virtual_card_commission_amount:0; ?> </td>
                        </tr>
                        <tr>
                          <td> Card Bonus:  </td>
                          <td><?php echo isset($sales_person_summary->card_bonus_amount)?$sales_person_summary->card_bonus_amount:0; ?> </td>
                        </tr>
                       <tr>
                        <td> Total Commission:  </td>
                        <td><?php echo isset($sales_person_summary->total_commission_amount)?$sales_person_summary->total_commission_amount:0; ?></td>
                      </tr>
                      <tr>
                        <td> Basic Salary:  </td>
                        <td><?php echo isset($sales_person_summary->report_basic_pay_amount )?$sales_person_summary->report_basic_pay_amount :0; ?></td>
                      </tr>
                      <tr>
                        <td> Mobile Allowance:  </td>
                        <td><?php echo isset($sales_person_summary->report_mobile_allowance)?$sales_person_summary->report_mobile_allowance:0; ?></td>
                      </tr>
                      <tr>
                        <td> Cash Reward (30+ Card):  </td>
                        <td><?php echo isset($sales_person_summary->cash_reward_amount )?$sales_person_summary->cash_reward_amount :0; ?></td>
                      </tr>
                      <tr>
                        <td> Sub Total:  </td>
                        <td> <b> <?php echo isset($sales_person_summary->grand_total_amount  )?$sales_person_summary->grand_total_amount :0; ?></b></td>
                      </tr>

                     </table>
                  </td>
               </tr>
             </table>
             </span>

                            </section>
                        </div>
                    </div>
            </div>
            @endif
        </div>
    </div>

    <div id="all_individual_report" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                &times;
            </button>
            <h4 class="modal-title">All Individual Report Download</h4>
        </div>

        <div class="modal-body">
            <form role="form" class="form-horizontal" action="{{ url('/sales/report-history/view') }}"
                  id="" method="post" role="form" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group col-md-12">
                            <label class="col-sm-5 control-label">
                                <strong>Report Zone</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-5">
                                <select name="sales_zone" class="form-control transaction_list">
                                    <option value="0"> Select Cost</option>
                                    @if(!empty($sales_zone_list) && count($sales_zone_list)>0)
                                        @foreach ($sales_zone_list as $key => $list){
                                        <option  value="{{$list->id}}">{{$list->zone_name}}</option>
                                        @endforeach
                                    @endif

                                </select>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label class="col-sm-5 control-label">
                                <strong>Report Year</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-5">
                                <input type="number" class="form-control" name="history_year" min="2017" step="1">
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="col-sm-5 control-label">
                                <strong>Report Month</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-5">
                                <select class="form-control" name="history_month">
                                    <option value=''>--Select Month--</option>
                                    <option selected value='1'>Janaury</option>
                                    <option value='2'>February</option>
                                    <option value='3'>March</option>
                                    <option value='4'>April</option>
                                    <option value='5'>May</option>
                                    <option value='6'>June</option>
                                    <option value='7'>July</option>
                                    <option value='8'>August</option>
                                    <option value='9'>September</option>
                                    <option value='10'>October</option>
                                    <option value='11'>November</option>
                                    <option value='12'>December</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">
                            </div>
                            <div class="col-sm-3">
                                <input class="btn btn-danger btn-squared" name="reset" value="Reset" type="reset">
                                <input class="btn btn-success btn-squared" name="submit" value="Save" type="submit">
                            </div>
                            <div class="col-sm-2">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('JScript')
    <style type="text/css">

        #outtable{
            padding: 20px;
            border:1px solid #e3e3e3;
            width:600px;
            border-radius: 5px;
        }
        .short{
            width: 50px;
        }
        .normal{
            width: 150px;
        }
        table{
            border-collapse: collapse;

            width: 100%;
        }
        thead th{
            text-align: left;
            padding: 2px;
            border: 1px solid #000;
        }
        tbody td{
            border: 1px solid #000;
            padding: 2px 2px;
        }
        tbody tr:nth-child(even){

        }
        tbody tr:hover{
            background: #EAE9F5
        }
        .pg{
            page-break-before:always; margin-top: -20px;
        }
        .pg:first-child{
            page-break-before: avoid;
        }
        p{
            margin: 2px 0 0 0;
            font-family: arial;
            font-weight: bold;
        }
        .content p{
            margin: 2px;
        }
        .content table{
            border-spacing: 0px;
        }
        .details{


        }
        .details td{


        }
        .details td:nth-child(1) {
            font-weight: bold;
        }
        .details td:last-child {
            text-align: right;
        }

        .sign td{
            padding-bottom: 50px;
            border: none;
            font-size: 11px;
        }
        .sign span{
            font-weight: bold;
        }
        .top-header {
            margin-top: 25px;
            margin-bottom: 20px;
        }
    </style>
@endsection