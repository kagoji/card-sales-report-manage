<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportHistory extends Model
{
    protected $table = 'report_history';
    protected $fillable = [
        'user_id',
        'history_title',
        'history_year',
        'history_month',
        'history_date',
        'history_lock_status',
    ];
}
