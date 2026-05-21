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
            $table->unsignedInteger('completed_plays')->default(0);
            $table->unsignedBigInteger('total_listen_seconds')->default(0);
            $table->timestamp('last_played_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tracks', function (Blueprint $table) {
            $table->dropColumn('completed_plays');
            $table->dropColumn('total_listen_seconds');
            $table->dropColumn('last_played_at');
        });
    }
};
