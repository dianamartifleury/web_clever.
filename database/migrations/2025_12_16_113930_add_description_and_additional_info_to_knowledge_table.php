<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('knowledge', function (Blueprint $table) {
            $table->text('description')->nullable()->after('title');
            $table->text('additional_info')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('knowledge', function (Blueprint $table) {
            $table->dropColumn(['description', 'additional_info']);
        });
    }
};
