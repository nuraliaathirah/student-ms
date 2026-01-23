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
        Schema::create('registration', function (Blueprint $table) {
            $table->id('registration_id');
            $table->string('student_id', 20);
            $table->unsignedBigInteger('section_id');
            $table->enum('status', ['approved', 'pending', 'cancelled'])->default('pending');
            $table->string('grade', 5)->nullable();
            $table->timestamp('registered_at')->useCurrent();
            $table->timestamp('approved_at')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();

            $table->foreign('student_id')->references('student_id')->on('student')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('section_id')->references('section_id')->on('course_section')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('approved_by')->references('id')->on('users')->onUpdate('cascade')->nullOnDelete();

            $table->unique(['student_id', 'section_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration');
    }
};
