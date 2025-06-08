@extends('layouts.noAuth')
 
@section('title', __('messages.login')) 

@section('styles') 
   <style>
        .multiselect-container {
            width: 100%;
            position: relative;
        }

        .multiselect-container .search-input {
            width: 100%;
            position: relative;
        }

        .multiselect-container input[type="checkbox"]{
            margin-right: 10px;
        }

        .options {
            display: none;
            border: 1px solid #ccc;
            max-height: 150px;
            overflow-y: auto;
            background-color: white;
            position: absolute;
            width: 100%;
            z-index: 51;
            margin-top: -20px;
            border-radius: 0px 10px;
            padding: 10px;
        }

        .options label {
            display: flex;
            padding: 5px;
            cursor: pointer;
        }
        .multiselect-container input+label{
            z-index:50;
        }
   </style>
@stop

@section('content')
<main class=""> 
    <section class="w-full mx-auto md:my-10 md:my-auto">  
        <div class="my-2 md:my-auto w-full"> 
            <div class="px-0 md:px-28 md:container mx-2 md:mx-auto"> 
                <h2 class="text-center text-3xl text-gray-700 mt-10 text-white bg-[#4D4E8D] py-2">{{ __('routes.register') }}</h2>
                <form action="">
                    <div class="flex relative overflow-hidden border-t-[1px] border-x-[1px] border-[#4D4E8D]"> 
                        <div id="bg-tab" class="absolute w-[calc(50%_+_1px)] h-12 bg-[#4D4E8D] -skew-x-[16deg] focus:outline-none z-[-1] transition-all duration-300 ease-in-out left-[-8px]"> 
                        </div>
                        <button type="button" class="relative w-[calc(50%_+_1px)] h-12 focus:outline-none tab-button text-white" data-element="0">
                            <span class="block">{{__("routes.patient")}}</span>
                        </button>
                        <button type="button" class="relative w-[calc(50%_+_1px)] h-12 focus:outline-none tab-button" data-element="1">
                            <span class="block">{{__("routes.medical")}}</span>
                        </button> 
                    </div> 
                    <div class="grid grid-cols-2 border border-1 border-t-0 rounded-bl-lg rounded-br-lg">
                        <div class="text-center col-span-2  bg-[#4D4E8D] m-[-1px] py-4">
                            <span class="w-[300px] h-[100px] mb-10 mt-2  inline-block text-white">
                                <img class="w-8/12 m-auto" src="{{ $logos->logo_public ? asset("resources/img/brand/").'/'.$logos->logo_public : asset('/resources/img/brand/logo_public.svg') }}" alt=""> 
                            </span> 
                        </div> 
                        <header class="col-span-2"> 
                            <div class="float-right">  
                                <button type="button" class="mr-2 mt-2 border-b-2 group relative flex items-center justify-center px-4 py-1 text-sm font-medium text-gray-900 dark:text-gray-200 transition-all duration-200  hover:bg-gray-200 dark:hover:bg-slate-950">
                                    {!!app()->getLocale() == "es" ? "🇲🇽<span class='ml-2'>Español</span>" : ""!!}
                                    {!!app()->getLocale() == "en" ? "🇺🇸<span class='ml-2'>English</span>" : ""!!}
                                    <div class="z-10 hidden group-hover:block text-left w-32 border-[1px] border-gray-300 dark:border-slate-800 absolute -right-3 top-7 bg-white dark:bg-[#070F26] rounded-md overflow-hidden">
                                        @if(app()->getLocale() == "en")     
                                            <a href="{{$_['baseURL']}}/lang/es" class="w-64 px-2 py-2 block hover:bg-gray-100 dark:hover:bg-[#020617] flex items-center">
                                                🇲🇽&emsp;Español
                                            </a> 
                                        @endif
                                        @if(app()->getLocale() == "es") 
                                            <a href="{{$_['baseURL']}}/lang/en" class="w-64 px-2 py-2 block hover:bg-gray-100 dark:hover:bg-[#020617] flex items-center">
                                                🇺🇸&emsp;English
                                            </a> 
                                        @endif
                                    </div>
                                </button>
                            </div>
                        </header> 
                        <div class="col-span-2 md:col-span-1 mt-5 md:mt-10">
                            <div class="grid grid-cols-1 md:grid-cols-2 sm:mx-10 mt-4">  
                                <div class="px-4 md:px-2 col-span-2 md:col-span-1">
                                    <div class="relative z-0 mb-2 group">
                                        <input type="text" autocomplete="off" name="username" id="username"  class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                        <label for="username" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.username")}}</label>
                                        <small id="username_message" class="text_error pl-2 italic"></small>
                                    </div>
                                </div> 
                                <div class="px-4 md:px-2 col-span-2 md:col-span-1">
                                    <div class="relative z-0 mb-2 group">
                                        <input type="text" autocomplete="off" name="first_name" id="first_name"  class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                        <label for="first_name" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.first_name")}}</label>
                                        <small id="first_name_message" class="text_error pl-2 italic"></small>
                                    </div>
                                </div>  
                                <div class="px-4 md:px-2 col-span-2 md:col-span-1">
                                    <div class="relative z-0 mb-2 group">
                                        <input type="text" autocomplete="off" name="last_name" id="last_name" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                        <label for="last_name" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.last_name")}}</label>
                                        <small id="last_name_message" class="text_error pl-2 italic"></small>
                                    </div>
                                </div>  
                                <div class="px-4 md:px-2 col-span-2 md:col-span-1">
                                    <div class="relative z-0 mb-2 group">
                                        <input type="text" autocomplete="off" name="email" id="email" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                        <label for="email" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">E-mail</label>
                                        <small id="email_message" class="text_error pl-2 italic"></small>
                                    </div>
                                </div>  
                                <div class="px-4 md:px-2 col-span-2 md:col-span-1">
                                    <div class="relative z-0 mb-2 group">
                                        <input type="text" autocomplete="off" name="phone" id="phone" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                        <label for="phone" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.phone")}}</label>
                                        <small id="phone_message" class="text_error pl-2 italic"></small>
                                    </div>
                                </div>    
                                <div class="px-4 md:px-2 col-span-2 md:col-span-1">
                                    <div class="relative z-0 group mb-2">
                                        <select name="language" id="language" class="bg-white dark:bg-slate-900 block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                                            <option value=""></option>
                                            <option value="es"> 🇲🇽 {{__("language.es")}}</option>
                                            <option value="en"> 🇺🇸 {{__("language.en")}}</option>
                                        </select>
                                        <label for="language" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.language")}}</label>
                                        <small id="language_message" class="text_error pl-2 italic"></small>
                                    </div>
                                </div>  
                                <div class="px-4 md:px-2 col-span-2 md:col-span-1">
                                    <div class="relative z-0 group mb-2">
                                        <select name="gender" id="gender" class="bg-white dark:bg-slate-900 block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                                            <option value=""></option>
                                            @foreach ($genders as $key => $item)  
                                                <option value="{{$key}}">{{$item}}</option>
                                            @endforeach
                                        </select> 
                                        <label for="gender" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.gender")}}</label>
                                        <small id="gender_message" class="text_error pl-2 italic"></small>
                                    </div>
                                </div>  
                                <div class="hidden md:inline md:col-span-1"></div>
                                <div class="px-4 md:px-2 col-span-2 md:col-span-1 mb-2">
                                    <div class="col-span-2 md:col-span-1 flex items-center ">
                                        <div class="relative z-10 group w-full ">
                                            <input autocomplete="off" type="password" name="password" id="password" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                                            <label for="password" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.password")}}</label>
                                        </div>
                                        <button type="button" onclick="seePasswordInput($('#password'),this)" class="-ml-8 -mb-[5px] text-sm font-medium focus:outline-none z-20 bg-gray-300 dark:bg-[#070F26] text-gray-500 p-2 rounded-sm" title="{{__("messages.addType")}}">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  class="h-4 w-4" viewBox="0 0 24 24"  fill="none"  stroke="#526270"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                        </button> 
                                        <button type="button" onclick="hidePasswordInput($('#password'),this)" class="hidden -ml-8 -mb-[5px] text-sm font-medium focus:outline-none z-20 bg-gray-300 dark:bg-[#070F26] text-gray-500 p-2 rounded-sm" title="{{__("messages.addType")}}">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  class="h-4 w-4" viewBox="0 0 24 24"  fill="none"  stroke="#526270"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye-off"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" /><path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" /><path d="M3 3l18 18" /></svg>
                                        </button> 
                                    </div> 
                                    <small id="password_message" class="text_error pl-2 italic"></small>
                                </div>  
                                <div class="px-4 md:px-2 col-span-2 md:col-span-1">
                                    <div class="col-span-2 md:col-span-1 flex items-center">
                                        <div class="relative z-10 group w-full">
                                            <input autocomplete="off" type="password" name="password_confirmation" id="password_confirmation" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                                            <label for="password_confirmation" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.password_confirmation")}}</label>
                                        </div>
                                        <button type="button" onclick="seePasswordInput($('#password_confirmation'),this)" class="-ml-8 -mb-[5px] text-sm font-medium focus:outline-none z-20 bg-gray-300 dark:bg-[#070F26] text-gray-500 p-2 rounded-sm" title="{{__("messages.addType")}}">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  class="h-4 w-4" viewBox="0 0 24 24"  fill="none"  stroke="#526270"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                        </button> 
                                        <button type="button" onclick="hidePasswordInput($('#password_confirmation'),this)" class="hidden -ml-8 -mb-[5px] text-sm font-medium focus:outline-none z-20 bg-gray-300 dark:bg-[#070F26] text-gray-500 p-2 rounded-sm" title="{{__("messages.addType")}}">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  class="h-4 w-4" viewBox="0 0 24 24"  fill="none"  stroke="#526270"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye-off"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" /><path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" /><path d="M3 3l18 18" /></svg>
                                        </button> 
                                    </div> 
                                    <small id="password_confirmation_message" class="text_error pl-2 italic"></small>
                                </div>    
                            </div>   
                        </div>
                        <div class="col-span-2 md:col-span-1 mt-0 md:mt-10">
                            <div class="grid grid-cols-1 md:grid-cols-2 sm:mx-10 mt-4" id="patientTab">  
                                <div class="px-4 md:px-2 col-span-2 md:col-span-1"> 
                                    <div class="relative z-0 mb md:mb-2 group ">
                                        <div class="relative">
                                            <div class="absolute inset-y-0 end-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                                </svg>
                                            </div>
                                            <input id="dob" name="dob" autocomplete="off" datepicker datepicker-autohide type="text" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" ">
                                        </div>
                                        <label for="dob" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.dob")}}</label>
                                        <small id="dob_message" class="text_error pl-2 italic"></small>
                                    </div>
                                </div>  
                                <div class="px-4 md:px-2 col-span-2 md:col-span-1">
                                    <div class="relative z-0 mb md:mb-2 group">
                                        <input type="text" name="patient_address" id="patient_address" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                        <label for="patient_address" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.address")}}</label>
                                        <small id="patient_address_message" class="text_error pl-2 italic"></small>
                                    </div>
                                </div> 
                                <div class="px-4 md:px-2 col-span-2 md:col-span-1">
                                    <div class="relative z-0 mb md:mb-2 group">
                                        <input type="text" name="patient_city" id="patient_city" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                        <label for="patient_city" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.city")}}</label>
                                        <small id="patient_city_message" class="text_error pl-2 italic"></small>
                                    </div>
                                </div> 
                                <div class="px-4 md:px-2 col-span-2 md:col-span-1">
                                    <div class="relative z-0 mb md:mb-2 group">
                                        <input type="text" name="patient_state" id="patient_state" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                        <label for="patient_state" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.state")}}</label>
                                        <small id="patient_state_message" class="text_error pl-2 italic"></small>
                                    </div>
                                </div> 
                                <div class="px-4 md:px-2 col-span-2 md:col-span-1">
                                    <div class="relative z-0 mb md:mb-2 group">
                                        <input type="text" name="patient_zipcode" id="patient_zipcode" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                        <label for="patient_zipcode" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.zipcode")}}</label>
                                        <small id="patient_zipcode_message" class="text_error pl-2 italic"></small>
                                    </div>
                                </div> 
                                <div class="px-4 md:px-2 col-span-2 md:col-span-1">
                                    <div class="relative z-0 mb md:mb-2 group">
                                        <select name="patient_country" id="patient_country" class="bg-white dark:bg-slate-900 block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                                            @foreach ($countries as $key => $item)
                                                <option value="{{$key}}" {{$key == "MX" ? "selected" : ""}} >{{$item}}</option>
                                            @endforeach
                                        </select>
                                        <label for="patient_country" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.country")}}</label>
                                        <small id="patient_country_message" class="text_error pl-2 italic"></small>
                                    </div>
                                </div> 
                                <div class="px-4 md:px-2 col-span-2 md:col-span-1">
                                    <div class="relative z-0 group mb-2">
                                        <select name="bloodType" id="bloodType" class="bg-white dark:bg-slate-900 block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                                            <option value=""></option>
                                            <option value="A+">A+</option>
                                            <option value="A-">A-</option>
                                            <option value="B+">B+</option>
                                            <option value="B-">B-</option>
                                            <option value="AB+">AB+</option>
                                            <option value="AB-">AB-</option>
                                            <option value="O+">O+</option>
                                            <option value="O-">O-</option>
                                        </select> 
                                        <label for="bloodType" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.bloodType")}}</label>
                                        <small id="bloodType_message" class="text_error pl-2 italic"></small>
                                    </div>
                                </div>
                                <div class="px-4 md:px-2 col-span-2 md:col-span-1">
                                    <div class="relative z-0 group mb-2">
                                        <select name="doctor" id="doctor" class="bg-white dark:bg-slate-900 block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                                            <option value=""></option>
                                            @foreach($doctors as $doctor)
                                                <option value="{{$doctor->id}}">{{$doctor->first_name}} {{$doctor->last_name}}</option>
                                            @endforeach
                                        </select> 
                                        <label for="doctor" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.isPatienteFrom")}}</label>
                                        <small id="doctor_message" class="text_error pl-2 italic"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 sm:mx-10 mt-4 hidden" id="doctorTab">
                                <div class="px-4 md:px-2 col-span-2 md:col-span-1">
                                    <div class="relative z-0 group mb-2">
                                        <select name="title" id="title" class="bg-white dark:bg-slate-900 block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                                            <option value=""></option>
                                            <option value="Dr.">Dr.</option>
                                            <option value="Dra.">Dra.</option> 
                                        </select> 
                                        <label for="title" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.title")}}</label>
                                        <small id="title_message" class="text_error pl-2 italic"></small>
                                    </div>
                                </div>  
                                <div class="px-4 md:px-2 col-span-2 md:col-span-1">
                                    <div class="relative z-0 mb-2 group">
                                        <input type="text" autocomplete="off" name="license" id="license" class="block py-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                        <label for="license" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.license")}}</label>
                                        <small id="license_message" class="text_error pl-2 italic"></small>
                                    </div>
                                </div>   
                                <div class="px-4 md:px-2 col-span-2 md:col-span-1">
                                    <div class="relative z-0 mb-2 group">
                                        <input type="text" autocomplete="off" name="timeslot" id="timeslot" class="block py-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                        <label for="timeslot" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.timeslot")}}</label>
                                        <small id="timeslot_message" class="text_error pl-2 italic"></small>
                                    </div>
                                </div>  
                                <div class="px-4 md:px-2 col-span-2">  
                                    <select name="medical_unit[]" id="medical_unit" multiple>
                                        <option value=""></option>
                                        @foreach ($medicalUnits as $key => $item)  
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select> 
                                </div>  
                                <div class="px-4 md:px-2 col-span-2"> 
                                    <select name="specialties[]" id="specialties" multiple>
                                        <option value=""></option>
                                        @foreach ($specialties as $key => $item)  
                                            <option value="{{$item->id}}">{{__("specialties.".$item->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>  
                            </div>
                        </div> 
                        <div class="col-span-2 text-center md:text-right px-4">  
                            <input type="hidden" name="role" id="role" value="3">
                            <button class="text-white bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-800 dark:hover:bg-emerald-900 rounded-md px-10 py-2">{{__("messages.save")}}</button>
                        </div>
                        <div class="col-span-2">
                            <div class="text-center">
                                <hr class="mt-4">
                                <div class="-mt-[14px] mb-6 bg-white w-12 mx-auto font-[500] text-[#666666]">{{__("messages.or")}}</div>
                            </div>
                            <div class="text-center mb-4">
                                <a href="{{$_['baseURL']}}/login" class="my-2 font-[500] text-[#666666] hover:text-[#4D4E8D]">
                                    {{__("messages.login")}}
                                </a>
                            </div> 
                        </div>
                    </div>
                </form> 
            </div> 
        </div> 
    </section>
</main>
 
@stop

@section('scripts')
    <script src="{{ asset('/resources/libs/multiSelectCustom/multiSelect.js') }}"></script> 
    <script>
        const url = baseURL+"{{$_['routes']['auth']['register']}}"; 
        const redirect = baseURL+"/login"; 
        const days   = {!! json_encode($days) !!};
        const months = [];
        const noResults = "{{__('messages.noResults')}}";
        const searchText = "{{__('messages.search')}}"; 

        ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'].forEach(key => {
            months.push(@json($months)[key]);
        });   

        $("#specialties").initMultiSelect({
            inputClass: 'block py-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer',
            optionsContinerClass: 'bg-white dark:bg-slate-900 block w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer', 
            labelText: "{{__('routes.specialties')}}",
            noResults: noResults,
            placeholderSearch: searchText,
        });
        
        $("#medical_unit").initMultiSelect({
            inputClass: 'block py-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer',
            optionsContinerClass: 'bg-white dark:bg-slate-900 block w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer', 
            labelText: "{{__('routes.medical_units')}}",
            noResults: noResults,
            placeholderSearch: searchText,
        });
    </script> 
    <script src="{{ asset('/resources/libs/flowbite/datepicker.min.js') }}"></script> 
    <script src="{{ asset('/resources/js/pages/register.js') }}"></script> 
@stop
 