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
        Schema::connection('mentor')->create('mentor_schedule', function (Blueprint $table) {
            $table->id();
            $table->integer("mentor_id");
            $table->integer("daysOfTheWeek");
            $table->string("start");
            $table->string("end");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mentor_schedule');
    }
};
