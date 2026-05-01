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
        Schema::create('whisky_flavour_whisky_tasting', function (Blueprint $table) {
            $table->id();
            $table->foreignId('whisky_tasting_id')->constrained()->cascadeOnDelete();
            $table->foreignId('whisky_flavour_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['whisky_tasting_id', 'whisky_flavour_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whisky_flavour_whisky_tasting');
    }
};
