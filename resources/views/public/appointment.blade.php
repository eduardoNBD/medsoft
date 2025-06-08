@extends('layouts.public',[ 'current_route'  => 'appointment'])

@section('title', __('messages.scheduleAppointment')) 

@section('styles') 
   <style>
        .datepicker-picker,
        .datepicker-picker .days,
        .datepicker-picker .days-of-week,
        .datepicker-grid {
            width: 100% !important
        }
        .datepicker-picker{
            box-shadow: 0px 0px 7px 0px #00000055 !important;
        }
   </style>
@stop

@section('content')  
    <section class="pb-20 md:pb-32 pt-60 bg-[url('../img/publicImg/appointmentbg.jpeg')] bg-fixed bg-no-repeat bg-cover bg-center  relative">
        <div class="container mx-auto">
            <div class="absolute inset-0 bg-slate-900/60"></div>
            <div class="relative z-10 text-center text-white flex flex-col items-center justify-center px-4">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">
                    {{__('messages.scheduleAppointment')}}
                </h2>
            </div>
        </div>
    </section>
    <section class="py-16 md:py-32 bg-[#fafafa]">
        <div class="md:container mx-auto">
            <div class="grid grid-cols-6 gap-4">
                <div class="col-span-6 md:col-span-2 ">
                    <div class="relative flex flex-col min-w-0 break-words bg-white w-full shadow-lg rounded-lg">
                        <div class="px-6">
                            <div class="flex flex-wrap justify-center">
                                <div class=" px-4 lg:order-2 flex justify-center"> 
                                    <img alt="{{$doctor->user->first_name}} {{$doctor->user->last_name}}" src="{{$doctor->user->image ? asset("/storage/app/").'/'.$doctor->user->image : asset('/resources/img/user.png')}}" class="shadow rounded-full w-20 h-20 align-middle border-none absolute top-[-40px]"> 
                                </div> 
                            </div>
                            <div class="text-center mt-10 pb-4">
                                <h3 class="text-2xl font-semibold leading-normal text-slate-700">
                                    {{$doctor->title}} {{$doctor->user->first_name}} {{$doctor->user->last_name}}
                                </h3>
                                <hr class="my-4 border-b-1 border-gray-300"> 
                                <div class="flex flex-col sm:flex-row justify-center gap-2 text-slate-700  text-center">
                                    <div class="flex gap-1 items-center  justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mt-[3px]" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path><path d="M16 12v1.5a2.5 2.5 0 0 0 5 0v-1.5a9 9 0 1 0 -5.5 8.28"></path></svg> 
                                        {{$doctor->user->email}}
                                    </div>
                                    <div class="hidden sm:inline text-slate-400">|</div>
                                    <div class="flex gap-1 items-center  justify-center"> 
                                        <svg xmlns="http://www.w3.org/2000/svg"  width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M6 5a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2v-14z"></path><path d="M11 4h2"></path><path d="M12 17v.01"></path></svg> 
                                        {{$doctor->user->phone}}
                                    </div> 
                                </div>
                                <div class="mx-10"> 
                                    @foreach(json_decode($doctor->specialties) as $specialty)
                                        <span class="text-sm text-gray-100 bg-blue-900 rounded py-1 px-2 flex items-center justify-center mt-2 w-fit mx-auto">
                                            {{$specialty}}
                                        </span> 
                                    @endforeach
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="col-span-6 md:col-span-4">
                    <div class="bg-white w-full mb-6 shadow-lg rounded-lg h-full">
                        <form id="form_appointment">
                            <div class="grid grid-cols-12">
                                <div class="px-4 col-span-12 md:col-span-6 pt-10">
                                    <div class="relative z-0 group mb-2">
                                        <select name="medical_unit" id="medical_unit" class="bg-white dark:bg-slate-900 block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                                            <option value=""></option>
                                            @foreach ($doctor->medical_units as $medical_unit)
                                                <option value="{{$medical_unit->id}}" {{$medicalUnit == $medical_unit->id ? "selected" : ""}}>{{$medical_unit->name}}</option>
                                            @endforeach
                                        </select> 
                                        <label for="medical_unit" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("routes.medical_unit")}}</label>
                                        <small id="medical_unit_message" class="text_error pl-2 italic"></small>
                                    </div>
                                </div>
                                <div class="px-4 col-span-12 md:col-span-6 pt-2 md:pt-10">
                                    <div class="relative z-0 group mb-2">
                                        <select onchange="setPrice()" name="subject" id="subject" class="bg-white dark:bg-slate-900 block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                                            <option value=""></option>
                                            @foreach($subjects as $subject)
                                                <option value="{{$subject}}">{{__("subjects.".$subject)}}</option>
                                            @endforeach
                                        </select> 
                                        <label for="subject" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.subject")}}</label>
                                        <small id="subject_message" class="text_error pl-2 italic"></small>
                                    </div>
                                </div>
                                <div class="px-4 col-span-12 md:col-span-6 pt-2 hidden">
                                    <div class="relative z-0 group mb-2">
                                        <input type="text" autocomplete="off" name="timeslot" id="timeslot" readonly class="block py-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                        <label for="timeslot" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.timeslot")}}</label>
                                        <small id="timeslot_message" class="text_error pl-2 italic"></small>
                                    </div>
                                </div> 
                                @if(Auth::check() && Auth::user()->role == 3)
                                    <div class="col-span-4 mb-4 hidden" id="usePatientInfo">
                                        <div class="flex justify-end">
                                            <div class="me-2 text-sm">
                                                <label for="usePatientInfoCheck" class="font-medium text-gray-900 dark:text-gray-300">{{__("messages.usePatientInfo")}}</label> 
                                            </div>
                                            <div class="flex items-center  h-5">
                                                <input id="usePatientInfoCheck" name="usePatientInfoCheck" aria-describedby="usePatientInfoCheck-text" type="checkbox" value="1" checked class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-4 col-span-12 md:col-span-4 hidden">
                                        <div class="relative z-0 mb-2 group">
                                            <input type="text" autocomplete="off" name="first_name" id="first_name" value="{{Auth::user()->first_name}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                            <label for="first_name" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.first_name")}}</label>
                                            <small id="first_name_message" class="text_error pl-2 italic"></small>
                                        </div>
                                    </div>  
                                    <div class="px-4 col-span-12 md:col-span-4 hidden">
                                        <div class="relative z-0 mb-2 group">
                                            <input type="text" autocomplete="off" name="last_name" id="last_name" value="{{Auth::user()->last_name}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                            <label for="last_name" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.last_name")}}</label>
                                            <small id="last_name_message" class="text_error pl-2 italic"></small>
                                        </div>
                                    </div>  
                                    <div class="px-4 col-span-12 md:col-span-4 hidden">
                                        <div class="relative z-0 mb-2 group">
                                            <input type="text" autocomplete="off" name="email" id="email" value="{{Auth::user()->email}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                            <label for="email" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">E-mail</label>
                                            <small id="email_message" class="text_error pl-2 italic"></small>
                                        </div>
                                    </div>  
                                    <div class="px-4 col-span-12 md:col-span-4 hidden">
                                        <div class="relative z-0 mb-2 group">
                                            <input type="text" autocomplete="off" name="phone" id="phone" value="{{Auth::user()->phone}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                            <label for="phone" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.phone")}}</label>
                                            <small id="phone_message" class="text_error pl-2 italic"></small>
                                        </div>
                                    </div> 
                                    <div class="px-4 col-span-12 md:col-span-4 hidden"> 
                                        <div class="relative z-0 mb-2 group ">
                                            <div class="relative max-w-sm">
                                                <div class="absolute inset-y-0 end-0 flex items-center ps-3 pointer-events-none">
                                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                                    </svg>
                                                </div>
                                                <input id="dob" name="dob" autocomplete="off" value="{{Auth::user()->patient->dob}}" type="text" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" ">
                                            </div>
                                            <label for="dob" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.dob")}}</label>
                                            <small id="dob_message" class="text_error pl-2 italic"></small> 
                                        </div>
                                    </div>  
                                    <div class="px-4 col-span-12 md:col-span-4 hidden">
                                        <div class="relative z-0 group mb-2">
                                            <select name="bloodType" id="bloodType" class="bg-white dark:bg-slate-900 block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                                                <option value=""></option>
                                                <option value="A+" {{Auth::user()->patient->blood_type == "A+" ? "selected" : ""}}>A+</option>
                                                <option value="A-" {{Auth::user()->patient->blood_type == "A-" ? "selected" : ""}}>A-</option>
                                                <option value="B+" {{Auth::user()->patient->blood_type == "B+" ? "selected" : ""}}>B+</option>
                                                <option value="B-" {{Auth::user()->patient->blood_type == "B-" ? "selected" : ""}}>B-</option>
                                                <option value="AB+" {{Auth::user()->patient->blood_type == "AB+" ? "selected" : ""}}>AB+</option>
                                                <option value="AB-" {{Auth::user()->patient->blood_type == "AB-" ? "selected" : ""}}>AB-</option>
                                                <option value="O+" {{Auth::user()->patient->blood_type == "O+" ? "selected" : ""}}>O+</option>
                                                <option value="O-" {{Auth::user()->patient->blood_type == "O-" ? "selected" : ""}}>O-</option>
                                            </select> 
                                            <label for="bloodType" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.bloodType")}}</label>
                                            <small id="bloodType_message" class="text_error pl-2 italic"></small>
                                        </div>
                                    </div>  
                                    <div class="px-4 col-span-12 md:col-span-4 hidden">
                                        <div class="relative z-0 group mb-2">
                                            <select name="language" id="language" class="bg-white dark:bg-slate-900 block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                                                <option value=""></option>
                                                <option value="es" {{Auth::user()->language == "es" ? "selected ": ''}}> 🇲🇽 {{__("language.es")}}</option>
                                                <option value="en" {{Auth::user()->language == "en" ? "selected ": ''}}> 🇺🇸 {{__("language.en")}}</option>
                                            </select>
                                            <label for="language" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.language")}}</label>
                                            <small id="language_message" class="text_error pl-2 italic"></small>
                                        </div>
                                    </div>   
                                    <div class="px-4 col-span-12 md:col-span-4 hidden">
                                        <div class="relative z-0 group mb-2">
                                            <select name="gender" id="gender" class="bg-white dark:bg-slate-900 block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                                                <option value=""></option>
                                                @foreach ($genders as $key => $item) 
                                                    <option value="{{$key}}"  {{Auth::user()->gender == $key ? "selected ": ''}}>{{$item}}</option>
                                                @endforeach
                                            </select> 
                                            <label for="gender" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.gender")}}</label>
                                            <small id="gender_message" class="text_error pl-2 italic"></small>
                                        </div>
                                    </div>    
                                    <hr class="px-4 col-span-12 mb-4"> 
                                    <div class="px-4 col-span-12 mb-4">
                                        <div class="flex justify-end">
                                            <div class="me-2 text-sm">
                                                <label for="allergies" class="block text-right text-gray-900 dark:text-gray-300">{{__("messages.haveAllergies")}}</label> 
                                            </div>
                                            <div class="flex items-center h-5">
                                                <input id="allergies" name="allergies" aria-describedby="allergies-text" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-4 col-span-12 mb-4 hidden" id="allergies_text_row">
                                        <div class="px-2 col-span-2 md:col-span-1">
                                            <div class="relative z-0 mb-2 group">
                                                <textarea autocomplete="off" name="allergies_text" id="allergies_text" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" >{{Auth::user()->allergies_text}}</textarea>
                                                <label for="allergies_text" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.allergies")}}</label>
                                                <small id="allergies_text_message" class="text_error pl-2 italic"></small>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="px-4 col-span-12 mb-4">
                                        <div class="flex justify-end">
                                            <div class="me-2 text-sm">
                                                <label for="surgeries" class="block text-right text-gray-900 dark:text-gray-300">{{__("messages.haveSurgeries")}}</label> 
                                            </div>
                                            <div class="flex items-center  h-5">
                                                <input id="surgeries" name="surgeries" aria-describedby="surgeries-text" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-4 col-span-12 mb-4 hidden" id="surgeries_text_row">
                                        <div class="px-2 col-span-2 md:col-span-1">
                                            <div class="relative z-0 mb-2 group">
                                                <textarea autocomplete="off" name="surgeries_text" id="surgeries_text" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" >{{Auth::user()->surgeries_text}}</textarea>
                                                <label for="surgeries_text" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.surgeries")}}</label>
                                                <small id="surgeries_text_message" class="text_error pl-2 italic"></small>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="px-4 col-span-12 mb-4">
                                        <div class="flex justify-end">
                                            <div class="me-2 text-sm">
                                                <label for="addictions" class="block text-right text-gray-900 dark:text-gray-300">{{__("messages.haveAddictions")}}</label> 
                                            </div>
                                            <div class="flex items-center  h-5">
                                                <input id="addictions" name="addictions" aria-describedby="addictions-text" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-4 col-span-12 mb-4 hidden" id="addictions_text_row">
                                        <div class="px-2 col-span-2 md:col-span-1">
                                            <div class="relative z-0 mb-2 group">
                                                <textarea autocomplete="off" name="addictions_text" id="addictions_text" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" ></textarea>
                                                <label for="addictions_text" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.addictions")}}</label>
                                                <small id="addictions_text_message" class="text_error pl-2 italic"></small>
                                            </div>
                                        </div> 
                                    </div> 
                                    <div class="px-4 col-span-12 mb-4">
                                        <div class="flex justify-end">
                                            <div class="me-2 text-sm">
                                                <label for="medications" class="block text-right text-gray-900 dark:text-gray-300">{{__("messages.haveMedications")}}</label> 
                                            </div>
                                            <div class="flex items-center  h-5">
                                                <input id="medications" name="medications" aria-describedby="medications-text" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-4 col-span-12 mb-4 hidden" id="medications_text_row">
                                        <div class="px-2 col-span-2 md:col-span-1">
                                            <div class="relative z-0 mb-2 group">
                                                <textarea autocomplete="off" name="medications_text" id="medications_text" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" >{{Auth::user()->medications_text}}</textarea>
                                                <label for="medications_text" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.medications")}}</label>
                                                <small id="medications_text_message" class="text_error pl-2 italic"></small>
                                            </div>
                                        </div> 
                                    </div> 
                                    <hr class="col-span-12">
                                @endif
                            </div>                            
                            <div class="grid grid-cols-12 sm:mx-10 mt-4">  
                                <div class="px-2 col-span-12 md:col-span-6" id="rowDateTime">  
                                    <div class=""> 
                                        <input type="hidden" name="hour">
                                        <input type="hidden" name="date">
                                        <div class="px-2 py-2">
                                            <h3 class="text-gray-900 dark:text-white text-base font-medium mb-3 text-center" id="appDateHour"></h3>
                                            <small id="date_message" class="text_error pl-2 italic"></small>
                                            <div id="datepicker" inline-datepicker minDate="{{date("Y-m-d")}}"></div>
                                        </div>
                                    </div>
                                </div>   
                                <div class="px-2 col-span-12 md:col-span-6">
                                    <div class=" pt-0 md:pt-10"> 
                                        <small id="hour_message" class="text_error pl-2 italic"></small>
                                        <div class="w-full mt-5">
                                            <ul id="timetable" class="grid w-full grid-cols-4 gap-2 mt-5 px-4 md:px-2"> </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-12 sm:col-span-6 text-right text-[#526270] dark:text-gray-400 mb-6 mt-4 flex px-4 ml-auto">
                                    <label for="">{{__('messages.cost')}}:</label>
                                    <input type="text" autocomplete="off" name="subtotal" id="subtotal" readonly value="0" class="mx-2 w-full text-right input_text bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#4D4E8D] mt-[-9px]" placeholder="" />
                                </div>  
                                <hr class="col-span-12 pb-4">
                                <div class="col-span-12 flex flex-col md:flex-row justify-between gap-4 px-4">
                                    @if(Auth::check() && Auth::user()->role == 3) 
                                        <input type="hidden" autocomplete="off" name="doctor" id="doctor" value="{{$doctor->id}}" />
                                        <input type="hidden" autocomplete="off" name="patient" id="patient" value="{{Auth::user()->patient->id}}" />
                                        <button class="button_primary rounded py-2 px-4 mt-4">
                                            {{__('messages.scheduleAppointment')}}
                                        </button>
                                    @endif
                                    @if(!Auth::check())
                                        <a href="{{$_['baseURL']}}/login" class="button_secondary rounded py-2 px-4">
                                            {{__('messages.loginToScheduleAppointment')}}
                                        </a>
                                        <div class="text-center flex-1 pt-[11px] mb-[-13px]">
                                            <hr class="mt-2">
                                            <div class="-mt-[16px] mb-6 bg-white w-12 mx-auto font-[500] text-xl text-[#666666]">{{__("messages.or")}}</div>
                                        </div>
                                        <a href="{{$_['baseURL']}}/register" class="button_secondary rounded py-2 px-4">
                                            {{__('messages.registerToScheduleAppointment')}}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section("scripts")   
    <script>
        const urlGetAvailable = '{{$_['baseURL']."/appointments/getAvailableTimes/"}}{{$doctor->id}}/';
        const url = '{{$_['baseURL']}}/appointments/create';
        const redirect  = '{{$_['baseURL']}}/profile';
        let appDate = "";
        let appHour = "";
        const withoutAppointmentsSearch = "{{__('messages.withoutAppointments')}}";
        const date_after = "{{__('rules.date_after')}}";
        const days   = {!! json_encode($days) !!};
        let prices = {!! json_encode($prices) !!}; 
        let times = {!! json_encode($times) !!}; 
        const months = [];
        ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'].forEach(key => {
            months.push(@json($months)[key]);
        });   
    </script>
    <script src="{{ asset('/resources/libs/flowbite/datepicker.min.js') }}"></script> 
    <script src="{{ asset('/resources/js/public/appointment.js') }}"></script>
@stop