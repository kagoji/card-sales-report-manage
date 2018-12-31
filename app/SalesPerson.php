<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesPerson extends Model
{
    protected $table = 'sales_persons';
    protected $fillable = [
        'salesExecutiveCode',
        'salesExecutiveName',
        'salesDesigCode',
        'salesDesigTitle',
        'dateOfJoining',
        'sales_persons_account_no',
        'sales_persons_mobile_no',
        'sales_persons_zone_id',
        'sales_persons_zone_name',
        'sales_persons_target',
        'sales_persons_basic',
        'sales_persons_mobile_bill',
        'sales_persons_status',
    ];
}
