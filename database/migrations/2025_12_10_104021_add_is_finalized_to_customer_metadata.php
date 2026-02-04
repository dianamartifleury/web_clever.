<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsFinalizedToCustomerMetadata extends Migration
{
    public function up()
    {
        Schema::table('customer_metadata', function (Blueprint $table) {
            $table->boolean('is_finalized')->default(false)->after('blocked');
        });
    }

    public function down()
    {
        Schema::table('customer_metadata', function (Blueprint $table) {
            $table->dropColumn('is_finalized');
        });
    }
}
