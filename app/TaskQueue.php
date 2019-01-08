<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskQueue extends Model
{
    protected $table = 'task_queue';
    protected $fillable = [
        'task_name',
        'task_user_id',
        'task_user_name',
        'task_start_at',
        'task_stop_at',
        'task_status', //1 means Running 2 means Completed
    ];
}
