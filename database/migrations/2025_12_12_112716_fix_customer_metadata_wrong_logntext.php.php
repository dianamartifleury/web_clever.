<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Fix wrong LONGTEXT casts in customer_metadata.
     * We revert fields that should NOT be encrypted or large.
     */
    public function up()
    {
        Schema::table('customer_metadata', function (Blueprint $table) {

            // These fields MUST NOT be LONGTEXT – restore to TEXT
            $table->text('digital_trace')->nullable()->change();
            $table->text('geolocation')->nullable()->change();
            $table->text('browser_language')->nullable()->change();
            $table->text('source')->nullable()->change();
        });
    }

    /**
     * Optional rollback (not needed, but included for consistency).
     */
    public function down()
    {
        Schema::table('customer_metadata', function (Blueprint $table) {

            // Restore to LONGTEXT only if someone ever needs it again
            $table->longText('digital_trace')->nullable()->change();
            $table->longText('geolocation')->nullable()->change();
            $table->longText('browser_language')->nullable()->change();
            $table->longText('source')->nullable()->change();
        });
    }
};
