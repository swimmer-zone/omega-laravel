<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('travels', 'blogs');

        Schema::table('blogs', function (Blueprint $table) {
            $table->string('blog_type')->default('travel')->after('slug');
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('blog_type');
        });

        Schema::rename('blogs', 'travels');
    }
};
