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
        Schema::create('certificate_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('patient_id'); 
            $table->uuid('doctor_id'); 
            $table->text('notes')->nullable();
            $table->text('type');
            $table->string('status')->default('1');
            $table->text('rejection_reason')->nullable();
            $table->uuid('certificate_id')->nullable();
            $table->timestamps();
 
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade'); 
            $table->foreign('certificate_id')->references('id')->on('certificates')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_requests');
    }
};
