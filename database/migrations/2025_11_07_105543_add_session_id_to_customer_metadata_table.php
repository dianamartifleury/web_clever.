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
            // 🔹 Añadimos identificador de sesión o visitante
            if (!Schema::hasColumn('customer_metadata', 'session_id')) {
                $table->string('session_id', 255)->nullable()->after('id');
            }

            // 🔹 Opcional: si geolocation y digital_trace no son JSON aún, convertirlos
            if (Schema::hasColumn('customer_metadata', 'geolocation')) {
                $table->json('geolocation')->nullable()->change();
            }

            if (Schema::hasColumn('customer_metadata', 'digital_trace')) {
                $table->json('digital_trace')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_metadata', function (Blueprint $table) {
            $table->dropColumn('session_id');
        });
    }
};
