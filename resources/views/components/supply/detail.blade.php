<div action="#" method="POST" id="form_supply"  class="grid grid-cols-12 gap-y-4 gap-x-0 md:gap-4 mx-4">  
    <section class="bg_secondary px-7 pt-5 pb-5 w-full rounded-lg col-span-12 md:col-span-4 relative">
        <h1 class="text-center text-2xl font-bold title_text mb-4">{{__($title)}}</h1> 
        <div class="px-2 col-span-2 mb-4">
            <img id="img-supply" width="200" height="200" alt="Image picture" class="border-2 b-[#444444] m-auto h-[150px] w-[150px] mb-4 rounded-full" src="{{ $supply->image ? asset("/storage/app/").'/'.$supply->image : asset('/resources/img/noimg.jpg') }}" /> 
        </div>   
        <div class="grid grid-cols-1 md:grid-cols-2 mt-4">  
            <div class="px-2 col-span-2 mb-4">
                <div class="relative z-0 group">
                    <input type="text" autocomplete="off" name="name" id="name" disabled="disabled" value="{{$supply->name}}" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                    <label for="name" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.name")}}</label>
                </div>
            </div>  
            <div class="px-2 col-span-2 mb-4">
                <div class="relative z-0 group">
                    <textarea autocomplete="off" disabled="disabled" name="description" id="description" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" >{{$supply->description}}</textarea>
                    <label for="description" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.description")}}</label>
                </div>
            </div> 
            <div class="px-2 col-span-2 mb-4">
                <div class="relative z-0 group mb-2">
                    <select name="category" id="category" disabled="disabled" class="bg_secondary block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                        <option value=""></option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}" {{$supply->cat_id == $category->id ? "selected" : ""}} >{{__("item_categories.".$category->name)}}</option>
                        @endforeach
                    </select> 
                    <label for="category" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.category")}}</label>
                </div>
            </div> 
            <div class="px-2 col-span-2 mb-4">
                <div class="relative z-0 group mb-2">
                    <select name="medical_unit" id="medical_unit" disabled="disabled" class="bg_secondary block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                        <option value=""></option>
                        @foreach($medicalUnits as $medicalUnit)
                            <option value="{{$medicalUnit->id}}" {{$supply->medical_unit->id == $medicalUnit->id ? "selected" : ""}} >{{$medicalUnit->name}}</option>
                        @endforeach
                    </select> 
                    <label for="medical_unit" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("routes.medical_unit")}}</label>
                </div>
            </div>  
            <div class="px-2 col-span-2 mb-4">
                <div class="relative z-0 group">
                    <input type="text" autocomplete="off" disabled="disabled" name="barcode" id="barcode" value="{{$supply->barcode}}" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                    <label for="barcode" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.barcode")}}</label>
                </div>
            </div>   
            <div class="px-2 col-span-2 mb-4">
                <div class="relative z-0 group">
                    <input type="text" autocomplete="off" disabled="disabled" name="commission" id="commission" value="{{$supply->commission_amount}}" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                    <label for="commission" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.commission")}}%</label>
                </div>
            </div>      
        </div>
    </section>
    <section class="bg_secondary px-2 md:px-7 pt-5 pb-5 w-full rounded-lg col-span-12 md:col-span-8 h-fit"> 
        @include('../components/supply/detail_table')  
    </section>
</div>
<div id="itemReload" tabindex="-1" class="hidden flex bg-[#0000006b] overflow-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg_modal rounded-lg shadow ">
            <button onclick="supplyReloadForm.reset();closeModal('#itemReload')" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="itemReload">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <form id="supplyReloadForm">
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-16 h-16" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M9 3m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v1a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M10 6v.98c0 .877 -.634 1.626 -1.5 1.77c-.866 .144 -1.5 .893 -1.5 1.77v8.48a2 2 0 0 0 2 2h6a2 2 0 0 0 2 -2v-8.48c0 -.877 -.634 -1.626 -1.5 -1.77a1.795 1.795 0 0 1 -1.5 -1.77v-.98" /><path d="M7 12h10" /><path d="M7 18h10" /><path d="M11 15h2" /> <path d="M18 3v6" /><path d="M15 6h6" /></svg>  
                    <div class="text-left grid grid-cols-2">
                        <div class="px-2 col-span-2"> 
                            <div class="relative z-0 mb-2 group ">
                                <div class="relative">
                                    <div class="absolute inset-y-0 end-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 input_label_text" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                        </svg>
                                    </div>
                                    <input id="expiration" name="expiration" value="{{$supply->expiration ? date("d/m/Y",strtotime($supply->expiration)) : ""}}" autocomplete="off" datepicker datepicker-autohide type="text" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" ">
                                </div>
                                <label for="expiration" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.expiration")}}</label>
                                <small id="expiration_message" class="text_error pl-2 italic"></small>
                            </div>
                        </div>  
                        <div class="px-2 col-span-1">
                            <div class="relative z-0 mb-2 group">
                                <input type="text" autocomplete="off" name="qty" id="qty" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                <label for="qty" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.qty")}}</label>
                                <small id="qty_message" class="text_error pl-2 italic"></small>
                            </div>
                        </div>  
                        <div class="px-2 col-span-1">
                            <div class="relative z-0 mb-2 group">
                                <input type="text" autocomplete="off" name="commission" id="commission" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                <label for="commission" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.commission")}}%</label>
                                <small id="commission_message" class="text_error pl-2 italic"></small>
                            </div>
                        </div>  
                        <div class="px-2 col-span-1">
                            <div class="relative z-0 mb-2 group">
                                <input type="text" autocomplete="off" name="cost" id="cost" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                <label for="cost" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.cost")}}</label>
                                <small id="cost_message" class="text_error pl-2 italic"></small>
                            </div>
                        </div>  
                        <div class="px-2 col-span-1">
                            <div class="relative z-0 mb-2 group">
                                <input type="text" autocomplete="off" name="price" id="price" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                <label for="price" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.price")}}</label>
                                <small id="price_message" class="text_error pl-2 italic"></small>
                            </div>
                        </div> 
                    </div>
                    <input type="hidden" name="reload_id" id="reload_id" value="">
                    <input type="hidden" name="item_id" id="item_id" value="{{$id}}">
                    <button class="button_success focus:ring-4 focus:outline-none font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center my-4">
                        {{__("messages.addSupplyReload")}}
                    </button> 
                </form>
            </div>
        </div>
    </div>
</div>