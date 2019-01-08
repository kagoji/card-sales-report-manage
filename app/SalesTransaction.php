<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesTransaction extends Model
{
    protected $table = 'sales_transaction';
    protected $fillable = [
        'transaction_exp_id',
        'transaction_year',
        'transaction_month',
        'customer_id',
        'customer_name',
        'customer_mobile',
        'customer_address',
        'customer_captureDate',
        'customer_limit',
        'tran_prd_grp',
        'tran_prd_name',
        'tran_commission_amount',
        'tran_prd_SalesExecutiveCODE',
        'tran_prd_SalesExecutiveName',
    ];
}
