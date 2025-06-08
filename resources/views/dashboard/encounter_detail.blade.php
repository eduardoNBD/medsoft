@extends('layouts.dashboard',[ 'current_route'  => '/dashboard/encounters'])

@section('title', __($title)." ".$encounter->name) 

@section('styles') 
   <style> .autocomplete-items{margin-top:-20px;}</style> 
   <link href="{{ asset('/resources/css/autocomplete.css') }}" rel="stylesheet"> 
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
                <a href="{{$_['baseURL'].$_['routes']['encounters']['root']}}" class="inline-flex items-center text-sm font-medium breadcrumbs_text">
                    <svg class="w-4 h-4 mr-2.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.5 21h-4.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v3" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h10" /><path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18 16.5v1.5l.5 .5" /></svg>
                    {{__('routes.encounters')}}
                </a>
            </li>
            <li class="inline-flex items-center">
                <svg class="w-4 h-4 inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7l5 5l-5 5" /><path d="M13 7l5 5l-5 5" /></svg>
            </li> 
            <li>
                <div class="flex items-center breadcrumbs_text">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                    <span class="ms-1 text-sm font-medium md:ms-2">{{$encounter->patient->user->first_name}} {{$encounter->patient->user->last_name}}</span>
                </div>
            </li>
        </ol>
    </nav>
@stop

