@extends('layouts.dashboard',[ 'current_route'  => '/dashboard/certificates'])

@section('title', __('routes.certificate')) 

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
                <a href="{{$_['baseURL'].$_['routes']['certificates']['root']}}" class="inline-flex items-center text-sm font-medium breadcrumbs_text">
                    <svg class="w-4 h-4 mx-1" xmlns="http://www.w3.org/2000/svg"viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M17 20h-11a3 3 0 0 1 0 -6h11a3 3 0 0 0 0 6h1a3 3 0 0 0 3 -3v-11a2 2 0 0 0 -2 -2h-10a2 2 0 0 0 -2 2v8"></path></svg>
                    {{__('routes.certificates')}}
                </a>
            </li> 
            <li class="inline-flex items-center">
                <svg class="w-4 h-4 inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7l5 5l-5 5" /><path d="M13 7l5 5l-5 5" /></svg>
            </li>
            <li class="inline-flex items-center">
                <span class="text-sm font-medium breadcrumbs_text">{{__('routes.certificate')}}</span>
            </li> 
        </ol>
    </nav>
@stop

@section('styles')  
    <link rel="stylesheet" href="{{ asset('/resources/libs/richtexteditor/rte_theme_default.css') }}" /> 
@stop

@section('content') 
    @include('../components/certificate/form')   
@stop
 
@section('scripts')   
    <script type="text/javascript" src="{{ asset('/resources/libs/richtexteditor/rte.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/resources/libs/richtexteditor/plugins/all_plugins.js') }}"></script> 
    @if(app()->getLocale() == "en")
        <script type="text/javascript" src="{{ asset('/resources/libs/richtexteditor/lang/rte-lang.js') }}"></script> 
    @else 
        <script type="text/javascript" src="{{ asset('/resources/libs/richtexteditor/lang/rte-lang-'.app()->getLocale().'.js') }}"></script> 
    @endif 
    <script src="{{ asset('/resources/libs/jsPDF/jspdf.umd.min.js') }}"></script>    
    <script>    
        const url = '{{$id ? $_['baseURL']."/certificates/update/".$id : $_['baseURL']."/certificates/create" }}'; 
        const urlGet = '{{$_['baseURL']."/medicals/getData/"}}'; 
        const redirect = '{{$_['baseURL'].$_['routes']['certificates']['root']}}'; 
        const content = `{!!$certificate->content!!}`.replaceAll("&lt;",'<').replaceAll("&gt;",'>');
        let patient = '{{$certificate->patient_id}}';
        let medical_unit = '{{$certificate->medical_unit_id}}';
        const days   = {!! json_encode($days) !!};
        const months = [];
        
        const editor = new RichTextEditor('#contentEditor', {toolbar :"basic"});

        if(content){
            editor.setHTMLCode(content);
        }
          
        $("rte-powerby").style.display = "none";

        ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'].forEach(key => {
            months.push(@json($months)[key]);
        });    
    </script> 
    <script src="{{ asset('/resources/libs/flowbite/datepicker.min.js') }}"></script> 
    <script src="{{ asset('/resources/js/pages/certificate.js') }}"></script>
@stop