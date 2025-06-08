<section  class="grid grid-cols-12 gap-y-4 gap-x-0 md:gap-4 mx-4">  
    <div class="col-span-12">
        <div class="rounded-lg overflow-hidden" id="pdf-preview" class="h-0">
            
        </div>
    </div>
    <section class="px w-full col-span-12 md:col-span-8 h-fit order-2 sm:order-1">
        <div class="border-b border-gray-200 dark:border-gray-700">
            <ul class="grid grid-cols-2 -mb-px text-xs md:text-sm font-medium tab_text gap-1 mx-2" id="tabList">
                <li class="col-span-1" role="presentation">
                    <button onClick="showTab('#tab-detail',this)" class="h-full inline-flex items-center px-4 py-3 rounded-t-lg  w-full tab_text_active tab_background_active">
                        {{__("messages.detail")}}
                    </button>
                </li>
                <li class="col-span-1" role="presentation">
                    <button onClick="showTab('#tab-record',this)" class="h-full inline-flex items-center px-4 py-3 rounded-t-lg w-full tab_text tab_background">
                        {{__("messages.record")}}
                    </button>
                </li> 
            </ul>
        </div>
        <div id="default-tab-content" class="bg_secondary rounded-b-lg pb-4 md:px-4">
            <div class="tab-item rounded-lg pt-2" id="tab-detail" >
                @include("../components/patient/detailTab",[
                    "hiddeButton" => false
                ])
            </div>
            <div class="hidden tab-item pt-2 pb-8 rounded-lg" id="tab-record" >
                @include("../components/patient/recordTab")
            </div>
        </div>
    </section>
    <section class="bg_secondary px-3 md:px-7 pt-5 pb-5 w-full rounded-t-lg col-span-12 md:col-span-4 relative grid grid-cols-1 md:grid-cols-2 h-fit order-1 sm:order-2"> 
        <div class="col-span-2 text-right">
            <button type="button" onclick="recordMedical({{$patient}})" class="inverted button_success border-2 p-1 rounded-lg" title="Crear PDF">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-printer"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"></path><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"></path><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z"></path></svg>
            </button>
        </div>
        <h1 class="col-span-2 text-center text-2xl font-bold title_text mb-4">{{__("messages.patientDetail")}}</h1>    
        <div class="px-2 col-span-2 mb-2">
            <img id="img-user" width="200" height="200" alt="Image picture" class="border-2 b-[#444444] m-auto h-[150px] w-[150px] mb-4 rounded-full" src="{{ $patient->image ? asset("../storage/app/").'/'.$patient->image : asset('/resources/img/user.png') }}" /> 
        </div> 
        <hr class="px-2 col-span-2 mb-5">  
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
                <select name="patient_country" id="patient_country" disabled class="bg_secondary block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                    @foreach ($countries as $key => $item)
                        <option value="{{$key}}" {{($patient->country == "" && $key == "MX") || $patient->country == $key ? "selected" : ""}} >{{$item}}</option>
                    @endforeach
                </select>
                <label for="patient_country" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.country")}}</label>
            </div>
        </div> 
        <div class="px-2 col-span-2 md:col-span-1">
            <div class="relative z-0 group mb-5">
                <select name="bloodType" id="bloodType" disabled class="bg_secondary block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
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
        <div class="px-2 col-span-2 md:col-span-1 {{Auth::user()->role == 2 ? 'hidden' : ''}}">
            <div class="relative z-0 group mb-5">
                <select name="doctor" id="doctor" disabled class="bg_secondary block p-2 w-full text-sm input_text border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                    <option>{{$patient->doctor->user->first_name}} {{$patient->doctor->user->last_name}}</option> 
                </select> 
                <label for="doctor" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.isPatienteFrom")}}</label>
            </div>
        </div>   
    </section>
</section>