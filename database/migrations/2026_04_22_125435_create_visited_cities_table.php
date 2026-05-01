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
        Schema::create('visited_cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('latitude', total: 10, places: 7);
            $table->decimal('longitude', total: 10, places: 7);
            $table->json('annotation');
            $table->string('link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visited_cities');
    }
};
