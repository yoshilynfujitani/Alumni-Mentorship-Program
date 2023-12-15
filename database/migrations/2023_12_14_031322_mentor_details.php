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
        Schema::connection('mentor')->create('mentorDetails', function (Blueprint $table) {
            $table->id("mentorId");

            $table->string('name');
            $table->string('email');
            $table->boolean('verified')->default(0);
            $table->string('field');
            $table->string('password');
            $table->integer('role')->default(1);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('personal_access_tokens');
    }
};
