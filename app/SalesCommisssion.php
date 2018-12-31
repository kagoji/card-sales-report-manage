<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesCommisssion extends Model
{

    protected $table = 'sales_commission';
    protected $fillable = [
        'cmm_prd_grp',
        'cmm_name',
        'cmm_prd_grp_type_name',
        'cmm_amount',
    ];
}
