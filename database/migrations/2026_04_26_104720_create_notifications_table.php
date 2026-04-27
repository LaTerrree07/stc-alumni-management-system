<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('notification_id');

            $table->foreignId('user_id')
                ->constrained('users', 'user_id')
                ->cascadeOnDelete();

            $table->string('message');
            $table->string('type')->nullable();

            $table->enum('status', ['unread', 'read'])
                ->default('unread');

            $table->string('related_table')->nullable();
            $table->unsignedBigInteger('related_id')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['related_table', 'related_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};