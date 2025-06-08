<form action="#" method="POST" id="form_expenseRecord"  class="grid grid-cols-6 gap-y-4 gap-x-0 md:gap-4 mx-4">  
    <section class="bg_secondary px-7 pt-5 pb-5 w-full rounded-lg col-span-6 md:col-span-2 relative h-fit">
        @csrf <!-- {{ csrf_field() }} -->  
        <div class="grid grid-cols-1 md:grid-cols-2 mt-4">  
            <div class="px-2 col-span-2 md:col-span-1">
                <div class="relative z-0 group mb-2">
                    <select name="medical_unit" id="medical_unit" class="bg_secondary block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                        <option value=""></option>
                        @foreach ($medicalUnits as $medicalUnit)
                            <option value="{{$medicalUnit->id}}" {{$medicalUnit->id == $expenseRecord->medical_unit_id ? "selected" : ""}}>{{$medicalUnit->name}}</option>
                        @endforeach
                    </select> 
                    <label for="medical_unit" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("routes.medical_unit")}}</label>
                    <small id="medical_unit_message" class="text_error pl-2 italic"></small>
                </div>
            </div>
            <div class="px-2 col-span-2 md:col-span-1"> 
                <div class="relative z-0 group mb-5">
                    <div class="relative">
                        <div class="absolute inset-y-0 end-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        <input id="date" name="date"  value="{{$expenseRecord->date ? date("d/m/Y",strtotime($expenseRecord->date)) : ''}}" autocomplete="off" datepicker datepicker-autohide type="text" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" ">
                    </div>
                    <label for="date" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.date")}}</label>
                    <small id="date_message" class="text_error pl-2 italic"></small>
                </div>
            </div>  
            <div class="px-2 col-span-2 md:col-span-1">
                <div class="relative z-0 group mb-2">
                    <select name="payment_method" id="payment_method" class="bg_secondary block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                        <option value=""></option>
                        @foreach($paymentMethods as $key  =>  $payment_method)
                            <option value="{{$key}}" {{$expenseRecord->payment_method == $key ? "selected" : ""}} >{{$payment_method}}</option>
                        @endforeach
                    </select> 
                    <label for="payment_method" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.payment_method")}}</label>
                    <small id="payment_method_message" class="text_error pl-2 italic"></small>
                </div>
            </div> 
            <div class="px-2 col-span-2">
                <div class="relative z-0 group">
                    <textarea autocomplete="off" name="notes" id="notes" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" >{{$expenseRecord->notes}}</textarea>
                    <label for="notes" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.notes")}}</label>
                    <small id="notes_message" class="text_error pl-2 italic"></small>
                </div>
            </div> 
        </div>
    </section>
    <section class="bg_secondary px-7 pt-5 pb-5 w-full rounded-lg col-span-6 md:col-span-4 relative h-fit"> 
        <h1 class="text-center text-2xl font-bold title_text mb-4">{{__($title)}}</h1>
        <hr>
        <div class="grid grid-cols-3 sm:mx-10 mt-4">    
            <h1 class="text-center text-2xl font-bold title_text mb-4 col-span-3">{{__('routes.expenses')}}</h1>
            <hr class="mb-4 col-span-3">
            <div class="text-right col-span-3">
                <button type="button" onclick="addItem()" class="button_primary rounded-md p-2">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="12"  height="12"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                </button>
            </div> 
            <div id="itemsContainer" class="col-span-3 mt-2">
                @foreach ($expenseRecord->items as $key => $item)
                    <div class="grid grid-cols-12 rowItem border-2 rounded-lg mb-4 p-4 pt-6 md:border-0" id="rowItem_{{$key+1}}">
                        <div class="col-span-12 md:col-span-5 px-2">
                            <div class="relative mb-2 group">
                                <input type="text"  autocomplete="off" name="item_{{$key+1}}" id="item_{{$key+1}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" data-object="{{json_encode($item)}}" value="{{$item->name}}" placeholder="" />
                                <label for="item_{{$key+1}}" class="peer-focus:font-medium absolute text-sm input_label_Text duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__('messages.supply_or_service')}}</label>
                                <small id="item_message_{{$key+1}}" class="text_error pl-2 italic"></small>
                            </div> 
                        </div>
                        <div class="col-span-6 xs:col-span-3 md:col-span-2 px-2">
                            <div class="relative z-0 mb-2 group">
                                <input type="number"  autocomplete="off" name="qty_{{$key+1}}" id="qty_{{$key+1}}" value="{{$item->qty}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" onChange="calcTotal()"/>
                                <label for="qty_{{$key+1}}" class="peer-focus:font-medium absolute text-sm input_label_Text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__('messages.qty')}}</label>
                                <small id="qty_message_{{$key+1}}" class="text_error pl-2 italic"></small>
                            </div>
                        </div>
                        <div class="col-span-6 xs:col-span-4 md:col-span-2 px-2">
                            <div class="relative z-0 mb-2 group">
                                <input type="text" autocomplete="off" name="price_{{$key+1}}" id="price_{{$key+1}}" value="{{$item->price}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" onchange="calcTotal()"/>
                                <label for="price_{{$key+1}}" class="peer-focus:font-medium absolute text-sm input_label_Text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__('messages.price')}}</label>
                                <small id="price_message_{{$key+1}}" class="text_error pl-2 italic"></small>
                            </div>
                        </div>
                        <div class="col-span-10 xs:col-span-4 md:col-span-2 px-2">
                            <div class="relative z-0 mb-2 group">
                                <input type="text" autocomplete="off" readonly name="total_{{$key+1}}" id="total_{{$key+1}}"  value="{{$item->price*$item->qty}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                <label for="total_{{$key+1}}" class="peer-focus:font-medium absolute text-sm input_label_Text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Total</label>
                                <small id="total_message_{{$key+1}}" class="text_error pl-2 italic"></small>
                            </div>
                        </div>
                        <div class="col-span-1 px-2">
                            @if($expenseRecord->status == 1)
                                <button type="button" class="button_error rounded-md mt-4 p-1" onclick="removeItem(this)">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="16"  height="16"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach 
            </div>
            <small id="items_message" class="text_error pl-2 italic"></small>
        </div>
        <div class="grid grid-cols-12 sm:mx-10 mt-4"> 
            <hr class="col-span-12 mb-8">
            <div class="col-span-8 md:col-span-10 text-right input_label_Text mb-6">
                <label for="">Total:</label>
            </div>
            <div class="col-span-4 md:col-span-2 text-right input_label_Text mb-6">
                <input type="text" value=" " autocomplete="off" name="total" id="total" readonly value="0" class="mx-2 w-full text-right input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 mt-[-9px]" placeholder="" />
            </div> 
            <div class="col-span-12 text-center md:text-center mt-4">  
                <button type="button" class="button_success rounded-md px-10 py-2" onclick="save()">{{__("messages.save")}}</button>
            </div>
        </div>
    </section>
</form>