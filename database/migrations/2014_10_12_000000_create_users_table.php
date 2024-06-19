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
        Schema::connection('admin')->create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->integer("verified")->default(0);
            $table->string('password');
            $table->integer('course')->nullable();
            $table->string('field')->nullable();
            $table->integer('role');
            $table->integer('first_login')->default(1);
            $table->integer('code')->nullable();
            $table->integer('rating')->default(0);
            $table->integer('ticketStatus')->nullable();
            $table->integer('fieldToTake')->nullable();
            $table->integer('allowToAppoint')->default(0);
            $table->timestamps('last_active_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
