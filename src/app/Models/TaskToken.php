<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskToken extends Model
{
    use HasFactory;

    protected $fillable = ['task_id', 'token', 'expires_at'];

    protected $dates = ['expires_at'];

    /**
     * Checking if the token is still valid
     */
    public function isValid()
    {
        return $this->expires_at->isFuture();
    }
}
