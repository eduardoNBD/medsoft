

<div class="">
    <div class="bg_secondary relative shadow-md rounded-lg col-span-1">
        <div class="p-6 mb-2">
            <h2 class="text-center text-2xl font-bold title_text mb-4">{{__("messages.filters")}}</h2>
            <hr class="mb-2">
            <form id="report_form" class="grid grid-cols-3 gap-2">
                <div class="relative z-0 group mb-2 mt-4 col-span-3 md:col-span-1">
                    <select name="medical_unit" id="medical_unit" class="bg_secondary block p-2 w-full text-sm input_text border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                        <option value="">{{__("messages.all_her")}}</option>
                        @foreach ($medicalUnits as $medicalUnit)
                            <option value="{{$medicalUnit->id}}">{{$medicalUnit->name}}</option>
                        @endforeach
                    </select> 
                    <label for="medical_unit" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("routes.medical_unit")}}</label>
                    <small id="medical_unit_message" class="text_error pl-2 italic"></small>
                </div>
                <div class="relative z-0 mb md:mb-2 group  mt-4 col-span-3 md:col-span-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 end-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 input_label_text" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        <input id="start" name="start" autocomplete="off" datepicker datepicker-autohide type="text" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" ">
                    </div>
                    <label for="start" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.start")}}</label>
                    <small id="start_message" class="text_error pl-2 italic"></small>
                </div>
                <div class="relative z-0 mb-2 group  mt-4 col-span-3 md:col-span-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 end-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 input_label_text" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        <input id="end" name="end" autocomplete="off" datepicker datepicker-autohide type="text" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" ">
                    </div>
                    <label for="end" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.end")}}</label>
                    <small id="end_message" class="text_error pl-2 italic"></small>
                </div>
                <div class="text-center col-span-3 gap-2">
                    <button class="mr-4 button_success focus:ring-4 font-medium rounded-lg text-sm px-8 py-2">
                        {{__("messages.generateReport")}}
                    </button>
                    <button id="exportExcellButton" type="button" class="hidden button_secondary focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-8 py-2" onclick="exportExcell()">
                        {{__("messages.downloadXLS")}}
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="bg_secondary relative shadow-md rounded-lg col-span-2">
        <div id="reportContent" class="p-2">
             
        </div>
    </div>
</div>