<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumni_profiles', function (Blueprint $table) {
            $table->id('profile_id');

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users', 'user_id')
                ->cascadeOnDelete();

            $table->string('profile_picture')->nullable();
            $table->string('contact_number')->nullable();
            $table->year('graduation_year')->nullable();
            $table->string('program')->nullable();
            $table->string('company')->nullable();
            $table->string('location')->nullable();
            $table->string('job_title')->nullable();
            $table->text('skills')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni_profiles');
    }
};