@extends('layouts.dashboard',[ 'current_route'  => '/dashboard'])

@section('title', __('routes.dashboard')) 

@section('styles')
    <style> 
        .highcharts-data-table{
            
            padding:10px;
        }
        .highcharts-data-table table{
            width:50%; 
            margin:auto;
            border: 1px solid;
            outline: none;
            border-radius: 10px;
        }
        .dark .highcharts-data-table,
        .dark .highcharts-data-table table, 
        .dark .highcharts-table-caption{
            color: white;
        }
        .highcharts-number{
            text-align: center;
        }
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
        </ol>
    </nav>
@stop

@section('content') 
    <div class="grid gap-3 grid-cols-12 px-4 mb-4"> 
        @if(Auth::user()->role == 1 || Auth::user()->role == 2) 
            <section class="col-span-12 md:col-span-4">
                @include('../components/textContent', [
                    'color' => 'bg-emerald-500 dark:bg-green-700',
                    'colorText' => 'text-gray-200',
                    'title' => "<div>".__("messages.totalAppointments")."</div><div>".date("d/m/Y")."</div>",
                    'subtitle' => $totalApp ?? 0,
                    'url' => $_['baseURL'].$_['routes']['appointments']['root'],
                    'icon' =>
                        '<span class="absolute bottom-[-2px] right-[-6px]"> 
                            <svg class="text-emerald-400 dark:text-green-600" xmlns="http://www.w3.org/2000/svg"  width="80"  height="80"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1.4"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.5 21h-4.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v3" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h10" /><path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18 16.5v1.5l.5 .5" /></svg>
                        </span>',
                ])
            </section> 
        @endif
        @if(Auth::user()->role == 1 || Auth::user()->role == 2) 
            <section class="col-span-12 md:col-span-4">
                @include('../components/textContent', [
                    'color' => 'bg-rose-500 dark:bg-red-700',
                    'colorText' => 'text-gray-200',
                    'title' => "<div>".__("messages.pendingAppointments")."</div><div>".date("d/m/Y")."</div>",
                    'subtitle' => $pendingApp ?? 0, 
                    'url' => $_['baseURL'].$_['routes']['appointments']['root'],
                    'icon' =>
                        '<span class="absolute bottom-[-2px] right-[-6px]"> 
                            <svg class="text-rose-400 dark:text-red-600" xmlns="http://www.w3.org/2000/svg"  width="80"  height="80"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M17 13v4h4" /><path d="M12 3v4a1 1 0 0 0 1 1h4" /><path d="M11.5 21h-6.5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v2m0 3v4" /></svg>
                        </span>',
                ])
            </section>  
        @endif 
        @if(Auth::user()->role == 1 || Auth::user()->role == 2) 
            <section class="col-span-12 md:col-span-4">
                @include('../components/textContent', [
                    'color' => 'bg-sky-500 dark:bg-blue-700',
                    'colorText' => 'text-gray-200',
                    'title' => "<div>".__("messages.attendedAppointments")."</div><div>".date("d/m/Y")."</div>",
                    'subtitle' => $completeApp ?? 0,
                    'url' => $_['baseURL'].$_['routes']['appointments']['root'],
                    'icon' =>
                        '<span class="absolute bottom-[-2px] right-[-6px]"> 
                            <svg class="text-sky-400 dark:text-blue-600" xmlns="http://www.w3.org/2000/svg"  width="80"  height="80"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11.5 17h-7.5a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3c.016 .129 .037 .256 .065 .382" /><path d="M9 17v1a3 3 0 0 0 2.502 2.959" /><path d="M15 19l2 2l4 -4" /></svg>
                        </span>',
                ])
            </section>  
        @endif
        @if(Auth::user()->role == 2) 
            <div class="hidden md:inline md:col-span-1"><span></span></div>
        @endif
        <section class="col-span-6 sm:col-span-4 md:col-span-2">
            <a href="{{$_['baseURL'].$_['routes']['patients']['root']}}">
                <div class="shadow-lg px-4 py-6 flex flex-col items-center justify-center rounded-lg button_primary"> 
                    <svg class="flex-shrink-0 w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" fill="currentColor"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M48 0C21.5 0 0 21.5 0 48L0 256l144 0c8.8 0 16 7.2 16 16s-7.2 16-16 16L0 288l0 64 144 0c8.8 0 16 7.2 16 16s-7.2 16-16 16L0 384l0 80c0 26.5 21.5 48 48 48l217.9 0c-6.3-10.2-9.9-22.2-9.9-35.1c0-46.9 25.8-87.8 64-109.2l0-95.9L320 48c0-26.5-21.5-48-48-48L48 0zM152 64l16 0c8.8 0 16 7.2 16 16l0 24 24 0c8.8 0 16 7.2 16 16l0 16c0 8.8-7.2 16-16 16l-24 0 0 24c0 8.8-7.2 16-16 16l-16 0c-8.8 0-16-7.2-16-16l0-24-24 0c-8.8 0-16-7.2-16-16l0-16c0-8.8 7.2-16 16-16l24 0 0-24c0-8.8 7.2-16 16-16zM512 272a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM288 477.1c0 19.3 15.6 34.9 34.9 34.9l218.2 0c19.3 0 34.9-15.6 34.9-34.9c0-51.4-41.7-93.1-93.1-93.1l-101.8 0c-51.4 0-93.1 41.7-93.1 93.1z"></path></svg>
                    {{__("routes.patients")}}
                    <strong>{{$tPatients}}</strong>
                </div>
            </a>
        </section>
        @if(Auth::user()->role == 1) 
            <section class="col-span-6 sm:col-span-4 md:col-span-2">
                <a href="{{$_['baseURL'].$_['routes']['medicals']['root']}}">
                    <div class="shadow-lg px-4 py-6 flex flex-col items-center justify-center rounded-lg button_secondary"> 
                        <svg class="flex-shrink-0 w-8 h-8"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-96 55.2C54 332.9 0 401.3 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7c0-81-54-149.4-128-171.1l0 50.8c27.6 7.1 48 32.2 48 62l0 40c0 8.8-7.2 16-16 16l-16 0c-8.8 0-16-7.2-16-16s7.2-16 16-16l0-24c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 24c8.8 0 16 7.2 16 16s-7.2 16-16 16l-16 0c-8.8 0-16-7.2-16-16l0-40c0-29.8 20.4-54.9 48-62l0-57.1c-6-.6-12.1-.9-18.3-.9l-91.4 0c-6.2 0-12.3 .3-18.3 .9l0 65.4c23.1 6.9 40 28.3 40 53.7c0 30.9-25.1 56-56 56s-56-25.1-56-56c0-25.4 16.9-46.8 40-53.7l0-59.1zM144 448a24 24 0 1 0 0-48 24 24 0 1 0 0 48z"></path></svg>
                        {{__("routes.medicals")}}
                        <strong>{{$tDoctors}}</strong>
                    </div>
                </a>
            </section>
        @endif
        <section class="col-span-6 sm:col-span-4 md:col-span-2">
            <a href="{{$_['baseURL'].$_['routes']['supplies']['root']}}">
                <div class="shadow-lg px-4 py-6 flex flex-col items-center justify-center rounded-lg button_error"> 
                    <svg class="flex-shrink-0 w-8 h-8" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9 3m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v1a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z"></path><path d="M10 6v.98c0 .877 -.634 1.626 -1.5 1.77c-.866 .144 -1.5 .893 -1.5 1.77v8.48a2 2 0 0 0 2 2h6a2 2 0 0 0 2 -2v-8.48c0 -.877 -.634 -1.626 -1.5 -1.77a1.795 1.795 0 0 1 -1.5 -1.77v-.98"></path><path d="M7 12h10"></path><path d="M7 18h10"></path><path d="M11 15h2"></path></svg>
                    {{__("routes.supplies")}}
                    <strong>{{$tSupplies}}</strong>
                </div>
            </a>
        </section>
        <section class="col-span-6 sm:col-span-4 md:col-span-2">
            <a href="{{$_['baseURL'].$_['routes']['services']['root']}}">
                <div class="shadow-lg px-4 py-6 flex flex-col items-center justify-center rounded-lg button_success"> 
                    <svg class="flex-shrink-0 w-8 h-8" width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h-1a2 2 0 0 0 -2 2v3.5h0a5.5 5.5 0 0 0 11 0v-3.5a2 2 0 0 0 -2 -2h-1" /><path d="M8 15a6 6 0 1 0 12 0v-3" /><path d="M11 3v2" /><path d="M6 3v2" /><path d="M20 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /></svg>
                    {{__("routes.services")}}
                    <strong>{{$tServices}}</strong>
                </div>
            </a>
        </section>
        @if(Auth::user()->role == 2) 
            <div class="inline md:hidden col-span-2"><span></span></div>
        @endif
        <section class="col-span-6 sm:col-span-4 md:col-span-2">
            <a href="{{$_['baseURL'].$_['routes']['appointments']['root']}}">
                <div class="shadow-lg px-4 py-6 flex flex-col items-center justify-center rounded-lg button_regular"> 
                    <svg class="flex-shrink-0 w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10.5 21h-4.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v3"></path><path d="M16 3v4"></path><path d="M8 3v4"></path><path d="M4 11h10"></path><path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path><path d="M18 16.5v1.5l.5 .5"></path></svg>
                    {{__("routes.appointments")}}
                    <strong>{{$tAppointment}}</strong>
                </div>
            </a>
        </section>
        <section class="col-span-6 sm:col-span-4 md:col-span-2"> 
            <a href="{{$_['baseURL'].$_['routes']['encounters']['root']}}">
                <div class="shadow-lg px-4 py-6 flex flex-col items-center justify-center rounded-lg button_warning"> 
                    <svg class="flex-shrink-0 w-8 h-8 text_regular" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path><path d="M10 14h4"></path><path d="M12 12v4"></path></svg>
                    <span class="text_regular">{{__("routes.encounters")}}</span>
                    <strong class="text_regular">{{$tEncounters}}</strong>
                </div>
            </a>
        </section>
        @if(Auth::user()->role == 1 || Auth::user()->role == 2) 
            <section class="col-span-12 md:col-span-6">
                @include('components.genericTable', [
                    'headers' => [
                                    __("messages.name") => '',
                                    __("messages.contact")=> 'hidden md:table-cell',
                                    __('messages.dob') => 'hidden md:table-cell',
                                    __("messages.created_at") => ''],
                    'classTd' => [
                                    'fullname' => '',
                                    'email' => 'text-center hidden md:table-cell',
                                    'dob' => 'text-center hidden md:table-cell',
                                    'created_at' => ''],
                    'rows' => $patients,
                    'noData' => __("messages.noResults"),
                    'title' => __("messages.latestPatient")
                ])
            </section>
        @endif
        @if(Auth::user()->role == 1)
            <section class="col-span-12 md:col-span-6">
                @include('components.genericTable', [
                    'headers' => [
                                    __("messages.name") => '',
                                    __("messages.contact")=> 'hidden md:table-cell',
                                    __('messages.license') => 'hidden md:table-cell',
                                    __("messages.created_at") => ''],
                    'classTd' => [
                                    'fullname' => '',
                                    'email' => 'text-center hidden md:table-cell',
                                    'license' => 'text-center hidden md:table-cell',
                                    'created_at' => ''],
                    'rows' => $doctors,
                    'noData' => __("messages.noResults"),
                    'title' => __("messages.latestDoctor")
                ])
            </section>
        @endif
    </div>   
@stop

@section('scripts')
   
@stop