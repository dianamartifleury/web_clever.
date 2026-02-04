<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {

            // Campos auxiliares para búsqueda (NO cifrados)
            if (!Schema::hasColumn('customers', 'first_name_search')) {
                $table->string('first_name_search')->nullable()->index();
            }

            if (!Schema::hasColumn('customers', 'last_name_search')) {
                $table->string('last_name_search')->nullable()->index();
            }

            if (!Schema::hasColumn('customers', 'email_search')) {
                $table->string('email_search')->nullable()->index();
            }

            if (!Schema::hasColumn('customers', 'phone_search')) {
                $table->string('phone_search')->nullable()->index();
            }
        });
    }

    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn([
                'first_name_search',
                'last_name_search',
                'email_search',
                'phone_search'
            ]);
        });
    }
};
