<div id="formDoctor">
    <h1 class="text-center text-2xl font-bold title_text pb-4">{{__("messages.doctorInfo")}}</h1>
    <hr />
    <div class="grid grid-cols-1 md:grid-cols-6 mt-4">
        <div class="px-2 col-span-1">
            <div class="relative z-0 group mb-2">
                <select name="title" id="title" class="bg_secondary block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                    <option value=""></option>
                    <option value="Dr." {{$user->doctor->title == "Dr." ? "selected" : ""}}>Dr.</option>
                    <option value="Dra." {{$user->doctor->title == "Dra." ? "selected" : ""}}>Dra.</option> 
                </select> 
                <label for="title" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.title")}}</label>
                <small id="title_message" class="text_error pl-2 italic"></small>
            </div>
        </div>  
        <div class="px-2 col-span-2">
            <div class="relative z-0 mb-2 group">
                <input type="text" autocomplete="off" name="license" id="license" value="{{$user->doctor->license}}" class="block py-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                <label for="license" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.license")}}</label>
                <small id="license_message" class="text_error pl-2 italic"></small>
            </div>
        </div> 
        <div class="px-2 col-span-6 md:col-span-3">  
            <select name="medical_unit[]" id="medical_unit" multiple>
                <option value=""></option>
                @foreach ($medicalUnits as $key => $item)  
                    <option value="{{$item->id}}" {{in_array($item->id,json_decode($user->doctor->medical_units ? $user->doctor->medical_units : "[]",true)) ? "selected" : ""}}>{{$item->name}}</option>
                @endforeach
            </select> 
        </div>  
        <div class="px-2 col-span-6 md:col-span-3">
            <div class="relative z-0 mb-2 group">
                <input type="text" autocomplete="off" name="commission" id="commission" value="{{$user->doctor->commission_amount}}" class="block py-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                <label for="commission" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.commission")}} %</label>
                <small id="commission_message" class="text_error pl-2 italic"></small>
            </div>
        </div>   
        <div class="px-2 col-span-6 md:col-span-3">
            <div class="relative z-0 mb-2 group">
                <input type="text" autocomplete="off" name="timeslot" id="timeslot" value="{{$user->doctor->timeslot}}" class="block py-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                <label for="timeslot" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.timeslot")}}</label>
                <small id="timeslot_message" class="text_error pl-2 italic"></small>
            </div>
        </div>  
        <div class="px-2 col-span-6 md:col-span-3"> 
            <select name="specialties[]" id="specialties" multiple>
                <option value=""></option>
                @foreach ($specialties as $key => $item)  
                    <option value="{{$item->id}}" {{in_array($item->id,$user->doctor->specialty_ids)? "selected" : ""}}>{{__("specialties.".$item->name)}}</option>
                @endforeach
            </select>
        </div> 
        <div class="px-2 col-span-6 md:col-span-3">
            <div class="flex flex-col justify-end">
                <div class="me-2 text-sm">
                    <label for="offer_discount" class="font-medium paragraph_text">{{__("messages.canOfferDiscount")}}</label> 
                </div>
                <div class="flex justify-end  h-5">
                    <input id="offer_discount" name="offer_discount" aria-describedby="offer_discount-text" type="checkbox" value="1" {{$user->doctor->offer_discount ? "checked" : ""}} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                </div>
            </div>
        </div> 
    </div>
    <div class="col-span-6">
        @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
            <div class="grid grid-cols-5 mb-4 flex ">
                <div class="flex gap-2">
                    <input id="{{$day}}" {{$user->doctor->{$day} ? "checked" : ""}} name="{{$day}}" type="checkbox" value="1" class="mt-[15px] w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label class="paragraph_text mt-[10px]">{{__("days.".$day)}}</label>
                </div>
                <div class="px-2 col-span-2"> 
                    <div class="relative z-0 mb-2 group">
                        <div class="absolute inset-y-0 end-[-11px] top-[-20px] flex items-center pe-3.5 pointer-events-none">
                            <svg class="w-4 h-4 input_label_text" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <input type="time" id="{{$day}}_start_time" name="{{$day}}_start_time" value="{{$user->doctor->{$day.'_start_time'} ? date('H:i',strtotime($user->doctor->{$day.'_start_time'})):''}}" class="block py-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                        <label for="{{$day}}_start_time" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.startService")}}</label>
                        <small id="{{$day}}_start_time_message" class="text_error pl-2 italic"></small>
                    </div>
                </div>
                <div class="px-2 col-span-2"> 
                    <div class="relative z-0 mb-2 group">
                        <div class="absolute inset-y-0 end-[-11px] top-[-20px] flex items-center pe-3.5 pointer-events-none">
                            <svg class="w-4 h-4 input_label_text" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <input type="time" id="{{$day}}_end_time" name="{{$day}}_end_time" value="{{$user->doctor->{$day.'_end_time'} ? date('H:i',strtotime($user->doctor->{$day.'_end_time'})):''}}" class="block py-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                        <label for="{{$day}}_end_time" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.endService")}}</label>
                        <small id="{{$day}}_end_time_message" class="text_error pl-2 italic"></small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>