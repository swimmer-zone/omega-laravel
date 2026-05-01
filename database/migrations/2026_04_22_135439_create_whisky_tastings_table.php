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
        Schema::create('whisky_tastings', function (Blueprint $table) {
            $table->id();
            $table->string('brand');
            $table->string('name')->nullable();
            $table->decimal('strength', total: 3, places: 1);
            $table->foreignId('whisky_country_id')->constrained()->cascadeOnDelete();
            $table->foreignId('whisky_region_id')->constrained()->cascadeOnDelete();
            $table->foreignId('whisky_type_id')->constrained()->cascadeOnDelete();
            $table->foreignId('whisky_cask_type_id')->constrained()->cascadeOnDelete();
            $table->timestamp('date_of_tasting')->nullable();
		    $table->string('location')->nullable();
		    $table->string('finish')->nullable();
		    $table->text('notes')->nullable();
            $table->decimal('rating', total: 2, places: 1);
            $table->foreignId('whisky_distillery_id')->constrained()->cascadeOnDelete();
            $table->boolean('would_buy')->default(false);
		    $table->integer('age')->nullable();
		    $table->string('url')->nullable();
		    $table->string('glance')->nullable();
            $table->foreignId('whisky_color_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whisky_tastings');
    }
};
