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
        Schema::connection('admin')->create('conversations', function (Blueprint $table) {
            $table->id();
            $table->integer('userId');
            $table->integer('apppointmentId');
            $table->string('chats');
            
            
        
  
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
        Schema::connection('admin')->dropIfExists('conversations');
    
    }
};
