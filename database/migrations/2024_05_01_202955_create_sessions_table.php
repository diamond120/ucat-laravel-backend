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
        Schema::create('sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('package_id')->constrained();
            $table->integer('user_id');
            $table->boolean('completed');
            $table->double('score')->nullable();
            $table->foreignId('section_id')->nullable()->constrained();
            $table->foreignId('question_id')->nullable()->constrained();
            $table->integer('first_time')->nullable();
            $table->integer('last_time')->nullable();
            $table->timestamp('started_at');
            $table->timestamp('finished_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
