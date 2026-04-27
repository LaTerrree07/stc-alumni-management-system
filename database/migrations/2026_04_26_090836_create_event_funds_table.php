<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_funds', function (Blueprint $table) {
            $table->id('fund_id');

            $table->year('fund_year')->unique();

            $table->decimal('total_fund', 12, 2)->default(0);
            $table->decimal('used_fund', 12, 2)->default(0);
            $table->decimal('remaining_fund', 12, 2)->default(0);

            $table->foreignId('created_by')
                ->constrained('users', 'user_id')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_funds');
    }
};