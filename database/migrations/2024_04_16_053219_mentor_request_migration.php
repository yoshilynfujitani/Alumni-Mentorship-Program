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
        //
        Schema::connection('admin')->create('mentorrequest', function (Blueprint $table) {
            $table->id();
            $table->string('userId');
            $table->string('email');
            $table->integer("verified")->default(0);
          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::connection('admin')->dropIfExists('mentorrequest');
    }
};
