@extends('layouts.public',[ 'current_route'  => 'medicals'])

@section('title', __('routes.medicals')) 

@section('content')  
    <section class="pb-20 pt-40 bg-blue-950 bg-fixed bg-no-repeat bg-cover bg-center  relative">
        <div class="container mx-auto"> 
            <h3 class="text-center text-[#fafafa] text-2xl md:text-4xl font-medium">
                {{__("messages.searchMedical")}}
            </h3>
            <hr class="mb-10 mt-4">
            <form action="">
                <div class="grid grid-cols-3 gap-2 mx-4">
                    <div class="col-span-3 md:col-span-1">
                        <div class="relative z-0 mb-2 group">
                            <input type="text" autocomplete="off" name="name" id="name" class="block py-2 px-0 w-full text-sm text-[#fafafa] bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                            <label for="name" class="peer-focus:font-medium absolute text-sm text-[#fafafa] duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-[#fafafa] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.name")}}</label>
                        </div>
                    </div>
                    <div class="col-span-3 md:col-span-1"> 
                        <div class="relative z-0 group mb-2">
                            <select name="medical_unit" id="medical_unit" class="bg-blue-950 block p-2 w-full text-sm text-gray-200 border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                                <option value=""></option>
                                @foreach ($medicalUnits as $item) 
                                    <option value="{{$item->id}}" {{$medicalUnit == $item->id ? "selected" : ""}}>{{$item->name}}</option>
                                @endforeach
                            </select> 
                            <label for="medical_unit" class="z-10 peer-focus:font-medium absolute text-sm text-[#fafafa] duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-[#fafafa] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("routes.medical_unit")}}</label>
                        </div> 
                    </div>
                    <div class="col-span-3 md:col-span-1">
                        <div class="relative z-0 group mb-2">
                            <select name="specialty" id="specialty" class="bg-blue-950 block p-2 w-full text-sm text-gray-200 border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                                <option value=""></option>
                                @foreach ($specialties as $speiclalty) 
                                    <option value="{{$speiclalty->id}}">{{__("specialties.".$speiclalty->name)}}</option>
                                @endforeach
                            </select> 
                            <label for="specialty" class="z-10 peer-focus:font-medium absolute text-sm text-[#fafafa] duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-[#fafafa] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("routes.specialties")}}</label>
                        </div> 
                    </div>
                </div>
            </form>
        </div>
    </section>
    <section class="pb-32 pt-8 bg-[#fafafa]">
        <div class="md:container mx-auto"> 
            <div class="grid grid-cols-2 gap-2" id="medicalsContent"> 
                <!--
                foreach ($medicals as $medical)
                    <div class="col-span-2 md:col-span-1">  
                        <div class="bg-white border border-gray-200 rounded-lg shadow m-4 h-full">
                            <div class="flex flex-col items-center pb-10 mt-8">
                                <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="$medical->image ? asset("/storage/app/").'/'.$medical->image : asset('/resources/img/user.png')}}" alt="$medical->fullname}}"/>
                                <h5 class="mb-1  mx-4 text-xl font-medium text-gray-800 dark:text-white">$medical->fullname}}</h5> 
                                <div class="flex flex-col md:flex-row gap-2 mx-10">
                                    foreach (json_decode($medical->specialties) as $specialty)
                                        <span class="text-sm text-gray-100 bg-blue-900 rounded py-1 px-2 flex items-center justify-center">
                                            $specialty}}
                                        </span>
                                    endforeach
                                </div>
                                <button class="button_secondary rounded py-2 px-4 mt-4">{{__("messages.addAppointment")}}</button>
                            </div>
                        </div>  
                    </div>  
                endforeach
                -->
            </div>
            <div id="pagination"></div>
        </div>
    </section>  
@stop

@section("scripts")   
    <script>
        const url = '{{$_['baseURL']."/medicals/list?page="}}'; 
        let currentPage = {{$page}}; 
        const withoutMedicalsSearch = "{{__('messages.withoutDoctors')}}";
        const addAppointmentText = '{{__("messages.scheduleAppointment")}}';
        const address = "{{__('messages.address')}}";
        const addresses = "{{__('messages.addresses')}}";
        const msg = "{{isset($_GET['msg']) ? $_GET['msg'] : ""}}";
        const currentURL = baseURL + "/medicals";
        
        if(msg){
            createAlert(...msg.split("_"));
            window.history.pushState({}, title, currentURL);
        }
    </script>
    <script src="{{ asset('/resources/js/public/medicals.js') }}"></script>  
@stop