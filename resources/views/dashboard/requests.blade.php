@extends('layouts.dashboard',[ 'current_route'  => '/dashboard/requests'])

@section('title', __('routes.requests')) 

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
                <a href="{{$_['baseURL'].$_['routes']['requests']['root']}}" class="inline-flex items-center text-sm font-medium breadcrumbs_text">
                    <svg class="w-4 h-4 mr-2.5" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" /><path d="M5 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1z" /><path d="M20 16.5a1.5 1.5 0 0 0 -3 0v3a1.5 1.5 0 0 0 3 0" /><path d="M12.5 15a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1 -3 0v-3a1.5 1.5 0 0 1 1.5 -1.5z" /></svg>
                    {{__('routes.requests')}}
                </a>
            </li> 
        </ol>
    </nav>
@stop

@section('styles') 
@stop

@section('content')
    <section class="mx-2 md:m-4">
        <div class="mx-auto px-2"> 
            @include('../components/request/table')
        </div>
    </section> 
    <div id="deleteModal" tabindex="-1" class="hidden flex bg-[#0000006b] overflow-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg_modal rounded-lg shadow">
                <button onclick="closeModal('#deleteModal')" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="deleteModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal title_text">{{__("messages.certificateRequestDeleteAsk")}}</h3> 
                    <div class="w-full p-4">   
                        <div class="relative z-0 mb-2 group text-left">
                            <textarea autocomplete="off" row="1" name="cancellation_reason" id="cancellation_reason" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" ></textarea>
                            <label for="cancellation_reason" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.reasonCancel")}}</label>
                            <small id="cancellation_reason_message" class="text_error pl-2 italic"></small>
                        </div>
                    </div> 
                    <button  onclick="confirmDelete()" data-modal-hide="deleteModal" type="button" class="button_error focus:ring-4 focus:outline-none font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        {{__("messages.yes")}}
                    </button>
                    <button onclick="closeModal('#deleteModal')" data-modal-hide="deleteModal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium inverted button_regular focus:outline-none rounded-lg border focus:z-10 focus:ring-4">{{__("messages.no")}}, {{__("messages.cancel")}}</button>
                </div>
            </div>
        </div>
    </div>  
    <div id="detailModal" tabindex="-1" class="hidden flex bg-[#0000006b] overflow-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg_modal rounded-lg shadow">
                <button onclick="closeModal('#detailModal')" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="detailModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 mt-2 text-center">
                    <div class="modal-body mt-4">
                        <h2 class="title_text text-2xl">{{__("routes.request")}}</h2> 
                        <hr class="mt-2 mb-4"> 
                        <div class="grid grid-cols-2 paragraph_text">
                            <div>
                                <small><i>{{__("routes.patient")}}</i></small>
                                <p id="patientText"></p>
                            </div>
                            <div>
                                <small><i>{{__("routes.medical")}}</i></small>
                                <p id="doctorText"></p>
                            </div>
                            <div class="col-span-2 text-center"> 
                                <small><i>{{__("messages.type")}}</i></small>
                                <p id="typeText"></p>
                            </div>
                        </div> 
                        <hr class="mt-2 mb-4">  
                        <h2 class="paragraph_text text-md mt-4 mb-4" id="titleDetail">{{__("messages.detail")}}</h2>
                        <div class="paragraph_text text-left">
                            <div class="pt-2">
                                <hr class="mb-2">
                                <small>{{__("messages.notes")}}</small>
                                <div class="text-muted pl-2 mb-2" id="notesText"></div>
                                <hr>
                            </div>
                            <div class="hidden pt-2" id="cancelRow">
                                <small>{{__("messages.reasonCancel")}}</small>
                                <div class="text-muted pl-2 mb-2" id="cancelText"></div>
                                <hr>
                            </div>
                            <div class="hidden pt-2" id="downloadRow">
                                 
                            </div> 
                            <div class="hidden pt-2" id="generateRow">

                            </div>
                        </div>
                    </div>
                </div>
            </div>        
        </div>
    </div>   
@stop

@section('scripts')
    <script> 
        const url = '{{$_['baseURL']."/requests/list?page="}}'; 
        const urlDel = '{{$_['baseURL']."/requests/delete/"}}';   
        const certificatedURL = "{{$_['baseURL'].$_['routes']['certificates']['new']}}/"; 
        const detailText = "{{__('messages.detail')}}";
        const editText = "{{__('messages.generate')}}";   
        const restoreText = "{{__('messages.restore')}}";
        const deleteText = "{{__('messages.refuse')}}"; 
        const generateText = "{{__('messages.generated')}}";  
        const deletedText = "{{__('messages.refuse_his')}}";  
        let currentPage = {{$page}}; 
        const msg = "{{isset($_GET['msg']) ? $_GET['msg'] : ""}}";
        const currentURL = "{{$_['baseURL'].$_['routes']['requests']['root']}}/";  
        const withoutRequestsSearch = "{{__('messages.withoutCertificateRequest')}}";
        const urlContent = '{{$_['baseURL']."/certificates/getContent/"}}'; 
        const downloadText = "{{__('messages.download')}}";   
        const types = {
            "1": '{{__("messages.medicalCertificate")}}',
            "2": '{{__("messages.certificate")}}',
            "3": '{{__("messages.recipe")}}'
        };

        if(msg){
            createAlert(...msg.split("_"));
            window.history.pushState({}, title, currentURL);
        } 

        if({!! json_encode($request) !!}){ 
            $("#simple-search").value = "{{$request_id}}"; 
        }
    </script>  
    <script src="{{ asset('/resources/js/pages/requests.js') }}"></script> 
    <script>
        if({!! json_encode($request) !!}){
            detailRequests({!! json_encode($request) !!}); 
        }
    </script>
@stop