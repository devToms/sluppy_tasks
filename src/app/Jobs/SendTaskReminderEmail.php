<?php

namespace App\Jobs;

use App\Models\Task;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendTaskReminderEmail implements ShouldQueue
{
    use Dispatchable, Queueable;

    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function handle()
    {
        $task = $this->task;
        $user = User::find($task->user_id);
        
        Mail::to($user->email)->send(new \App\Mail\TaskReminder($task));
    }
}
