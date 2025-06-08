<div  class="grid grid-cols-1 md:grid-cols-7 gap-y-4 gap-x-0 md:gap-4 mx-4">  
    <div class="col-span-7">
        <div class="rounded-lg overflow-hidden" id="pdf-preview" class="h-0">
            
        </div>
    </div>
    <section class="bg_secondary px-3 md:px-7 pt-5 pb-5 w-full rounded-lg col-span-6 md:col-span-2 relative h-fit">
         <h2 class="title_text px-4 py-3 text-2xl">
            Variables
         </h2>
         <article class="bg_modal p-4 rounded-lg h-[400px] overflow-auto">
            <div class="paragraph_text text-sm mb-2">
                <strong>$patient_fullName$</strong>
                <small class="block px-4">{{__("messages.patientFullNameText")}}</small>
            </div>
            <hr>
            <div class="paragraph_text text-sm my-2">
                <strong>$patient_first_name$</strong>
                <small class="block px-4">{{__("messages.patientFirstName")}}</small>
            </div>
            <hr>
            <div class="paragraph_text text-sm my-2">
                <strong>$patient_last_name$</strong>
                <small class="block px-4">{{__("messages.patientLastName")}}</small>
            </div>  
            <hr>
            <div class="paragraph_text text-sm my-2">
                <strong>$patient_fullAddress$</strong>
                <small class="block px-4">{{__("messages.patientFullAddress")}}</small>
            </div>
            <hr>
            <div class="paragraph_text text-sm my-2">
                <strong>$patient_address$</strong>
                <small class="block px-4">{{__("messages.patientAddress")}}</small>
            </div>
            <hr>
            <div class="paragraph_text text-sm my-2">
                <strong>$patient_city$</strong> 
                <small class="block px-4">{{__("messages.patientCity")}}</small>
            </div>
            <hr>
            <div class="paragraph_text text-sm my-2">
                <strong>$patient_state$</strong>
                <small class="block px-4">{{__("messages.patientState")}}</small>
            </div>
            <hr>
            <div class="paragraph_text text-sm my-2">
                <strong>$patient_country$</strong>
                <small class="block px-4">{{__("messages.patientCountry")}}</small>
            </div>
            <hr>
            <div class="paragraph_text text-sm my-2">
                <strong>$patient_blood_type$</strong>
                <small class="block px-4">{{__("messages.patientBloodType")}}</small>
            </div>
            <hr>
            <div class="paragraph_text text-sm mb-2">
                <strong>$medical_fullName$</strong>
                <small class="block px-4">{{__("messages.medicalFullNameText")}}</small>
            </div>
            <hr>
            <div class="paragraph_text text-sm my-2">
                <strong>$medical_first_name$</strong>
                <small class="block px-4">{{__("messages.medicalFirstName")}}</small>
            </div>
            <hr>
            <div class="paragraph_text text-sm my-2">
                <strong>$medical_last_name$</strong>
                <small class="block px-4">{{__("messages.medicalLastName")}}</small>
            </div>  
            <hr>
            <div class="paragraph_text text-sm my-2">
                <strong>$medical_fullAddress$</strong>
                <small class="block px-4">{{__("messages.medicalFullAddress")}}</small>
            </div>
            <hr>
            <div class="paragraph_text text-sm my-2">
                <strong>$medical_address$</strong>
                <small class="block px-4">{{__("messages.medicalAddress")}}</small>
            </div>
            <hr>
            <div class="paragraph_text text-sm my-2">
                <strong>$medical_city$</strong> 
                <small class="block px-4">{{__("messages.medicalCity")}}</small>
            </div>
            <hr>
            <div class="paragraph_text text-sm my-2">
                <strong>$medical_state$</strong>
                <small class="block px-4">{{__("messages.medicalState")}}</small>
            </div>
            <hr>
            <div class="paragraph_text text-sm my-2">
                <strong>$medical_country$</strong>
                <small class="block px-4">{{__("messages.medicalCountry")}}</small>
            </div>
            <hr>
         </article>
    </section>
    <section class="bg_secondary px-3 md:px-7 pt-5 pb-5 w-full rounded-b-lg col-span-6 md:col-span-5 h-fit"> 
        <form id="form_certificate">
            <div class="px-2 col-span-2 md:col-span-1">
                <div class="relative z-0 mb-2 group">
                    <input type="text" autocomplete="off" name="title" id="title" value="{{$certificate->title}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                    <label for="title" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.title")}}</label>
                    <small id="title_message" class="text_error pl-2 italic"></small>
                </div>
            </div> 
            <label for="content" class="title_text px-4 py-3 text-xl">{{__("messages.content")}}</label>
            <hr>
            <div id="editorContent" class="mt-2">
                <div> 
                    <div id="contentEditor" class="editor-container"></div>    
                    <small id="content_message" class="text_error pl-2 italic"></small>
                    <textarea name="content" id="content" cols="30" rows="10" class="rounded-lg w-full p-2 mt-2 border" style="display: none;"></textarea>
                </div>
            </div>
            <div class="grid grid-cols-2"> 
                <div class="px-2 mt-4 cols-span-2 md:col-span-1">
                    <div class="relative z-0 mt-2 group">
                        <textarea autocomplete="off" name="notes" id="notes" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" >{{$certificate->notes}}</textarea>
                        <label for="notes" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.notes")}}</label>
                        <small id="notes_message" class="text_error pl-2 italic"></small>
                    </div>
                </div>  
                <div class="px-2 col-span-2 md:col-span-1 {{Auth::user()->role == 2 ? 'hidden' : ''}}">
                    <div class="relative mt-4 z-0 group mb-2 mt-0 md:mt-11">
                        <select name="doctor" id="doctor" {{$certificate->doctor->id ? "disabled" : ""}} class="bg_secondary block p-2 w-full text-sm input_text border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                            <option value=""></option>
                            @foreach($doctors as $doctor)
                                <option value="{{$doctor->id}}" {{$certificate->doctor->id == $doctor->id ? "selected" : ""}} >{{$doctor->first_name}} {{$doctor->last_name}}</option>
                            @endforeach
                        </select> 
                        <label for="doctor" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("routes.medical")}}</label>
                        <small id="doctor_message" class="text_error pl-2 italic"></small>
                    </div>
                </div>
                <div class="px-2 col-span-2 md:col-span-1">
                    <div class="relative z-0 group mb-2 {{Auth::user()->role == 2 ? 'mb-2 mt-0 md:mt-11' : ''}}">
                        <select name="medical_unit" id="medical_unit" class="bg_secondary block p-2 w-full text-sm input_text border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                        </select> 
                        <label for="medical_unit" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("routes.medical_unit")}}</label>
                        <small id="medical_unit_message" class="text_error pl-2 italic"></small>
                    </div>
                </div>
                <div class="px-2 col-span-2 md:col-span-1">
                    <div class="relative z-0 group mb-2">
                        <select name="patient" id="patient" {{$certificate->patient->id ? "disabled" : ""}} class="bg_secondary block p-2 w-full text-sm input_text border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                        </select> 
                        <label for="patient" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("routes.patient")}}</label>
                        <small id="patient_message" class="text_error pl-2 italic"></small>
                    </div>
                </div>
                <div class="px-2 col-span-2 md:col-span-1">
                    <div class="relative z-0 group mb-2">
                        <select name="type" id="type" class="bg_secondary block p-2 w-full text-sm input_text border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                            <option value=""></option>
                            <option value="1" {{$certificate->type == 1 ? "selected" : ""}}>{{__("messages.medicalCertificate")}}</option>
                            <option value="2" {{$certificate->type == 2 ? "selected" : ""}}>{{__("messages.certificate")}}</option>
                            <option value="3" {{$certificate->type == 3 ? "selected" : ""}}>{{__("messages.recipe")}}</option>
                        </select> 
                        <label for="type" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.type")}}</label>
                        <small id="type_message" class="text_error pl-2 italic"></small>
                    </div>
                </div>
                <div class="px-2 col-span-2 md:col-span-1"> 
                    <div class="relative z-0 mb md:mb-2 group ">
                        <div class="relative">
                            <div class="absolute inset-y-0 end-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 input_label_text" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>
                            <input id="expires_at" name="expires_at" value="{{$certificate->expires_at ? date("d/m/Y",strtotime($certificate->expires_at)) : ""}}" autocomplete="off" datepicker datepicker-autohide type="text" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" ">
                        </div>
                        <label for="expires_at" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.expedition")}}</label>
                        <small id="expires_at_message" class="text_error pl-2 italic"></small>
                    </div>
                </div>
            </div>
            <div class="text-right mt-4">
                <input type="hidden" value="{{$request->id}}" name="request_id" id="request_id">
                <button class="button_success rounded-md px-10 py-2">{{__("messages.save")}}</button>
            </div>
        </form>
    </section>
</div>