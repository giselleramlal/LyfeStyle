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
        Schema::create('sleep_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('date');
            $table->unsignedBigInteger('daily_log_id')->nullable();
            $table->time('sleep_time');
            $table->time('wake_time');
            $table->decimal('duration_hours', 4, 2);
            $table->integer('quality'); // 1-10 scale
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // Note: daily_logs foreign key removed since table doesn't exist yet
            
            // Indexes
            $table->index(['user_id', 'date']);
            $table->index('date');
            $table->unique(['user_id', 'date']); // Prevent duplicate entries for same user/date
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sleep_logs');
    }
};