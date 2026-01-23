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
        Schema::create('student', function (Blueprint $table) {
            $table->string('student_id', 20)->primary();
            $table->foreignId('user_id')->unique()->constrained('users');
            $table->string('name', 100);
            $table->string('matric_no', 20)->unique()->nullable();
            $table->string('program_code', 20)->nullable();
            $table->integer('intake_year')->nullable();
            $table->string('phone_no', 20)->nullable();

            $table->foreign('program_code')->references('program_code')->on('programme');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student');
    }
};
