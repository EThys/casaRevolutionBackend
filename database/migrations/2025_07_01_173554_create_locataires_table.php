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
        Schema::create('TLocataires', function (Blueprint $table) {
            $table->id("LocataireId");
            $table->unsignedBigInteger('UserId');
            $table->unsignedBigInteger('TypeCardId');
            $table->unsignedBigInteger('TypeAccountId');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('number_card')->nullable();
            $table->string('address')->nullable();
            $table->string('images')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('password')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('TLocataires');
    }
};
