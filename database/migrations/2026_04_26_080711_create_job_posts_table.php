<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id('job_id');

            $table->foreignId('user_id')
                ->constrained('users', 'user_id')
                ->cascadeOnDelete();

            $table->string('company_name');
            $table->string('job_title');
            $table->string('job_type')->nullable();
            $table->string('location')->nullable();
            $table->string('salary_range')->nullable();
            $table->string('application_link')->nullable();
            $table->text('description');
            $table->text('requirements')->nullable();

            $table->enum('status', ['pending', 'approved', 'rejected', 'archived'])
                ->default('pending');

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
        Schema::dropIfExists('job_posts');
    }
};