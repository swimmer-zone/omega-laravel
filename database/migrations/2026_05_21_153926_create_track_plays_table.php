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
        Schema::create('track_plays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('track_id')->constrained()->cascadeOnDelete();

            $table->string('visitor_id')->nullable()->index();
            $table->unsignedInteger('played_seconds')->default(0);
            $table->unsignedInteger('duration_seconds')->nullable();

            $table->boolean('counted')->default(false);
            $table->boolean('completed')->default(false);

            $table->string('user_agent')->nullable();
            $table->string('ip_hash')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('track_plays');
    }
};
