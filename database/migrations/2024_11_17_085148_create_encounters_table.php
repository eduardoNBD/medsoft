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
        Schema::create('encounters', function (Blueprint $table) {
            $table->uuid('id')->primary();  
            $table->uuid('appointment_id')->nullable();  
            $table->uuid('patient_id')->nullable();
            $table->uuid('doctor_id')->nullable();
            $table->uuid('medical_unit_id')->nullable();
            $table->datetime('date');  
            $table->text('notes')->nullable(); 
            $table->string('status')->default('1');   
            $table->decimal('subtotal', 8, 2)->default(0.00);  
            $table->decimal('discount', 8, 2)->default(0.00);  
            $table->decimal('total', 8, 2)->default(0.00);  
            $table->decimal('commission_amount', 11, 2)->nullable();  
            $table->text('subject');
            $table->json('items');
            $table->json('files');
            $table->text('diagnosis');
            $table->text('treatment');
            $table->string('payment_status')->default('1');  
            $table->string('report_status')->default('0');  
            $table->string('payment_method')->nullable();  
            $table->boolean('addictions')->default(false);   
            $table->text('addictions_text')->nullable();  
            $table->boolean('allergies')->default(false);  
            $table->text('allergies_text')->nullable();   
            $table->boolean('surgeries')->default(false);   
            $table->text('surgeries_text')->nullable();  
            $table->boolean('medications')->default(false);  
            $table->text('medications_text')->nullable();
            $table->date('patient_dob')->nullable(); 
            $table->enum('patient_gender', ['male', 'female', 'other']);
            $table->string('patient_first_name');
            $table->string('patient_last_name'); 
            $table->string('patient_email');
            $table->string('patient_phone')->nullable(); 
            $table->string('patient_language', length: 5);
            $table->string('patient_blood_type', 4)->nullable();  
            $table->text('cancellation_reason')->nullable();
            $table->uuid('created_by'); 

            $table->timestamps();
            
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('set null');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->foreign('medical_unit_id')->references('id')->on('medical_units')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encounters');
    }
};
