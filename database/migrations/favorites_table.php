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
        Schema::create('TPropertyFavorites', function (Blueprint $table) {
            $table->bigIncrements('PropertyFavoriteId');
            $table->unsignedBigInteger('UserId');
            $table->unsignedBigInteger('PropertyId');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('TPropertyFavorites');
    }
};
