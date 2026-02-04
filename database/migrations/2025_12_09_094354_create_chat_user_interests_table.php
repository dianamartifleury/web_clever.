<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chat_user_interests', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->index();
            $table->string('interest');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chat_user_interests');
    }
};
