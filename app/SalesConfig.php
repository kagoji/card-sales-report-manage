<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesConfig extends Model
{
    protected $table = 'sales_config';
    protected $fillable = [
        'designationCode',
        'designationTitle',
        'config_target',
        'config_basic',
        'config_mobile_bill',
    ];
}
