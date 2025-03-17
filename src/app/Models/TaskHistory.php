<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskHistory extends Model
{
    protected $fillable = [
        'task_id',
        'name',
        'description',
        'priority',
        'status',
        'due_date',
        'user_id',
    ];
}
