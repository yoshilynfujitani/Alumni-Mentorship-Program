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
        Schema::connection('mentor')->create('feedback', function (Blueprint $table) {
            $table->id();
            $table->integer('appointmendId');
            $table->integer('userId');
            $table->integer('userToRateId');
            $table->integer('rating');
            $table->string('comments');
          
            
  
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
        Schema::connection('mentor')->dropIfExists('feedback');
    }
};
