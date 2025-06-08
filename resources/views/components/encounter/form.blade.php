<form action="#" method="POST" id="form_encounter"  class="grid grid-cols-1 md:grid-cols-6 gap-y-4 gap-x-0 md:gap-4 mx-4">  
    <section class="bg_secondary px-7 pt-5 pb-5 w-full rounded-lg col-span-6 md:col-span-2 relative h-fit">
        @csrf <!-- {{ csrf_field() }} -->  
        <hr>
        <div class="grid grid-cols-1 md:grid-cols-2 mt-4">  
            <div class="px-2 col-span-2 md:col-span-1 {{Auth::user()->role == 2 ? 'hidden' : ''}}">
                <div class="relative z-0 group mb-2">
                    <select name="doctor" id="doctor" {{$encounter->doctor->id ? "disabled" : ""}} class="bg_secondary block p-2 w-full text-sm input_text input_border bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer">
                        <option value=""></option>
                        @foreach($doctors as $doctor)
                            <option value="{{$doctor->id}}" {{$encounter->doctor->id == $doctor->id ? "selected" : ""}} >{{$doctor->first_name}} {{$doctor->last_name}}</option>
                        @endforeach
                    </select> 
                    <label for="doctor" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("routes.medical")}}</label>
                    <small id="doctor_message" class="text_error pl-2 italic"></small>
                </div>
            </div>
            <div class="px-2 col-span-2 md:col-span-1">
                <div class="relative z-0 group mb-2">
                    <select name="patient" id="patient" {{$encounter->patient->id ? "disabled" : ""}} class="bg_secondary block p-2 w-full text-sm input_text input_border bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer">
                        <option value=""></option>
                        @foreach($patients as $patient)
                            <option value="{{$patient->id}}" {{$encounter->patient->id == $patient->id ? "selected" : ""}} >{{$patient->first_name}} {{$patient->last_name}}</option>
                        @endforeach
                    </select> 
                    <label for="patient" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("routes.patient")}}</label>
                    <small id="patient_message" class="text_error pl-2 italic"></small>
                </div>
            </div>
            <div class="px-2 col-span-2 md:col-span-1">
                <div class="relative z-0 group mb-2">
                    <select name="medical_unit" id="medical_unit" class="bg_secondary block p-2 w-full text-sm input_text input_border bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer">
                    </select> 
                    <label for="medical_unit" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("routes.medical_unit")}}</label>
                    <small id="medical_unit_message" class="text_error pl-2 italic"></small>
                </div>
            </div>
            <div class="px-2 col-span-2">
                <div class="relative z-0 group mb-2 md:col-span-1">
                    <select onchange="setPrice()" name="subject" id="subject" class="bg_secondary block p-2 w-full text-sm input_text input_border bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer">
                        <option value=""></option>
                        @foreach($subjects as $subject)
                            <option value="{{$subject}}" {{$encounter->subject == $subject ? "selected" : ""}} >{{__("subjects.".$subject)}}</option>
                        @endforeach
                    </select> 
                    <label for="subject" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.subject")}}</label>
                    <small id="subject_message" class="text_error pl-2 italic"></small>
                </div>
            </div>   
        </div>
    </section>
    <section class="bg_secondary px-7 pt-5 pb-5 w-full rounded-lg col-span-6 md:col-span-4 relative h-fit"> 
        <h1 class="text-center text-2xl font-bold title_text mb-4">{{__($title)}}</h1>
        <hr>
        <div class="grid grid-cols-1 md:grid-cols-3 sm:mx-10 mt-4">  
            <h2 class="col-span-4 text-center text-md font-bold title_text mb-4">{{__("messages.patientInfo")}}</h2>
            <hr class="col-span-4 mb-4">
            <div class="col-span-4 mb-4 hidden" id="usePatientInfo">
                <div class="flex justify-end">
                    <div class="me-2 text-sm">
                        <label for="usePatientInfoCheck" class="font-medium paragraph_text">{{__("messages.usePatientInfo")}}</label> 
                    </div>
                    <div class="flex items-center  h-5">
                        <input id="usePatientInfoCheck" name="usePatientInfoCheck" aria-describedby="usePatientInfoCheck-text" type="checkbox" value="1" {{$encounter->usePatient ? "checked" : ""}} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    </div>
                </div>
            </div>
            <div class="px-2 col-span-3 md:col-span-1">
                <div class="relative z-0 mb-2 group">
                    <input type="text" autocomplete="off" name="first_name" id="first_name" value="{{$encounter->patient_first_name}}" class="block py-2.5 px-0 w-full text-sm input_text input_border bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                    <label for="first_name" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.first_name")}}</label>
                    <small id="first_name_message" class="text_error pl-2 italic"></small>
                </div>
            </div>  
            <div class="px-2 col-span-3 md:col-span-1">
                <div class="relative z-0 mb-2 group">
                    <input type="text" autocomplete="off" name="last_name" id="last_name" value="{{$encounter->patient_last_name}}" class="block py-2.5 px-0 w-full text-sm input_text input_border bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                    <label for="last_name" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.last_name")}}</label>
                    <small id="last_name_message" class="text_error pl-2 italic"></small>
                </div>
            </div>  
            <div class="px-2 col-span-3 md:col-span-1">
                <div class="relative z-0 mb-2 group">
                    <input type="text" autocomplete="off" name="email" id="email" value="{{$encounter->patient_email}}" class="block py-2.5 px-0 w-full text-sm input_text input_border bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                    <label for="email" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">E-mail</label>
                    <small id="email_message" class="text_error pl-2 italic"></small>
                </div>
            </div>  
            <div class="px-2 col-span-3 md:col-span-1">
                <div class="relative z-0 mb-2 group">
                    <input type="text" autocomplete="off" name="phone" id="phone" value="{{$encounter->patient_phone}}" class="block py-2.5 px-0 w-full text-sm input_text input_border bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                    <label for="phone" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.phone")}}</label>
                    <small id="phone_message" class="text_error pl-2 italic"></small>
                </div>
            </div> 
            <div class="px-2 col-span-3 md:col-span-1"> 
                <div class="relative z-0 mb-2 group ">
                    <div class="relative max-w-sm">
                        <div class="absolute inset-y-0 end-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 input_label_text" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        <input id="dob" name="dob" value="{{$encounter->patient_dob ? date("d/m/Y",strtotime($encounter->patient_dob)) : ""}}" autocomplete="off" datepicker datepicker-autohide type="text" class="block py-2 px-0 w-full text-sm input_text input_border bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer" placeholder=" ">
                    </div>
                    <label for="dob" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.dob")}}</label>
                    <small id="dob_message" class="text_error pl-2 italic"></small>
                </div>
            </div>  
            <div class="px-2 col-span-3 md:col-span-1">
                <div class="relative z-0 group mb-2">
                    <select name="bloodType" id="bloodType" class="bg_secondary block p-2 w-full text-sm input_text input_border bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer">
                        <option value=""></option>
                        <option value="A+" {{"A+" == $encounter->patient_blood_type ? "selected" : ""}}>A+</option>
                        <option value="A-" {{"A-" == $encounter->patient_blood_type ? "selected" : ""}}>A-</option>
                        <option value="B+" {{"B+" == $encounter->patient_blood_type ? "selected" : ""}}>B+</option>
                        <option value="B-" {{"B-" == $encounter->patient_blood_type ? "selected" : ""}}>B-</option>
                        <option value="AB+" {{"AB+" == $encounter->patient_blood_type ? "selected" : ""}}>AB+</option>
                        <option value="AB-" {{"AB-" == $encounter->patient_blood_type ? "selected" : ""}}>AB-</option>
                        <option value="O+" {{"O+" == $encounter->patient_blood_type ? "selected" : ""}}>O+</option>
                        <option value="O-" {{"O-" == $encounter->patient_blood_type ? "selected" : ""}}>O-</option>
                    </select> 
                    <label for="bloodType" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.bloodType")}}</label>
                    <small id="bloodType_message" class="text_error pl-2 italic"></small>
                </div>
            </div>  
            <div class="px-2 col-span-3 md:col-span-1">
                <div class="relative z-0 group mb-2">
                    <select name="language" id="language" class="bg_secondary block p-2 w-full text-sm input_text input_border bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer">
                        <option value=""></option>
                        <option value="es" {{"es" == $encounter->patient_language ? "selected" : ""}}> 🇲🇽 {{__("language.es")}}</option>
                        <option value="en" {{"en" == $encounter->patient_language ? "selected" : ""}}> 🇺🇸 {{__("language.en")}}</option>
                    </select>
                    <label for="language" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.language")}}</label>
                    <small id="language_message" class="text_error pl-2 italic"></small>
                </div>
            </div>   
            <div class="px-2 col-span-3 md:col-span-1">
                <div class="relative z-0 group mb-2">
                    <select name="gender" id="gender" class="bg_secondary block p-2 w-full text-sm input_text input_border bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer">
                        <option value=""></option>
                        @foreach ($genders as $key => $item) 
                            <option value="{{$key}}" {{($key == $encounter->patient_gender && $encounter->patient_gender != null)? "selected" : ""}}>{{$item}}</option>
                        @endforeach
                    </select> 
                    <label for="gender" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.gender")}}</label>
                    <small id="gender_message" class="text_error pl-2 italic"></small>
                </div>
            </div>   
            <hr class="col-span-4 mb-4"> 
            <div class="col-span-4 mb-4">
                <div class="flex justify-end">
                    <div class="me-2 text-sm">
                        <label for="allergies" class="block text-right input_label_text">{{__("messages.haveAllergies")}}</label> 
                    </div>
                    <div class="flex items-center  h-5">
                        <input id="allergies" name="allergies" aria-describedby="allergies-text" type="checkbox" value="1" {{$encounter->allergies ? "checked" : ""}} class="w-4 h-4 text-gray-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    </div>
                </div>
            </div>
            <div class="col-span-4 mb-4 hidden" id="allergies_text_row">
                <div class="px-2 col-span-2 md:col-span-1">
                    <div class="relative z-0 mb-2 group">
                        <textarea autocomplete="off" name="allergies_text" id="allergies_text" class="block py-2.5 px-0 w-full text-sm input_text input_border bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer" placeholder="" >{{$encounter->allergies_text}}</textarea>
                        <label for="allergies_text" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.allergies")}}</label>
                        <small id="allergies_text_message" class="text_error pl-2 italic"></small>
                    </div>
                </div> 
            </div>
            <div class="col-span-4 mb-4">
                <div class="flex justify-end">
                    <div class="me-2 text-sm">
                        <label for="surgeries" class="block text-right input_label_text">{{__("messages.haveSurgeries")}}</label> 
                    </div>
                    <div class="flex items-center  h-5">
                        <input id="surgeries" name="surgeries" aria-describedby="surgeries-text" type="checkbox" value="1" {{$encounter->surgeries ? "checked" : ""}} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    </div>
                </div>
            </div>
            <div class="col-span-4 mb-4 hidden" id="surgeries_text_row">
                <div class="px-2 col-span-2 md:col-span-1">
                    <div class="relative z-0 mb-2 group">
                        <textarea autocomplete="off" name="surgeries_text" id="surgeries_text" class="block py-2.5 px-0 w-full text-sm input_text input_border bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer" placeholder="" >{{$encounter->surgeries_text}}</textarea>
                        <label for="surgeries_text" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.surgeries")}}</label>
                        <small id="surgeries_text_message" class="text_error pl-2 italic"></small>
                    </div>
                </div> 
            </div>
            <div class="col-span-4 mb-4">
                <div class="flex justify-end">
                    <div class="me-2 text-sm">
                        <label for="addictions" class="block text-right input_label_text">{{__("messages.haveAddictions")}}</label> 
                    </div>
                    <div class="flex items-center  h-5">
                        <input id="addictions" name="addictions" aria-describedby="addictions-text" type="checkbox" value="1" {{$encounter->addictions ? "checked" : ""}} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    </div>
                </div>
            </div>
            <div class="col-span-4 mb-4 hidden" id="addictions_text_row">
                <div class="px-2 col-span-2 md:col-span-1">
                    <div class="relative z-0 mb-2 group">
                        <textarea autocomplete="off" name="addictions_text" id="addictions_text" class="block py-2.5 px-0 w-full text-sm input_text input_border bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer" placeholder="" >{{$encounter->addictions_text}}</textarea>
                        <label for="addictions_text" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.addictions")}}</label>
                        <small id="addictions_text_message" class="text_error pl-2 italic"></small>
                    </div>
                </div> 
            </div> 
            <div class="col-span-4 mb-4">
                <div class="flex justify-end">
                    <div class="me-2 text-sm">
                        <label for="medications" class="block text-right input_label_text">{{__("messages.haveMedications")}}</label> 
                    </div>
                    <div class="flex items-center  h-5">
                        <input id="medications" name="medications" aria-describedby="medications-text" type="checkbox" value="1" {{$encounter->medications ? "checked" : ""}} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    </div>
                </div>
            </div>
            <div class="col-span-4 mb-4 hidden" id="medications_text_row">
                <div class="px-2 col-span-2 md:col-span-1">
                    <div class="relative z-0 mb-2 group">
                        <textarea autocomplete="off" name="medications_text" id="medications_text" class="block py-2.5 px-0 w-full text-sm input_text input_border bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer" placeholder="" >{{$encounter->medications_text}}</textarea>
                        <label for="medications_text" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.medications")}}</label>
                        <small id="medications_text_message" class="text_error pl-2 italic"></small>
                    </div>
                </div> 
            </div> 
        </div>
        <div class="grid grid-cols-12 sm:mx-10 mt-4"> 
            <hr class="col-span-12 mb-8">
            <div class="col-span-8 md:col-span-10 text-right input_label_text mb-6">
                <label for="">Subtotal:</label>
            </div>
            <div class="col-span-4 md:col-span-2 text-right input_label_text mb-6">
                <input type="text" value="{{$encounter->subtotal}}" autocomplete="off" name="subtotal" id="subtotal" readonly value="0" class="mx-2 w-full text-right input_text input_border bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 mt-[-9px]" placeholder="" />
            </div>
            @if($encounter->doctor->offer_discount || $encounter->discount != 0)
                <div class="col-span-8 md:col-span-10 text-right input_label_text">
                    <label for="">{{__("messages.discount")}}:</label>
                </div>
                <div class="col-span-4 md:col-span-2 text-right input_label_text">
                    <input type="text" value="{{$encounter->discount}}" autocomplete="off" name="discount" id="discount" value="{{$encounter->discount ?? '0'}}" class="mx-2 w-full text-right input_text input_border bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 mt-[-9px]" placeholder="" />
                </div>
            @endif
            <div class="col-span-12 text-center md:text-center mt-4">  
                <button class="button_success rounded-md px-10 py-2">{{__("messages.save")}}</button>
            </div>
        </div>
    </section>
</form>