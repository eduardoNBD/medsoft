@extends('layouts.dashboard',[ 'current_route'  => '/dashboard/users'])

@section('title', __('routes.users')) 

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
                <a href="{{$_['baseURL'].$_['routes']['users']['root']}}" class="inline-flex items-center text-sm font-medium breadcrumbs_text">
                    <svg class="w-4 h-4 mr-2.5" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" /><path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M17 10h2a2 2 0 0 1 2 2v1" /><path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M3 13v-1a2 2 0 0 1 2 -2h2" /></svg>
                    {{__('routes.users')}}
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
            @include('../components/user/table')
        </div>
    </section> 
    <div id="deleteModal" tabindex="-1" class="hidden flex bg-[#0000006b] overflow-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
             <div class="relative bg_modal rounded-lg shadow ">
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
                     <h3 class="mb-5 text-lg font-normal title_text">{{__("messages.userDeleteAsk")}}</h3>
                    <button  onclick="confirmDelete()" data-modal-hide="deleteModal" type="button" class="button_error focus:ring-4 focus:outline-none font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        {{__("messages.yes")}}
                    </button>
                    <button onclick="closeModal('#deleteModal')" data-modal-hide="deleteModal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium inverted button_regular focus:outline-none rounded-lg border focus:z-10 focus:ring-4 ">{{__("messages.no")}}, {{__("messages.cancel")}}</button>
                </div>
            </div>
        </div>
    </div>
    <div id="restoreModal" tabindex="-1" class="hidden flex bg-[#0000006b] overflow-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
             <div class="relative bg_modal rounded-lg shadow ">
                <button onclick="closeModal('#restoreModal')" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="restoreModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                     <h3 class="mb-5 text-lg font-normal title_text">{{__("messages.userRestoreAsk")}}</h3>
                    <button  onclick="confirmRestore()" data-modal-hide="restoreModal" type="button" class="button_success focus:ring-4 focus:outline-none font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        {{__("messages.yes")}}
                    </button>
                    <button onclick="closeModal('#restoreModal')" data-modal-hide="restoreModal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium inverted button_regular focus:outline-none rounded-lg border focus:z-10 focus:ring-4 ">{{__("messages.no")}}, {{__("messages.cancel")}}</button>
                </div>
            </div>
        </div>
    </div>
    <div id="changePassword" tabindex="-1" class="hidden flex bg-[#0000006b] overflow-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
             <div class="relative bg_modal rounded-lg shadow ">
                <button onclick="closeModal('#changePassword')" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="changePassword">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-16 h-16" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" /><path d="M8 11v-4a4 4 0 1 1 8 0v4" /><path d="M15 16h.01" /><path d="M12.01 16h.01" /><path d="M9.02 16h.01" /></svg>
                    <div class="col-span-6 md:col-span-4 text-left">
                        <div class="px-2 col-span-2 md:col-span-1 mb-2">
                            <div class="col-span-2 md:col-span-1 flex items-center">
                                <div class="relative z-10 group w-full ">
                                    <input autocomplete="off" type="password" name="new_password" id="new_password" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                                    <label for="new_password" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.newPassword")}}</label>
                                </div>
                                <button type="button" onclick="seePasswordInput($('#new_password'),this)" class="-ml-8 -mb-[5px] text-sm font-medium focus:outline-none z-20 button_secondary p-2 rounded-sm" title="{{__("messages.addType")}}">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  class="h-4 w-4" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                </button> 
                                <button type="button" onclick="hidePasswordInput($('#new_password'),this)" class="hidden -ml-8 -mb-[5px] text-sm font-medium focus:outline-none z-20 button_secondary p-2 rounded-sm" title="{{__("messages.addType")}}">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  class="h-4 w-4" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye-off"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" /><path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" /><path d="M3 3l18 18" /></svg>
                                </button> 
                            </div> 
                            <small id="new_password_message" class="text_error pl-2 italic"></small>
                        </div>  
                        <div class="px-2 col-span-2 md:col-span-1">
                            <div class="col-span-2 md:col-span-1 flex items-center">
                                <div class="relative z-10 group w-full">
                                    <input autocomplete="off" type="password" name="new_password_confirmation" id="new_password_confirmation" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                                    <label for="new_password_confirmation" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.newPassword_confirmation")}}</label>
                                </div>
                                <button type="button" onclick="seePasswordInput($('#new_password_confirmation'),this)" class="-ml-8 -mb-[5px] text-sm font-medium focus:outline-none z-20 button_secondary p-2 rounded-sm" title="{{__("messages.addType")}}">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  class="h-4 w-4" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                </button> 
                                <button type="button" onclick="hidePasswordInput($('#new_password_confirmation'),this)" class="hidden -ml-8 -mb-[5px] text-sm font-medium focus:outline-none z-20 button_secondary p-2 rounded-sm" title="{{__("messages.addType")}}">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  class="h-4 w-4" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye-off"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" /><path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" /><path d="M3 3l18 18" /></svg>
                                </button> 
                            </div> 
                            <small id="new_password_confirmation_message" class="text_error pl-2 italic"></small>
                        </div>  
                    </div>
                    <button  onclick="confirmChangePassword()" data-modal-hide="changePassword" type="button" class="button_success focus:ring-4 focus:outline-none font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center my-4">
                        {{__("messages.changePassword")}}
                    </button> 
                </div>
            </div>
        </div>
    </div>
    <div id="detailUser" tabindex="-1" class="hidden flex bg-[#0000006b] overflow-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
             <div class="relative bg_modal rounded-lg shadow ">
                <button onclick="closeModal('#detailUser')" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="detailUser">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center"> 
                    <h3 class="mb-2 text-lg font-normal title_text">
                        <span id="modalFullname" class="block flex items-center justify-center"></span>
                        <small id="modalUsername"></small>
                    </h3>  
                    <hr class="mb-2">
                    <div class="text-center paragraph_text">
                        <small><i id="modalRole"></i></small>
                    </div>
                    <div class="grid grid-cols-2 paragraph_text">
                        <div>
                            <small><i>{{__("messages.phone")}}</i></small>
                            <p id="modalPhone"></p>
                        </div>
                        <div>
                            <small><i>{{__("messages.email")}}</i></small>
                            <p id="modalEmail"></p>
                        </div>
                    </div> 
                    <hr class="mt-4">
                    <div id="patientDetail" class="paragraph_text mt-4">
                        <strong class="text-xl">{{__("messages.patientInfo")}}</strong>
                        <div class="text-left ">
                            <strong>{{__("messages.address")}}: </strong>
                            <span id="patientAddress"></span> 
                        </div> 
                        <div class="grid grid-cols-2 mt-4">
                            <div>
                                <strong>{{__("messages.dob")}}</strong>
                                <p id="patientDob" class="pl-4"></p>  
                            </div>
                            <div>
                                <strong>{{__("messages.bloodType")}}</strong>
                                <p id="patientBlood" class="pl-4"></p>  
                            </div>
                        </div>
                    </div>
                    <div id="doctorDetail" class="paragraph_text mt-4">
                        <strong class="text-xl">{{__("messages.doctorInfo")}}</strong>
                        <div class="mt-2">
                            <strong>{{__("messages.license")}} </strong>
                            <p id="doctorLicense"></p> 
                        </div> 
                        <div class="mt-6">
                            <strong>{{__("routes.medical_units")}} </strong>
                            <p id="medicalUnits"></p> 
                        </div> 
                        <div class="mt-6"> 
                            <strong class="text-xl">{{__("routes.specialties")}}</strong> 
                            <div class="mt-2" id="doctorSpecialties"> </div> 
                        </div> 
                        <div class="text-center paragraph_text mt-4">  
                                <small><i>{{__("messages.commission")}}</i></small>
                                <p id="modalCommission"></p> 
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>    
@stop

