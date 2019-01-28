<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Report Table</title>
    <style type="text/css">
        body{
            font-size: 12px;
            font-family: arial;
        }
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
</head>
<body onload="window.print();" onfocus="window.close()">
<?php if(isset($sales_person_summary)){ ?>
<div class="box-body">

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
        <?php if(isset($last_card_report) && !empty($last_card_report)){ ?>
            <tr>
                <td>Card Sale (6 Months)</td>
                <td><?php  echo isset($last_card_report)?$last_card_report:''; ?></td>
            </tr>
        <?php }?>
        <tr>
            <td>Packages (<?php echo $sales_person_summary->report_year;?>)</td>
            <td><?php  echo isset($observation_status['observation_count'])? str_pad($observation_status['observation_count'],2,'0',STR_PAD_LEFT):''; ?>, Month: <?php  echo isset($observation_status['last_observation'])?$observation_status['last_observation']:''; ?></td>
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
<?php }?>
</body>
</html>