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
        Schema::create('TCommissionnaires', function (Blueprint $table) {
            $table->id("CommissionnaireId");
            $table->unsignedBigInteger('UserId');
            $table->unsignedBigInteger('TypeCardId');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('fullname')->unique();
            $table->string('phone')->nullable()->unique();
            $table->string('email')->nullable()->unique();
            $table->string('number_card')->nullable()->unique();
            $table->string('card_front')->nullable();
            $table->string('card_back')->nullable();
            $table->string('address')->nullable();
            $table->string('images')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('TCommissionnaires');
    }
};