@section('content') 
<div class="grid grid-cols-6 gap-y-4 gap-x-0 md:gap-4 mx-4">  
    <div class="col-span-6">
        <div class="rounded-lg overflow-hidden" id="pdf-preview" class="h-0"></div>
    </div>
    <section class="px w-full col-span-6 md:col-span-4 h-fit order-1 md:order-2">
        <div class="border-b border-gray-200 dark:border-gray-700">
            <ul class="grid grid-cols-4 text-xs md:text-sm font-medium tab_text gap-1 mx-2" id="tabList">
                <li class="col-span-2 md:col-span-1" role="presentation">
                    <button onClick="showTab('#tab-encounter',this)" class="h-full inline-flex items-center px-4 py-3 rounded-t-lg w-full tab_text_active tab_background_active">
                        {{__("routes.encounter")}}
                    </button>
                </li>
                <li class="col-span-2 md:col-span-1" role="presentation">
                    <button onClick="showTab('#tab-detail',this)" class="h-full inline-flex items-center px-4 py-3 rounded-t-lg w-full tab_text tab_background">
                        {{__("messages.detail")}}
                    </button>
                </li> 
                <li class="col-span-2 md:col-span-1" role="presentation">
                    <button onClick="showTab('#tab-record',this)" class="h-full inline-flex items-center px-4 py-3 rounded-t-lg w-full tab_text tab_background">
                        {{__("messages.record")}}
                    </button>
                </li> 
                <li class="col-span-2 md:col-span-1" role="presentation">
                    <button onClick="showTab('#tab-patient',this)" class="h-full inline-flex items-center px-4 py-3 rounded-t-lg w-full tab_text tab_background">
                        {{__("routes.patient")}}
                    </button>
                </li> 
            </ul>
        </div>
        <div id="default-tab-content" class="bg_secondary rounded-b-lg pb-4 md:px-4">
            <div class="tab-item rounded-lg pt-2" id="tab-encounter" > 
                <section class="bg_secondary px-7 pt-5 pb-5 w-full rounded-lg col-span-6 md:col-span-4 relative h-fit"> 
                    <div class="px-5 mt-2 flex gap-2 justify-end">
                        <button onclick="generatePDF('preview')" class="inverted button_regular border-2 ml-4 p-1 rounded-lg" title="Crear PDF">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"></path></svg>
                        </button>
                        <button onclick="generatePDF('download')" class="inverted button_success border-2 p-1 rounded-lg" title="Crear PDF">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="20"  height="20"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-printer"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" /></svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-4 sm:mx-10 mt-4">    
                        @if($encounter->allergies || $encounter->surgeries || $encounter->addictions || $encounter->medications)
                            <hr class="col-span-4 mb-4">  
                            @if($encounter->allergies)
                                <div class="px-2 col-span-4 md:col-span-2 mt-4"> 
                                    <small class="text-sm font-bold title_text">{{__("messages.allergies")}}</small>
                                    <div class="paragraph_text">{{$encounter->allergies_text}}</div>  
                                </div>  
                            @endif
                            @if($encounter->surgeries)
                                <div class="px-2 col-span-4 md:col-span-2 mt-4"> 
                                    <small class="text-sm font-bold title_text">{{__("messages.surgeries")}}</small>
                                    <div class="paragraph_text">{{$encounter->surgeries_text}}</div>  
                                </div>  
                            @endif 
                            @if($encounter->addictions)
                                <div class="px-2 col-span-4 md:col-span-2 mt-4"> 
                                    <small class="text-sm font-bold title_text">{{__("messages.addictions")}}</small>
                                    <div class="paragraph_text">{{$encounter->addictions_text}}</div>  
                                </div>  
                            @endif  
                            @if($encounter->medications)
                                <div class="px-2 col-span-4 md:col-span-2 mt-4"> 
                                    <small class="text-sm font-bold title_text">{{__("messages.medications")}}</small>
                                    <div class="paragraph_text">{{$encounter->medications_text}}</div>  
                                </div>  
                            @endif    
                        @endif 
                    </div>
                    <div class="sm:mx-10 mt-4">  
                        <h1 class="text-center text-2xl font-bold title_text mb-4 col-span-12">{{__('messages.supplies_or_service')}}</h1>
                        <hr class="mb-4">
                        <div class="text-right">
                            @if($encounter->status == 1)
                                <button type="button" onclick="addItem()" class="button_primary rounded-md p-2">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="12"  height="12"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                </button>
                            @else
                                <br>
                            @endif
                        </div> 
                        <div id="itemsContainer">
                            @foreach ($encounter->items as $key => $item)
                                <div class="grid grid-cols-12 rowItems" id="rowItem_{{$key+1}}">
                                    <div class="col-span-5 px-2">
                                        <div class="relative mb-2 group">
                                            <input type="text" {{$encounter->status != 1 ? "readOnly" : ""}} autocomplete="off" name="item_{{$key+1}}" id="item_{{$key+1}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 focus:border-[#4D4E8D] peer" data-object="{{json_encode($item)}}" value="{{$item->name}}" placeholder="" />
                                            <label for="item_{{$key+1}}" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__('messages.supply_or_service')}}</label>
                                            <small id="item_message_{{$key+1}}" class="text_error pl-2 italic"></small>
                                        </div> 
                                    </div>
                                    <div class="col-span-2 px-2">
                                        <div class="relative z-0 mb-2 group">
                                            <input type="number" {{$encounter->status != 1 ? "readOnly" : ""}} autocomplete="off" name="qty_{{$key+1}}" id="qty_{{$key+1}}" value="{{$item->qty}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 focus:border-[#4D4E8D] peer" placeholder="" onChange="calcTotal()"/>
                                            <label for="qty_{{$key+1}}" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__('messages.qty')}}</label>
                                            <small id="qty_message_{{$key+1}}" class="text_error pl-2 italic"></small>
                                        </div>
                                    </div>
                                    <div class="col-span-2 px-2">
                                        <div class="relative z-0 mb-2 group">
                                            <input type="text" autocomplete="off" readonly name="price_{{$key+1}}" id="price_{{$key+1}}" value="{{$item->price}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                            <label for="price_{{$key+1}}" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__('messages.price')}}</label>
                                            <small id="price_message_{{$key+1}}" class="text_error pl-2 italic"></small>
                                        </div>
                                    </div>
                                    <div class="col-span-2 px-2">
                                        <div class="relative z-0 mb-2 group">
                                            <input type="text" autocomplete="off" readonly name="total_{{$key+1}}" id="total_{{$key+1}}"  value="{{$item->price*$item->qty}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                            <label for="total_{{$key+1}}" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Total</label>
                                            <small id="total_message_{{$key+1}}" class="text_error pl-2 italic"></small>
                                        </div>
                                    </div>
                                    <div class="col-span-1 px-2">
                                        @if($encounter->status == 1)
                                            <button type="button" class="button_error rounded-md mt-4 p-1" onclick="removeItem(this)">
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="16"  height="16"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach 
                        </div>
                    </div>
                    <div class="grid grid-cols-12 sm:mx-10 mt-4"> 
                        <hr class="col-span-12 mb-8">
                        <div class="col-span-8 md:col-span-10 text-right title_text mb-4">
                            <label for="">Subtotal:</label>
                        </div>
                        <div class="col-span-4 md:col-span-2 text-right title_text mb-4">
                            <input type="text" value="{{$encounter->subtotal}}" autocomplete="off" name="subtotal" id="subtotal" readonly value="0" class="mx-2 w-full text-right input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 input_border mt-[-9px]" placeholder="" />
                        </div>
                        <div class="col-span-8 md:col-span-10 text-right title_text mb-4">
                            <label for="">{{__('messages.supplies_or_service')}}:</label>
                        </div>
                        <div class="col-span-4 md:col-span-2 text-right title_text mb-4">
                            <input type="text" value="" autocomplete="off" name="supplies_or_service" id="supplies_or_service" readonly value="0" class="mx-2 w-full text-right input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 input_border mt-[-9px]" placeholder="" />
                        </div> 
                        <div class="col-span-8 md:col-span-10 text-right title_text  mb-4 {{($encounter->doctor->offer_discount || $encounter->discount != 0) ? '' : 'hidden'}}">
                            <label for="">{{__("messages.discount")}}:</label>
                        </div>
                        <div class="col-span-4 md:col-span-2 text-right title_text  mb-4 {{($encounter->doctor->offer_discount || $encounter->discount != 0) ? '' : 'hidden'}}">
                            <input type="text" {{$encounter->status != 1 ? "readOnly" : ""}} autocomplete="off" name="discount" id="discount" value="{{$encounter->discount ?? '0'}}" onchange="calcTotal()" class="mx-2 w-full text-right input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 input_border mt-[-9px]" placeholder="" />
                        </div> 
                        <div class="col-span-8 md:col-span-10 text-right title_text">
                            <label for="">Total:</label>
                        </div>
                        <div class="col-span-4 md:col-span-2 text-right title_text">
                            <input type="text" readOnly autocomplete="off" name="total" id="total" value="{{floatval($encounter->subtotal)-floatval($encounter->discount ?? 0)}}" class="mx-2 w-full text-right input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 input_border mt-[-9px]" placeholder="" />
                        </div> 
                        <div class="flex items-center justify-center col-span-12 {{$encounter->status != 1 ? 'hidden' : ''}}">
                            <label for="files" class="flex flex-col items-center justify-center w-full h-30 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">{{__('messages.clickToUpload')}}</span> {{__("messages.orDrag")}}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                                </div>
                                <input id="files" type="file" class="hidden" multiple accept="image/*,application/pdf"/>
                            </label>
                        </div> 
                        <div id="file-preview" class="col-span-12 grid grid-cols-1 md:grid-cols-4 gap-2 mt-2"></div>
                        @if($encounter->status == 1)
                            <div class="col-span-12 text-center md:text-center mt-4">  
                                <button onclick="save()" class="button_success rounded-md px-10 py-2">{{__("messages.save")}}</button>
                                <button onclick="pay()"  class="button_primary rounded-md px-10 py-2">{{__("messages.pay")}}</button>
                            </div>
                        @endif
                    </div>
                </section>
            </div>
            <div class="hidden tab-item rounded-lg pt-2" id="tab-detail" >
                @include("../components/patient/detailTab",[
                    "hiddeButton" => true
                ])
            </div>
            <div class="hidden tab-item pt-2 pb-8 rounded-lg" id="tab-record" >
                @include("../components/patient/recordTab")
            </div>
            <div class="hidden tab-item pt-2 pb-8 rounded-lg grid grid-cols-2" id="tab-patient" >
                <h1 class="col-span-2 text-center text-2xl font-bold title_text">{{__("messages.patientDetail")}}</h1>    
                <div class="px-2 col-span-2 mb-2">
                    <img id="img-user" width="200" height="200" alt="Image picture" class="border-2 b-[#444444] m-auto h-[150px] w-[150px] mb-4 rounded-full" src="{{ $encounter->patient->image ? asset("../storage/app/").'/'.$encounter->patient->image : asset('/resources/img/user.png') }}" /> 
                </div> 
                <hr class="px-2 col-span-2 mb-5">  
                <div class="px-2 col-span-2 md:col-span-1">
                    <div class="relative z-0 group mb-5">
                        <input type="text" autocomplete="off" name="first_name" id="first_name" disabled value="{{$encounter->patient->user->first_name}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                        <label for="first_name" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.first_name")}}</label>
                    </div>
                </div>  
                <div class="px-2 col-span-2 md:col-span-1">
                    <div class="relative z-0 group mb-5">
                        <input type="text" autocomplete="off" name="last_name" id="last_name" disabled value="{{$encounter->patient->user->last_name}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                        <label for="last_name" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.last_name")}}</label>
                    </div>
                </div>  
                <div class="px-2 col-span-2 md:col-span-1">
                    <div class="relative z-0 group mb-5">
                        <input type="text" autocomplete="off" name="email" id="email" disabled value="{{$encounter->patient->user->email}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                        <label for="email" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">E-mail</label>
                    </div>
                </div>  
                <div class="px-2 col-span-2 md:col-span-1">
                    <div class="relative z-0 group mb-5">
                        <input type="text" autocomplete="off" name="phone" id="phone" disabled value="{{$encounter->patient->user->phone}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                        <label for="phone" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.phone")}}</label>
                    </div>
                </div>
                <div class="px-2 col-span-2 md:col-span-1"> 
                    <div class="relative z-0 group mb-5">
                        <div class="relative">
                            <div class="absolute inset-y-0 end-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 input_label_text" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>
                            <input id="dob" name="dob" disabled value="{{date("d/m/Y",strtotime($encounter->patient->dob))}}" autocomplete="off" datepicker datepicker-autohide type="text" class="block py-2 px-0 w-full text-sm input_text input_border bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" ">
                        </div>
                        <label for="dob" class="peer-focus:font-medium absolute text-sm input_label_text  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.dob")}}</label>
                    </div>
                </div>  
                <div class="px-2 col-span-2 md:col-span-1">
                    <div class="relative z-0 group mb-5">
                        <input type="text" autocomplete="off" name="gender" id="gender" disabled value="{{__("messages.".$encounter->patient->user->gender)}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                        <label for="gender" class="peer-focus:font-medium absolute text-sm input_label_text  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.gender")}}</label>
                    </div>
                </div>
                <div class="px-2 col-span-2 md:col-span-1">
                    <div class="relative z-0 group mb-5">
                        <input type="text" name="patient_address" id="patient_address" disabled value="{{$encounter->patient->address}}" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                        <label for="patient_address" class="peer-focus:font-medium absolute text-sm input_label_text  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.address")}}</label>
                    </div>
                </div> 
                <div class="px-2 col-span-2 md:col-span-1">
                    <div class="relative z-0 group mb-5">
                        <input type="text" name="patient_city" id="patient_city" disabled value="{{$encounter->patient->city}}" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                        <label for="patient_city" class="peer-focus:font-medium absolute text-sm input_label_text  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.city")}}</label>
                    </div>
                </div> 
                <div class="px-2 col-span-2 md:col-span-1">
                    <div class="relative z-0 group mb-5">
                        <input type="text" name="patient_state" id="patient_state" disabled value="{{$encounter->patient->state}}" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                        <label for="patient_state" class="peer-focus:font-medium absolute text-sm input_label_text  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.state")}}</label>
                    </div>
                </div> 
                <div class="px-2 col-span-2 md:col-span-1">
                    <div class="relative z-0 group mb-5">
                        <input type="text" name="patient_zipcode" id="patient_zipcode" disabled value="{{$encounter->patient->zipcode}}" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                        <label for="patient_zipcode" class="peer-focus:font-medium absolute text-sm input_label_text  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.zipcode")}}</label>
                    </div>
                </div> 
                <div class="px-2 col-span-2 md:col-span-1">
                    <div class="relative z-0 group mb-5">
                        <select name="patient_country" id="patient_country" disabled class="bg_secondary block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                            @foreach ($countries as $key => $item)
                                <option value="{{$key}}" {{($encounter->patient->country == "" && $key == "MX") || $encounter->patient->country == $key ? "selected" : ""}} >{{$item}}</option>
                            @endforeach
                        </select>
                        <label for="patient_country" class="z-10 peer-focus:font-medium absolute text-sm input_label_text  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.country")}}</label>
                    </div>
                </div> 
                <div class="px-2 col-span-2 md:col-span-1">
                    <div class="relative z-0 group mb-5">
                        <select name="bloodType" id="bloodType" disabled class="bg_secondary block p-2 w-full text-sm input_text  border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                            <option value=""></option>
                            <option value="A+" {{"A+" == $encounter->patient->blood_type ? "selected" : ""}}>A+</option>
                            <option value="A-" {{"A-" == $encounter->patient->blood_type ? "selected" : ""}}>A-</option>
                            <option value="B+" {{"B+" == $encounter->patient->blood_type ? "selected" : ""}}>B+</option>
                            <option value="B-" {{"B-" == $encounter->patient->blood_type ? "selected" : ""}}>B-</option>
                            <option value="AB+" {{"AB+" == $encounter->patient->blood_type ? "selected" : ""}}>AB+</option>
                            <option value="AB-" {{"AB-" == $encounter->patient->blood_type ? "selected" : ""}}>AB-</option>
                            <option value="O+" {{"O+" == $encounter->patient->blood_type ? "selected" : ""}}>O+</option>
                            <option value="O-" {{"O-" == $encounter->patient->blood_type ? "selected" : ""}}>O-</option>
                        </select> 
                        <label for="bloodType" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.bloodType")}}</label>
                    </div>
                </div>
            </div>
        </div>
    </section> 
    <section class="bg_secondary px-7 pt-5 pb-5 w-full rounded-lg col-span-6 md:col-span-2 relative h-fit md:order-1 order-2">
        <div class="grid grid-cols-2 mt-4">  
            <div class="px-2 col-span-2 md:col-span-1 {{Auth::user()->role == 2 ? 'hidden' : ''}}">
                <div class="relative z-0 group mb-5">
                    <select name="doctor" id="doctor" disabled class="bg_secondary block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                        <option>{{$encounter->patient->doctor->user->first_name}} {{$encounter->patient->doctor->user->last_name}}</option> 
                    </select> 
                    <label for="doctor" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.isPatienteFrom")}}</label>
                </div>
            </div>   
            <h1 class="text-center text-2xl font-bold title_text mb-4 col-span-2">{{__($title)}}</h1>
            <hr class="col-span-2"> 
            <div class="px-2 col-span-1 mt-4">
                <small class="text-sm title_text">{{__("routes.medical")}}</small>
                <div class="paragraph_text">{{$encounter->doctor_user->first_name}} {{$encounter->doctor_user->last_name}}</div>  
            </div>
            <div class="px-2 col-span-1 mt-4">
                <small class="text-sm title_text">{{__("routes.patient")}}</small>
                <div class="paragraph_text">{{$encounter->patient_first_name}} {{$encounter->patient_last_name}}</div>  
            </div>  
            <div class="px-2 col-span-1 mt-4">
                <small class="text-sm title_text">{{__("messages.date")}}</small>
                <div class="paragraph_text">{{date("Y-m-d") == date("Y-m-d",strtotime($encounter->date)) ? __("messages.today").", ".date("H:i",strtotime($encounter->date)) : date("d/m/Y H:i",strtotime($encounter->date))}}</div>  
            </div>   
            <div class="px-2 col-span-2 mt-4">
                <small class="text-sm title_text">{{__("messages.subject")}}</small>
                <div class="paragraph_text">{{__("subjects.".$encounter->subject)}}</div>  
            </div>  
            <div class="px-2 col-span-2 mt-4">
                <small class="text-sm title_text">{{__("routes.medical_unit")}}</small>
                <div class="paragraph_text">{{$encounter->medical_unit->name}}</div>  
            </div>
            <hr class="col-span-2 my-4">  
            <h2 class="col-span-2 text-center text-md font-bold title_text my-2">{{__("messages.patientInfo")}}</h2>
            <div class="px-2 col-span-1 mt-4">
                <small class="text-sm title_text">{{__("messages.bloodType")}}</small>
                <div class="paragraph_text">{{$encounter->patient_blood_type}}</div>  
            </div> 
            <div class="px-2 col-span-1 mt-4">
                <small class="text-sm title_text">{{__("messages.dob")}}</small>
                <div class="paragraph_text">{{date("d/m/Y",strtotime($encounter->patient_dob))}}</div>  
            </div> 
            <div class="px-2 col-span-1 mt-4"> 
                <small class="text-sm title_text">{{__("messages.gender")}}</small>
                <div class="paragraph_text">{{__("messages.".$encounter->patient_gender)}}</div>  
            </div>    
            <div class="px-2 col-span-1 mt-4"> 
                <small class="text-sm title_text">{{__("messages.language")}}</small>
                <div class="paragraph_text">{{__("language.".$encounter->patient_language)}}</div>  
            </div>   
            <hr class="col-span-2 my-4">
            <div class="px-2 col-span-2">
                <div class="relative z-0 mt-2 group">
                    <textarea autocomplete="off" {{$encounter->status != 1 ? "readOnly" : ""}} name="diagnosis" id="diagnosis" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" >{{$encounter->diagnosis}}</textarea>
                    <label for="diagnosis" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.diagnosis")}}</label>
                    <small id="diagnosis_message" class="text_error pl-2 italic"></small>
                </div>
            </div>  
            <div class="px-2 col-span-2">
                <div class="relative z-0 group">
                    <textarea autocomplete="off" {{$encounter->status != 1 ? "readOnly" : ""}} name="treatment" id="treatment" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" >{{$encounter->treatment}}</textarea>
                    <label for="treatment" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.treatment")}}</label>
                    <small id="treatment_message" class="text_error pl-2 italic"></small>
                </div>
            </div> 
            <div class="px-2 col-span-2">
                <div class="relative z-0 group">
                    <textarea autocomplete="off" {{$encounter->status != 1 ? "readOnly" : ""}} name="notes" id="notes" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" >{{$encounter->notes}}</textarea>
                    <label for="notes" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.notes")}}</label>
                    <small id="notes_message" class="text_error pl-2 italic"></small>
                </div>
            </div> 
            <div class="px-2 col-span-2">
                <div class="relative z-0 group mb-2">
                    <select {{$encounter->status != 1 ? "disabled" : ""}} name="payment_method" id="payment_method" class="bg_secondary block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                        <option value=""></option>
                        @foreach($paymentMethods as $key  =>  $payment_method)
                            <option value="{{$key}}" {{$encounter->payment_method == $key ? "selected" : ""}} >{{$payment_method}}</option>
                        @endforeach
                    </select> 
                    <label for="payment_method" class="z-10 peer-focus:font-medium absolute text-sm input_label_text  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.payment_method")}}</label>
                    <small id="payment_method_message" class="text_error pl-2 italic"></small>
                </div>
            </div>  
        </div>
    </section>
