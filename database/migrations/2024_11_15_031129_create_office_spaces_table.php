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
        Schema::create('office_spaces', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique()->nullable();
            $table->string('thumbnail')->nullable();
            $table->longText('about')->nullable();
            $table->foreignId('city_id')->constrained()->cascadeOnDelete();
            $table->integer('is_open')->default(1)->nullable();
            $table->integer('is_full')->default(0)->nullable();
            $table->unsignedInteger('price');
            $table->unsignedInteger('duration');
            $table->string('addess')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office_spaces');
    }
};
