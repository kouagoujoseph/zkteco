<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('presence_par_semaines', function (Blueprint $table) {
            $table->id();
            $table->string('user_name');
            $table->Date('date_day');
            $table->String('jour');
            $table->Time('time_by_day');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presence_par_semaines');
    }
};
