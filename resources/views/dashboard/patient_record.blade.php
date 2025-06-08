@extends('layouts.dashboard',[ 'current_route'  => '/dashboard/patients'])

@section('title', __('messages.record')) 

@section('breadcrumbs')
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="{{$_['baseURL'].$_['routes']['dashboard']['root']}}" class="inline-flex items-center text-sm font-medium breadcrumbs_text">
                    <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                    </svg>
                    {{__('routes.dashboard')}}
                </a>
            </li> 
            <li class="inline-flex items-center">
                <svg class="w-4 h-4 inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7l5 5l-5 5" /><path d="M13 7l5 5l-5 5" /></svg>
            </li>
            <li class="inline-flex items-center">
                <a href="{{$_['baseURL'].$_['routes']['patients']['root']}}" class="inline-flex items-center text-sm font-medium breadcrumbs_text">
                    <svg class="w-4 h-4 mx-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" fill="currentColor"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M48 0C21.5 0 0 21.5 0 48L0 256l144 0c8.8 0 16 7.2 16 16s-7.2 16-16 16L0 288l0 64 144 0c8.8 0 16 7.2 16 16s-7.2 16-16 16L0 384l0 80c0 26.5 21.5 48 48 48l217.9 0c-6.3-10.2-9.9-22.2-9.9-35.1c0-46.9 25.8-87.8 64-109.2l0-95.9L320 48c0-26.5-21.5-48-48-48L48 0zM152 64l16 0c8.8 0 16 7.2 16 16l0 24 24 0c8.8 0 16 7.2 16 16l0 16c0 8.8-7.2 16-16 16l-24 0 0 24c0 8.8-7.2 16-16 16l-16 0c-8.8 0-16-7.2-16-16l0-24-24 0c-8.8 0-16-7.2-16-16l0-16c0-8.8 7.2-16 16-16l24 0 0-24c0-8.8 7.2-16 16-16zM512 272a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM288 477.1c0 19.3 15.6 34.9 34.9 34.9l218.2 0c19.3 0 34.9-15.6 34.9-34.9c0-51.4-41.7-93.1-93.1-93.1l-101.8 0c-51.4 0-93.1 41.7-93.1 93.1z"/></svg>
                    {{__('routes.patients')}}
                </a>
            </li> 
            <li class="inline-flex items-center">
                <svg class="w-4 h-4 inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7l5 5l-5 5" /><path d="M13 7l5 5l-5 5" /></svg>
            </li>
            <li class="inline-flex items-center">
                <span class="text-sm font-medium breadcrumbs_text">{{__('messages.record')}}</span>
            </li> 
        </ol>
    </nav>
@stop

@section('styles')  
@stop

@section('content') 
    @include('../components/patient/record')  
@stop

@section('scripts')      
    <script> 
        const url = '{{$_['baseURL']."/patient/update_record/".$patient->medical_histories->id }}'; 
        const redirect = "{{$_['baseURL'].$_['routes']['patients']['record']($id)}}"; 
        const days   = {!! json_encode($days) !!};
        const months = [];
        const msg = "{{isset($_GET['msg']) ? $_GET['msg'] : ""}}";
        const currentURL = "{{$_['baseURL'].$_['routes']['patients']['record']($id)}}"; 
        const gender = "{{$patient->user->gender}}";
        if(msg){
            createAlert(...msg.split("_"));
            window.history.pushState({}, title, currentURL);
        }
        
        ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'].forEach(key => {
            months.push(@json($months)[key]);
        });   

    </script>
    <script src="{{ asset('/resources/libs/flowbite/datepicker.min.js') }}"></script> 
    <script src="{{ asset('/resources/js/pages/patient_record.js') }}"></script> 
@stop