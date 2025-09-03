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
        Schema::table('TProperties', function (Blueprint $table) {
            $table->string('district')->nullable()->after('address');
            $table->string('quartier')->nullable()->after('commune');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('TProperties', function (Blueprint $table) {
            $table->dropColumn(['district', 'quartier']);
        });
    }
};
