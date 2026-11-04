<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table): void {
            $table->unsignedInteger('id')->primary();
            $table->string('name', 150);
            $table->string('type', 100);
            $table->string('dimension', 150);
        });

        Schema::create('characters', function (Blueprint $table): void {
            $table->unsignedInteger('id')->primary();
            $table->string('name', 150);
            $table->string('status', 20);
            $table->string('species', 100);
            $table->string('type', 150);
            $table->string('gender', 20);
            $table->string('image');
            $table->unsignedInteger('origin_location_id')->nullable();
            $table->unsignedInteger('current_location_id')->nullable();
            $table->foreign('origin_location_id')->references('id')->on('locations')->nullOnDelete();
            $table->foreign('current_location_id')->references('id')->on('locations')->nullOnDelete();
        });

        Schema::create('episodes', function (Blueprint $table): void {
            $table->unsignedInteger('id')->primary();
            $table->string('name', 150);
            $table->string('air_date', 50);
            $table->string('episode', 10)->index();
        });

        Schema::create('character_episode', function (Blueprint $table): void {
            $table->unsignedInteger('character_id');
            $table->unsignedInteger('episode_id');
            $table->foreign('character_id')->references('id')->on('characters')->cascadeOnDelete();
            $table->foreign('episode_id')->references('id')->on('episodes')->cascadeOnDelete();
            $table->primary(['character_id', 'episode_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('character_episode');
        Schema::dropIfExists('episodes');
        Schema::dropIfExists('characters');
        Schema::dropIfExists('locations');
    }
};
