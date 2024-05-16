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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->text('text')->nullable();
            $table->string('image_url')->nullable();
            $table->string('type'); //MC, DD
            $table->text('options');
            $table->text('option_image_urls')->nullable();
            $table->text('actions')->nullable();
            $table->text('answer');
            $table->text('explanation');
            $table->foreignId('situation_id')->constrained();
            $table->foreignId('section_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
