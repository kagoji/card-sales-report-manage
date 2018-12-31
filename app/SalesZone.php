<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesZone extends Model
{
    protected $table = 'sales_zone';
    protected $fillable = [
        'zone_name',
    ];
}
