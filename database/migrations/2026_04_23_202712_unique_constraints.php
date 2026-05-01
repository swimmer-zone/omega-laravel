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
        Schema::table('whisky_countries', function (Blueprint $table) {
            $table->unique('name');
        });

        Schema::table('whisky_regions', function (Blueprint $table) {
            $table->unique('name');
        });

        Schema::table('whisky_types', function (Blueprint $table) {
            $table->unique('name');
        });

        Schema::table('whisky_finishes', function (Blueprint $table) {
            $table->unique('name');
        });

        Schema::table('whisky_colors', function (Blueprint $table) {
            $table->unique('name');
        });

        Schema::table('whisky_flavours', function (Blueprint $table) {
            $table->unique('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('whisky_countries', function (Blueprint $table) {
            $table->dropUnique(['name']);
        });

        Schema::table('whisky_regions', function (Blueprint $table) {
            $table->dropUnique(['name']);
        });

        Schema::table('whisky_types', function (Blueprint $table) {
            $table->dropUnique(['name']);
        });

        Schema::table('whisky_finishes', function (Blueprint $table) {
            $table->dropUnique(['name']);
        });

        Schema::table('whisky_colors', function (Blueprint $table) {
            $table->dropUnique(['name']);
        });

        Schema::table('whisky_flavours', function (Blueprint $table) {
            $table->dropUnique(['name']);
        });
    }
};
