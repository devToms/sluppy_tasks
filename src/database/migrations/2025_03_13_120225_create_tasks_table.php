<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255); // Nazwa zadania
            $table->text('description')->nullable(); // Opis
            $table->enum('priority', ['low', 'medium', 'high']); // Priorytet
            $table->enum('status', ['to-do', 'in progress', 'done']); // Status
            $table->dateTime('due_date'); // Termin wykonania
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relacja z użytkownikiem
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
