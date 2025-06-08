<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->longText('content'); 
            $table->uuid('patient_id'); 
            $table->uuid('doctor_id');  
            $table->uuid('medical_unit_id');
            $table->uuid('created_by');  
            $table->date('expires_at')->nullable();  
            $table->boolean('is_signed')->default(false); 
            $table->text('notes')->nullable();
            $table->text('title');
            $table->text('type');
            $table->text('cancellation_reason')->nullable();
            $table->string('status')->default('1');
            $table->timestamps();
 
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('certificates');
    }
}
