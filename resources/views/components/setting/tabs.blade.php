<section class="bg-white dark:bg-slate-900 px md:px-7 pt-5 pb-5 w-full rounded-lg col-span-6 md:col-span-2 relative h-fit bg_modal">
    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="grid grid-cols-6 text-xs md:text-sm font-medium gap-[1px] mx-2" id="tabList">
            <li class="col-span-3 md:col-span-1" role="presentation">
                <button onClick="showTab('#tab-general',this)" class="h-full inline-flex items-center px-4 py-3 rounded-t-lg w-full tab_background_active tab_text_active">
                    {{__("messages.general")}}
                </button>
            </li>
            <li class="col-span-3 md:col-span-1" role="presentation">
                <button onClick="showTab('#tab-colors',this)" class="h-full inline-flex items-center px-4 py-3 rounded-t-lg w-full tab_background tab_text">
                    {{__("messages.colors")}}
                </button>
            </li>
            <li class="col-span-3 md:col-span-1" role="presentation">
                <button onClick="showTab('#tab-encounter_prices',this)" id="calendarButton" class="h-full inline-flex items-center px-4 py-3 rounded-t-lg w-full tab_background tab_text">
                    {{__("messages.encounter_prices")}}
                </button>
            </li> 
            <li class="col-span-3 md:col-span-1" role="presentation">
                <button onClick="showTab('#tab-specialties',this)" id="calendarButton" class="h-full inline-flex items-center px-4 py-3 rounded-t-lg w-full tab_background tab_text">
                    {{__("routes.specialties")}}
                </button>
            </li> 
        </ul>
    </div>
    <div id="default-tab-content" class="">
        <div class="tab-item p-4 pb-8 rounded-lg" id="tab-general" >
            @include('../components/setting/generalTab')
        </div>
        <div class="hidden tab-item p-4 pb-8 rounded-lg" id="tab-colors" >
            @include('../components/setting/colorTab')
        </div>
        <div class="hidden tab-item p-4 rounded-lg" id="tab-encounter_prices">
            <form id="pricesForm">
                <div class="grid grid-cols-4">
                    @foreach ($subjects as $langKey => $lang) 
                        <div class="col-span-1">
                            <h3 class="my-2 text-[#526270] dark:text-gray-400">{{__("language.".$langKey)}}</h3>
                            @foreach ($lang as $key => $item) 
                                <div class="relative z-0 mb-2 md:mb-4 group mx-2">
                                    <input type="text" id="{{$key}}_{{$langKey}}" name="lang[{{$langKey}}][{{$key}}]" value="{{$item}}" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                    <label for="{{$key}}_{{$langKey}}" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.name")}}</label>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                    <div>
                        <h3 class="my-2 text-[#526270] dark:text-gray-400">{{__("messages.prices")}}</h3>
                        @foreach (reset($subjects) as $key => $lang)  
                            <div class="relative z-0 mb-2 md:mb-4 group mx-2">
                                <input type="number" id="{{$key}}" name="key[{{$key}}][price]" value="{{$settings->contains('key', $key) ? str_replace('"',"",$settings->firstWhere('key', $key)->value) : 0}}" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                <label for="{{$key}}" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.price")}}</label>
                            </div>
                        @endforeach
                    </div>
                    <div>
                        <h3 class="my-2 text-[#526270] dark:text-gray-400">{{__("messages.encounterTime")}}</h3>
                        @foreach (reset($subjects) as $key => $lang)  
                            <div class="relative z-0 mb-2 md:mb-4 group mx-2">
                                <div class="flex">
                                    <input type="number" id="{{$key}}_time" name="key[{{$key}}][time]" value="{{$settings->contains('key', $key.'_time') ? str_replace('"',"",$settings->firstWhere('key', $key.'_time')->value) : 0}}" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                    <button type="button" class="button_error px-2 rounded" onclick="deleteRow('{{$key}}','pricesForm')">x</button>
                                </div>
                                <label for="{{$key}}_time" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.time")}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="flex justify-center">
                    <button class="flex items-center justify-center text-white bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-800 dark:hover:bg-emerald-900 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-8 py-2">
                        {{__("messages.save")}}
                    </button> 
                </div>
            </form>
            <div class="flex justify-end">
                <button onclick="addEncounter()" class="flex items-center justify-center button_primary focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-8 py-2">
                    {{__("messages.add")}}
                </button> 
            </div>
        </div> 
        <div class="hidden tab-item p-4 rounded-lg" id="tab-specialties">
            <form id="specialtiesForm">
                <div class="grid grid-cols-2">
                    @foreach ($specialties as $langKey => $lang) 
                        <div class="col-span-1">
                            <h3 class="my-2 text-[#526270] dark:text-gray-400">{{__("language.".$langKey)}}</h3>
                            @foreach ($lang as $key => $item) 
                                <div class="relative z-0 mb-2 md:mb-4 group mx-2">
                                    <input type="text" id="{{$key}}_{{$langKey}}" name="lang[{{$langKey}}][{{$key}}]" value="{{$item}}" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                    <label for="{{$key}}_{{$langKey}}" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.name")}}</label>
                                </div>
                            @endforeach
                        </div>
                    @endforeach 
                </div>
                <div class="flex justify-center">
                    <button class="flex items-center justify-center text-white bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-800 dark:hover:bg-emerald-900 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-8 py-2">
                        {{__("messages.save")}}
                    </button> 
                </div>
            </form>
            <div class="flex justify-end">
                <button onclick="addSpecialty()" class="flex items-center justify-center button_primary focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-8 py-2">
                    {{__("messages.add")}}
                </button> 
            </div>
        </div> 
    </div> 
</section>