@section('scripts')
    <script> 
        const url = '{{$_['baseURL']."/users/list?page="}}'; 
        const urlDel = '{{$_['baseURL']."/users/delete/"}}';
        const urlRes = '{{$_['baseURL']."/users/restore/"}}';
        const urlChangePassword = '{{$_['baseURL']."/users/updatePasswordForUser/"}}';
        const detailText = "{{__('messages.detail')}}";
        const editText = "{{__('messages.edit')}}";   
        const deleteText = "{{__('messages.delete')}}";
        const restoreText = "{{__('messages.restore')}}";
        const deletedText = "{{__('messages.deleted_his')}}";
        const changePasswordText = "{{__('messages.changePassword')}}";
        const withoutUsersSearch = "{{__('messages.withoutUsers')}}";
        const userEditURL = "{{$_['baseURL'].$_['routes']['users']['edit']('')}}";
        let currentPage = {{$page}}; 
        const msg = "{{isset($_GET['msg']) ? $_GET['msg'] : ""}}";
        const currentURL = "{{$_['baseURL'].$_['routes']['users']['root']}}/";
        const roles = @json($roles);  
        const days   = {!! json_encode($days) !!};
        const months = []; 
        const specialties = {!! json_encode($specialties) !!};

        ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'].forEach(key => {
            months.push(@json($months)[key]);
        }); 

        if(msg){
            createAlert(...msg.split("_"));
            window.history.pushState({}, title, currentURL);
        }
    </script>
    <script src="{{ asset('/resources/js/pages/users.js') }}"></script> 
@stop