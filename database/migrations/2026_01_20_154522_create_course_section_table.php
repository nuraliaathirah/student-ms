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
        Schema::create('course_section', function (Blueprint $table) {
            $table->id('section_id');
            $table->string('course_id', 20);
            $table->string('lecturer_id', 20);
            $table->string('semester_id', 20);
            $table->string('section_no', 5);
            $table->string('schedule', 100)->nullable();
            $table->string('venue', 50)->nullable();

            $table->foreign('course_id')->references('course_id')->on('course');
            $table->foreign('lecturer_id')->references('lecturer_id')->on('lecturer');
            $table->foreign('semester_id')->references('semester_id')->on('semester');

            $table->unique(['course_id', 'section_no', 'semester_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_section');
    }
};
