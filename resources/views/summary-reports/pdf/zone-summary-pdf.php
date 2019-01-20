<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Report Table</title>
    <style type="text/css">
        body{
            font-size: 10px;
            font-family: arial;
        }
        #outtable{
            padding: 20px;

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
            text-align: center;
            padding: 2px;
            border: 1px solid #000;
        }
        tbody td{
            border: 1px solid #000;
            padding: 2px 4px;
        }
        tbody tr:nth-child(even){

        }
        tbody tr:hover{
            background: #EAE9F5
        }
        .pg{
            page-break-before:always;
        }
        .pg:first-child{
            page-break-before: avoid;
        }
        p{
            margin-bottom: 5px;
            font-family: arial;
            font-weight: bold;
        }
        .content p{
            margin: 5px;
        }
        .content table{
            border-spacing: 0px;
        }
        .details{
            width: 40%;

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
            padding-bottom: 130px;
            border: none;
            font-size: 11px;
        }
        .sign span{
            font-weight: bold;
        }

    </style>
</head>
<body>
<?php if(isset($zone_summery_list) && count($zone_summery_list)>0){ ?>
    <div class="box-body">
        <p style="text-align: center; font-size: 13px;"> Southeast Bank Ltd. <br/> Card Division, Head Office, Dhaka <br/><?php echo (isset($zone_info->zone_name))?$zone_info->zone_name:'';?></p>
        <p style="font-size: 13px;"> Salary Summary Report (Sales) </p>
        <p> Ref # HO/CCD/<?php echo date('Y');?>/ <br/ > Date: <?php echo date('F d, Y');?> </p> <br />
        <table class="" align="center" id="category">
            <thead>
            <tr>
                <th rowspan="2">Sl.</th>
                <th rowspan="2" style="width: 110px;">Name of Employee</th>
                <th rowspan="2" style="width: 110px;">Designation</th>
                <th rowspan="2" style="width: 60px;">Date of Joining</th>
                <th rowspan="2">Basic Pay</th>
                <th colspan="3">Allowances</th>
                <th rowspan="2">Total</th>
                <th rowspan="2">Account No.</th>
            </tr>
            <tr>
                <th>Commission</th>
                <th>Mobile Bill</th>
                <th>Cash Reward</th>
            </tr>
            </thead>

            <?php
            $total_basic = 0;
            $total_commission = 0;
            $total_mobile_allowance = 0;
            $total_cash_reward = 0;
            $total_grand_total = 0;
            ?>

            <?php foreach ($zone_summery_list as $key => $summery_list){?>


            <tbody>

            <tr>
                <td style="text-align: center;"><?php echo ($key+1) ;?></td>
                <td style="text-align: center;"> <?php echo (isset($summery_list->report_ExecutiveName))?$summery_list->report_ExecutiveName:'';?> </td>
                <td style="text-align: right;"><?php echo (isset($summery_list->report_DesigCode))?$summery_list->report_DesigCode:'';?>  </td>
                <td style="text-align: right;"><?php echo (isset($summery_list->report_dateOfjoining))?$summery_list->report_dateOfjoining:'';?>  </td>
                <td style="text-align: right;"><?php echo (isset($summery_list->report_basic_pay_amount))?$summery_list->report_basic_pay_amount:'';?>  </td>
                <td style="text-align: right;"><?php echo (isset($summery_list->total_commission_amount))?$summery_list->total_commission_amount:'';?>  </td>
                <td style="text-align: right;"> <?php echo (isset($summery_list->report_mobile_allowance))?$summery_list->report_mobile_allowance:'';?> </td>
                <td style="text-align: center;"><?php echo (isset($summery_list->cash_reward_amount))?$summery_list->cash_reward_amount:'';?> </td>
                <td style="text-align: center;"><?php echo (isset($summery_list->grand_total_amount))?$summery_list->grand_total_amount:'';?> </td>
                <td style="text-align: center;"><?php echo (isset($summery_list->report_sales_persons_account_no))?$summery_list->report_sales_persons_account_no:'';?> </td>
            </tr>
            <?php
                $total_basic = $total_basic+$summery_list->report_basic_pay_amount;
                $total_commission = $total_commission+$summery_list->total_commission_amount;
                $total_mobile_allowance = $total_mobile_allowance+$summery_list->report_mobile_allowance;
                $total_cash_reward = $total_cash_reward+$summery_list->cash_reward_amount;
                $total_grand_total = $total_grand_total+$summery_list->grand_total_amount;
            ?>

            <?php } ?>
            <tr style="font-weight: bold;">
                <td colspan="4"> Total </td>
                <td style="text-align: right;"><?php echo  number_format($total_basic,2,'.','' ) ;?></td>
                <td id="sum1" style="text-align: right;"> <?php echo  number_format($total_commission,2,'.','' ) ;?> </td>
                <td style="text-align: right;"> <?php echo  number_format($total_mobile_allowance,2,'.','' ) ;?> </td>
                <td style="text-align: right;"> <?php echo  number_format($total_cash_reward,2,'.','' ) ;?> </td>
                <td id="sum2" style="text-align: right;"> <?php echo  number_format($total_grand_total,2,'.','' ) ;?> </td>
                <td> </td>
            </tr>
            </tbody>
        </table>

        <table class="sign" style="margin-top: 90px;">
            <tr>
                <td> <span>S. M. Wahiduzzaman</span> <br /> Senior Executive Officer </td>
                <td style="text-align: right;"> <span>Kazi Saiful Islam</span> <br /> Assistant Vice President  </td>
            </tr>
            <tr>
                <td> <span>N. M. Firoz Kamal</span> <br /> Senior Assistant Vice President </td>
                <td style="text-align: right;"> <span>Md. Abdus Sabur Khan</span> <br /> Senior Vice President & Head of Cards  </td>
            </tr>
        </table>

    </div>
    <?php
} ?>
</body>
</html>