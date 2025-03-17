<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Task extends Model
{
    use HasFactory, CrudTrait;
    
    protected $fillable = [
        'name',
        'description',
        'priority',
        'status',
        'due_date',
        'user_id',
        'public_link'
  ]; 


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
