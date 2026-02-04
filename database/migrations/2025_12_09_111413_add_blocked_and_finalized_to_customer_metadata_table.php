<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBlockedAndFinalizedToCustomerMetadataTable extends Migration
{
    public function up()
    {
        Schema::table('customer_metadata', function (Blueprint $table) {
            if (! Schema::hasColumn('customer_metadata', 'blocked')) {
                $table->boolean('blocked')->default(false)->after('bot_score');
            }
            if (! Schema::hasColumn('customer_metadata', 'finalized')) {
                $table->boolean('finalized')->default(false)->after('blocked');
            }
            // opcional:
            if (! Schema::hasColumn('customer_metadata', 'captcha_fail_count')) {
                $table->integer('captcha_fail_count')->default(0)->after('finalized');
            }
        });
    }

    public function down()
    {
        Schema::table('customer_metadata', function (Blueprint $table) {
            if (Schema::hasColumn('customer_metadata', 'captcha_fail_count')) {
                $table->dropColumn('captcha_fail_count');
            }
            if (Schema::hasColumn('customer_metadata', 'finalized')) {
                $table->dropColumn('finalized');
            }
            if (Schema::hasColumn('customer_metadata', 'blocked')) {
                $table->dropColumn('blocked');
            }
        });
    }
}
