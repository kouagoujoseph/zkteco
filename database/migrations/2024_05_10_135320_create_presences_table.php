<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('presences', function (Blueprint $table) {
            $table->id();
            $table->datetime('check-in')->nullable();
            $table->datetime('break-in')->nullable();
            $table->datetime('break-out')->nullable();
            $table->datetime('check-out')->nullable();
            $table->string('user_name');
            $table->string('time_by_day')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('presences');
    }
};
