<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medical_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('patient_id');
            $table->string('file_number')->unique();
            $table->string('marital_status')->nullable(); // Estado Civil
            $table->string('occupation')->nullable(); // Ocupación
            //$table->string('origin')->nullable(); // Originaria
            //$table->string('resident')->nullable(); // Residente
            $table->string('religion')->nullable(); // Religión
            $table->string('spouse_occupation')->nullable(); // Ocupación del Cónyuge
            $table->text('family_cancer_history')->nullable(); // Antecedentes Familiares Oncológicos
            $table->text('non_pathological_history')->nullable(); // Antecedentes personales no patológicos
            $table->boolean('smoking')->default(false); // Tabaquismo
            $table->boolean('passive_smoking')->default(false); // Tabaquismo pasivo
            $table->text('smoking_details')->nullable(); // Detalles del hábito de fumar
            $table->boolean('alcohol_usage')->default(false); // Consumo de alcohol
            $table->text('alcohol_details')->nullable(); // Frecuencia de consumo 
            $table->boolean('drug_usage')->default(false); // ¿Ha consumido drogas?
            $table->text('drug_details')->nullable(); // Detalles sobre drogas
            $table->string('last_drug_usage')->nullable(); // Última vez de consumo de drogas
            $table->float('weight')->nullable(); // Peso 
            $table->float('height')->nullable(); // Altura 
            $table->text('other_non_pathological_history')->nullable(); // Otros
            $table->text('pathological_history')->nullable(); // Antecedentes personales patológicos 
            $table->text('gynecological_history')->nullable(); // Antecedentes Ginecológicos 
            $table->boolean('urinary_incontinence')->default(false); // Incontinencia Urinaria
            $table->boolean('urinary_incontinence_treatement')->default(false); // Incontinencia Urinaria
            $table->text('urinary_incontinence_details')->nullable(); // Detalles de incontinencia
            $table->text('urinary_incontinence_treatement_detail')->nullable(); // Incontinencia Urinaria
            $table->string('patient_signature')->nullable(); // Firma de la paciente 
            $table->boolean('has_insurance')->default(false); // ¿Tiene seguro médico?
            $table->text('insurance_name')->nullable(); // ¿Tiene seguro médico?
            $table->text('insurance_id')->nullable(); // ¿Tiene seguro médico? 
            $table->boolean('has_stable_partner')->default(false); // ¿Tiene pareja estable?
            $table->boolean('has_had_sex')->default(false); // ¿Ha tenido relaciones sexuales?
            $table->string('last_sex_with_partner')->nullable(); // Última relación con pareja
            $table->string('last_sex_with_other')->nullable(); // Última relación con otra pareja 
            $table->integer('sexual_start_age')->nullable(); // Inicio de vida sexual
            $table->integer('sexual_partners_count')->nullable(); // Número de parejas sexuales 
            $table->text('condom_usage')->nullable(); // Uso de condón 
            $table->boolean('has_family_diseases')->default(false); // ¿Antecedentes familiares?
            $table->text('family_diseases_details')->nullable(); // Detalles de enfermedades familiares
            $table->boolean('has_vih_test')->default(false); // ¿Prueba de VIH?
            $table->date('vih_last_test_date')->nullable(); // Fecha último examen VIH
            $table->string('vih_result')->nullable(); // Resultado de examen VIH
            $table->boolean('has_allergies')->default(false); // ¿Tiene alergias?
            $table->text('allergies_details')->nullable(); // Detalles de alergias
            $table->boolean('has_surgeries')->default(false); // ¿Ha tenido cirugías?
            $table->text('surgery_details')->nullable(); // Detalles de cirugías
            $table->boolean('has_blood_transfusion')->default(false); // ¿Transfusiones?  
            $table->date('last_blood_transfusion')->nullable(); // Ultima Transfusiones  
            $table->boolean('sexual_pain')->nullable();  
            $table->text('sexual_pain_frequency')->nullable(); // Frecuencia de dolor
            $table->boolean('sexual_discomfort')->default(false); // Molestia al coito 
            $table->boolean('sexual_sensibility')->default(false); // sensibilidad en el coito 
            $table->boolean('sexual_dryness')->default(false); // Resequedad en el  coito 
            $table->boolean('metrorrhagia')->default(false); // Metrorragia
            $table->text('metrorrhagia_detail')->nullable(); // Metrorragia
            $table->text('menarche')->nullable();
            $table->boolean('leukorrhea')->default(false); // Leucorrea
            $table->text('leukorrhea_detail')->nullable(); // Leucorrea
            $table->boolean('pruritus')->default(false); // Prurito
            $table->text('pruritus_detail')->nullable();// Prurito 
            $table->string('menstrual_rhythm')->nullable(); 
            $table->string('last_menstrual')->nullable(); 
            $table->integer('gestation')->default(0); 
            $table->integer('birth')->default(0); 
            $table->integer('abortion')->default(0); 
            $table->integer('cesarean')->default(0); 
            $table->text('notes')->nullable();  
            $table->timestamps();

            //pending
            $table->boolean('hyperpigmentation_genital')->default(false);
            $table->text('hyperpigmentation_genital_detail')->nullable();
            $table->text('face_detail')->nullable();
            $table->text('wrinkles_detail')->nullable();
            $table->text('face_parameters')->nullable(); // Parámetros de cara
            $table->text('scar_parameters')->nullable(); // Parámetros de cicatriz
            $table->text('stretch_marks_parameters')->nullable(); // Parámetros de estrías
            $table->text('nail_parameters')->nullable(); // Parámetros de uña 
             

            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_histories');
    }
}
