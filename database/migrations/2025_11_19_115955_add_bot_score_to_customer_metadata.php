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
        Schema::table('customer_metadata', function (Blueprint $table) {

            // Añadir campo bot_score (si no existe ya)
            if (!Schema::hasColumn('customer_metadata', 'bot_score')) {
                $table->integer('bot_score')->default(0)->after('suspected_bot');
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_metadata', function (Blueprint $table) {

            // Eliminar el campo en rollback
            if (Schema::hasColumn('customer_metadata', 'bot_score')) {
                $table->dropColumn('bot_score');
            }

        });
    }
};
