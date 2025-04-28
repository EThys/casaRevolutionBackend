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
        Schema::create('TpropertyFeature', function (Blueprint $table) {
            $table->unsignedBigInteger('PropertyId');
            $table->unsignedBigInteger('PropertyFeatureId');

            $table->foreign('PropertyId')
                  ->references('PropertyId')
                  ->on('TProperties')
                  ->onDelete('cascade');

            $table->foreign('PropertyFeatureId')
                  ->references('PropertyFeatureId')
                  ->on('TPropertyFeatures')
                  ->onDelete('cascade');

            $table->primary(['PropertyId', 'PropertyFeatureId']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('TpropertyFeature');

    }
};
