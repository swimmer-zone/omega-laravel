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
        Schema::table('whisky_tastings', function (Blueprint $table) {
            $table->foreignId('whisky_region_id')->nullable()->change();
            $table->foreignId('whisky_type_id')->nullable()->change();
            $table->foreignId('whisky_cask_type_id')->nullable()->change();
            $table->foreignId('whisky_distillery_id')->nullable()->change();

            $table->foreignId('whisky_flavour_id')->constrained()->cascadeOnDelete()->after('location');
            $table->foreignId('whisky_finish_id')->constrained()->cascadeOnDelete()->after('whisky_flavour_id');

            $table->dropColumn('finish');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('whisky_tastings', function (Blueprint $table) {
            $table->foreignId('whisky_region_id')->nullable(false)->change();
            $table->foreignId('whisky_type_id')->nullable(false)->change();
            $table->foreignId('whisky_cask_type_id')->nullable(false)->change();
            $table->foreignId('whisky_distillery_id')->nullable(false)->change();

            $table->dropColumn('whisky_flavour_id');
            $table->dropColumn('whisky_finish_id');

            $table->text('finish')->after('location');
        });
    }
};
