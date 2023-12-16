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
        Schema::connection('mentor')->create('appointmentDetails', function (Blueprint $table) {
            $table->id("appointmentId");
            $table->string('title');
            $table->string('field');
            $table->boolean('Status')->default(0);
            $table->string("mentorId");
            $table->string("studentId");
            $table->datetime('startSchedule');
        
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
        Schema::dropIfExists('appointmentDetails');
    }
};
