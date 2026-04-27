<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id('donation_id');

            $table->foreignId('user_id')
                ->constrained('users', 'user_id')
                ->cascadeOnDelete();

            $table->string('donor_name');
            $table->decimal('amount', 12, 2);
            $table->date('donation_date');

            $table->enum('payment_type', ['e-wallet', 'bank']);
            $table->enum('payment_method', ['gcash', 'bpi', 'landbank']);

            $table->string('reference_details')->nullable();
            $table->string('proof_of_payment')->nullable();
            $table->string('purpose')->nullable();

            $table->enum('status', ['pending', 'verified', 'rejected', 'archived'])
                ->default('pending');

            $table->foreignId('verified_by')
                ->nullable()
                ->constrained('users', 'user_id')
                ->nullOnDelete();

            $table->timestamp('verified_at')->nullable();
            $table->text('admin_note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};