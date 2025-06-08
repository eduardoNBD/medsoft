@extends('layouts.dashboard',[ 'current_route'  => '/dashboard/appointments'])

@section('title', __($title)." ".$appointment->name) 

@section('styles') 
   <style>
        .datepicker{min-width: 200px; width: 260px;}
        #rowDateTime .datepicker{ width: 100%;}
        .datepicker-picker,.datepicker-picker .days,.datepicker-picker .days-of-week,.datepicker-grid {width: 100% !important}
        .datepicker-picker{box-shadow: 0px 0px 7px 0px #00000055 !important;}
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
                <a href="{{$_['baseURL'].$_['routes']['appointments']['root']}}" class="inline-flex items-center text-sm font-medium breadcrumbs_text">
                    <svg class="w-4 h-4 mr-2.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.5 21h-4.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v3" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h10" /><path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18 16.5v1.5l.5 .5" /></svg>
                    {{__('routes.appointments')}}
                </a>
            </li>
            <li class="inline-flex items-center">
                <svg class="w-4 h-4 inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7l5 5l-5 5" /><path d="M13 7l5 5l-5 5" /></svg>
            </li>
            @if($id)
                <li>
                    <div class="flex items-center"> 
                        <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                        <span class="ms-1 text-sm font-medium text-gray-700 hover:text-[#4D4E8D] md:ms-2 dark:text-gray-400 dark:hover:text-white">{{$appointment->patient->fullName}}</span>
                    </div>
                </li>
            @else 
                <li>
                    <div class="flex items-center"> 
                        <span class="text-sm font-medium breadcrumbs_text">{{__('routes.appointment')}}</span>
                    </div>
                </li>
            @endif
        </ol>
    </nav>
@stop

@section('content') 
    @include('../components/appointment/form')  
@stop 

@section('scripts') 
    <script src="{{ asset('/resources/libs/multiSelectCustom/multiSelect.js') }}"></script> 
    <script>
        const id = "{{$id}}"
        const url = '{{$id ? $_['baseURL']."/appointments/update/".$id : $_['baseURL']."/appointments/create" }}';
        const urlGetAvailable = '{{$_['baseURL']."/appointments/getAvailableTimes/"}}';
        const redirect = '{{$_['baseURL'].$_['routes']['appointments']['root']}}'; 
        const days   = {!! json_encode($days) !!};
        const months = [];
        const noResults = "{{__('messages.noResults')}}";
        const date_after = "{{__('rules.date_after')}}";
        const withoutAppointmentsSearch = "{{__('messages.withoutAppointments')}}";
        let appDate = "{{$appointment->date ? explode(' ',$appointment->date)[0] : ''}}";
        let appHour = "{{$appointment->date ? substr((explode(' ',$appointment->date)[1]),0,5) : ''}}";
        let patients = {!! json_encode($patients) !!};
        let doctors = {!! json_encode($doctors) !!};
        let prices = {!! json_encode($prices) !!}; 
        const appointment = {!! json_encode($appointment) !!}; 
        const doctor = "{{$doctorID}}";
       
        let currentPatient =  "{{$id_patient}}" ? patients.filter(patients => patients.id == "{{$id_patient}}")[0] : {};
        
        ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'].forEach(key => {
            months.push(@json($months)[key]);
        });    

    </script> 
    <script src="{{ asset('/resources/libs/flowbite/datepicker.min.js') }}"></script> 
    <script src="{{ asset('/resources/js/pages/appointment.js') }}"></script>  
    <script src="{{ asset('/resources/js/pages/userAutocomplete.js') }}"></script>  
@stop