<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1) Drop foreign key
        DB::statement('ALTER TABLE `customer_metadata` DROP FOREIGN KEY `customer_metadata_customer_id_foreign`;');

        // 2) Make column nullable
        DB::statement('ALTER TABLE `customer_metadata` MODIFY `customer_id` BIGINT UNSIGNED NULL;');

        // 3) Re-add foreign key
        DB::statement('ALTER TABLE `customer_metadata` 
            ADD CONSTRAINT `customer_metadata_customer_id_foreign` 
            FOREIGN KEY (`customer_id`) REFERENCES `customers`(`id`) ON DELETE CASCADE;');
    }

    public function down(): void
    {
        // reverse changes: make NOT NULL again (may fail if rows exist with NULL)
        DB::statement('ALTER TABLE `customer_metadata` DROP FOREIGN KEY `customer_metadata_customer_id_foreign`;');
        DB::statement('ALTER TABLE `customer_metadata` MODIFY `customer_id` BIGINT UNSIGNED NOT NULL;');
        DB::statement('ALTER TABLE `customer_metadata` 
            ADD CONSTRAINT `customer_metadata_customer_id_foreign` 
            FOREIGN KEY (`customer_id`) REFERENCES `customers`(`id`) ON DELETE CASCADE;');
    }
};
