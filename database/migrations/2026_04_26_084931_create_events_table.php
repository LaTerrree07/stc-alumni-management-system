<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id('event_id');

            $table->foreignId('user_id')
                ->constrained('users', 'user_id')
                ->cascadeOnDelete();

            $table->string('event_title');
            $table->date('event_date');
            $table->time('event_time')->nullable();
            $table->string('location')->nullable();
            $table->string('event_image')->nullable();
            $table->text('description');
            $table->decimal('budget_used', 12, 2)->nullable();

            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'completed',
                'cancelled',
                'archived',
            ])->default('pending');

            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users', 'user_id')
                ->nullOnDelete();

            $table->timestamp('reviewed_at')->nullable();
            $table->text('admin_note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};