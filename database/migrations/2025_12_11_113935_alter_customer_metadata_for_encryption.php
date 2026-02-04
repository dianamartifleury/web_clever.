<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Convert encrypted fields to LONGTEXT to support AES-256 encrypted payloads.
     */
    public function up()
    {
        Schema::table('customer_metadata', function (Blueprint $table) {
            // These fields must be LONGTEXT because encrypted content is much larger
            $table->longText('digital_trace')->nullable()->change();
            $table->longText('geolocation')->nullable()->change();
            $table->longText('browser_language')->nullable()->change();
            $table->longText('source')->nullable()->change();
        });
    }

    /**
     * Revert back to TEXT (safe fallback).
     */
    public function down()
    {
        Schema::table('customer_metadata', function (Blueprint $table) {
            $table->text('digital_trace')->nullable()->change();
            $table->text('geolocation')->nullable()->change();
            $table->text('browser_language')->nullable()->change();
            $table->text('source')->nullable()->change();
        });
    }
};
