<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultationPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultation_prices', function (Blueprint $table) {
            $table->uuid('id')->primary(); 
            $table->uuid('medical_unit_id'); 
            $table->string('consultation_type');  
            $table->decimal('price', 8, 2); 
            $table->tinyInteger('status')->default(1);  
            $table->timestamps(); 
 
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
        Schema::dropIfExists('consultation_prices');
    }
}

