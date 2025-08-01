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
        Schema::create('TPropertyVisits', function (Blueprint $table) {
            $table->bigIncrements('PropertyVisitId');
            $table->unsignedBigInteger('PropertyId');
            $table->unsignedBigInteger('UserId')->nullable();
            $table->string('name');
            $table->string('secondName')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->text('message')->nullable();
            $table->string('address')->nullable();
            $table->date('visitDate');
            $table->time('visitHour');
            $table->string('ipAddress');
            $table->string('cancellation_reason')->nullable();
            $table->enum('status', ['pending', 'validated', 'cancelled'])->default('pending');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('TPropertyVisits');
    }
};
