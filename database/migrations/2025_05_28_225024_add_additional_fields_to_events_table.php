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
        Schema::table('events', function (Blueprint $table) {
            $table->string('thumbnail')->nullable();
            $table->string('venue_thumbnail')->nullable();
            $table->string('bg_map')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->boolean('is_open')->default(true);
            $table->boolean('has_started')->default(false);
            $table->time('time_at')->nullable();
            $table->dateTime('end_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'thumbnail', 
                'venue_thumbnail', 
                'bg_map',
                'price',
                'is_open',
                'has_started',
                'time_at',
                'end_date',
            ]);
        });
    }
};
