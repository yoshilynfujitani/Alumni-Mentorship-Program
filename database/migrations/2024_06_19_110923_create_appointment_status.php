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
        Schema::connection('mentor')->create('appointmentstatus', function (Blueprint $table) {
            $table->id();
            $table->string("statusName");
            $table->integer("statusId");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mentor')->dropIfExists('appointmentstatus');
    }
};
