@extends('layouts.dashboard',[ 'current_route'  => '/dashboard/profile'])

@section('title', __("messages.profile")." ".Auth::user()->first_name." ".Auth::user()->last_name) 

@section('styles') 
   <style>.multiselect-container {width: 100%;position: relative;}.multiselect-container .search-input {width: 100%;position: relative;}.multiselect-container input[type="checkbox"]{margin-right: 10px;}.options {display: none;border: 1px solid #ccc;max-height: 150px;overflow-y: auto;background-color: white;position: absolute;width: 100%;z-index: 60;margin-top: -20px;border-radius: 0px 10px;padding: 10px;}.options label {display: flex;padding: 5px;cursor: pointer;}.multiselect-container input+label{z-index:50;}</style>
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
                <span class="inline-flex items-center text-sm font-medium breadcrumbs_text">
                    <svg class="w-4 h-4 mr-2.5" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24" viewBox="0 0 24 24" fill="currentColor" class="mr-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 2a5 5 0 1 1 -5 5l.005 -.217a5 5 0 0 1 4.995 -4.783z"></path><path d="M14 14a5 5 0 0 1 5 5v1a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-1a5 5 0 0 1 5 -5h4z"></path></svg>
                    {{__('routes.profile')}}
                </spana> 
            </li>   
        </ol>
    </nav>
@stop

@section('content') 
    @include('../components/user/profile')  
@stop 

@section('scripts') 
    <script src="{{ asset('/resources/libs/multiSelectCustom/multiSelect.js') }}"></script> 
    <script>
        const url = '{{$_['baseURL']."/users/update/updateProfile" }}'; 
        const urlDesAuth = '{{$_['baseURL']."/users/update/credentials" }}'; 
        const urlProfile = '{{$_['baseURL']."/users/updateProfile" }}'; 
        const urlPassword = '{{$_['baseURL']."/users/updatePassword" }}'; 
        const urlLogoImage = '{{$_['baseURL']."/users/updateProfilePhoto" }}'; 
        const urlProfileDoctor = '{{$_['baseURL']."/users/updateProfileDoctor" }}'; 
        const urlSchedules = '{{$_['baseURL']."/users/updateSchedules" }}'; 
        const days   = {!! json_encode($days) !!};
        const months = [];
        const noResults = "{{__('messages.noResults')}}";
        const searchText = "{{__('messages.search')}}";
        const doctor = "{{$doctorID}}";
        const currentURL = "{{$_['baseURL'].$_['routes']['profile']}}/";
        const msg = "{{isset($_GET['msg']) ? $_GET['msg'] : ""}}";
        
        ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'].forEach(key => {
            months.push(@json($months)[key]);
        });   

        if(msg){
            createAlert(...msg.split("_"));
            window.history.pushState({}, title, currentURL);
        }
        if($("#specialties")){
            $("#specialties").initMultiSelect({
                inputClass: 'block py-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer',
                optionsContinerClass: 'bg-white dark:bg-slate-900 block w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer', 
                labelText: "{{__('routes.specialties')}}",
                noResults: noResults,
                placeholderSearch: searchText,
            });
        }
        if($("#medical_unit")){
            $("#medical_unit").initMultiSelect({
                inputClass: 'block py-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer',
                optionsContinerClass: 'bg-white dark:bg-slate-900 block w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer', 
                labelText: "{{__('routes.medical_units')}}",
                noResults: noResults,
                placeholderSearch: searchText,
            });
        }
    </script> 
    <script src="{{ asset('/resources/libs/flowbite/datepicker.min.js') }}"></script> 
    <script src="{{ asset('/resources/js/pages/profile.js') }}"></script>    
@stop