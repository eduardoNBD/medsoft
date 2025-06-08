<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->uuid('id')->primary(); 
            $table->uuid('patient_id');
            $table->uuid('doctor_id');
            $table->uuid('medical_unit_id');
            $table->text('event_id')->nullable();
            $table->dateTime('date');
            $table->dateTime('end_date');   
            $table->string('status')->default('1');   
            $table->string('payment_status')->default('1');  
            $table->string('report_status')->default('0');  
            $table->string('payment_type')->nullable();  
            $table->decimal('discount', 8, 2)->default(0);  
            $table->decimal('commission_amount', 11, 2)->nullable();  
            $table->text('subject');
            $table->text('cancellation_reason')->nullable();
            $table->text('reschedule_reason')->nullable(); 
            $table->boolean('usePatient')->default(false); 
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
            $table->decimal('subtotal', 8, 2)->default(0);
            $table->unsignedTinyInteger('origin');
            $table->uuid('created_by'); 
 
            $table->timestamps();    
            
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade'); 
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade'); 
            $table->foreign('medical_unit_id')->references('id')->on('medical_units')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}