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
        Schema::create('pdf_templates', function (Blueprint $table) {
            $table->uuid('id')->primary(); 
            $table->uuid('doctor_id');
            $table->string('name');  
            $table->string('module');  
            $table->longText('header'); 
            $table->longText('body'); 
            $table->longText('footer'); 
            $table->timestamps();

            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pdf_templates');
    }
};
