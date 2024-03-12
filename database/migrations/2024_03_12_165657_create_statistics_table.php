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
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ad_id');
            $table->index('ad_id');
            $table->bigInteger('impressions');
            $table->bigInteger('clicks');
            $table->bigInteger('unique_clicks');
            $table->bigInteger('leads');
            $table->bigInteger('conversion');
            $table->bigInteger('roi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistics');
    }
};
