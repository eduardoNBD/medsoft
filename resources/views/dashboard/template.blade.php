@extends('layouts.dashboard',[ 'current_route'  => '/dashboard/templates'])

@section('title', __($title)." ".$template->name) 

@section('styles') 
    <link rel="stylesheet" href="{{ asset('/resources/libs/richtexteditor/rte_theme_default.css') }}" /> 
@stop

@section('breadcrumbs')
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="{{$_['baseURL'].$_['routes']['dashboard']['root']}}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-[#4D4E8D] dark:text-gray-400 dark:hover:text-white">
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
                <a href="{{$_['baseURL'].$_['routes']['users']['root']}}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <svg class="w-4 h-4 mr-2.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M14 3v4a1 1 0 0 0 1 1h4"></path><path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4"></path><path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6"></path><path d="M17 18h2"></path><path d="M20 15h-3v6"></path><path d="M11 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1z"></path></svg>
                    {{__('routes.templates')}}
                </a>
            </li>
            <li class="inline-flex items-center">
                <svg class="w-4 h-4 inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7l5 5l-5 5" /><path d="M13 7l5 5l-5 5" /></svg>
            </li>
            @if($id)
                <li>
                    <div class="flex items-center">
                        <span class="ms-1 text-sm font-medium text-gray-700 hover:text-[#4D4E8D] md:ms-2 dark:text-gray-400 dark:hover:text-white">{{$supply->name}}</span>
                    </div>
                </li>
            @else 
                <li>
                    <div class="flex items-center"> 
                        <span class="ms-1 text-sm font-medium text-gray-700 hover:text-[#4D4E8D] md:ms-2 dark:text-gray-400 dark:hover:text-white">{{__('routes.template')}}</span>
                    </div>
                </li>
            @endif
        </ol>
    </nav>
@stop

@section('content') 
    @include('../components/template/form')  
@stop 

@section('scripts')  
    <script type="text/javascript" src="{{ asset('/resources/libs/richtexteditor/rte.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/resources/libs/richtexteditor/plugins/all_plugins.js') }}"></script> 
    @if(app()->getLocale() == "en")
        <script type="text/javascript" src="{{ asset('/resources/libs/richtexteditor/lang/rte-lang.js') }}"></script> 
    @else 
        <script type="text/javascript" src="{{ asset('/resources/libs/richtexteditor/lang/rte-lang-'.app()->getLocale().'.js') }}"></script> 
    @endif 
    <script>
        const url = '{{$id ? $_['baseURL']."/supplies/update/".$id : $_['baseURL']."/supplies/create" }}'; 
        const redirect = '{{$_['baseURL'].$_['routes']['supplies']['root']}}'; 
        const days   = {!! json_encode($days) !!};
        const months = [];
        
        ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'].forEach(key => {
            months.push(@json($months)[key]);
        }); 


        const editors = [
            { container: '#headerEditor', textarea: '#header' },
            { container: '#contentEditor', textarea: '#body' },
            { container: '#footerEditor', textarea: '#footer' },
        ];

        const Instances = editors.map((editor) => {  
            return new RichTextEditor(editor.container);;
        });
          
        $("rte-powerby").forEach(element => {
            element.style.display = "none";
        });
    </script>  
@stop