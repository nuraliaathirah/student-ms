<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $blueprint) {
            $blueprint->uuid('id')->primary();
            $blueprint->string('type');
            $blueprint->morphs('notifiable'); // This handles user_id and user_type automatically
            $blueprint->text('data');
            $blueprint->timestamp('read_at')->nullable();
            $blueprint->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};