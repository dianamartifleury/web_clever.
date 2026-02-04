<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {

            // Campos personales que ahora estarán cifrados → LONGTEXT obligatorio
            $table->longText('first_name')->nullable()->change();
            $table->longText('last_name')->nullable()->change();
            $table->longText('country')->nullable()->change();
            $table->longText('city')->nullable()->change();
            $table->longText('phone')->nullable()->change();
            $table->longText('company')->nullable()->change();
            $table->longText('email')->nullable()->change();
            $table->longText('notes')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {

            // Revertir a TEXT como fallback
            $table->text('first_name')->nullable()->change();
            $table->text('last_name')->nullable()->change();
            $table->text('country')->nullable()->change();
            $table->text('city')->nullable()->change();
            $table->text('phone')->nullable()->change();
            $table->text('company')->nullable()->change();
            $table->text('email')->nullable()->change();
            $table->text('notes')->nullable()->change();
        });
    }
};