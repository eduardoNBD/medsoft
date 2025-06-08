@extends('layouts.public',[ 'current_route'  => 'profile'])

@section('title', __('routes.profile')) 

@section('content')  
    <section class="pb-20 md:pb-32 pt-60 bg-[url('../img/publicImg/bg_profile.png')] bg-fixed bg-no-repeat bg-cover bg-center  relative">
        <div class="container mx-auto">
            <div class="absolute inset-0 bg-slate-900/60"></div>
            <div class="relative z-10 text-center text-white flex flex-col items-center justify-center px-4">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">
                    {{__("routes.profile")}}
                </h2>
            </div>
        </div>
    </section>
    <section class="py-10 md:py-32 bg-[#fafafa]">
        <div class="md:container mx-auto">
            <div class="grid grid-cols-6 gap-4">
                <div class="col-span-6 md:col-span-2 ">
                    <div class="relative flex flex-col min-w-0 break-words bg-white w-full shadow-lg rounded-lg">
                        <div class="px-6">
                            <div class="flex flex-wrap justify-center">
                                <div class=" px-4 lg:order-2 flex justify-center"> 
                                    <img alt="..." src="{{Auth::user()->image ? asset("/storage/app/").'/'.Auth::user()->image : asset('/resources/img/user.png')}}" class="shadow rounded-full w-20 h-auto align-middle border-none absolute top-[-40px]"> 
                                </div> 
                            </div>
                            <div class="text-center mt-10">
                                <h3 class="text-3xl font-semibold leading-normal text-slate-700">
                                    {{Auth::user()->first_name}} {{Auth::user()->last_name}}
                                </h3>
                                <small class="text-gray-500">{{__("messages.".Auth::user()->gender)}}</small>
                                <div class="text-sm leading-normal mt-0 mb-2 text-slate-400 font-bold uppercase">
                                    <i class="fas fa-map-marker-alt mr-2 text-lg text-slate-400"></i>
                                    {{Auth::user()->patient->address}}, {{Auth::user()->patient->state}} 
                                </div>
                                <div class="flex flex-col sm:flex-row justify-center gap-2 text-slate-700  text-center">
                                    <div class="flex gap-1 items-center  justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mt-[3px]" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path><path d="M16 12v1.5a2.5 2.5 0 0 0 5 0v-1.5a9 9 0 1 0 -5.5 8.28"></path></svg> 
                                        {{Auth::user()->email}}
                                    </div>
                                    <div class="hidden sm:inline text-slate-400">|</div>
                                    <div class="flex gap-1 items-center  justify-center"> 
                                        <svg xmlns="http://www.w3.org/2000/svg"  width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M6 5a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2v-14z"></path><path d="M11 4h2"></path><path d="M12 17v.01"></path></svg> 
                                        {{Auth::user()->phone}}
                                    </div> 
                                </div>
                            </div>
                            <div class="mt-4 border-t">
                                <div class="px-4 pt-4 pb-4"> 
                                    <ul class="hidden md:block tabList"> 
                                        <li class="border-b">
                                            <button  onClick="showTab('#tab-appointments','appointments')" class="appointments mx-1 w-full link_text_active link_background_active text-left px-1.5 py-2 text-sm font-medium transition-all duration-200 rounded-md">{{__("routes.appointments")}}</button>
                                        </li>
                                        <li class="border-b">
                                            <button  onClick="showTab('#tab-profile','profile')" class="profile mx-1 w-full link_text link_background text-left px-1.5 py-2 text-sm font-medium transition-all duration-200 rounded-md">{{__("routes.profile")}}</button>
                                        </li> 
                                        <li class="border-b">
                                            <button  onClick="showTab('#tab-record','record')" class="record mx-1 w-full link_text link_background text-left px-1.5 py-2 text-sm font-medium transition-all duration-200 rounded-md">{{__("messages.record")}}</button>
                                        </li>
                                        <li class="border-b">
                                            <button  onClick="showTab('#tab-user','user')" class="user mx-1 w-full link_text link_background text-left px-1.5 py-2 text-sm font-medium transition-all duration-200 rounded-md">{{__("routes.user")}}</button>
                                        </li>
                                        <li class="border-b">
                                            <button onClick="showTab('#tab-password','password')" class="password mx-1 w-full link_text link_background text-left px-1.5 py-2 text-sm font-medium transition-all duration-200 rounded-md">{{__("messages.password")}}</button>
                                        </li>
                                        <li class="border-b">
                                            <button onClick="showTab('#tab-certificate','certificate')" class="certificate mx-1 w-full link_text link_background text-left px-1.5 py-2 text-sm font-medium transition-all duration-200 rounded-md">{{__("routes.certificates")}}</button>
                                        </li>
                                    </ul>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-6 md:col-span-4">
                    <div class="bg-white w-full mb-6 shadow-lg rounded-lg h-full">
                        <div class="px-6">
                            <ul class="block sm:hidden grid grid-cols-6 tabList">
                                <li class="border-b col-span-3 sm:col-span-2 md:col-span-1">
                                    <button  onClick="showTab('#tab-appointments','appointments')" class="appointments mx-1 w-full link_text_active link_background_active group text-center px-1.5 py-2 text-sm font-medium transition-all duration-200 rounded-tr-md rounded-tl-md" href="">{{__("routes.appointments")}}</button>
                                </li>
                                <li class="border-b col-span-3 sm:col-span-2 md:col-span-1">
                                    <button onClick="showTab('#tab-profile','profile')" class="profile mx-1 w-full link_text link_background group text-center px-1.5 py-2 text-sm font-medium transition-all duration-200 rounded-tr-md rounded-tl-md" href="">{{__("routes.profile")}}</button>
                                </li> 
                                <li class="border-b col-span-3 sm:col-span-2 md:col-span-1">
                                    <button  onClick="showTab('#tab-record','record')" class="record mx-1 w-full link_text link_background group text-center px-1.5 py-2 text-sm font-medium transition-all duration-200 rounded-tr-md rounded-tl-md" href="">{{__("messages.record")}}</button>
                                </li>
                                <li class="border-b col-span-3 sm:col-span-2 md:col-span-1">
                                    <button onClick="showTab('#tab-user','user')" class="user mx-1 w-full link_text link_background group text-center px-1.5 py-2 text-sm font-medium transition-all duration-200 rounded-tr-md rounded-tl-md" href="">{{__("routes.user")}}</button>
                                </li>
                                <li class="border-b col-span-3 sm:col-span-2 md:col-span-1">
                                    <button onClick="showTab('#tab-password','password')" class="password mx-1 w-full link_text link_background group text-center px-1.5 py-2 text-sm font-medium transition-all duration-200 rounded-tr-md rounded-tl-md" href="">{{__("messages.password")}}</button>
                                </li>
                                <li class="border-b col-span-3 sm:col-span-2 md:col-span-1">
                                    <button  onClick="showTab('#tab-certificate','certificate')" class="certificate mx-1 w-full link_text link_background group text-center px-1.5 py-2 text-sm font-medium transition-all duration-200 rounded-tr-md rounded-tl-md" href="">{{__("routes.certificates")}}</button>
                                </li>
                            </ul> 
                            <div id="tabsContent" class="w-full mb-4"> 
                                <div class="hidden p-2 md:p-6 text-medium text-gray-500  rounded-lg w-full tab-item" id="tab-profile">
                                    <form id="formprofile">
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white m-2">{{__("routes.profile")}}</h3>
                                        <hr class="mb-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 mt-4">  
                                            <div class="px-2 col-span-2 md:col-span-1"> 
                                                <div class="relative z-0 mb md:mb-2 group ">
                                                    <div class="relative">
                                                        <div class="absolute inset-y-0 end-0 flex items-center ps-3 pointer-events-none">
                                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                                            </svg>
                                                        </div>
                                                        <input id="dob" name="dob" value="{{Auth::user()->patient->dob ? date("d/m/Y",strtotime(Auth::user()->patient->dob)) : ""}}" autocomplete="off" datepicker datepicker-autohide type="text" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" ">
                                                    </div>
                                                    <label for="dob" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.dob")}}</label>
                                                    <small id="dob_message" class="text_error pl-2 italic"></small>
                                                </div>
                                            </div>  
                                            <div class="px-2 col-span-2 md:col-span-1">
                                                <div class="relative z-0 mb md:mb-2 group">
                                                    <input type="text" name="patient_address" id="patient_address" value="{{Auth::user()->patient->address}}" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                                    <label for="patient_address" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.address")}}</label>
                                                    <small id="patient_address_message" class="text_error pl-2 italic"></small>
                                                </div>
                                            </div> 
                                            <div class="px-2 col-span-2 md:col-span-1">
                                                <div class="relative z-0 mb md:mb-2 group">
                                                    <input type="text" name="patient_city" id="patient_city" value="{{Auth::user()->patient->city}}" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                                    <label for="patient_city" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.city")}}</label>
                                                    <small id="patient_city_message" class="text_error pl-2 italic"></small>
                                                </div>
                                            </div> 
                                            <div class="px-2 col-span-2 md:col-span-1">
                                                <div class="relative z-0 mb md:mb-2 group">
                                                    <input type="text" name="patient_state" id="patient_state" value="{{Auth::user()->patient->state}}" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                                    <label for="patient_state" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.state")}}</label>
                                                    <small id="patient_state_message" class="text_error pl-2 italic"></small>
                                                </div>
                                            </div> 
                                            <div class="px-2 col-span-2 md:col-span-1">
                                                <div class="relative z-0 mb md:mb-2 group">
                                                    <input type="text" name="patient_zipcode" id="patient_zipcode" value="{{Auth::user()->patient->zipcode}}" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                                    <label for="patient_zipcode" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.zipcode")}}</label>
                                                    <small id="patient_zipcode_message" class="text_error pl-2 italic"></small>
                                                </div>
                                            </div> 
                                            <div class="px-2 col-span-2 md:col-span-1">
                                                <div class="relative z-0 mb md:mb-2 group">
                                                    <select name="patient_country" id="patient_country" class="bg-white dark:bg-slate-900 block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                                                        @foreach ($countries as $key => $item)
                                                            <option value="{{$key}}" {{(Auth::user()->patient->country == "" && $key == "MX") || Auth::user()->patient->country == $key ? "selected" : ""}} >{{$item}}</option>
                                                        @endforeach
                                                    </select>
                                                    <label for="patient_country" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.country")}}</label>
                                                    <small id="patient_country_message" class="text_error pl-2 italic"></small>
                                                </div>
                                            </div> 
                                            <div class="px-2 col-span-2 md:col-span-1">
                                                <div class="relative z-0 group mb-2">
                                                    <select name="bloodType" id="bloodType" class="bg-white dark:bg-slate-900 block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                                                        <option value=""></option>
                                                        <option value="A+" {{"A+" == Auth::user()->patient->blood_type ? "selected" : ""}}>A+</option>
                                                        <option value="A-" {{"A-" == Auth::user()->patient->blood_type ? "selected" : ""}}>A-</option>
                                                        <option value="B+" {{"B+" == Auth::user()->patient->blood_type ? "selected" : ""}}>B+</option>
                                                        <option value="B-" {{"B-" == Auth::user()->patient->blood_type ? "selected" : ""}}>B-</option>
                                                        <option value="AB+" {{"AB+" == Auth::user()->patient->blood_type ? "selected" : ""}}>AB+</option>
                                                        <option value="AB-" {{"AB-" == Auth::user()->patient->blood_type ? "selected" : ""}}>AB-</option>
                                                        <option value="O+" {{"O+" == Auth::user()->patient->blood_type ? "selected" : ""}}>O+</option>
                                                        <option value="O-" {{"O-" == Auth::user()->patient->blood_type ? "selected" : ""}}>O-</option>
                                                    </select> 
                                                    <label for="bloodType" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.bloodType")}}</label>
                                                    <small id="bloodType_message" class="text_error pl-2 italic"></small>
                                                </div>
                                            </div>  
                                            <div class="col-span-2 text-center md:text-right">  
                                                <button class="text-white bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-800 dark:hover:bg-emerald-900 rounded-md px-10 py-2">{{__("messages.save")}}</button>
                                            </div> 
                                        </div>
                                    </form>
                                </div>
                                <div class="hidden text-medium text-gray-500  rounded-lg w-full tab-item" id="tab-record">
                                    <section class="bg-secondary-light dark:bg-secondary-dark pt-5 pb-5 w-full rounded-lg col-span-6 md:col-span-2 relative"> 
                                        @foreach ([
                                            [
                                                'title' => 'Información General',
                                                'bg' => 'dark:bg-blue-600 bg-blue-800',
                                                'text' => 'text-white',
                                                'details' => [
                                                    'Número de Expediente' => $medical_histories->file_number,
                                                    'Estado Civil' => $medical_histories->marital_status ? __("messages.".$medical_histories->marital_status) : null,
                                                    'Ocupación' => $medical_histories->occupation,
                                                    'Religión' => $medical_histories->religion,
                                                    'Ocupación del Cónyuge' => $medical_histories->spouse_occupation,
                                                ],
                                            ],
                                            [
                                                'title' => 'Antecedentes Familiares y No Patológicos',
                                                'bg' => 'dark:bg-slate-600 bg-slate-800',
                                                'text' => 'text-white',
                                                'details' => [
                                                    'Antecedentes Familiares Oncológicos' => $medical_histories->family_cancer_history,
                                                    'Antecedentes Personales No Patológicos' => $medical_histories->non_pathological_history,
                                                    'Tabaquismo' => $medical_histories->smoking ? __("messages.yes") : null,
                                                    'Tabaquismo Pasivo' => $medical_histories->passive_smoking ? __("messages.yes") : null,
                                                    'Detalles del Hábito de Fumar' => $medical_histories->smoking_details,
                                                    'Consumo de Alcohol' => $medical_histories->alcohol_usage ? __("messages.yes") : null,
                                                    'Detalles del Consumo de Alcohol' => $medical_histories->alcohol_details,
                                                    'Uso de Drogas' => $medical_histories->drug_usage ? __("messages.yes") : null,
                                                    'Última vez de Consumo de Drogas' => $medical_histories->last_drug_usage ? date("d/m/Y",strtotime($medical_histories->last_drug_usage )) : null,
                                                    'Otros Antecedentes No Patológicos' => $medical_histories->other_non_pathological_history,
                                                ],
                                            ],
                                            [
                                                'title' => 'Antecedentes Patológicos y Observaciones',
                                                'bg' => 'dark:bg-red-600 bg-red-800',
                                                'text' => 'text-white',
                                                'details' => [
                                                    'Antecedentes Patológicos' => $medical_histories->pathological_history,
                                                    'Pruebas de VIH' => $medical_histories->has_vih_test ? __("messages.yes") : null,
                                                    'Fecha Última Prueba de VIH' => $medical_histories->vih_last_test_date ? date("d/m/Y",strtotime($medical_histories->vih_last_test_date )) : null,
                                                    'Resultado de VIH' => $medical_histories->vih_result,
                                                    'Alergias' => $medical_histories->has_allergies ? __("messages.yes") : null,
                                                    'Detalles de Alergias' => $medical_histories->allergies_details,
                                                    'Cirugías' => $medical_histories->has_surgeries ? __("messages.yes") : null,
                                                    'Detalles de Cirugías' => $medical_histories->surgery_details,
                                                    'Transfusiones' => $medical_histories->has_blood_transfusion ? __("messages.yes") : null,
                                                    'Incontinencia Urinaria' => $medical_histories->urinary_incontinence ? __("messages.yes") : null,
                                                    'Detalles de Incontinencia' => $medical_histories->urinary_incontinence_details,
                                                    'Incontinencia Urinaria Tratamiento' => $medical_histories->urinary_incontinence_treatement ? __("messages.yes") : null,
                                                    'Detalles de Tratamiento de Incontinencia' => $medical_histories->urinary_incontinence_treatement_detail,
                                                    'Notas' => $medical_histories->notes ?? 'No hay notas adicionales.',
                                                ],
                                            ],
                                            [
                                                'title' => 'Detalles Físicos',
                                                'bg' => 'dark:bg-green-600 bg-green-800',
                                                'text' => 'text-white',
                                                'details' => [
                                                    'Peso' => $medical_histories->weight ? $medical_histories->weight . ' kg' : null,
                                                    'Altura' => $medical_histories->height ? $medical_histories->height . ' cm' : null,
                                                ],
                                            ],
                                            [
                                                'title' => 'Vida sexual',
                                                'bg' => 'dark:bg-yellow-600 bg-yellow-800',
                                                'text' => 'text-white',
                                                'details' => [
                                                    '¿Ha tenido relaciones sexuales?' => $medical_histories->has_had_sex ? "Sí" : null,
                                                    'Edad de incio de actividad sexual' => $medical_histories->sexual_start_age,
                                                    'Numero de parejas sexuales' => $medical_histories->sexual_partners_count,
                                                    '¿Tienes pareja estable?' => $medical_histories->has_stable_partner ? "Sí" : null,
                                                    '¿Usas condon?' => $medical_histories->condom_usage ? "Sí" : null,
                                                    'Fecha de ultima relación sexual con pareja' => $medical_histories->last_sex_with_partner ? date("d/m/Y",strtotime($medical_histories->last_sex_with_partner )) : null,
                                                    'Fecha de ultima relación sexual con otra persona' => $medical_histories->last_sex_with_other ? date("d/m/Y",strtotime($medical_histories->last_sex_with_other )) : null,
                                                ],
                                            ],
                                            [
                                                'title' => 'Historia Ginecológica',
                                                'bg' => 'dark:bg-rose-800 bg-rose-950',
                                                'text' => 'text-white',
                                                'details' => [
                                                    'Antecedentes Ginecológicos' => $medical_histories->gynecological_history,
                                                    'Última menstruación' => $medical_histories->last_menstrual ? date("d/m/Y",strtotime($medical_histories->last_menstrual )) : null,
                                                    'Menarquia' => $medical_histories->menarche,
                                                    'Ritmo menstrual' => $medical_histories->menstrual_rhythm,
                                                    'Pruritos' => $medical_histories->pruritus ? __("messages.yes") : null,
                                                    'Detalles de pruritos' => $medical_histories->pruritus_detail,
                                                    'Leucorrea' => $medical_histories->leukorrhea ? __("messages.yes") : null,
                                                    'Detalles de leucorrea' => $medical_histories->leukorrhea_detail,
                                                    'Metrorragia' => $medical_histories->metrorrhagia ? __("messages.yes") : null,
                                                    'Detalles de metrorragia' => $medical_histories->metrorrhagia_detail,
                                                    '¿Siente dolor al realizar actividad sexual?' => $medical_histories->sexual_pain ? __("messages.yes") : null, 
                                                    '¿Siente molestia durante el coito?' => $medical_histories->sexual_discomfort ? __("messages.yes") : null,
                                                    'Frecuencia del dolor' => $medical_histories->sexual_pain_frequency,
                                                    'Gestaciones' => $medical_histories->gestation,
                                                    'Partos' => $medical_histories->birth,
                                                    'Abortos' => $medical_histories->abortion,
                                                    'Cesáreas' => $medical_histories->cesarean,
                                                ],
                                                'condition' => Auth::user()->gender === 'female',
                                            ],
                                        ] as $card)
                                            @if (!isset($card['condition']) || $card['condition'])
                                                <div class="mb-4 border rounded-lg overflow-hidden shadow-sm">
                                                    <div class="p-3 {{ $card['bg'] }} {{ $card['text'] }} font-semibold">
                                                        {{ $card['title'] }}
                                                    </div>
                                                    <div class="p-4 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 grid grid-cols-2">
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
                                </div>
                                <div class="hidden p-2 md:p-6 text-medium text-gray-500  rounded-lg w-full tab-item" id="tab-user">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white m-2">{{__("routes.user")}}</h3>
                                    <hr class="mb-4">
                                    <form id="formuser">
                                        <div class="grid grid-cols-1 md:grid-cols-2 sm:mx-10 mt-4">  
                                            <div class="px-2 col-span-2 md:col-span-1">
                                                <div class="relative z-0 mb-2 group">
                                                    <input type="text" autocomplete="off" name="username" id="username" value="{{Auth::user()->username}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                                    <label for="username" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.username")}}</label>
                                                    <small id="username_message" class="text_error pl-2 italic"></small>
                                                </div>
                                            </div> 
                                            <div class="px-2 col-span-2 md:col-span-1">
                                                <div class="relative z-0 mb-2 group">
                                                    <input type="text" autocomplete="off" name="first_name" id="first_name" value="{{Auth::user()->first_name}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                                    <label for="first_name" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.first_name")}}</label>
                                                    <small id="first_name_message" class="text_error pl-2 italic"></small>
                                                </div>
                                            </div>  
                                            <div class="px-2 col-span-2 md:col-span-1">
                                                <div class="relative z-0 mb-2 group">
                                                    <input type="text" autocomplete="off" name="last_name" id="last_name" value="{{Auth::user()->last_name}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                                    <label for="last_name" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.last_name")}}</label>
                                                    <small id="last_name_message" class="text_error pl-2 italic"></small>
                                                </div>
                                            </div>  
                                            <div class="px-2 col-span-2 md:col-span-1">
                                                <div class="relative z-0 mb-2 group">
                                                    <input type="text" autocomplete="off" name="email" id="email" value="{{Auth::user()->email}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                                    <label for="email" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">E-mail</label>
                                                    <small id="email_message" class="text_error pl-2 italic"></small>
                                                </div>
                                            </div>  
                                            <div class="px-2 col-span-2 md:col-span-1">
                                                <div class="relative z-0 mb-2 group">
                                                    <input type="text" autocomplete="off" name="phone" id="phone" value="{{Auth::user()->phone}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                                    <label for="phone" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.phone")}}</label>
                                                    <small id="phone_message" class="text_error pl-2 italic"></small>
                                                </div>
                                            </div>   
                                            <div class="px-2 col-span-2 md:col-span-1">
                                                <div class="relative z-0 group mb-2">
                                                    <select name="language" id="language" class="bg-white dark:bg-slate-900 block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                                                        <option value=""></option>
                                                        <option value="es" {{"es" == Auth::user()->language ? "selected" : ""}}> 🇲🇽 {{__("language.es")}}</option>
                                                        <option value="en" {{"en" == Auth::user()->language ? "selected" : ""}}> 🇺🇸 {{__("language.en")}}</option>
                                                    </select>
                                                    <label for="language" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.language")}}</label>
                                                    <small id="language_message" class="text_error pl-2 italic"></small>
                                                </div>
                                            </div>  
                                            <div class="px-2 col-span-2 md:col-span-1">
                                                <div class="relative z-0 group mb-2">
                                                    <select name="gender" id="gender" class="bg-white dark:bg-slate-900 block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                                                        <option value=""></option>
                                                        @foreach ($genders as $key => $item)  
                                                            <option value="{{$key}}" {{($key == Auth::user()->gender && Auth::user()->gender != null)? "selected" : ""}}>{{$item}}</option>
                                                        @endforeach
                                                    </select> 
                                                    <label for="gender" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.gender")}}</label>
                                                    <small id="gender_message" class="text_error pl-2 italic"></small>
                                                </div>
                                            </div>  
                                            <div class="col-span-2 text-center md:text-right">  
                                                <button class="text-white bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-800 dark:hover:bg-emerald-900 rounded-md px-10 py-2">{{__("messages.save")}}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div> 
                                <div class="hidden p-2 md:p-6 bg-white text-medium text-gray-500  rounded-lg w-full tab-item" id="tab-password"> 
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white m-2">{{__("messages.password")}}</h3>
                                    <hr class="mb-4">
                                    <form id="formpassword">
                                        <p class="text-center italic mb-2">{{__("messages.ifForgetYouPassword")}}</p>
                                        <div class="md:w-6/12 m-auto mb-2">
                                            <div class="flex items-center">
                                                <div class="relative z-10 group w-full ">
                                                    <input autocomplete="off" type="password" name="old_password" id="old_password" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                                                    <label for="old_password" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.oldPassword")}}</label>
                                                </div>
                                                <button type="button" onclick="seePasswordInput($('#old_password'),this)" class="-ml-8 -mb-[5px] text-sm font-medium focus:outline-none z-20 bg-gray-300 dark:bg-[#070F26] text-gray-500 p-2 rounded-sm" title="{{__("messages.addType")}}">
                                                    <svg  xmlns="http://www.w3.org/2000/svg"  class="h-4 w-4" viewBox="0 0 24 24"  fill="none"  stroke="#526270"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                                </button> 
                                                <button type="button" onclick="hidePasswordInput($('#old_password'),this)" class="hidden -ml-8 -mb-[5px] text-sm font-medium focus:outline-none z-20 bg-gray-300 dark:bg-[#070F26] text-gray-500 p-2 rounded-sm" title="{{__("messages.addType")}}">
                                                    <svg  xmlns="http://www.w3.org/2000/svg"  class="h-4 w-4" viewBox="0 0 24 24"  fill="none"  stroke="#526270"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye-off"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" /><path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" /><path d="M3 3l18 18" /></svg>
                                                </button> 
                                            </div> 
                                            <small id="old_password_message" class="text_error pl-2 italic"></small>
                                        </div>  
                                        <div class="md:w-6/12 m-auto mb-2">
                                            <div class="flex items-center">
                                                <div class="relative z-10 group w-full ">
                                                    <input autocomplete="off" type="password" name="new_password" id="new_password" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                                                    <label for="new_password" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.newPassword")}}</label>
                                                </div>
                                                <button type="button" onclick="seePasswordInput($('#new_password'),this)" class="-ml-8 -mb-[5px] text-sm font-medium focus:outline-none z-20 bg-gray-300 dark:bg-[#070F26] text-gray-500 p-2 rounded-sm" title="{{__("messages.addType")}}">
                                                    <svg  xmlns="http://www.w3.org/2000/svg"  class="h-4 w-4" viewBox="0 0 24 24"  fill="none"  stroke="#526270"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                                </button> 
                                                <button type="button" onclick="hidePasswordInput($('#new_password'),this)" class="hidden -ml-8 -mb-[5px] text-sm font-medium focus:outline-none z-20 bg-gray-300 dark:bg-[#070F26] text-gray-500 p-2 rounded-sm" title="{{__("messages.addType")}}">
                                                    <svg  xmlns="http://www.w3.org/2000/svg"  class="h-4 w-4" viewBox="0 0 24 24"  fill="none"  stroke="#526270"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye-off"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" /><path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" /><path d="M3 3l18 18" /></svg>
                                                </button> 
                                            </div> 
                                            <small id="new_password_message" class="text_error pl-2 italic"></small>
                                        </div>  
                                        <div class="md:w-6/12 m-auto">
                                            <div class="flex items-center">
                                                <div class="relative z-10 group w-full">
                                                    <input autocomplete="off" type="password" name="new_password_confirmation" id="new_password_confirmation" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                                                    <label for="new_password_confirmation" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.newPassword_confirmation")}}</label>
                                                </div>
                                                <button type="button" onclick="seePasswordInput($('#new_password_confirmation'),this)" class="-ml-8 -mb-[5px] text-sm font-medium focus:outline-none z-20 bg-gray-300 dark:bg-[#070F26] text-gray-500 p-2 rounded-sm" title="{{__("messages.addType")}}">
                                                    <svg  xmlns="http://www.w3.org/2000/svg"  class="h-4 w-4" viewBox="0 0 24 24"  fill="none"  stroke="#526270"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                                </button> 
                                                <button type="button" onclick="hidePasswordInput($('#new_password_confirmation'),this)" class="hidden -ml-8 -mb-[5px] text-sm font-medium focus:outline-none z-20 bg-gray-300 dark:bg-[#070F26] text-gray-500 p-2 rounded-sm" title="{{__("messages.addType")}}">
                                                    <svg  xmlns="http://www.w3.org/2000/svg"  class="h-4 w-4" viewBox="0 0 24 24"  fill="none"  stroke="#526270"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye-off"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" /><path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" /><path d="M3 3l18 18" /></svg>
                                                </button> 
                                            </div> 
                                            <small id="new_password_confirmation_message" class="text_error pl-2 italic"></small>
                                        </div>   
                                        <div class="col-span-2 text-center md:text-center">  
                                            <button class="text-white bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-800 dark:hover:bg-emerald-900 rounded-md px-10 py-2">{{__("messages.changePassword")}}</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="hidden p-2 md:p-6 bg-white text-medium text-gray-500  rounded-lg w-full tab-item" id="tab-certificate">
                                    <button onclick="openModal('#newDocument')" class="float-end text-white bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-800 dark:hover:bg-emerald-900 rounded-md px-10 py-2">{{__("messages.requestCertificate")}}</button>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white m-2">{{__("routes.certificates")}}</h3>
                                    <hr class="mb-4">
                                    <div class="bg-white relative shadow-md rounded-lg"> 
                                        <table class="w-full text-sm text-left text-gray-700">
                                            <thead class="text-xs uppercase table_header text_table_header">
                                                <tr>   
                                                    <th scope="col" class="px-4 py-3">{{__("routes.medical")}}</th>  
                                                    <th scope="col" class="px-4 py-3">{{__("messages.notes")}}</th>  
                                                    <th scope="col" class="px-4 py-3 text-center hidden md:table-cell">{{__("messages.date")}}</th>    
                                                    <th scope="col" class="px-4 py-3">
                                                        <span class="sr-only">Actions</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody> 
                                                @if(count($certificates))
                                                    @foreach ($certificates as $item)
                                                    <tr>   
                                                        <th scope="col" class="px-4 py-3">{{$item->fullnameDoctor}}</th>  
                                                        <th scope="col" class="px-4 py-3">{{$item->notes}}</th>  
                                                        <th scope="col" class="px-4 py-3 text-center hidden md:table-cell">{{date("d/m/Y",strtotime($item->created_at))}}</th>    
                                                        <th scope="col" class="px-4 py-3">
                                                            <a href="{{$_['baseURL']}}/certificates/getContent/{{$item->id}}" target="_blank">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path><path d="M7 11l5 5l5 -5"></path><path d="M12 4l0 12"></path></svg>
                                                            </a>
                                                        </th>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                <tr>
                                                    <td colspan="5">
                                                        <h1 class="text-center text-2xl md:text-3xl m-10 md:m-20">
                                                            <svg class="mx-auto" xmlns="http://www.w3.org/2000/svg" width="60"  height="60" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 20h-11a3 3 0 0 1 0 -6h11a3 3 0 0 0 0 6h1a3 3 0 0 0 3 -3v-11a2 2 0 0 0 -2 -2h-10a2 2 0 0 0 -2 2v8" /></svg>
                                                            {{__('messages.withoutCertificates')}}
                                                        </h1>
                                                    </td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>   
                                    </div>
                                </div>
                                <div class="p-2 md:p-6 bg-white text-medium text-gray-500  rounded-lg w-full tab-item" id="tab-appointments">
                                    <a href="{{$_['baseURL']}}/appointment/{{Auth::user()->patient->doctor_id}}" class="float-end text-white bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-800 dark:hover:bg-emerald-900 rounded-md px-10 py-2">{{__("messages.addAppointment")}}</a>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white m-2">{{__("routes.appointments")}}</h3>
                                    <hr class="mb-4">
                                    <div class="bg-white relative shadow-md rounded-lg">
                                        <div class="flex flex-col items-center justify-between space-y-3  p-4">
                                            <div class="w-full"> 
                                                <div id="date-range-picker" date-rangepicker  class="flex items-center">
                                                    <div class="relative flex-1">
                                                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                                            </svg>
                                                        </div>
                                                        <input id="datepicker-range-start" name="start" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{__('messages.start')}}">
                                                    </div>
                                                    <span class="mx-4 text-gray-500">-</span>
                                                    <div class="relative flex-1">
                                                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                                            </svg>
                                                        </div>
                                                        <input id="datepicker-range-end" name="end" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{__('messages.end')}}">
                                                    </div>
                                                    <button id="clear-daterange" type="button" class="hidden ml-4 bg-red-500 text-white px-4 py-2 rounded-lg">
                                                        {{__("messages.clear")}}
                                                    </button>
                                                </div> 
                                            </div>
                                            <ul class="ml-0 items-center w-full text-sm font-medium bg-white border rounded-lg grid grid-cols-4">
                                                <li class="w-full col-span-2 md:col-span-1">
                                                    <div class="flex items-center ps-3">
                                                        <input id="cancel" name="status" type="checkbox" onclick="if(checkedInputs()){ getPagination(currentPageAppointments) }else{ this.checked = true;}" value="0" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                                        <label for="cancel" class="w-full py-2 ms-2 text-sm font-medium paragraph_text">{{__("messages.canceled_her")}}</label>
                                                    </div>
                                                </li>
                                                <li class="w-full col-span-2 md:col-span-1">
                                                    <div class="flex items-center ps-3">
                                                        <input id="pending" name="status" type="checkbox" onclick="if(checkedInputs()){ getPagination(currentPageAppointments) }else{ this.checked = true;}" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" checked>
                                                        <label for="pending" class="w-full py-2 ms-2 text-sm font-medium paragraph_text">{{__("messages.pendings")}}</label>
                                                    </div>
                                                </li> 
                                                <li class="w-full col-span-2 md:col-span-1">
                                                    <div class="flex items-center ps-3">
                                                        <input id="confirmed" name="status" type="checkbox" onclick="if(checkedInputs()){ getPagination(currentPageAppointments) }else{ this.checked = true;}" value="2" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" checked>
                                                        <label for="confirmed" class="w-full py-2 ms-2 text-sm font-medium paragraph_text">{{__("messages.confirmed")}}</label>
                                                    </div>
                                                </li> 
                                                <li class="w-full col-span-2 md:col-span-1">
                                                    <div class="flex items-center ps-3">
                                                        <input id="completed" name="status" type="checkbox" onclick="if(checkedInputs()){ getPagination(currentPageAppointments) }else{ this.checked = true;}" value="3" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                                        <label for="completed" class="w-full py-2 ms-2 text-sm font-medium paragraph_text">{{__("messages.completed_her")}}</label>
                                                    </div>
                                                </li> 
                                            </ul> 
                                        </div> 
                                        <table class="w-full text-sm text-left text-gray-700">
                                            <thead class="text-xs uppercase table_header text_table_header">
                                                <tr>   
                                                    <th scope="col" class="px-4 py-3">{{__("routes.medical")}}</th>  
                                                    <th scope="col" class="px-4 py-3 text-center">{{__("messages.date")}}</th>  
                                                    <th scope="col" class="px-4 py-3 text-center hidden md:table-cell">Subtotal</th>    
                                                    <th scope="col" class="px-4 py-3">
                                                        <span class="sr-only">Actions</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>  
                                            </tbody>
                                        </table>  
                                        <nav id="pagination" class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">
                                        </nav>  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> 
    <div id="deleteModal" tabindex="-1" class="hidden flex bg-[#0000006b] overflow-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
             <div class="relative bg_modal rounded-lg shadow ">
                <button onclick="closeModal('#deleteModal')" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="deleteModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                     <h3 class="mb-5 text-lg font-normal title_text">{{__("messages.appointmentDeleteAsk")}}</h3>
                    <div class="w-full p-4">   
                        <div class="relative z-0 mb-2 group text-left">
                            <textarea autocomplete="off" row="1" name="cancellation_reason" id="cancellation_reason" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" ></textarea>
                            <label for="cancellation_reason" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.reasonCancel")}}</label>
                            <small id="cancellation_reason_message" class="text_error pl-2 italic"></small>
                        </div>
                    </div> 
                    <button  onclick="confirmDelete()" data-modal-hide="deleteModal" type="button" class="button_error focus:ring-4 focus:outline-none font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        {{__("messages.yes")}}
                    </button>
                    <button onclick="closeModal('#deleteModal')" data-modal-hide="deleteModal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium inverted button_regular focus:outline-none rounded-lg border focus:z-10 focus:ring-4 ">{{__("messages.no")}}, {{__("messages.cancel")}}</button>
                </div>
            </div>
        </div>
    </div> 
    <div id="newDocument" tabindex="-1" class="hidden flex bg-[#0000006b] overflow-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
             <div class="relative bg_modal rounded-lg shadow ">
                <button onclick="closeModal('#newDocument')" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="newDocument">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center"> 
                     <h3 class="mb-5 text-lg font-normal title_text">{{__("routes.create_certificate")}}</h3>
                    <form id="documentform">
                        <div class="px-2 w-full">
                            <div class="relative z-0 group mb-2 text-left">
                                <select name="type" id="type" class="bg-white dark:bg-slate-900 block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                                    <option value=""></option>
                                    <option value="1">{{__("messages.medicalCertificate")}}</option>
                                    <option value="2">{{__("messages.certificate")}}</option>
                                    <option value="3">{{__("messages.recipe")}}</option>
                                </select> 
                                <label for="type" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.type")}}</label>
                                <small id="type_message" class="text_error pl-2 italic"></small>
                            </div>
                        </div>
                        <div class="w-full p-4">   
                            <div class="relative z-0 mb-2 group text-left">
                                <textarea autocomplete="off" row="1" name="notes" id="notes" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" ></textarea>
                                <label for="notes" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.notes")}}</label>
                                <small id="notes_message" class="text_error pl-2 italic"></small>
                            </div>
                        </div> 
                        <input type="hidden" name="doctor_id" id="doctor_id" value="{{Auth::user()->patient->doctor_id}}">
                        <button class="text-white button_success focus:ring-4 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                            {{__("messages.save")}}
                        </button>
                    </form> 
                </div>
            </div>
        </div>
    </div> 
    <div id="detailAppointment" tabindex="-1" class="hidden flex bg-[#0000006b] overflow-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
             <div class="relative bg_modal rounded-lg shadow ">
                <button onclick="closeModal('#detailAppointment')" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="detailAppointment">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 mt-2 text-center">
                    <div class="modal-body mt-4">
                        <h2 class="text-gray-400 dark:text-gray-200  text-2xl">{{__("routes.appointment")}}</h2>
                        <i id="statusText"></i>
                        <hr class="mt-2 mb-4">
                        <i id="dateText" class="text-gray-400 dark:text-gray-200  mb-2 block"></i>
                        <i id="subject"></i>
                        <div class="grid grid-cols-2 text-gray-400 dark:text-gray-200">
                            <div class="hidden">
                                <small><i>{{__("routes.patient")}}</i></small>
                                <p id="patientText"></p>
                            </div>
                            <div class="col-span-2">
                                <small><i>{{__("routes.medical")}}</i></small>
                                <p id="doctorText"></p>
                            </div>
                        </div> 
                        <hr class="mt-2 mb-4">
                        <h2 class="text-gray-400 dark:text-gray-200  text-md mb-4">{{__("messages.patientInfo")}}</h2>
                        <div class="grid grid-cols-2 text-gray-400 dark:text-gray-200 text-left">
                            <div class="text-center">
                                <small><i>{{__("messages.dob")}}</i></small>
                                <p id="dobText" class="pl-4"></p>
                            </div>
                            <div class="text-center">
                                <small><i>{{__("messages.bloodType")}}</i></small>
                                <p id="bloodTypeText" class="pl-4"></p>
                            </div>
                        </div>  
                        <h2 class="text-gray-400 dark:text-gray-200  text-md mt-4 mb-4" id="titleDetail">{{__("messages.detail")}}</h2>
                        <div class="text-gray-400 dark:text-gray-200  text-left">
                            <div class="hidden pt-2" id="allergiesRow">
                                <hr class="mb-2">
                                <small>{{__("messages.allergies")}}</small>
                                <div class="text-muted pl-2 mb-2" id="allergiesText"></div>
                                <hr>
                            </div>
                            <div class="hidden pt-2" id="addictionsRow">
                                <small>{{__("messages.addictions")}}</small>
                                <div class="text-muted pl-2 mb-2" id="addictionsText"></div>
                                <hr>
                            </div>
                            <div class="hidden pt-2" id="medicationsRow">
                                <small>{{__("messages.medications")}}</small>
                                <div class="text-muted pl-2 mb-2" id="medicationsText"></div>
                                <hr>
                            </div>
                            <div class="hidden pt-2" id="surgeriesRow">
                                <small>{{__("messages.surgeries")}}</small>
                                <div class="text-muted pl-2 mb-2" id="surgeriesText"></div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>        
        </div>
    </div>
