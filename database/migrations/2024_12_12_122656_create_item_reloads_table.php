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
        Schema::create('item_reloads', function (Blueprint $table) {
            $table->uuid('id')->primary(); 
            $table->uuid('item_id');  
            $table->integer('quantity');  
            $table->integer('remaining');   
            $table->decimal('price', 10, 2);   
            $table->decimal('cost', 10, 2);   
            $table->string('expiration',15)->nullable();
            $table->uuid('created_by');   
            $table->string('status')->default('1');
            $table->timestamps();   
         
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');  // Relación con items
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');  // Relación con usuarios
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_reloads');
    }
};
