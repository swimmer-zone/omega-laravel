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
        Schema::create('whisky_distilleries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('latitude', total: 10, places: 7);
            $table->decimal('longitude', total: 10, places: 7);
            $table->integer('marker_offset');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whisky_distilleries');
    }
};
