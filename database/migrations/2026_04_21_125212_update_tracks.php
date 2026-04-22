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
        Schema::table('tracks', function (Blueprint $table) {
            $table->string('track_number')->nullable()->after('file');
            $table->string('artist')->nullable()->after('title');
            $table->string('album')->nullable()->after('artist');
            $table->string('genre')->nullable()->after('album');
            $table->string('year')->nullable()->after('genre');
            $table->text('comment')->nullable()->after('year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tracks', function (Blueprint $table) {
            $table->dropColumn('track_number');
            $table->dropColumn('artist');
            $table->dropColumn('album');
            $table->dropColumn('genre');
            $table->dropColumn('year');
            $table->dropColumn('comment');
        });
    }
};
