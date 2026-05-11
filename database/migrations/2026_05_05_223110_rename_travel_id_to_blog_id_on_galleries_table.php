<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropForeign(['travel_id']);
            $table->renameColumn('travel_id', 'blog_id');
            $table->foreign('blog_id')->references('id')->on('blogs')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropForeign(['blog_id']);
            $table->renameColumn('blog_id', 'travel_id');
            $table->foreign('travel_id')->references('id')->on('travels')->cascadeOnDelete();
        });
    }
};
