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
        Schema::create('items', function (Blueprint $table) {
            $table->uuid('id')->primary();  
            $table->uuid('medical_unit_id');
            $table->uuid('cat_id');
            $table->uuid('area_id', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('Unit', 255)->nullable();
            $table->string('name', 255); 
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('cost', 10, 2)->nullable();  
            $table->enum('type', ['supply', 'service']);   
            $table->text('description')->nullable();  
            $table->text('barcode')->nullable();  
            $table->decimal('commission_amount', 11, 2)->nullable();  
            $table->string('status')->default('1');
            $table->uuid('created_by'); 

            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade'); 
            $table->foreign('area_id')->references('id')->on('area_categories')->onDelete('cascade')->onUpdate('cascade'); 
            $table->foreign('medical_unit_id')->references('id')->on('medical_units')->onDelete('cascade')->onUpdate('cascade'); 
            $table->foreign('cat_id')->references('id')->on('item_categories')->onDelete('cascade')->onUpdate('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void{ 
        Schema::dropIfExists('items');
    }
};
