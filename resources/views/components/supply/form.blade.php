<form action="#" method="POST" id="form_supply"  class="grid grid-cols-1 md:grid-cols-7 gap-y-4 gap-x-0 md:gap-4 mx-4"> 
    @if($id)    
        <input autocomplete="off" id="maindeleted" name="maindeleted" type="checkbox"  class="hidden"/>
    @endif 
    <section class="bg_secondary px-7 pt-5 pb-5 w-full rounded-lg col-span-6 md:col-span-3 relative">
        <button type="button" id="delMain" class="button_error p-2 rounded-full absolute right-[36%] top-[3%] {{$supply->image ? "" : "hidden"}}" >
            <svg  xmlns="http://www.w3.org/2000/svg"  width="18"  height="18"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
        </button> 
        <div class="px-2 col-span-2 mb-4">
            <img id="img-supply" width="200" height="200" alt="Image picture" class="border-2 b-[#444444] m-auto h-[150px] w-[150px] mb-4 rounded-full" src="{{ $supply->image ? asset("/storage/app/").'/'.$supply->image : asset('/resources/img/noimg.jpg') }}" /> 
            <div class="relative w-10/12  m-auto">
                <label title="Click to upload" for="imgSupply" class=" flex items-center justify-center gap-4 px-4 py-2 before:border-gray-400/60 hover:before:border-gray-300 group before:bg-gray-100 before:dark:bg-gray-700 before:absolute before:inset-0 before:rounded-3xl before:border before:border-dashed before:transition-transform before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95">
                    <div class="w-max relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 dark:text-gray-200" viewBox="0 0 64 64" fill="none">
                            <path d="M32.381 18.167V45.166" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M41.381 24.167L32.381 18.167L23.382 24.167" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M32.382 58.334C47.1098 58.334 59.049 46.3948 59.049 31.667C59.049 16.9392 47.1098 5 32.382 5C17.6542 5 5.715 16.9392 5.715 31.667C5.715 46.3948 17.6542 58.334 32.382 58.334Z" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="relative">
                        <span class="block text-base font-semibold relative text-gray-600 dark:text-gray-200 text-sm ">
                            {{__("messages.uploadSupplyPicture")}}
                        </span> 
                    </div>
                </label>
                <input autocomplete="off" class="opacity-0 absolute top-0 w-full h-full cursor-pointer" onChange="handleChangeImage()" type="file" name="imgSupply" id="imgSupply" />
            </div>
        </div>  
        <div class="px-2 col-span-2 md:col-span-1">
            <div class="relative z-0 group">
                <textarea autocomplete="off" name="description" id="description" class="block py-2 px-0 w-full text-sm input_text border-0 border-b-2 input_border bg-transparent appearance-none focus:outline-none focus:ring-0 peer" placeholder="" >{{$supply->description}}</textarea>
                <label for="description" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.description")}}</label>
                <small id="description_message" class="text_error pl-2 italic"></small>
            </div>
        </div>   
    </section>
    <section class="bg_secondary px-7 pt-5 pb-5 w-full rounded-lg col-span-6 md:col-span-4 h-fit">
        @csrf <!-- {{ csrf_field() }} --> 
        <h1 class="text-center text-2xl font-bold title_text mb-4">{{__($title)}}</h1>
        <hr>
        <div class="grid grid-cols-1 md:grid-cols-2 sm:mx-10 mt-4">  
            <div class="px-2 col-span-2 md:col-span-1">
                <div class="relative z-0 mb-2 group">
                    <input type="text" autocomplete="off" name="name" id="name" value="{{$supply->name}}" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                    <label for="name" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.name")}}</label>
                    <small id="name_message" class="text_error pl-2 italic"></small>
                </div>
            </div> 
            <div class="px-2 col-span-2 md:col-span-1">
                <div class="relative z-0 group mb-2">
                    <select name="category" id="category" class="bg_secondary block p-2 w-full text-sm input_text border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                        <option value=""></option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}" {{$supply->cat_id == $category->id ? "selected" : ""}} >{{__("item_categories.".$category->name)}}</option>
                        @endforeach
                    </select> 
                    <label for="category" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.category")}}</label>
                    <small id="category_message" class="text_error pl-2 italic"></small>
                </div>
            </div> 
            <div class="px-2 col-span-2 md:col-span-1">
                <div class="relative z-0 group mb-2">
                    <select name="medical_unit" id="medical_unit" {{$supply->medical_unit->id ? "disabled" : ""}} class="bg_secondary block p-2 w-full text-sm input_text border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                        <option value=""></option>
                        @foreach($medicalUnits as $medicalUnit)
                            <option value="{{$medicalUnit->id}}" {{$supply->medical_unit->id == $medicalUnit->id ? "selected" : ""}} >{{$medicalUnit->name}}</option>
                        @endforeach
                    </select> 
                    <label for="medical_unit" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("routes.medical_unit")}}</label>
                    <small id="medical_unit_message" class="text_error pl-2 italic"></small>
                </div>
            </div>  
            <div class="px-2 col-span-2 md:col-span-1">
                <div class="relative z-0 mb-2 group">
                    <input type="text" autocomplete="off" name="barcode" id="barcode" value="{{$supply->barcode}}" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                    <label for="barcode" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.barcode")}}</label>
                    <small id="barcode_message" class="text_error pl-2 italic"></small>
                </div>
            </div>   
            <div class="px-2 col-span-2 md:col-span-1">
                <div class="relative z-0 mb-2 group">
                    <input type="text" autocomplete="off" name="commission" id="commission" value="{{$supply->commission_amount}}" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                    <label for="commission" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.commission")}}%</label>
                    <small id="commission_message" class="text_error pl-2 italic"></small>
                </div>
            </div>      
            <div class="col-span-2 text-center md:text-right"> 
                <input type="hidden" value=""> 
                <button class="button_success rounded-md px-10 py-2">{{__("messages.save")}}</button>
            </div>
        </div>
    </section>
</form>