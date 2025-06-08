@extends('layouts.dashboard',[ 
    'current_route'  =>  in_array($role,[2,3]) ? ($role == 2 ? "/dashboard/medicals" : "/dashboard/patients") :'/dashboard/users']
)

@section('title', __($title)." ".$user->name) 

@section('styles') 
   <style>
        .multiselect-container {width: 100%;position: relative;} .multiselect-container .search-input {width: 100%;position: relative;}.multiselect-container input[type="checkbox"]{margin-right: 10px;}.options {display: none;border: 1px solid #ccc;max-height: 150px;overflow-y: auto;background-color: white;position: absolute;width: 100%;z-index: 1;margin-top: -20px;border-radius: 0px 10px;padding: 10px;}.options label {display: flex;padding: 5px;cursor: pointer;}.multiselect-container input+label{z-index:50;}
   </style>
@stop

@section('breadcrumbs')
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="{{$_['baseURL'].$_['routes']['dashboard']['root']}}" class="inline-flex items-center text-sm font-medium breadcrumbs_text">
                    <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                    </svg>
                    {{__('routes.dashboard')}}
                </a>
            </li>  
            <li class="inline-flex items-center">
                <svg class="w-4 h-4 inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7l5 5l-5 5" /><path d="M13 7l5 5l-5 5" /></svg>
            </li>
            <li class="inline-flex items-center">
                @if($role == 2)
                    <a href="{{$_['baseURL'].$_['routes']['medicals']['root']}}" class="inline-flex items-center text-sm font-medium breadcrumbs_text">
                        <svg class="w-4 h-4 mr-2.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-96 55.2C54 332.9 0 401.3 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7c0-81-54-149.4-128-171.1l0 50.8c27.6 7.1 48 32.2 48 62l0 40c0 8.8-7.2 16-16 16l-16 0c-8.8 0-16-7.2-16-16s7.2-16 16-16l0-24c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 24c8.8 0 16 7.2 16 16s-7.2 16-16 16l-16 0c-8.8 0-16-7.2-16-16l0-40c0-29.8 20.4-54.9 48-62l0-57.1c-6-.6-12.1-.9-18.3-.9l-91.4 0c-6.2 0-12.3 .3-18.3 .9l0 65.4c23.1 6.9 40 28.3 40 53.7c0 30.9-25.1 56-56 56s-56-25.1-56-56c0-25.4 16.9-46.8 40-53.7l0-59.1zM144 448a24 24 0 1 0 0-48 24 24 0 1 0 0 48z"/></svg>
                        {{__('routes.medical')}}
                    </a>
                @elseif($role == 3)
                    <a href="{{$_['baseURL'].$_['routes']['medicals']['root']}}" class="inline-flex items-center text-sm font-medium breadcrumbs_text">
                        <svg class="w-4 h-4 mr-2.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" fill="currentColor"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M48 0C21.5 0 0 21.5 0 48L0 256l144 0c8.8 0 16 7.2 16 16s-7.2 16-16 16L0 288l0 64 144 0c8.8 0 16 7.2 16 16s-7.2 16-16 16L0 384l0 80c0 26.5 21.5 48 48 48l217.9 0c-6.3-10.2-9.9-22.2-9.9-35.1c0-46.9 25.8-87.8 64-109.2l0-95.9L320 48c0-26.5-21.5-48-48-48L48 0zM152 64l16 0c8.8 0 16 7.2 16 16l0 24 24 0c8.8 0 16 7.2 16 16l0 16c0 8.8-7.2 16-16 16l-24 0 0 24c0 8.8-7.2 16-16 16l-16 0c-8.8 0-16-7.2-16-16l0-24-24 0c-8.8 0-16-7.2-16-16l0-16c0-8.8 7.2-16 16-16l24 0 0-24c0-8.8 7.2-16 16-16zM512 272a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM288 477.1c0 19.3 15.6 34.9 34.9 34.9l218.2 0c19.3 0 34.9-15.6 34.9-34.9c0-51.4-41.7-93.1-93.1-93.1l-101.8 0c-51.4 0-93.1 41.7-93.1 93.1z"/></svg>
                        {{__('routes.patients')}}
                    </a>
                @else
                    <a href="{{$_['baseURL'].$_['routes']['users']['root']}}" class="inline-flex items-center text-sm font-medium breadcrumbs_text">
                        <svg class="w-4 h-4 mr-2.5" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" /><path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M17 10h2a2 2 0 0 1 2 2v1" /><path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M3 13v-1a2 2 0 0 1 2 -2h2" /></svg>
                        {{__('routes.users')}}
                    </a>
                @endif 
            </li> 
            <li class="inline-flex items-center">
                <svg class="w-4 h-4 inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7l5 5l-5 5" /><path d="M13 7l5 5l-5 5" /></svg>
            </li>
            @if($id)
                <li>
                    <div class="flex items-center breadcrumbs_text">
                        @if($user->role == 2) 
                            <svg class="w-4 h-4 mr-2.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-96 55.2C54 332.9 0 401.3 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7c0-81-54-149.4-128-171.1l0 50.8c27.6 7.1 48 32.2 48 62l0 40c0 8.8-7.2 16-16 16l-16 0c-8.8 0-16-7.2-16-16s7.2-16 16-16l0-24c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 24c8.8 0 16 7.2 16 16s-7.2 16-16 16l-16 0c-8.8 0-16-7.2-16-16l0-40c0-29.8 20.4-54.9 48-62l0-57.1c-6-.6-12.1-.9-18.3-.9l-91.4 0c-6.2 0-12.3 .3-18.3 .9l0 65.4c23.1 6.9 40 28.3 40 53.7c0 30.9-25.1 56-56 56s-56-25.1-56-56c0-25.4 16.9-46.8 40-53.7l0-59.1zM144 448a24 24 0 1 0 0-48 24 24 0 1 0 0 48z"/></svg>
                        @elseif($user->role == 3) 
                            <svg class="w-4 h-4 mr-2.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" fill="currentColor"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M48 0C21.5 0 0 21.5 0 48L0 256l144 0c8.8 0 16 7.2 16 16s-7.2 16-16 16L0 288l0 64 144 0c8.8 0 16 7.2 16 16s-7.2 16-16 16L0 384l0 80c0 26.5 21.5 48 48 48l217.9 0c-6.3-10.2-9.9-22.2-9.9-35.1c0-46.9 25.8-87.8 64-109.2l0-95.9L320 48c0-26.5-21.5-48-48-48L48 0zM152 64l16 0c8.8 0 16 7.2 16 16l0 24 24 0c8.8 0 16 7.2 16 16l0 16c0 8.8-7.2 16-16 16l-24 0 0 24c0 8.8-7.2 16-16 16l-16 0c-8.8 0-16-7.2-16-16l0-24-24 0c-8.8 0-16-7.2-16-16l0-16c0-8.8 7.2-16 16-16l24 0 0-24c0-8.8 7.2-16 16-16zM512 272a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM288 477.1c0 19.3 15.6 34.9 34.9 34.9l218.2 0c19.3 0 34.9-15.6 34.9-34.9c0-51.4-41.7-93.1-93.1-93.1l-101.8 0c-51.4 0-93.1 41.7-93.1 93.1z"/></svg>
                        @else
                            <svg class="w-4 h-4 mr-2.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                        @endif
                        <span class="text-sm font-medium">{{$user->first_name}} {{$user->last_name}}</span>
                    </div>
                </li>
            @else 
                <li>
                    <div class="flex items-center breadcrumbs_text">  
                        <span class="ms-1 text-sm font-medium">
                            {{__( in_array($role,[2,3]) ? ($role == 2 ? "routes.medical" : "routes.patient") :'routes.user')}}
                        </span>
                    </div>
                </li>
            @endif
        </ol>
    </nav>
@stop

@section('content') 
    @include('../components/user/form')  
@stop 

@section('scripts') 
    <script src="{{ asset('/resources/libs/multiSelectCustom/multiSelect.js') }}"></script> 
    <script>
        const url = '{{$id ? $_['baseURL']."/users/update/".$id : $_['baseURL']."/users/create" }}'; 
        const days   = {!! json_encode($days) !!};
        const months = [];
        const noResults = "{{__('messages.noResults')}}";
        const searchText = "{{__('messages.search')}}";
        const doctor = "{{$doctorID}}";

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
    <script src="{{ asset('/resources/js/pages/user.js') }}"></script>    
@stop