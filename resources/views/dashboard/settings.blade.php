@extends('layouts.dashboard',[ 'current_route'  => '/dashboard/settings'])

@section('title', __('routes.settings')) 

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
                <div class="inline-flex items-center text-sm font-medium breadcrumbs_text">
                    <svg class="w-4 h-4 mr-2.5"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 6m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M4 6l8 0" /><path d="M16 6l4 0" /><path d="M8 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M4 12l2 0" /><path d="M10 12l10 0" /><path d="M17 18m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M4 18l11 0" /><path d="M19 18l1 0" /></svg>
                    {{__('routes.settings')}}
                </div>
            </li> 
        </ol>
    </nav>
@stop

@section('styles') 
    <link rel="stylesheet" href="{{ asset('/resources/css/colorpicker.css') }}">
@stop

@section('content')
    <section class="mx-2 md:m-4">
        <div class="mx-auto px-2"> 
            @include('../components/setting/tabs')
        </div>
    </section>  
@stop

@section('scripts')
    <script> 
        const urlPrices = '{{$_['baseURL']."/setting/save/prices"}}'; 
        const urlSpecialties = '{{$_['baseURL']."/setting/save/specialties"}}'; 
        const urlColors = '{{$_['baseURL']."/setting/save/colors"}}';
        const urlLogos = '{{$_['baseURL']."/setting/save/logos"}}';
        const days    = {!! json_encode($days) !!};
        const months  = [];  
        const languages = {!! json_encode($languages) !!};
        const nameText  = '{{__("messages.name")}}';
        const priceText = '{{__("messages.price")}}';
        const timeText = '{{__("messages.time")}}';
        const currentLogos  = {!! json_encode($logos) !!};

        ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'].forEach(key => {
            months.push(@json($months)[key]);
        }); 
    </script>
    <script src="{{ asset('/resources/js/pages/settings.js') }}"></script> 
@stop