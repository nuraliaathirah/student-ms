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
        Schema::create('course', function (Blueprint $table) {
            $table->string('course_id', 20)->primary();
            $table->string('course_name', 100);
            $table->integer('credit_hours');
            $table->integer('max_students');
            $table->string('program_code', 20);
            $table->foreign('program_code')->references('program_code')->on('programme');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course');
    }
};
