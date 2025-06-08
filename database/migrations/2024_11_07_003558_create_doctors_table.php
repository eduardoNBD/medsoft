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
        Schema::create('doctors', function (Blueprint $table) {
            $table->uuid('id')->primary(); 
            $table->uuid('user_id');    
            $table->json('medical_units')->nullable();
            $table->text('channel_id')->nullable();
            $table->text('google_access_token')->nullable();
            $table->text('google_refresh_token')->nullable();
            $table->timestamp('google_token_expiry')->nullable();
            $table->string('title', 255)->nullable();   
            $table->json('specialty_ids')->nullable();
            $table->string('license', 255)->nullable();      
            $table->string('timeslot', 100)->nullable();  
            $table->string('status')->default('1');
            $table->decimal('commission_amount', 11, 2)->nullable();   
            $table->boolean('monday')->default(false);  
            $table->string('monday_end_time')->default("");  
            $table->string('monday_start_time')->default("");  
            $table->boolean('tuesday')->default(false);  
            $table->string('tuesday_end_time')->default("");  
            $table->string('tuesday_start_time')->default("");  
            $table->boolean('wednesday')->default(false);  
            $table->string('wednesday_end_time')->default("");  
            $table->string('wednesday_start_time')->default("");  
            $table->boolean('thursday')->default(false);  
            $table->string('thursday_end_time')->default("");  
            $table->string('thursday_start_time')->default("");  
            $table->boolean('friday')->default(false);  
            $table->string('friday_end_time')->default("");  
            $table->string('friday_start_time')->default("");  
            $table->boolean('saturday')->default(false);  
            $table->string('saturday_end_time')->default("");  
            $table->string('saturday_start_time')->default("");  
            $table->boolean('sunday')->default(false);  
            $table->string('sunday_end_time')->default("");  
            $table->string('sunday_start_time')->default("");  
            $table->boolean('offer_discount')->default(false);  
            $table->boolean('google_credentials_remember')->default(false);  

            $table->timestamps();
           
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void{
        Schema::dropIfExists('doctors');
    }
};



    
