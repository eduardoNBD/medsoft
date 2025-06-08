<form action="#" method="POST" id="form_expense"  class="grid grid-cols-6 gap-y-4 gap-x-0 md:gap-4 mx-4"> 
    <section class="bg_secondary px-7 py-5 w-full rounded-lg col-span-6 md:col-span-4 md:col-start-2 h-fit">
        @csrf <!-- {{ csrf_field() }} --> 
        <h1 class="text-center text-2xl font-bold title_text mb-4">{{__($title)}}</h1>
        <hr>
        <div class="grid grid-cols-2 sm:mx-10 mt-4">  
            <div class="px-2 col-span-2 md:col-span-1">
                <div class="relative z-0 mb-2 group">
                    <input type="text" autocomplete="off" name="name" id="name" value="{{$expense->name}}" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                    <label for="name" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.name")}}</label>
                    <small id="name_message" class="text_error pl-2 italic"></small>
                </div>
            </div>   
            <div class="px-2 col-span-2 md:col-span-1">
                <div class="relative z-0 mb-2 group">
                    <input type="text" autocomplete="off" name="barcode" id="barcode" value="{{$expense->barcode}}" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                    <label for="barcode" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.barcode")}}</label>
                    <small id="barcode_message" class="text_error pl-2 italic"></small>
                </div>
            </div>   
            <div class="px-2 col-span-2"> 
                <div class="relative z-0 group">
                    <textarea autocomplete="off" name="description" id="description" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" >{{$expense->description}}</textarea>
                    <label for="description" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.description")}}</label>
                    <small id="description_message" class="text_error pl-2 italic"></small>
                </div> 
            </div>   
            <div class="col-span-2 text-center md:text-right"> 
                <button class="button_success rounded-md px-10 py-2">{{__("messages.save")}}</button>
            </div>
        </div>
    </section>
</form>