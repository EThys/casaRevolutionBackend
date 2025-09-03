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
        Schema::create('TProperties', function (Blueprint $table) {
            $table->bigIncrements('PropertyId');
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 12, 2);
            $table->integer('surface');
            $table->integer('rooms');
            $table->integer('bedrooms');
            $table->integer('kitchen');
            $table->integer('living_room');
            $table->integer('bathroom');
            $table->integer('floor')->nullable();
            $table->string('address');
            $table->string('commune');
            $table->string('city');
            $table->string('postalCode');
            $table->boolean('sold')->default(false);
            $table->enum('transactionType', ['vente', 'location']);
            $table->boolean('isAvailable')->default(true);
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // Clés étrangères
            $table->unsignedBigInteger('PropertyTypeId');
            $table->unsignedBigInteger('UserId');

            // Index pour les recherches
            $table->index(['city', 'transactionType', 'price','commune']);
            $table->index(['isAvailable']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('TProperties');
    }
};
