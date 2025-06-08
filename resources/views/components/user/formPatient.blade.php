 <div id="formPatient" class=>
    <h1 class="text-center text-2xl font-bold title_text pb-4">{{__("messages.patientInfo")}}</h1>
    <hr />
    <div class="grid grid-cols-1 md:grid-cols-2 mt-4">  
        <div class="px-2 col-span-2 md:col-span-1"> 
            <div class="relative z-0 mb md:mb-2 group ">
                <div class="relative">
                    <div class="absolute inset-y-0 end-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 input_label_text" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                    </div>
                    <input id="dob" name="dob" value="{{$user->patient->dob ? date("d/m/Y",strtotime($user->patient->dob)) : ""}}" autocomplete="off" datepicker datepicker-autohide type="text" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" ">
                </div>
                <label for="dob" class="peer-focus:font-medium absolute text-sm input_label_text  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.dob")}}</label>
                <small id="dob_message" class="text_error pl-2 italic"></small>
            </div>
        </div>  
        <div class="px-2 col-span-2 md:col-span-1">
            <div class="relative z-0 mb md:mb-2 group">
                <input type="text" name="patient_address" id="patient_address" value="{{$user->patient->address}}" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                <label for="patient_address" class="peer-focus:font-medium absolute text-sm input_label_text  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.address")}}</label>
                <small id="patient_address_message" class="text_error pl-2 italic"></small>
            </div>
        </div> 
        <div class="px-2 col-span-2 md:col-span-1">
            <div class="relative z-0 mb md:mb-2 group">
                <input type="text" name="patient_city" id="patient_city" value="{{$user->patient->city}}" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                <label for="patient_city" class="peer-focus:font-medium absolute text-sm input_label_text  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.city")}}</label>
                <small id="patient_city_message" class="text_error pl-2 italic"></small>
            </div>
        </div> 
        <div class="px-2 col-span-2 md:col-span-1">
            <div class="relative z-0 mb md:mb-2 group">
                <input type="text" name="patient_state" id="patient_state" value="{{$user->patient->state}}" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                <label for="patient_state" class="peer-focus:font-medium absolute text-sm input_label_text  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.state")}}</label>
                <small id="patient_state_message" class="text_error pl-2 italic"></small>
            </div>
        </div> 
        <div class="px-2 col-span-2 md:col-span-1">
            <div class="relative z-0 mb md:mb-2 group">
                <input type="text" name="patient_zipcode" id="patient_zipcode" value="{{$user->patient->zipcode}}" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                <label for="patient_zipcode" class="peer-focus:font-medium absolute text-sm input_label_text  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.zipcode")}}</label>
                <small id="patient_zipcode_message" class="text_error pl-2 italic"></small>
            </div>
        </div> 
        <div class="px-2 col-span-2 md:col-span-1">
            <div class="relative z-0 mb md:mb-2 group">
                <select name="patient_country" id="patient_country" class="bg_secondary block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                    @foreach ($countries as $key => $item)
                        <option value="{{$key}}" {{($user->patient->country == "" && $key == "MX") || $user->patient->country == $key ? "selected" : ""}} >{{$item}}</option>
                    @endforeach
                </select>
                <label for="patient_country" class="z-10 peer-focus:font-medium absolute text-sm input_label_text  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.country")}}</label>
                <small id="patient_country_message" class="text_error pl-2 italic"></small>
            </div>
        </div> 
        <div class="px-2 col-span-2 md:col-span-1">
            <div class="relative z-0 group mb-2">
                <select name="bloodType" id="bloodType" class="bg_secondary block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                    <option value=""></option>
                    <option value="A+" {{"A+" == $user->patient->blood_type ? "selected" : ""}}>A+</option>
                    <option value="A-" {{"A-" == $user->patient->blood_type ? "selected" : ""}}>A-</option>
                    <option value="B+" {{"B+" == $user->patient->blood_type ? "selected" : ""}}>B+</option>
                    <option value="B-" {{"B-" == $user->patient->blood_type ? "selected" : ""}}>B-</option>
                    <option value="AB+" {{"AB+" == $user->patient->blood_type ? "selected" : ""}}>AB+</option>
                    <option value="AB-" {{"AB-" == $user->patient->blood_type ? "selected" : ""}}>AB-</option>
                    <option value="O+" {{"O+" == $user->patient->blood_type ? "selected" : ""}}>O+</option>
                    <option value="O-" {{"O-" == $user->patient->blood_type ? "selected" : ""}}>O-</option>
                </select> 
                <label for="bloodType" class="z-10 peer-focus:font-medium absolute text-sm input_label_text  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.bloodType")}}</label>
                <small id="bloodType_message" class="text_error pl-2 italic"></small>
            </div>
        </div>
        <div class="px-2 col-span-2 md:col-span-1 {{Auth::user()->role == 2 ? 'hidden' : ''}}">
            <div class="relative z-0 group mb-2">
                <select name="doctor" id="doctor" class="bg_secondary block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                    <option value=""></option>
                    @foreach($doctors as $doctor)
                        <option value="{{$doctor->id}}" {{$user->patient->doctor_id == $doctor->id ? "selected" : ""}} >{{$doctor->first_name}} {{$doctor->last_name}}</option>
                    @endforeach
                </select> 
                <label for="doctor" class="z-10 peer-focus:font-medium absolute text-sm input_label_text  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.isPatienteFrom")}}</label>
                <small id="doctor_message" class="text_error pl-2 italic"></small>
            </div>
        </div>
    </div>
</div>