@stop

@section("scripts") 
    <script>
        const urlProfile = '{{$_['baseURL']}}/users/updateProfilePatient';
        const urlUser = '{{$_['baseURL']}}/users/updateProfile';
        const urlPassword = '{{$_['baseURL']}}/users/updatePassword';
        const urlAppointments = '{{$_['baseURL']."/appointments/list?page="}}'; 
        const urlDocument = '{{$_['baseURL']}}/requests/create';
        const urlTab = baseURL+"/profile";
        const appointmentStatus = {!! json_encode($appointmentStatus) !!};
        const appointmentStatusColors = {!! json_encode($appointmentStatusColors) !!};
        const discountText  = "{{__('messages.discount')}}";
        const detailText = "{{__('messages.detail')}}";
        const deleteText = "{{__('messages.cancel')}}";  
        const withoutAppointmentsSearch = "{{__('messages.withoutAppointments')}}";
        const days   = {!! json_encode($days) !!};
        const months = [];
        let currentPageAppointments = 1;
        
        ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'].forEach(key => {
            months.push(@json($months)[key]);
        });  
    </script>
    <script src="{{ asset('/resources/libs/flowbite/datepicker.min.js') }}"></script> 
    <script src="{{ asset('/resources/js/public/profile.js') }}"></script>  
    <script src="{{ asset('/resources/js/public/appointments.js') }}"></script>  
    <script>
        if({!! json_encode($appointment) !!}){
            detailAppointment({!! json_encode($appointment) !!}); 
        }
    </script>
@stop