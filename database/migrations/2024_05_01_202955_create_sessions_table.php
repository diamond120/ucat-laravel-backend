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
            $table->id();
            $table->foreignId('package_id')->constrained();
            $table->integer('user_id');
            $table->boolean('completed');
            $table->double('score');
            $table->foreignId('section_id')->constrained();
            $table->foreignId('question_id')->constrained();
            $table->timestamp('started_at');
            $table->timestamp('finished_at');
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
