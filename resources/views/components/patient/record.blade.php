<form id="form"  class="grid grid-cols-1 md:grid-cols-7 gap-y-4 gap-x-0 md:gap-4 mx-4">   
    <section class="bg-white dark:bg-slate-900 px-3 md:px-7 pt-5 pb-5 w-full rounded-lg col-span-6 md:col-span-2 relative grid grid-cols-1 md:grid-cols-2 h-fit">
        <div class="px-2 col-span-2 mb-5">
            <img id="img-user" width="200" height="200" alt="Image picture" class="border-2 b-[#444444] m-auto h-[150px] w-[150px] mb-4 bg-purple-500 rounded-full" src="{{ $patient->image ? asset("../storage/app/").'/'.$patient->image : asset('/resources/img/user.png') }}" /> 
        </div> 
        <div class="px-2 col-span-2 md:col-span-1">
            <div class="relative z-0 group mb-5">
                <input type="text" autocomplete="off" name="first_name" id="first_name" disabled value="{{$patient->user->first_name}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                <label for="first_name" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.first_name")}}</label>
            </div>
        </div>  
        <div class="px-2 col-span-2 md:col-span-1">
            <div class="relative z-0 group mb-5">
                <input type="text" autocomplete="off" name="last_name" id="last_name" disabled value="{{$patient->user->last_name}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                <label for="last_name" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.last_name")}}</label>
            </div>
        </div>  
        <div class="px-2 col-span-2 md:col-span-1">
            <div class="relative z-0 group mb-5">
                <input type="text" autocomplete="off" name="email" id="email" disabled value="{{$patient->user->email}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                <label for="email" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">E-mail</label>
            </div>
        </div>  
        <div class="px-2 col-span-2 md:col-span-1">
            <div class="relative z-0 group mb-5">
                <input type="text" autocomplete="off" name="phone" id="phone" disabled value="{{$patient->user->phone}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
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
                    <input id="dob" name="dob" disabled value="{{date("d/m/Y",strtotime($patient->dob))}}" autocomplete="off" datepicker datepicker-autohide type="text" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" ">
                </div>
                <label for="dob" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.dob")}}</label>
            </div>
        </div>  
        <div class="px-2 col-span-2 md:col-span-1">
            <div class="relative z-0 group mb-5">
                <input type="text" autocomplete="off" name="gender" id="gender" disabled value="{{__("messages.".$patient->user->gender)}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                <label for="gender" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.gender")}}</label>
            </div>
        </div>
        <div class="px-2 col-span-2 md:col-span-1">
            <div class="relative z-0 group mb-5">
                <input type="text" name="patient_address" id="patient_address" disabled value="{{$patient->address}}" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                <label for="patient_address" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.address")}}</label>
            </div>
        </div> 
        <div class="px-2 col-span-2 md:col-span-1">
            <div class="relative z-0 group mb-5">
                <input type="text" name="patient_city" id="patient_city" disabled value="{{$patient->city}}" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                <label for="patient_city" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.city")}}</label>
            </div>
        </div> 
        <div class="px-2 col-span-2 md:col-span-1">
            <div class="relative z-0 group mb-5">
                <input type="text" name="patient_state" id="patient_state" disabled value="{{$patient->state}}" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                <label for="patient_state" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.state")}}</label>
            </div>
        </div> 
        <div class="px-2 col-span-2 md:col-span-1">
            <div class="relative z-0 group mb-5">
                <input type="text" name="patient_zipcode" id="patient_zipcode" disabled value="{{$patient->zipcode}}" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                <label for="patient_zipcode" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.zipcode")}}</label>
            </div>
        </div> 
        <div class="px-2 col-span-2 md:col-span-1">
            <div class="relative z-0 group mb-5">
                <select name="patient_country" id="patient_country" disabled class="bg_secondary block p-2 w-full text-sm input_text border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                    @foreach ($countries as $key => $item)
                        <option value="{{$key}}" {{($patient->country == "" && $key == "MX") || $patient->country == $key ? "selected" : ""}} >{{$item}}</option>
                    @endforeach
                </select>
                <label for="patient_country" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.country")}}</label>
            </div>
        </div> 
        <div class="px-2 col-span-2 md:col-span-1">
            <div class="relative z-0 group mb-5">
                <select name="bloodType" id="bloodType" disabled class="bg_secondary block p-2 w-full text-sm input_text border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                    <option value=""></option>
                    <option value="A+" {{"A+" == $patient->blood_type ? "selected" : ""}}>A+</option>
                    <option value="A-" {{"A-" == $patient->blood_type ? "selected" : ""}}>A-</option>
                    <option value="B+" {{"B+" == $patient->blood_type ? "selected" : ""}}>B+</option>
                    <option value="B-" {{"B-" == $patient->blood_type ? "selected" : ""}}>B-</option>
                    <option value="AB+" {{"AB+" == $patient->blood_type ? "selected" : ""}}>AB+</option>
                    <option value="AB-" {{"AB-" == $patient->blood_type ? "selected" : ""}}>AB-</option>
                    <option value="O+" {{"O+" == $patient->blood_type ? "selected" : ""}}>O+</option>
                    <option value="O-" {{"O-" == $patient->blood_type ? "selected" : ""}}>O-</option>
                </select> 
                <label for="bloodType" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.bloodType")}}</label>
            </div>
        </div>
        <div class="px-2 col-span-2 md:col-span-1">
            <div class="relative z-0 group mb-5">
                <select name="doctor" id="doctor" disabled class="bg_secondary block p-2 w-full text-sm input_text border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                    <option>{{$patient->doctor->user->first_name}} {{$patient->doctor->user->last_name}}</option> 
                </select> 
                <label for="doctor" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.isPatienteFrom")}}</label>
            </div>
        </div>   
    </section>
    <section class="bg_secondary px-3 md:px-7 pt-5 pb-5 w-full rounded-b-lg col-span-6 md:col-span-5 h-fit">
        @csrf <!-- {{ csrf_field() }} -->  
        <h1 class="text-center text-2xl font-bold title_text mb-4">{{__("messages.medical_record")}}</h1>
        <hr>
        <div class="grid grid-cols-1 md:grid-cols-6 sm:mx-10 mt-4">  
            <div class="px-2 col-span-6 sm:col-span-2">
                <div class="relative z-0 group mb-2">
                    <input type="text" autocomplete="off" name="no_record" id="no_record" disabled value="{{$patient->medical_histories->file_number}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                    <label for="no_record" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.no_record")}}</label>
                    <small id="no_record_message" class="text_error pl-2 italic"></small>
                </div>
            </div>  
            <div class="px-2 col-span-6 sm:col-span-2">
                <div class="relative z-0 group mb-2">
                    <select name="marital_status" id="marital_status" class="bg_secondary block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                        <option value=""></option>
                        <option value="single" {{"single" == $patient->medical_histories->marital_status ? "selected" : ""}}>{{__("messages.single")}}</option>
                        <option value="married" {{"married" == $patient->medical_histories->marital_status ? "selected" : ""}}>{{__("messages.married")}}</option> 
                    </select> 
                    <label for="marital_status" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.marital_status")}}</label>
                    <small id="marital_status_message" class="text_error pl-2 italic"></small>
                </div>
            </div>
            <div class="px-2 col-span-6 sm:col-span-2">
                <div class="relative z-0 group mb-2">
                    <input type="text" autocomplete="off" name="occupation" id="occupation" value="{{$patient->medical_histories->occupation}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                    <label for="occupation" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.occupation")}}</label>
                    <small id="occupation_message" class="text_error pl-2 italic"></small>
                </div>
            </div> 
            <div class="px-2 col-span-6 sm:col-span-2 hidden" id="spouse_occupation_row">
                <div class="relative z-0 group mb-2">
                    <input type="text" autocomplete="off" name="spouse_occupation" id="spouse_occupation" value="{{$patient->medical_histories->spouse_occupation}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                    <label for="spouse_occupation" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.spouse_occupation")}}</label>
                    <small id="spouse_occupation_message" class="text_error pl-2 italic"></small>
                </div>
            </div>  
            <div class="px-2 col-span-6 sm:col-span-2">
                <div class="relative z-0 group mb-2">
                    <input type="text" autocomplete="off" name="religion" id="religion" value="{{$patient->medical_histories->religion}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                    <label for="religion" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.religion")}}</label>
                    <small id="religion_message" class="text_error pl-2 italic"></small>
                </div>
            </div> 
            <div class="px-2 col-span-6 sm:col-span-2">
                <div class="relative z-0 group mb-2">
                    <input type="text" autocomplete="off" name="height" id="height" value="{{$patient->medical_histories->height}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                    <label for="height" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.height")}} (cm)</label>
                    <small id="height_message" class="text_error pl-2 italic"></small>
                </div>
            </div> 
            <div class="px-2 col-span-6 sm:col-span-2">
                <div class="relative z-0 group mb-2">
                    <input type="text" autocomplete="off" name="weight" id="weight" value="{{$patient->medical_histories->weight}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                    <label for="weight" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.weight")}} (kg)</label>
                    <small id="weight_message" class="text_error pl-2 italic"></small>
                </div>
            </div>   
            <div class="px-2 col-span-6 mb-2">
                <ul class="w-full text-sm font-medium flex sm:flex-row flex-col">
                    <li class="w-full ">
                        <div class="flex items-center ps-3">
                            <input id="has_blood_transfusion" name="has_blood_transfusion" type="checkbox" value="1" {{$patient->medical_histories->has_blood_transfusion ? "checked" : ''}}  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <label for="has_blood_transfusion" class="w-full py-2 ms-2 text-sm font-medium paragraph_text">{{__("messages.has_blood_transfusion")}}</label>
                        </div>
                    </li>  
                </ul> 
            </div>
            <div class="px-2 col-span-6 md:col-span-3 hidden transfusion_row"> 
                <div class="relative z-0 group mb-5 mt-0 md:mt-6">
                    <div class="relative">
                        <div class="absolute inset-y-0 end-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 input_label_text" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        <input id="last_blood_transfusion" name="last_blood_transfusion" value="{{$patient->medical_histories->last_blood_transfusion ? date("d/m/Y",strtotime($patient->medical_histories->last_blood_transfusion)) : ''}}" autocomplete="off" datepicker datepicker-autohide type="text" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" ">
                    </div>
                    <label for="last_blood_transfusion" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.last_blood_transfusion")}}</label>
                    <small id="last_blood_transfusion_message" class="text_error pl-2 italic"></small>
                </div>
            </div> 
            <div class="px-2 col-span-6 mb-2">
                <ul class="w-full text-sm font-medium flex sm:flex-row flex-col">
                    <li class="w-full ">
                        <div class="flex items-center ps-3">
                            <input id="smoking" name="smoking" type="checkbox" value="1" {{$patient->medical_histories->smoking ? "checked" : ''}} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <label for="smoking" class="w-full py-2 ms-2 text-sm font-medium paragraph_text">{{__("messages.smoking")}}</label>
                        </div>
                    </li> 
                    <li class="w-full ">
                        <div class="flex items-center ps-3">
                            <input id="passive_smoking" name="passive_smoking" type="checkbox" value="1" {{$patient->medical_histories->passive_smoking ? "checked" : ''}} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <label for="passive_smoking" class="w-full py-2 ms-2 text-sm font-medium paragraph_text">{{__("messages.passive_smoking")}}</label>
                        </div>
                    </li> 
                </ul> 
            </div>
            <div class="px-2 col-span-6 hidden" id="smoking_details_row">
                <div class="relative z-0 mb-2 group">
                    <textarea autocomplete="off" name="smoking_details" id="smoking_details" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" >{{$patient->medical_histories->smoking_details}}</textarea>
                    <label for="smoking_details" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.smoking_details")}}</label>
                    <small id="smoking_details_message" class="text_error pl-2 italic"></small>
                </div>
            </div> 
            <div class="px-2 col-span-6 mb-2">
                <ul class="w-full text-sm font-medium flex sm:flex-row flex-col">
                    <li class="w-full ">
                        <div class="flex items-center ps-3">
                            <input id="alcohol_usage" name="alcohol_usage" type="checkbox" value="1" {{$patient->medical_histories->alcohol_usage ? "checked" : ''}}  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <label for="alcohol_usage" class="w-full py-2 ms-2 text-sm font-medium paragraph_text">{{__("messages.alcohol_usage")}}</label>
                        </div>
                    </li>  
                </ul> 
            </div>
            <div class="px-2 col-span-6 hidden" id="alcohol_details_row">
                <div class="relative z-0 mb-2 group">
                    <textarea autocomplete="off" name="alcohol_details" id="alcohol_details" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" >{{$patient->medical_histories->alcohol_details}}</textarea>
                    <label for="alcohol_details" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.alcohol_details")}}</label>
                    <small id="alcohol_details_message" class="text_error pl-2 italic"></small>
                </div>
            </div> 
            <div class="px-2 col-span-6 mb-2">
                <ul class="w-full text-sm font-medium flex sm:flex-row flex-col">
                    <li class="w-full ">
                        <div class="flex items-center ps-3">
                            <input id="has_allergies" name="has_allergies" type="checkbox" value="1" {{$patient->medical_histories->has_allergies ? "checked" : ''}}  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <label for="has_allergies" class="w-full py-2 ms-2 text-sm font-medium paragraph_text">{{__("messages.has_allergies")}}</label>
                        </div>
                    </li>  
                </ul> 
            </div>
            <div class="px-2 col-span-6 hidden" id="allergies_row">
                <div class="relative z-0 mb-2 group">
                    <textarea autocomplete="off" name="allergies_details" id="allergies_details" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" >{{$patient->medical_histories->allergies_details}}</textarea>
                    <label for="allergies_details" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.allergies_details")}}</label>
                    <small id="allergies_details_message" class="text_error pl-2 italic"></small>
                </div>
            </div>  
            <div class="px-2 col-span-6 mb-2">
                <ul class="w-full text-sm font-medium flex sm:flex-row flex-col">
                    <li class="w-full ">
                        <div class="flex items-center ps-3">
                            <input id="has_surgeries" name="has_surgeries" type="checkbox" value="1" {{$patient->medical_histories->has_surgeries ? "checked" : ''}} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <label for="has_surgeries" class="w-full py-2 ms-2 text-sm font-medium paragraph_text">{{__("messages.has_surgeries")}}</label>
                        </div>
                    </li>  
                </ul> 
            </div>
            <div class="px-2 col-span-6" id="surgery_details_row">
                <div class="relative z-0 mb-2 group">
                    <textarea autocomplete="off" name="surgery_details" id="surgery_details" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" >{{$patient->medical_histories->surgery_details}}</textarea>
                    <label for="surgery_details" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.surgery_details")}}</label>
                    <small id="surgery_details_message" class="text_error pl-2 italic"></small>
                </div>
            </div>  
            <div class="px-2 col-span-6 mb-2">
                <ul class="w-full text-sm font-medium flex sm:flex-row flex-col">
                    <li class="w-full ">
                        <div class="flex items-center ps-3">
                            <input id="drug_usage" name="drug_usage" type="checkbox" value="1" {{$patient->medical_histories->drug_usage ? "checked" : ''}} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <label for="drug_usage" class="w-full py-2 ms-2 text-sm font-medium paragraph_text">{{__("messages.drug_usage")}}</label>
                        </div>
                    </li>  
                </ul> 
            </div>
            <div class="px-2 col-span-6 md:col-span-3 hidden drug_details_row">
                <div class="relative z-0 mb-2 group">
                    <textarea autocomplete="off" name="drug_details" id="drug_details" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" >{{$patient->medical_histories->drug_details}}</textarea>
                    <label for="drug_details" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.drug_details")}}</label>
                    <small id="drug_details_message" class="text_error pl-2 italic"></small>
                </div>
            </div> 
            <div class="px-2 col-span-6 md:col-span-3 hidden drug_details_row"> 
                <div class="relative z-0 group mb-5 mt-0 md:mt-6">
                    <div class="relative">
                        <div class="absolute inset-y-0 end-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 input_label_text" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        <input id="last_drug_usage" name="last_drug_usage" value="{{$patient->medical_histories->last_drug_usage ? date("d/m/Y",strtotime($patient->medical_histories->last_drug_usage)) : ''}}" autocomplete="off" datepicker datepicker-autohide type="text" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" ">
                    </div>
                    <label for="last_drug_usage" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.last_drug_usage")}}</label>
                    <small id="last_drug_usage_message" class="text_error pl-2 italic"></small>
                </div>
            </div>  
            <div class="px-2 col-span-6 mb-2">
                <ul class="w-full text-sm font-medium flex sm:flex-row flex-col">
                    <li class="w-full ">
                        <div class="flex items-center ps-3">
                            <input id="urinary_incontinence" name="urinary_incontinence" type="checkbox" value="1" {{$patient->medical_histories->urinary_incontinence ? "checked" : ''}} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <label for="urinary_incontinence" class="w-full py-2 ms-2 text-sm font-medium paragraph_text">{{__("messages.urinary_incontinence")}}</label>
                        </div>
                    </li> 
                    <li class="w-full ">
                        <div class="flex items-center ps-3 urinary_incontinence_details_row">
                            <input id="urinary_incontinence_treatement" name="urinary_incontinence_treatement" type="checkbox" value="1" {{$patient->medical_histories->urinary_incontinence_treatement ? "checked" : ''}} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <label for="urinary_incontinence_treatement" class="w-full py-2 ms-2 text-sm font-medium paragraph_text">{{__("messages.urinary_incontinence_treatement")}}</label>
                        </div>
                    </li>  
                </ul> 
            </div>
            <div class="px-2 col-span-6 hidden urinary_incontinence_details_row">
                <div class="relative z-0 mb-2 group">
                    <textarea autocomplete="off" name="urinary_incontinence_details" id="urinary_incontinence_details" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" >{{$patient->medical_histories->urinary_incontinence_details}}</textarea>
                    <label for="urinary_incontinence_details" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.urinary_incontinence_details")}}</label>
                    <small id="urinary_incontinence_details_message" class="text_error pl-2 italic"></small>
                </div>
            </div> 
            <div class="px-2 col-span-6 hidden urinary_incontinence_treatement_row">
                <div class="relative z-0 mb-2 group">
                    <textarea autocomplete="off" name="urinary_incontinence_treatement_detail" id="urinary_incontinence_treatement_detail" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" >{{$patient->medical_histories->urinary_incontinence_treatement_detail}}</textarea>
                    <label for="urinary_incontinence_treatement_detail" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.urinary_incontinence_treatement_details")}}</label>
                    <small id="urinary_incontinence_treatement_detail_message" class="text_error pl-2 italic"></small>
                </div>
            </div> 
            <div class="px-2 col-span-6 mb-2">
                <ul class="w-full text-sm font-medium flex sm:flex-row flex-col">
                    <li class="w-full ">
                        <div class="flex items-center ps-3">
                            <input id="has_family_diseases" name="has_family_diseases" type="checkbox" value="1" {{$patient->medical_histories->has_family_diseases ? "checked" : ''}}  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <label for="has_family_diseases" class="w-full py-2 ms-2 text-sm font-medium paragraph_text">{{__("messages.has_family_diseases")}}</label>
                        </div>
                    </li>  
                </ul> 
            </div>
            <div class="px-2 col-span-6 hidden" id="family_diseases_details_row">
                <div class="relative z-0 mb-2 group">
                    <textarea autocomplete="off" name="family_diseases_details" id="family_diseases_details" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" >{{$patient->medical_histories->family_diseases_details}}</textarea>
                    <label for="family_diseases_details" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.family_diseases_details")}}</label>
                    <small id="family_diseases_details_message" class="text_error pl-2 italic"></small>
                </div>
            </div> 
            <div class="px-2 col-span-6 sm:col-span-3">
                <div class="relative z-0 mb-2 group">
                    <textarea autocomplete="off" name="pathological_history" id="pathological_history" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" >{{$patient->medical_histories->pathological_history}}</textarea>
                    <label for="pathological_history" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.pathological_history")}}</label>
                    <small id="pathological_history_message" class="text_error pl-2 italic"></small>
                </div>
            </div> 
            <div class="px-2 col-span-6 sm:col-span-3">
                <div class="relative z-0 mb-2 group">
                    <textarea autocomplete="off" name="other_non_pathological_history" id="other_non_pathological_history" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" >{{$patient->medical_histories->other_non_pathological_history}}</textarea>
                    <label for="other_non_pathological_history" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.other_non_pathological_history")}}</label>
                    <small id="other_non_pathological_history_message" class="text_error pl-2 italic"></small>
                </div>
            </div> 
            <div class="px-2 col-span-6">
                <div class="relative z-0 mb-2 group">
                    <textarea autocomplete="off" name="family_cancer_history" id="family_cancer_history" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" >{{$patient->medical_histories->family_cancer_history}}</textarea>
                    <label for="family_cancer_history" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.family_cancer_history")}}</label>
                    <small id="family_cancer_history_message" class="text_error pl-2 italic"></small>
                </div>
            </div>
              
            <div class="px-2 col-span-6 mb-2">
                <ul class="w-full text-sm font-medium flex sm:flex-row flex-col">
                    <li class="w-full ">
                        <div class="flex items-center ps-3">
                            <input id="has_insurance" name="has_insurance" type="checkbox" value="1" {{$patient->medical_histories->has_insurance ? "checked" : ''}} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <label for="has_insurance" class="w-full py-2 ms-2 text-sm font-medium paragraph_text">{{__("messages.has_insurance")}}</label>
                        </div>
                    </li>  
                </ul> 
            </div> 
            <div class="px-2 col-span-6 sm:col-span-3 hidden has_insurance_row">
                <div class="relative z-0 group mb-2">
                    <input type="text" autocomplete="off" name="insurance_name" id="insurance_name" value="{{$patient->medical_histories->insurance_name}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                    <label for="insurance_name" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.insurance_name")}}</label>
                    <small id="insurance_name_message" class="text_error pl-2 italic"></small>
                </div>
            </div>  
            <div class="px-2 col-span-6 sm:col-span-3 hidden has_insurance_row">
                <div class="relative z-0 group mb-2">
                    <input type="text" autocomplete="off" name="insurance_id" id="insurance_id" value="{{$patient->medical_histories->insurance_id}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                    <label for="insurance_id" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.insurance_id")}}</label>
                    <small id="insurance_id_message" class="text_error pl-2 italic"></small>
                </div>
            </div>  
            <div class="px-2 col-span-6 mb-2">
                <ul class="w-full text-sm font-medium flex sm:flex-row flex-col">
                    <li class="w-full ">
                        <div class="flex items-center ps-3">
                            <input id="has_vih_test" name="has_vih_test" type="checkbox" value="1" {{$patient->medical_histories->has_vih_test ? "checked" : ''}} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <label for="has_vih_test" class="w-full py-2 ms-2 text-sm font-medium paragraph_text">{{__("messages.has_vih_test")}}</label>
                        </div>
                    </li>  
                </ul> 
            </div>
            <div class="px-2 col-span-6 sm:col-span-3 hidden has_vih_test_row"> 
                <div class="relative z-0 group mb-5">
                    <div class="relative">
                        <div class="absolute inset-y-0 end-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 input_label_text" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        <input id="vih_last_test_date" name="vih_last_test_date" value="{{$patient->medical_histories->vih_last_test_date ? date("d/m/Y",strtotime($patient->medical_histories->vih_last_test_date)) : ''}}" autocomplete="off" datepicker datepicker-autohide type="text" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" ">
                    </div>
                    <label for="vih_last_test_date" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.vih_last_test_date")}}</label>
                    <small id="vih_last_test_date_message" class="text_error pl-2 italic"></small>
                </div>
            </div>  
            <div class="px-2 col-span-6 sm:col-span-3 hidden has_vih_test_row">
                <div class="relative z-0 group mb-2">
                    <input type="text" autocomplete="off" name="vih_result" id="vih_result" value="{{$patient->medical_histories->vih_result}}" value="{{$patient->medical_histories->vih_result}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                    <label for="vih_result" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.vih_result")}}</label>
                    <small id="vih_result_message" class="text_error pl-2 italic"></small>
                </div>
            </div> 
            <div class="px-2 col-span-6 mb-2">
                <ul class="w-full text-sm font-medium flex sm:flex-row flex-col">
                    <li class="w-full ">
                        <div class="flex items-center ps-3">
                            <input id="has_had_sex" name="has_had_sex" type="checkbox" value="1" {{$patient->medical_histories->has_had_sex ? "checked" : ''}} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <label for="has_had_sex" class="w-full py-2 ms-2 text-sm font-medium paragraph_text">{{__("messages.has_had_sex")}}</label>
                        </div>
                    </li>   
                </ul> 
            </div>
            <div class="px-2 col-span-6 mb-2 hidden has_had_sex_row">
                <ul class="w-full text-sm font-medium flex sm:flex-row flex-col"> 
                    <li class="w-full ">
                        <div class="flex items-center ps-3">
                            <input id="has_stable_partner" name="has_stable_partner" type="checkbox" value="1" {{$patient->medical_histories->has_stable_partner ? "checked" : ''}} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <label for="has_stable_partner" class="w-full py-2 ms-2 text-sm font-medium paragraph_text">{{__("messages.has_stable_partner")}}</label>
                        </div>
                    </li>  
                    <li class="w-full ">
                        <div class="flex items-center ps-3">
                            <input id="condom_usage" name="condom_usage" type="checkbox" value="1" {{$patient->medical_histories->condom_usage ? "checked" : ''}}  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <label for="condom_usage" class="w-full py-2 ms-2 text-sm font-medium paragraph_text">{{__("messages.condom_usage")}}</label>
                        </div>
                    </li>  
                </ul> 
            </div>
            <div class="px-2 col-span-6 md:col-span-3 hidden has_had_sex_row"> 
                <div class="relative z-0 group mb-5">
                    <div class="relative">
                        <div class="absolute inset-y-0 end-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 input_label_text" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        <input id="last_sex_with_partner" name="last_sex_with_partner" value="{{$patient->medical_histories->last_sex_with_partner ? date("d/m/Y",strtotime($patient->medical_histories->last_sex_with_partner)) : ''}}" autocomplete="off" datepicker datepicker-autohide type="text" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" ">
                    </div>
                    <label for="last_sex_with_partner" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.last_sex_with_partner")}}</label>
                    <small id="last_sex_with_partner_message" class="text_error pl-2 italic"></small>
                </div>
            </div> 
            <div class="px-2 col-span-6 md:col-span-3 hidden has_had_sex_row"> 
                <div class="relative z-0 group mb-5">
                    <div class="relative">
                        <div class="absolute inset-y-0 end-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 input_label_text" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        <input id="last_sex_with_other" name="last_sex_with_other"  value="{{$patient->medical_histories->last_sex_with_other ? date("d/m/Y",strtotime($patient->medical_histories->last_sex_with_other)) : ''}}" autocomplete="off" datepicker datepicker-autohide type="text" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" ">
                    </div>
                    <label for="last_sex_with_other" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.last_sex_with_other")}}</label>
                    <small id="last_sex_with_other_message" class="text_error pl-2 italic"></small>
                </div>
            </div>  
            <div class="px-2 col-span-6 sm:col-span-3 hidden has_had_sex_row">
                <div class="relative z-0 group mb-2">
                    <input type="text" autocomplete="off" name="sexual_start_age" id="sexual_start_age" value="{{$patient->medical_histories->sexual_start_age}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                    <label for="sexual_start_age" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.sexual_start_age")}}</label>
                    <small id="sexual_start_age_message" class="text_error pl-2 italic"></small>
                </div>
            </div>  
            <div class="px-2 col-span-6 sm:col-span-3 hidden has_had_sex_row">
                <div class="relative z-0 group mb-2">
                    <input type="text" autocomplete="off" name="sexual_partners_count" id="sexual_partners_count" value="{{$patient->medical_histories->sexual_partners_count}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                    <label for="sexual_partners_count" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.sexual_partners_count")}}</label>
                    <small id="sexual_partners_count_message" class="text_error pl-2 italic"></small>
                </div>
            </div>     
            @if($patient->user->gender == "female") 
                <div class="px-2 col-span-6 mb-2 hidden has_had_sex_row">
                    <ul class="w-full text-sm font-medium flex sm:flex-row flex-col">
                        <li class="w-full ">
                            <div class="flex items-center ps-3">
                                <input id="sexual_pain" name="sexual_pain" type="checkbox" value="1" {{$patient->medical_histories->sexual_pain ? "checked" : ''}}  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                <label for="sexual_pain" class="w-full py-2 ms-2 text-sm font-medium paragraph_text">{{__("messages.sexual_pain")}}</label>
                            </div>
                        </li>  
                        <li class="w-full ">
                            <div class="flex items-center ps-3">
                                <input id="sexual_discomfort" name="sexual_discomfort" type="checkbox" value="1" {{$patient->medical_histories->sexual_discomfort ? "checked" : ''}}  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                <label for="sexual_discomfort" class="w-full py-2 ms-2 text-sm font-medium paragraph_text">{{__("messages.sexual_discomfort")}}</label>
                            </div>
                        </li>  
                    </ul> 
                </div>
                <div class="px-2 col-span-6 mb-2 hidden has_had_sex_row">
                    <ul class="w-full text-sm font-medium flex sm:flex-row flex-col">
                        <li class="w-full ">
                            <div class="flex items-center ps-3">
                                <input id="sexual_sensibility" name="sexual_sensibility" type="checkbox" value="1" {{$patient->medical_histories->sexual_sensibility ? "checked" : ''}}  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                <label for="sexual_sensibility" class="w-full py-2 ms-2 text-sm font-medium paragraph_text">{{__("messages.sexual_sensibility")}}</label>
                            </div>
                        </li>  
                        <li class="w-full ">
                            <div class="flex items-center ps-3">
                                <input id="sexual_dryness" name="sexual_dryness" type="checkbox" value="1" {{$patient->medical_histories->sexual_dryness ? "checked" : ''}}  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                <label for="sexual_dryness" class="w-full py-2 ms-2 text-sm font-medium paragraph_text">{{__("messages.sexual_dryness")}}</label>
                            </div>
                        </li>  
                    </ul> 
                </div>
                <div class="px-2 col-span-6 sm:col-span-3 mt-0 md:mt-6 hidden sexual_pain_row">
                    <div class="relative z-0 group mb-2">
                        <input type="text" autocomplete="off" name="sexual_pain_frequency" id="sexual_pain_frequency" value="{{$patient->medical_histories->sexual_pain_frequency}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                        <label for="sexual_pain_frequency" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.sexual_pain_frequency")}}</label>
                        <small id="sexual_pain_frequency_message" class="text_error pl-2 italic"></small>
                    </div>
                </div>   
                <div class="px-2 col-span-6 sm:col-span-3 hidden sexual_pain_row"> 
                </div>   
                <div class="px-2 col-span-6 mb-2">
                    <ul class="w-full text-sm font-medium flex sm:flex-row flex-col">
                        <li class="w-full ">
                            <div class="flex items-center ps-3">
                                <input id="metrorrhagia" name="metrorrhagia" type="checkbox" value="1" {{$patient->medical_histories->metrorrhagia ? "checked" : ''}}  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                <label for="metrorrhagia" class="w-full py-2 ms-2 text-sm font-medium paragraph_text">{{__("messages.metrorrhagia")}}</label>
                            </div>
                        </li>   
                    </ul> 
                </div> 
                <div class="px-2 col-span-6">
                    <div class="relative z-0 mb-2 group hidden metrorrhagia_row">
                        <textarea autocomplete="off" name="metrorrhagia_detail" id="metrorrhagia_detail" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" >{{$patient->medical_histories->metrorrhagia_detail}}</textarea>
                        <label for="metrorrhagia_detail" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.metrorrhagia_detail")}}</label>
                        <small id="metrorrhagia_detail_message" class="text_error pl-2 italic"></small>
                    </div>
                </div> 
                <div class="px-2 col-span-6 mb-2">
                    <ul class="w-full text-sm font-medium flex sm:flex-row flex-col">
                        <li class="w-full ">
                            <div class="flex items-center ps-3">
                                <input id="leukorrhea" name="leukorrhea" type="checkbox" value="1" {{$patient->medical_histories->leukorrhea ? "checked" : ''}}  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                <label for="leukorrhea" class="w-full py-2 ms-2 text-sm font-medium paragraph_text">{{__("messages.leukorrhea")}}</label>
                            </div>
                        </li>   
                    </ul> 
                </div> 
                <div class="px-2 col-span-6">
                    <div class="relative z-0 mb-2 group hidden leukorrhea_row">
                        <textarea autocomplete="off" name="leukorrhea_detail" id="leukorrhea_detail" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" >{{$patient->medical_histories->leukorrhea_detail}}</textarea>
                        <label for="leukorrhea_detail" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.leukorrhea_detail")}}</label>
                        <small id="leukorrhea_detail_message" class="text_error pl-2 italic"></small>
                    </div>
                </div> 
                <div class="px-2 col-span-6 mb-2">
                    <ul class="w-full text-sm font-medium flex sm:flex-row flex-col">
                        <li class="w-full ">
                            <div class="flex items-center ps-3">
                                <input id="pruritus" name="pruritus" type="checkbox" value="1" {{$patient->medical_histories->pruritus ? "checked" : ''}}  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                <label for="pruritus" class="w-full py-2 ms-2 text-sm font-medium paragraph_text">{{__("messages.pruritus")}}</label>
                            </div>
                        </li>   
                    </ul> 
                </div> 
                <div class="px-2 col-span-6">
                    <div class="relative z-0 mb-2 group hidden pruritus_row">
                        <textarea autocomplete="off" name="pruritus_detail" id="pruritus_detail" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" >{{$patient->medical_histories->pruritus_detail}}</textarea>
                        <label for="pruritus_detail" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.pruritus_detail")}}</label>
                        <small id="pruritus_detail_message" class="text_error pl-2 italic"></small>
                    </div>
                </div> 
                <div class="px-2 col-span-6 sm:col-span-3">
                    <div class="relative z-0 group mb-2">
                        <input type="text" autocomplete="off" name="menstrual_rhythm" id="menstrual_rhythm" value="{{$patient->medical_histories->menstrual_rhythm}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                        <label for="menstrual_rhythm" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.menstrual_rhythm")}}</label>
                        <small id="menstrual_rhythm_message" class="text_error pl-2 italic"></small>
                    </div>
                </div>  
                <div class="px-2 col-span-6 sm:col-span-3"> 
                    <div class="relative z-0 group mb-5">
                        <div class="relative">
                            <div class="absolute inset-y-0 end-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 input_label_text" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>
                            <input id="last_menstrual" name="last_menstrual" value="{{$patient->medical_histories->last_menstrual ? date("d/m/Y",strtotime($patient->medical_histories->last_menstrual)) : ''}}" autocomplete="off" datepicker datepicker-autohide type="text" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" ">
                        </div>
                        <label for="last_menstrual" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.last_menstrual")}}</label>
                    </div>
                </div>  
                <div class="px-2 col-span-6 sm:col-span-3 mt-0 md:mt-6">
                    <div class="relative z-0 group mb-2">
                        <input type="text" autocomplete="off" name="menarche" id="menarche" value="{{$patient->medical_histories->menarche}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                        <label for="menarche" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.menarche")}}</label>
                        <small id="menarche_message" class="text_error pl-2 italic"></small>
                    </div>
                </div> 
                <div class="px-2 col-span-6 sm:col-span-3">
                    <div class="relative z-0 mb-2 group">
                        <textarea autocomplete="off" name="gynecological_history" id="gynecological_history" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" >{{$patient->medical_histories->gynecological_history}}</textarea>
                        <label for="gynecological_history" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.gynecological_history")}}</label>
                        <small id="gynecological_history_message" class="text_error pl-2 italic"></small>
                    </div>
                </div>  
                <div class="px-2 col-span-3 sm:col-span-2 mt-0 md:mt-6">
                    <div class="relative z-0 group mb-2">
                        <input type="number" autocomplete="off" name="gestation" id="gestation" value="{{$patient->medical_histories->gestation}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                        <label for="gestation" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.gestation")}}</label>
                        <small id="gestation_message" class="text_error pl-2 italic"></small>
                    </div>
                </div> 
                <div class="px-2 col-span-3 sm:col-span-2 mt-0 md:mt-6">
                    <div class="relative z-0 group mb-2">
                        <input type="number" autocomplete="off" name="birth" id="birth" value="{{$patient->medical_histories->birth}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                        <label for="birth" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.birth")}}</label>
                        <small id="birth_message" class="text_error pl-2 italic"></small>
                    </div>
                </div> 
                <div class="px-2 col-span-3 sm:col-span-2 mt-0 md:mt-6">
                    <div class="relative z-0 group mb-2">
                        <input type="number" autocomplete="off" name="abortion" id="abortion" value="{{$patient->medical_histories->abortion}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                        <label for="abortion" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.abortion")}}</label>
                        <small id="abortion_message" class="text_error pl-2 italic"></small>
                    </div>
                </div> 
                <div class="px-2 col-span-3 sm:col-span-2 mt-0 md:mt-6">
                    <div class="relative z-0 group mb-2">
                        <input type="number" autocomplete="off" name="cesarean" id="cesarean" value="{{$patient->medical_histories->cesarean}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                        <label for="cesarean" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.cesarean")}}</label>
                        <small id="cesarean_message" class="text_error pl-2 italic"></small>
                    </div>
                </div> 
            @endif
            <div class="col-span-6 text-center md:text-right">  
                <button class="button_success rounded-md px-10 py-2">{{__("messages.save")}}</button>
            </div>
        </div>
    </section>
</form>