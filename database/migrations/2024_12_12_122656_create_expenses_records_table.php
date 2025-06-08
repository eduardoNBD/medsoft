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
        Schema::create('expenses_records', function (Blueprint $table) {
            $table->uuid('id')->primary();  
            $table->uuid('medical_unit_id')->nullable();
            $table->json('items'); 
            $table->text('notes')->nullable();  
            $table->date('date');
            $table->string('payment_method')->nullable();  
            $table->string('status')->default('1');
            $table->uuid('created_by');   
            $table->timestamps();   
            

            $table->foreign('medical_unit_id')->references('id')->on('medical_units')->onDelete('cascade')->onUpdate('cascade'); 
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses_records');
    }
};
