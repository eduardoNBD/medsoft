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
        Schema::create('expenses', function (Blueprint $table) {
            $table->uuid('id')->primary();    
            $table->string('name', 255); 
            $table->text('description')->nullable();  
            $table->text('barcode')->nullable();   
            $table->string('status')->default('1');
            $table->uuid('created_by'); 

            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void{ 
        Schema::dropIfExists('expenses');
    }
};
