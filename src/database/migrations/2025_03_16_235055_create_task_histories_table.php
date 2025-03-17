<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    { 
        Schema::create('task_histories', function (Blueprint $table) {
             $table->id();
             $table->foreignId('task_id')->constrained('tasks')->onDelete('cascade');
             $table->text('name')->nullable();
             $table->text('description')->nullable();
             $table->string('priority')->nullable();
             $table->string('status')->nullable();
             $table->date('due_date')->nullable();
             $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_histories');
    }
};
