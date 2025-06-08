<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_units', function (Blueprint $table) {
            $table->uuid('id')->primary(); 
            $table->string('name');  
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('zipcode');
            $table->tinyInteger('status')->default(1); 
            $table->string('logo')->nullable();  
            $table->string('phone', 15)->nullable();  
            $table->string('email')->nullable(); 
            $table->uuid('created_by'); 

            $table->timestamps(); 

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('expenses_records')) { 
            if (Schema::hasColumn('expenses_records', 'medical_unit_id')) {
                Schema::table('expenses_records', function (Blueprint $table) {
                    $table->dropForeign('expenses_records_medical_unit_id_foreign');
                    $table->dropColumn('medical_unit_id');
                });
            }
        
            // Si la clave foránea existe, elimínala
            if (Schema::hasColumn('expenses_records', 'medical_unit_id')) {
                Schema::table('expenses_records', function (Blueprint $table) {
                    $table->dropForeign('expenses_records_medical_unit_id_foreign');
                });
            }
        }

        Schema::dropIfExists('medical_units');
    }
}

