<section class="bg_secondary pt-5 pb-5 w-full rounded-lg col-span-6 md:col-span-2 relative"> 
    @foreach ([
        [
            'title' => 'Información General',
            'bg' => 'dark:bg-blue-600 bg-blue-800',
            'text' => 'text-white',
            'details' => [
                'Número de Expediente' => $patient->medical_histories->file_number,
                'Estado Civil' => $patient->medical_histories->marital_status ? __("messages.".$patient->medical_histories->marital_status) : null,
                'Ocupación' => $patient->medical_histories->occupation,
                'Religión' => $patient->medical_histories->religion,
                'Ocupación del Cónyuge' => $patient->medical_histories->spouse_occupation,
            ],
        ],
        [
            'title' => 'Antecedentes Familiares y No Patológicos',
            'bg' => 'dark:bg-slate-600 bg-slate-800',
            'text' => 'text-white',
            'details' => [
                'Antecedentes Familiares Oncológicos' => $patient->medical_histories->family_cancer_history,
                'Antecedentes Personales No Patológicos' => $patient->medical_histories->non_pathological_history,
                'Tabaquismo' => $patient->medical_histories->smoking ? __("messages.yes") : null,
                'Tabaquismo Pasivo' => $patient->medical_histories->passive_smoking ? __("messages.yes") : null,
                'Detalles del Hábito de Fumar' => $patient->medical_histories->smoking_details,
                'Consumo de Alcohol' => $patient->medical_histories->alcohol_usage ? __("messages.yes") : null,
                'Detalles del Consumo de Alcohol' => $patient->medical_histories->alcohol_details,
                'Uso de Drogas' => $patient->medical_histories->drug_usage ? __("messages.yes") : null,
                'Última vez de Consumo de Drogas' => $patient->medical_histories->last_drug_usage ? date("d/m/Y",strtotime($patient->medical_histories->last_drug_usage )) : null,
                'Otros Antecedentes No Patológicos' => $patient->medical_histories->other_non_pathological_history,
            ],
        ],
        [
            'title' => 'Antecedentes Patológicos y Observaciones',
            'bg' => 'dark:bg-red-600 bg-red-800',
            'text' => 'text-white',
            'details' => [
                'Antecedentes Patológicos' => $patient->medical_histories->pathological_history,
                'Pruebas de VIH' => $patient->medical_histories->has_vih_test ? __("messages.yes") : null,
                'Fecha Última Prueba de VIH' => $patient->medical_histories->vih_last_test_date ? date("d/m/Y",strtotime($patient->medical_histories->vih_last_test_date )) : null,
                'Resultado de VIH' => $patient->medical_histories->vih_result,
                'Alergias' => $patient->medical_histories->has_allergies ? __("messages.yes") : null,
                'Detalles de Alergias' => $patient->medical_histories->allergies_details,
                'Cirugías' => $patient->medical_histories->has_surgeries ? __("messages.yes") : null,
                'Detalles de Cirugías' => $patient->medical_histories->surgery_details,
                'Transfusiones' => $patient->medical_histories->has_blood_transfusion ? __("messages.yes") : null,
                'Incontinencia Urinaria' => $patient->medical_histories->urinary_incontinence ? __("messages.yes") : null,
                'Detalles de Incontinencia' => $patient->medical_histories->urinary_incontinence_details,
                'Incontinencia Urinaria Tratamiento' => $patient->medical_histories->urinary_incontinence_treatement ? __("messages.yes") : null,
                'Detalles de Tratamiento de Incontinencia' => $patient->medical_histories->urinary_incontinence_treatement_detail,
                'Notas' => $patient->medical_histories->notes ?? 'No hay notas adicionales.',
            ],
        ],
        [
            'title' => 'Detalles Físicos',
            'bg' => 'dark:bg-green-600 bg-green-800',
            'text' => 'text-white',
            'details' => [
                'Peso' => $patient->medical_histories->weight ? $patient->medical_histories->weight . ' kg' : null,
                'Altura' => $patient->medical_histories->height ? $patient->medical_histories->height . ' cm' : null,
            ],
        ],
        [
            'title' => 'Vida sexual',
            'bg' => 'dark:bg-yellow-600 bg-yellow-800',
            'text' => 'text-white',
            'details' => [
                '¿Ha tenido relaciones sexuales?' => $patient->medical_histories->has_had_sex ? "Sí" : null,
                'Edad de incio de actividad sexual' => $patient->medical_histories->sexual_start_age,
                'Numero de parejas sexuales' => $patient->medical_histories->sexual_partners_count,
                '¿Tienes pareja estable?' => $patient->medical_histories->has_stable_partner ? "Sí" : null,
                '¿Usas condon?' => $patient->medical_histories->condom_usage ? "Sí" : null,
                'Fecha de ultima relación sexual con pareja' => $patient->medical_histories->last_sex_with_partner ? date("d/m/Y",strtotime($patient->medical_histories->last_sex_with_partner )) : null,
                'Fecha de ultima relación sexual con otra persona' => $patient->medical_histories->last_sex_with_other ? date("d/m/Y",strtotime($patient->medical_histories->last_sex_with_other )) : null,
            ],
        ],
        [
            'title' => 'Historia Ginecológica',
            'bg' => 'dark:bg-rose-800 bg-rose-950',
            'text' => 'text-white',
            'details' => [
                'Antecedentes Ginecológicos' => $patient->medical_histories->gynecological_history,
                'Última menstruación' => $patient->medical_histories->last_menstrual ? date("d/m/Y",strtotime($patient->medical_histories->last_menstrual )) : null,
                'Menarquia' => $patient->medical_histories->menarche,
                'Ritmo menstrual' => $patient->medical_histories->menstrual_rhythm,
                'Pruritos' => $patient->medical_histories->pruritus ? __("messages.yes") : null,
                'Detalles de pruritos' => $patient->medical_histories->pruritus_detail,
                'Leucorrea' => $patient->medical_histories->leukorrhea ? __("messages.yes") : null,
                'Detalles de leucorrea' => $patient->medical_histories->leukorrhea_detail,
                'Metrorragia' => $patient->medical_histories->metrorrhagia ? __("messages.yes") : null,
                'Detalles de metrorragia' => $patient->medical_histories->metrorrhagia_detail,
                '¿Siente dolor al realizar actividad sexual?' => $patient->medical_histories->sexual_pain ? __("messages.yes") : null, 
                '¿Siente molestia durante el coito?' => $patient->medical_histories->sexual_discomfort ? __("messages.yes") : null,
                'Frecuencia del dolor' => $patient->medical_histories->sexual_pain_frequency,
                'Gestaciones' => $patient->medical_histories->gestation,
                'Partos' => $patient->medical_histories->birth,
                'Abortos' => $patient->medical_histories->abortion,
                'Cesáreas' => $patient->medical_histories->cesarean,
            ],
            'condition' => $patient->user->gender === 'female',
        ],
    ] as $card)
        @if (!isset($card['condition']) || $card['condition'])
            <div class="mb-4 border rounded-lg overflow-hidden shadow-sm">
                <div class="p-3 {{ $card['bg'] }} {{ $card['text'] }} font-semibold">
                    {{ $card['title'] }}
                </div>
                <div class="p-4 bg_modal paragraph_text grid grid-cols-2">
                    @foreach ($card['details'] as $label => $value)
                        @if ($value) 
                            <div class="flex flex-col items-stretch h-full col-span-2 md:col-span-1">
                                <p class="mb-2 flex-1 flex flex-col px-2">
                                    <strong>{{ $label }}:</strong>
                                    <small class="px-2">{{ $value }}</small>
                                </p>
                                <hr class="my-2 mx-1">
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach
</section>