</div>  
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
                <h3 class="mb-5 text-lg font-normal title_text ">{{__("messages.fileDeleteAsk")}}</h3>
                <button  onclick="deleteFile()" data-modal-hide="deleteModal" type="button" class="button_error focus:ring-4 focus:outline-none font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                    {{__("messages.yes")}}
                </button>
                <button onclick="closeModal('#deleteModal')" data-modal-hide="deleteModal" type="button" class="inverted button_regular py-2.5 px-5 ms-3 text-sm font-medium focus:outline-none rounded-lg border focus:z-10 focus:ring-4">{{__("messages.no")}}, {{__("messages.cancel")}}</button>
            </div>
        </div>
    </div>
</div>
<div id="imgReview" tabindex="-1" class="hidden flex bg-[#0000006b] overflow-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg_modal rounded-lg shadow ">
            <button onclick="closeModal('#imgReview')" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="deleteModal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-4 md:p-5 text-center">
                <img src="" alt="" class="w-full">
            </div>
        </div>
    </div>
</div>
<img src="{{ $logos->logo_public ? asset("resources/img/brand/").'/'.$logos->logo_public : asset('/resources/img/brand/logo_public.svg') }}" alt="hiddenImag" id="hiddenImag" class="hidden">
@stop 

@section('scripts') 
    <script src="{{ asset('/resources/libs/jsPDF/jspdf.umd.min.js') }}"></script>  
    <script src="{{ asset('/resources/libs/jsPDF/jspdf.autotable.min.js') }}"></script>   
    <script>
        const { jsPDF } = window.jspdf;
        const doc       = new jsPDF(); 
        const id = "{{$id}}"
        const url = '{{$_['baseURL']."/encounters/updateDetail/".$id }}'; 
        const delteFileUrl = '{{$_['baseURL']."/encounters/deleteFile/".$id }}'; 
        const urlItems = '{{$_['baseURL']."/encounters/items/".$patient->id }}';
        const urlPay = '{{$_['baseURL']."/encounters/pay/".$id }}'; 
        const redirect = '{{$_['baseURL'].$_['routes']['encounters']['root']}}'; 
        const days   = {!! json_encode($days) !!}; 
        const currentFiles = JSON.parse(@json($encounter->files)); 
        const supply_or_serviceText = '{{__("messages.supply_or_service")}}';
        const qtyText = '{{__("messages.qty")}}';
        const priceText = '{{__("messages.price")}}';
        const noResultsText = '{{__("messages.noResults")}}';
        const subtotal = {{$encounter->subtotal}}
        const enStatus = {{$encounter->status}};
        let itemCount = {{count($encounter->items)}};
        let currentItems = {!! json_encode($encounter->items) !!};
        let appDate = "{{$encounter->date ? explode(' ',$encounter->date)[0] : ''}}";
        let appHour = "{{$encounter->date ? substr((explode(' ',$encounter->date)[1]),0,5) : ''}}";
        let items = {!! json_encode($items) !!};
        let currentFile = "";
        let currentContent = null;  
        const urlFiles = '{{$_['baseURL']."/encounters/fileList/".$encounter->patient->id."?page="}}'; 
        const urlEncounters = '{{$_['baseURL']."/encounters/diagnosisList/".$encounter->patient->id."?page="}}'
        let currentPageFiles = 1;
        let currentPageDiagnosisEncounters = 1; 
        let currentPageTreatmentsEncounters = 1;
        let currentPageNotesEncounters = 1;
        let currentPageServicesEncounters = 1;
        let currentPageSuppliesEncounters = 1;
        const withoutFilesSearch = '{{__("messages.withoutFiles")}}'; 
        const withoutDiagnostics = '{{__("messages.withoutDiagnostics")}}';
        const withoutTreatments = '{{__("messages.withoutTreatments")}}';
        const withoutNotes = '{{__("messages.withoutNotes")}}';
        const withoutServices = '{{__("messages.withoutServices")}}';
        const withoutSupplies = '{{__("messages.withoutSupplies")}}';
    </script> 
    <script src="{{ asset('/resources/js/pages/patient_detail_files.js') }}"></script> 
    <script src="{{ asset('/resources/js/pages/patient_detail_diagnosis.js') }}"></script> 
    <script src="{{ asset('/resources/js/pages/patient_detail_items.js') }}"></script> 
    <script src="{{ asset('/resources/libs/autocomplete/autocomplete.js') }}"></script>  
    <script src="{{ asset('/resources/js/pages/encounter_detail.js') }}"></script>  
    <script>
        function generatePDF(action){    
            let initY = 34;
            let initX = 12;

            doc.setProperties({
                title: 'PDF',
                subject: '{{__("routes.encounter")}} {{$encounter->patient_first_name}}',
                author: '{{config('app.name')}}',
                keywords: 'pdf',
                creator: '{{config('app.name')}}',
                format: 'a4'
            });
 

            doc.setTextColor(80,80,80);
            doc.setFontSize(16); 
            doc.setFont(undefined,"bold"); 
            doc.text("{{__('messages.patientInfo')}}",setMiddle()-(calcWidth("{{__('messages.patientInfo')}}")/2.5), initY); 

            doc.setTextColor(80,80,80);
            doc.setFontSize(10); 
            doc.setFont(undefined,"bold");
            doc.text("{{__('messages.name')}}:",initX*2, initY+8,{align: "center"}); 

            doc.setFontSize(11); 
            doc.setFont(undefined,"normal");
            doc.text('{{$encounter->patient_first_name}} {{$encounter->patient_last_name}}',initX*2, initY+12,{align: "center"}); 

            doc.setTextColor(80,80,80);
            doc.setFontSize(10); 
            doc.setFont(undefined,"bold"); 
            doc.text("{{__('messages.dob')}}:",(initX+(200/4))*1.25, initY+8,{align: "center"}); 

            doc.setTextColor(80,80,80);
            doc.setFontSize(10); 
            doc.setFont(undefined,"normal"); 
            doc.text("{{date('d/m/Y',strtotime($encounter->patient_dob))}}",(initX+(200/4))*1.25, initY+12,{align: "center"});
            
            doc.setTextColor(80,80,80);
            doc.setFontSize(10); 
            doc.setFont(undefined,"bold"); 
            doc.text("{{__('messages.gender')}}:",(initX+((200/4)*2))*1.15, initY+8,{align: "center"}); 

            doc.setTextColor(80,80,80);
            doc.setFontSize(10); 
            doc.setFont(undefined,"normal"); 
            doc.text("{{__('messages.'.$encounter->patient_gender)}}",(initX+((200/4)*2))*1.15, initY+12,{align: "center"}); 

            doc.setTextColor(80,80,80);
            doc.setFontSize(10); 
            doc.setFont(undefined,"bold"); 
            doc.text("{{__('messages.bloodType')}}:",(initX+((200/4)*3))*1.10, initY+8,{align: "center"}); 

            doc.setTextColor(80,80,80);
            doc.setFontSize(10); 
            doc.setFont(undefined,"normal"); 
            doc.text("{{$encounter->patient_blood_type}}",(initX+((200/4)*3))*1.10, initY+12,{align: "center"}); 

            initY+=15; 

            doc.setTextColor(80,80,80);
            doc.setFontSize(10); 
            doc.setFont(undefined,"bold"); 
            doc.text("{{__('messages.diagnosis')}}:",initX+5, initY+8); 

            doc.setTextColor(80,80,80);
            doc.setFontSize(10); 
            doc.setFont(undefined,"normal"); 
            drawJustifiedText(doc,`{{$encounter->diagnosis}}`,initX+7, initY+13, 170, 5); 

            initY+= getHeight(`{{$encounter->diagnosis}}`,{maxWidth: 170 })+5;

            doc.setTextColor(80,80,80);
            doc.setFontSize(10); 
            doc.setFont(undefined,"bold"); 
            doc.text("{{__('messages.treatment')}}:",initX+5, initY+8); 

            doc.setTextColor(80,80,80);
            doc.setFontSize(10); 
            doc.setFont(undefined,"normal"); 
            drawJustifiedText(doc,`{{$encounter->treatment}}`,initX+7, initY+13, 170, 5); 

            initY+= getHeight(`{{$encounter->treatment}}`,{maxWidth: 170 })+5;

            if({{$encounter->allergies}}){
                doc.setTextColor(80,80,80);
                doc.setFontSize(10); 
                doc.setFont(undefined,"bold"); 
                doc.text("{{__('messages.allergies')}}:",initX+5, initY+10); 

                doc.setTextColor(80,80,80);
                doc.setFontSize(10); 
                doc.setFont(undefined,"normal"); 
                doc.text(`{{$encounter->allergies_text}}`,initX+7, initY+16, { maxWidth:170 }); 

                initY+= getHeight(`{{$encounter->allergies_text}}`,{maxWidth: 170 })+10;
            }

            if({{$encounter->surgeries}}){
                doc.setTextColor(80,80,80);
                doc.setFontSize(10); 
                doc.setFont(undefined,"bold"); 
                doc.text("{{__('messages.surgeries')}}:",initX+5, initY+10); 

                doc.setTextColor(80,80,80);
                doc.setFontSize(10); 
                doc.setFont(undefined,"normal"); 
                doc.text(`{{$encounter->surgeries_text}}`,initX+7, initY+16, { maxWidth:170 }); 

                initY+= getHeight(`{{$encounter->surgeries_text}}`,{maxWidth: 170 })+8;
            }

            if({{$encounter->addictions}}){
                doc.setTextColor(80,80,80);
                doc.setFontSize(10); 
                doc.setFont(undefined,"bold"); 
                doc.text("{{__('messages.addictions')}}:",initX+5, initY+10); 

                doc.setTextColor(80,80,80);
                doc.setFontSize(10); 
                doc.setFont(undefined,"normal"); 
                doc.text(`{{$encounter->addictions_text}}`,initX+7, initY+16, { maxWidth:170 }); 

                initY+= getHeight(`{{$encounter->addictions_text}}`,{maxWidth: 170 })+8;
            }

            if({{$encounter->medications}}){
                doc.setTextColor(80,80,80);
                doc.setFontSize(10); 
                doc.setFont(undefined,"bold"); 
                doc.text("{{__('messages.medications')}}:",initX+5, initY+10); 

                doc.setTextColor(80,80,80);
                doc.setFontSize(10); 
                doc.setFont(undefined,"normal"); 
                doc.text(`{{$encounter->medications_text}}`,initX+7, initY+16, { maxWidth:170 }); 

                initY+= getHeight(`{{$encounter->medications_text}}`,{maxWidth: 170 })+8;
            }
            
            if({{count($encounter->items)}}){
                doc.setTextColor(80,80,80);
                doc.setFontSize(16); 
                doc.setFont(undefined,"bold"); 
                doc.text("{{__('messages.supplies_or_service')}}",setMiddle()-(calcWidth("{{__('messages.supplies_or_service')}}")/2.5), initY+10); 

                initY+= 15;

                const headers = [
                    [
                        "{{__('messages.name')}}", 
                        "{{__('messages.qty')}}", 
                        "{{__('messages.price')}}", 
                        {
                            content: "SubTotal",
                            styles: { halign: "right", fontStyle: "bold" }
                        }
                    ]
                ];

                const body = currentItems.map(item => [
                    item.name,
                    item.qty,
                    `$ ${parseFloat(item.price).toFixed(2)}`,
                    {
                        content: `$ ${customNumberFormat(item.qty * item.price)}`,
                        styles: { halign: "right", fontStyle: "bold" }
                    }
                ]);
                
                if("{{$encounter->discount}}" && "{{$encounter->discount}}" != 0){
                    body.push([
                    {
                        content: "{{__('messages.discount')}}",
                        colSpan: 3,  
                        styles: { halign: "right", fillColor: [220, 220, 220], fontStyle: "bold" } 
                    },
                    {
                        content: `$ ${customNumberFormat(parseFloat("{{$encounter->discount}}").toFixed(2))}`,  
                        styles: { halign: "right", fontStyle: "bold" }
                    }
                ]);
                }

                body.push([
                    {
                        content: "Total",
                        colSpan: 3,  
                        styles: { halign: "right", fillColor: [220, 220, 220], fontStyle: "bold" } 
                    },
                    {
                        content: `$ ${customNumberFormat(currentItems
                            .reduce((sum, item) => {
                                const qty = parseFloat(item.qty) || 0;
                                const price = parseFloat(item.price) || 0;
                                return sum + qty * price;
                            }, 0)
                            .toFixed(2)-parseFloat("{{$encounter->discount}}"))}`,  
                        styles: { halign: "right", fontStyle: "bold" }
                    }
                ]); 

                doc.autoTable({
                    head: headers,
                    body: body,
                    columnStyles: {
                        0: { cellWidth: 100 },
                        1: { cellWidth: 24 }  
                    },
                    startY: initY, 
                    theme: "grid",  
                    headStyles: { 
                        fillColor: [234, 234, 234], 
                        textColor: [80, 80, 80], 
                        lineWidth: 0.5, // Grosor del borde
                        lineColor: [200, 200, 200] // Color negro para los bordes
                    },
                    styles: { fontSize: 10 }, // Tamaño de fuente
                    margin: { top: 25, bottom: 30 },  
                });


                initY = doc.lastAutoTable.finalY;
            }

            const totalPages = doc.internal.getNumberOfPages();
    
            for (let i = 1; i <= totalPages; i++) { 
                doc.setPage(i);
                setHeader();
                setFooter(i);
            }

            if(action == "download"){
                doc.save('{{__("routes.encounter")}} {{$encounter->patient_first_name}}');
            }else if(action == "preview"){
                
                const pdfBlob = doc.output('blob');
                const url = URL.createObjectURL(pdfBlob);

                const container = $('#pdf-preview'); 
                container.classList.remove("h-0");
                container.classList.add("h-[500px]");
                container.innerHTML = `<div class="bg-white h-[41px] p-2">
                                            <button onclick="closePreview()" class="border-red-700 text-white bg-red-700 border-2 ml-4 float-right p-1 rounded-lg" title="Cerrar PDF">
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="14"  height="14"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                                            </button>
                                        </div>
                                        <iframe src="${url}" width="100%" height="450px" type="application/pdf" ></iframe>`;
            }
        }

        function closePreview(){
            const container = $('#pdf-preview'); 
            container.classList.add("h-0");
            container.classList.remove("h-[500px]");
            container.innerHTML = "";
        } 

        function calcWidth(text,initLine = 10){ 
            return (doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor)+initLine+2;
        }

        function setPositionRight(text,rightLimit = 200){
            return (rightLimit-(doc.getStringUnitWidth(text) * (doc.internal.getFontSize()+1) / doc.internal.scaleFactor));
        }

        function setMiddle(width = 210){ 
            return (width/2);
        }

        function getHeight(text, options){
            const { maxWidth = 210 } = options;

            const lines = text.split('\n')
                              .flatMap(line => doc.splitTextToSize(line, maxWidth))
                              .filter(line => line.trim() !== "");  

         
            const textHeight = (lines.length / (doc.getLineHeightFactor())) * (doc.getFontSize()*0.65);
            console.log(lines.length * (doc.getLineHeightFactor()) * (doc.getFontSize()),lines.length,(doc.getLineHeightFactor()),(doc.getFontSize()))
            return textHeight;
        }

        function setFooter(text){
            doc.setFontSize(10); 
            const pageSize = doc.internal.pageSize;
            const pageHeight = pageSize.height || pageSize.getHeight();
            const textWidth = doc.getStringUnitWidth(text.toString()) * doc.internal.getFontSize() / doc.internal.scaleFactor;
            const textHeight = doc.internal.getLineHeight() / doc.internal.scaleFactor;
            const x = (pageSize.width - textWidth) / 2;
            const y = pageHeight - 10;  

            doc.text(text.toString(), x, y);
        }

        function setHeader(){
            doc.setDrawColor(200, 200, 200);
            doc.line(8, 22, 200, 22);
            doc.setFontSize(23); 
            doc.setFont(undefined,"bold");
            doc.setTextColor(80,80,80);
            doc.text("{{__("routes.encounter_detail")}}",setPositionRight("{{__("routes.encounter_detail")}}"), 16); 
            
            const img = $("#hiddenImag"); 
            
            var canvas = document.createElement('canvas');
            var ctx = canvas.getContext('2d');
            canvas.width = img.width;
            canvas.height = img.height;
            ctx.fillStyle = "#4d4e8d";
            ctx.fillRect(0, 0, canvas.width, canvas.height); 
            ctx.globalCompositeOperation = "destination-in";
            ctx.drawImage(img, 0, 0);
            var dataURL = canvas.toDataURL('image/png');
            doc.addImage(dataURL, 'PNG', 10, 3, img.width*0.055, img.height*0.055); 
        }
        function drawJustifiedText(doc, text, x, y, maxWidth, lineHeight) {
            const lines = doc.splitTextToSize(text, maxWidth); // Divide el texto en líneas ajustadas al ancho máximo

            lines.forEach((line, index) => {
                const words = line.split(" "); // Divide la línea en palabras
                if (index === lines.length - 1 || words.length === 1) {
                    // Última línea o línea con una sola palabra: texto alineado a la izquierda
                    doc.text(line, x, y);
                } else {
                    // Justificar la línea
                    const totalWordWidth = words.reduce((sum, word) => sum + doc.getTextWidth(word), 0);
                    const totalSpaceWidth = maxWidth - totalWordWidth;
                    const spaceWidth = totalSpaceWidth / (words.length - 1);

                    let currentX = x;
                    words.forEach((word, i) => {
                        doc.text(word, currentX, y);
                        if (i < words.length - 1) {
                            currentX += doc.getTextWidth(word) + spaceWidth;
                        }
                    });
                }
                y += lineHeight; // Moverse a la siguiente línea
            });
        }
        
    </script>
@stop