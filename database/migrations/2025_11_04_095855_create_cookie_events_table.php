<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCookieEventsTable extends Migration
{
    public function up(): void
    {
        Schema::create('cookie_events', function (Blueprint $table) {
            $table->id();
            $table->string('event_type')->nullable();
            $table->json('data')->nullable(); // o ->text('data') si tu base de datos no soporta JSON
            $table->string('ip', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cookie_events');
    }
}
