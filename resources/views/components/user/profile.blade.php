<div class="grid grid-cols-1 md:grid-cols-12 gap-y-4 gap-x-0 md:gap-4 mx-4"> 
    <div class="bg_secondary px-3 md:px-7 pt-10 pb-5 w-full rounded-lg col-span-12 md:col-span-4 relative h-fit">
        <button type="button" id="delMain" class="button_error p-2 rounded-full absolute right-[36%] top-[15%] {{Auth::user()->image ? "" : "hidden"}}" >
            <svg  xmlns="http://www.w3.org/2000/svg"  width="18"  height="18"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
        </button> 
        <div class="px-2 mb-4">
            <img id="img-user" width="200" height="200" alt="Image picture" class="border-2 b-[#444444] m-auto h-[150px] w-[150px] mb-4 rounded-full" src="{{ Auth::user()->image ? asset("/storage/app/").'/'.Auth::user()->image : asset('/resources/img/user.png') }}" /> 
            <div class="relative w-10/12  m-auto">
                <label title="Click to upload" for="imgUser" class=" flex items-center justify-center gap-4 px-4 py-2 before:border-gray-400/60 hover:before:border-gray-300 group before:bg-gray-100 before:dark:bg-gray-700 before:absolute before:inset-0 before:rounded-3xl before:border before:border-dashed before:transition-transform before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95">
                    <div class="w-max relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 dark:text-gray-200" viewBox="0 0 64 64" fill="none">
                            <path d="M32.381 18.167V45.166" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M41.381 24.167L32.381 18.167L23.382 24.167" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M32.382 58.334C47.1098 58.334 59.049 46.3948 59.049 31.667C59.049 16.9392 47.1098 5 32.382 5C17.6542 5 5.715 16.9392 5.715 31.667C5.715 46.3948 17.6542 58.334 32.382 58.334Z" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="relative">
                        <span class="block text-base font-semibold relative text-gray-600 dark:text-gray-200 text-sm ">
                            {{__("messages.uploadUserPicture")}}
                        </span> 
                    </div>
                </label>
                <input autocomplete="off" class="opacity-0 absolute top-0 w-full h-full cursor-pointer" onChange="handleChangeImage()" type="file" name="imgUser" id="imgUser" />
            </div>
        </div>  
    </div>
    <div class="col-span-12 md:col-span-8"> 
        <div class="md:flex">
            <ul id="tabList" class="grid gap-2 text-sm font-medium md:me-4 mb-4 md:mb-0 w-full md:w-[200px] h-fit">
                <li>
                    <button onClick="showTab('#tab-profile',this)" class="text-xs inline-flex items-center px-4 py-3 rounded-lg  w-full tab_text_active tab_background_active">
                        <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
                        </svg>
                        {{__("messages.profile")}}
                    </a>
                </li>
                <li>
                    <button onClick="showTab('#tab-password',this)" class="text-xs inline-flex items-center px-4 py-3 rounded-lg w-full tab_text tab_background">
                        <svg class="w-4 h-4 me-2" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round" ><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 17v4" /><path d="M10 20l4 -2" /><path d="M10 18l4 2" /><path d="M5 17v4" /><path d="M3 20l4 -2" /><path d="M3 18l4 2" /><path d="M19 17v4" /><path d="M17 20l4 -2" /><path d="M17 18l4 2" /><path d="M9 6a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /><path d="M7 14a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2" /></svg>
                        {{__("messages.password")}}
                    </button>
                </li>
                @if(Auth::user()->role == 2) 
                    <li>
                        <button onClick="showTab('#tab-googleCalendar',this)" id="calendarButton" class="text-xs inline-flex items-center px-4 py-3 rounded-lg w-full tab_text tab_background">
                            <svg class="w-4 h-4 me-2" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20.945 11a9 9 0 1 1 -3.284 -5.997l-2.655 2.392a5.5 5.5 0 1 0 2.119 6.605h-4.125v-3h7.945z" /></svg>
                            {{__("messages.googleCal")}}
                        </button>
                    </li>
                    <li>
                        <button onClick="showTab('#tab-medicalProfile',this)" class="text-xs inline-flex items-center px-4 py-3 rounded-lg w-full tab_text tab_background">
                            <svg  xmlns="http://www.w3.org/2000/svg"  class="w-5 h-5 me-2" width="24"  height="24"  viewBox="0 0 448 512" fill="currentColor"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-96 55.2C54 332.9 0 401.3 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7c0-81-54-149.4-128-171.1l0 50.8c27.6 7.1 48 32.2 48 62l0 40c0 8.8-7.2 16-16 16l-16 0c-8.8 0-16-7.2-16-16s7.2-16 16-16l0-24c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 24c8.8 0 16 7.2 16 16s-7.2 16-16 16l-16 0c-8.8 0-16-7.2-16-16l0-40c0-29.8 20.4-54.9 48-62l0-57.1c-6-.6-12.1-.9-18.3-.9l-91.4 0c-6.2 0-12.3 .3-18.3 .9l0 65.4c23.1 6.9 40 28.3 40 53.7c0 30.9-25.1 56-56 56s-56-25.1-56-56c0-25.4 16.9-46.8 40-53.7l0-59.1zM144 448a24 24 0 1 0 0-48 24 24 0 1 0 0 48z"/></svg>
                            {{__("messages.medicalProfile")}}
                        </button>
                    </li> 
                    <li>
                        <button onClick="showTab('#tab-schedules',this)" class="text-xs inline-flex items-center px-4 py-3 rounded-lg w-full tab_text tab_background">
                            <svg  xmlns="http://www.w3.org/2000/svg"  class="w-5 h-5 me-2" width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M21 12a9 9 0 1 0 -9.972 8.948c.32 .034 .644 .052 .972 .052" /><path d="M12 7v5l2 2" /><path d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39z" /></svg>
                            {{__("messages.schedules")}}
                        </button>
                    </li> 
                @endif
            </ul>
            <div id="tabsContent" class="w-full mb-4">
                <div class="p-6 text-medium bg_secondary rounded-lg w-full tab-item" id="tab-profile">
                    <h3 class="text-lg font-bold title_text m-2">{{__("messages.profile")}}</h3>
                    <hr class="mb-4">
                    <form id="formProfile">
                        <div class="grid grid-cols-2 sm:mx-10 mt-4">  
                            <div class="px-2 col-span-2 md:col-span-1">
                                <div class="relative z-0 mb-2 group">
                                    <input type="text" autocomplete="off" name="username" id="username" value="{{Auth::user()->username}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                    <label for="username" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.username")}}</label>
                                    <small id="username_message" class="text_error pl-2 italic"></small>
                                </div>
                            </div> 
                            <div class="px-2 col-span-2 md:col-span-1">
                                <div class="relative z-0 mb-2 group">
                                    <input type="text" autocomplete="off" name="first_name" id="first_name" value="{{Auth::user()->first_name}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                    <label for="first_name" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.first_name")}}</label>
                                    <small id="first_name_message" class="text_error pl-2 italic"></small>
                                </div>
                            </div>  
                            <div class="px-2 col-span-2 md:col-span-1">
                                <div class="relative z-0 mb-2 group">
                                    <input type="text" autocomplete="off" name="last_name" id="last_name" value="{{Auth::user()->last_name}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                    <label for="last_name" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.last_name")}}</label>
                                    <small id="last_name_message" class="text_error pl-2 italic"></small>
                                </div>
                            </div>  
                            <div class="px-2 col-span-2 md:col-span-1">
                                <div class="relative z-0 mb-2 group">
                                    <input type="text" autocomplete="off" name="email" id="email" value="{{Auth::user()->email}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                    <label for="email" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">E-mail</label>
                                    <small id="email_message" class="text_error pl-2 italic"></small>
                                </div>
                            </div>  
                            <div class="px-2 col-span-2 md:col-span-1">
                                <div class="relative z-0 mb-2 group">
                                    <input type="text" autocomplete="off" name="phone" id="phone" value="{{Auth::user()->phone}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                    <label for="phone" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.phone")}}</label>
                                    <small id="phone_message" class="text_error pl-2 italic"></small>
                                </div>
                            </div>   
                            <div class="px-2 col-span-2 md:col-span-1">
                                <div class="relative z-0 group mb-2">
                                    <select name="language" id="language" class="bg_secondary block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                                        <option value=""></option>
                                        <option value="es" {{"es" == Auth::user()->language ? "selected" : ""}}> 🇲🇽 {{__("language.es")}}</option>
                                        <option value="en" {{"en" == Auth::user()->language ? "selected" : ""}}> 🇺🇸 {{__("language.en")}}</option>
                                    </select>
                                    <label for="language" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.language")}}</label>
                                    <small id="language_message" class="text_error pl-2 italic"></small>
                                </div>
                            </div>  
                            <div class="px-2 col-span-2 md:col-span-1">
                                <div class="relative z-0 group mb-2">
                                    <select name="gender" id="gender" class="bg_secondary block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                                        <option value=""></option>
                                        @foreach ($genders as $key => $item)  
                                            <option value="{{$key}}" {{($key == Auth::user()->gender && Auth::user()->gender != null)? "selected" : ""}}>{{$item}}</option>
                                        @endforeach
                                    </select> 
                                    <label for="gender" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.gender")}}</label>
                                    <small id="gender_message" class="text_error pl-2 italic"></small>
                                </div>
                            </div>  
                            <div class="col-span-2 text-center md:text-right">  
                                <button class="button_success rounded-md px-10 py-2">{{__("messages.save")}}</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="hidden p-6 text-medium bg_secondary rounded-lg w-full tab-item" id="tab-password"> 
                    <h3 class="text-lg font-bold title_text m-2">{{__("messages.password")}}</h3>
                    <hr class="mb-4">
                    <form id="password_form">
                        <p class="text-center italic mb-2 paragraph_text">{{__("messages.ifForgetYouPassword")}}</p>
                        <div class="md:w-6/12 m-auto mb-2">
                            <div class="flex items-center">
                                <div class="relative z-10 group w-full ">
                                    <input autocomplete="off" type="password" name="old_password" id="old_password" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                                    <label for="old_password" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.oldPassword")}}</label>
                                </div>
                                <button type="button" onclick="seePasswordInput($('#old_password'),this)" class="-ml-8 -mb-[5px] text-sm font-medium focus:outline-none z-20 button_secondary p-2 rounded-sm" title="{{__("messages.addType")}}">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  class="h-4 w-4" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                </button> 
                                <button type="button" onclick="hidePasswordInput($('#old_password'),this)" class="hidden -ml-8 -mb-[5px] text-sm font-medium focus:outline-none z-20 button_secondary p-2 rounded-sm" title="{{__("messages.addType")}}">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  class="h-4 w-4" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye-off"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" /><path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" /><path d="M3 3l18 18" /></svg>
                                </button> 
                            </div> 
                            <small id="old_password_message" class="text_error pl-2 italic"></small>
                        </div>  
                        <div class="md:w-6/12 m-auto mb-2">
                            <div class="flex items-center">
                                <div class="relative z-10 group w-full ">
                                    <input autocomplete="off" type="password" name="new_password" id="new_password" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                                    <label for="new_password" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.newPassword")}}</label>
                                </div>
                                <button type="button" onclick="seePasswordInput($('#new_password'),this)" class="-ml-8 -mb-[5px] text-sm font-medium focus:outline-none z-20 button_secondary p-2 rounded-sm" title="{{__("messages.addType")}}">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  class="h-4 w-4" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                </button> 
                                <button type="button" onclick="hidePasswordInput($('#new_password'),this)" class="hidden -ml-8 -mb-[5px] text-sm font-medium focus:outline-none z-20 button_secondary p-2 rounded-sm" title="{{__("messages.addType")}}">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  class="h-4 w-4" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye-off"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" /><path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" /><path d="M3 3l18 18" /></svg>
                                </button> 
                            </div> 
                            <small id="new_password_message" class="text_error pl-2 italic"></small>
                        </div>  
                        <div class="md:w-6/12 m-auto">
                            <div class="flex items-center">
                                <div class="relative z-10 group w-full">
                                    <input autocomplete="off" type="password" name="new_password_confirmation" id="new_password_confirmation" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                                    <label for="new_password_confirmation" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.newPassword_confirmation")}}</label>
                                </div>
                                <button type="button" onclick="seePasswordInput($('#new_password_confirmation'),this)" class="-ml-8 -mb-[5px] text-sm font-medium focus:outline-none z-20 button_secondary p-2 rounded-sm" title="{{__("messages.addType")}}">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  class="h-4 w-4" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                </button> 
                                <button type="button" onclick="hidePasswordInput($('#new_password_confirmation'),this)" class="hidden -ml-8 -mb-[5px] text-sm font-medium focus:outline-none z-20 button_secondary p-2 rounded-sm" title="{{__("messages.addType")}}">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  class="h-4 w-4" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye-off"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" /><path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" /><path d="M3 3l18 18" /></svg>
                                </button> 
                            </div> 
                            <small id="new_password_confirmation_message" class="text_error pl-2 italic"></small>
                        </div>   
                        <div class="col-span-2 text-center md:text-center">  
                            <button class="button_success rounded-md px-10 py-2">{{__("messages.changePassword")}}</button>
                        </div>
                    </form>
                </div>
                @if(Auth::user()->role == 2)  
                    <div class="hidden p-6 text-medium bg_secondary rounded-lg w-full tab-item" id="tab-googleCalendar"> 
                        <h3 class="text-lg font-bold title_text m-2">{{__("messages.syncGoogle")}}</h3>
                        <hr class="mb-4">
                        <div class="col-span-2 text-center md:text-center">  
                            @if(!Auth::user()->doctor->google_access_token)
                                <a href="{{$_['baseURL']}}/google/redirect" class="button_success rounded-md px-10 py-2">
                                    {{__("messages.getAuth")}}
                                </a>
                            @else
                                <button onclick="removeAuth()" class="button_success rounded-md px-10 py-2">
                                    {{__("messages.desAuth")}}
                                </button>
                            @endif
                        </div>
                    </div>
                    <div class="hidden p-6 text-medium bg_secondary rounded-lg w-full tab-item" id="tab-medicalProfile"> 
                        <h3 class="text-lg font-bold title_text m-2">{{__("messages.medicalProfile")}}</h3>
                        <hr class="mb-4">
                        <div class="col-span-2">  
                            <form id="formDoctor">
                                <h1 class="text-center text-2xl font-bold title_text pb-4">{{__("messages.doctorInfo")}}</h1>
                                <hr />
                                <div class="grid grid-cols-6 mt-4">
                                    <div class="px-2 col-span-1">
                                        <div class="relative z-0 group mb-2">
                                            <select name="title" id="title" class="bg_secondary block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                                                <option value=""></option>
                                                <option value="Dr." {{Auth::user()->doctor->title == "Dr." ? "selected" : ""}}>Dr.</option>
                                                <option value="Dra." {{Auth::user()->doctor->title == "Dra." ? "selected" : ""}}>Dra.</option> 
                                            </select> 
                                            <label for="title" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.title")}}</label>
                                            <small id="title_message" class="text_error pl-2 italic"></small>
                                        </div>
                                    </div>  
                                    <div class="px-2 col-span-2">
                                        <div class="relative z-0 mb-2 group">
                                            <input type="text" autocomplete="off" name="license" id="license" value="{{Auth::user()->doctor->license}}" value="{{Auth::user()->license}}" class="block py-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                            <label for="license" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.license")}}</label>
                                            <small id="license_message" class="text_error pl-2 italic"></small>
                                        </div>
                                    </div> 
                                    <div class="px-2 col-span-6 md:col-span-3">  
                                        <select name="medical_unit[]" id="medical_unit" multiple>
                                            <option value=""></option>
                                            @foreach ($medicalUnits as $key => $item)  
                                                <option value="{{$item->id}}" {{in_array($item->id,json_decode(Auth::user()->doctor->medical_units,true)) ? "selected" : ""}}>{{$item->name}}</option>
                                            @endforeach
                                        </select> 
                                    </div> 
                                    <div class="px-2 col-span-6 md:col-span-3">
                                        <div class="relative z-0 mb-2 group">
                                            <input type="text" autocomplete="off" name="timeslot" id="timeslot" value="{{Auth::user()->doctor->timeslot}}" class="block py-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                            <label for="timeslot" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.timeslot")}}</label>
                                            <small id="timeslot_message" class="text_error pl-2 italic"></small>
                                        </div>
                                    </div>  
                                    <div class="px-2 col-span-6 md:col-span-3 mb-14 md:mb-0"> 
                                        <select name="specialties[]" id="specialties" multiple>
                                            <option value=""></option>
                                            @foreach ($specialties as $key => $item)  
                                                <option value="{{$item->id}}" {{in_array($item->id,json_decode(Auth::user()->doctor->specialty_ids))? "selected" : ""}}>{{__("specialties.".$item->name)}}</option>
                                            @endforeach
                                        </select>
                                    </div>   
                                    <div class="col-span-6 text-center md:text-right">  
                                        <button class="button_success rounded-md px-10 py-2">{{__("messages.save")}}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="hidden p-6 text-medium bg_secondary rounded-lg w-full h-fit tab-item" id="tab-schedules">
                        <h3 class="text-lg font-bold title_text m-2">{{__("messages.schedules")}}</h3>
                        <hr class="mb-4">
                        <form id="schedules_form">
                            @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                                <div class="grid grid-cols-5 p-0 sm:p-4">
                                    <div class="flex gap-2 col-span-1">
                                        <input id="{{$day}}" {{Auth::user()->doctor->{$day} ? "checked" : ""}} name="{{$day}}" type="checkbox" value="1" class="mt-[15px] w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label class="input_label_text mt-[10px]">{{__("days.".$day)}}</label>
                                    </div>
                                    <div class="px-2 col-span-2"> 
                                        <div class="relative z-0 mb-2 group">
                                            <div class="absolute inset-y-0 end-[-11px] top-[-20px] flex items-center pe-3.5 pointer-events-none">
                                                <svg class="w-4 h-4 input_label_text" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <input type="time" id="{{$day}}_start_time" name="{{$day}}_start_time" value="{{Auth::user()->doctor->{$day.'_start_time'} ? date('H:i',strtotime(Auth::user()->doctor->{$day.'_start_time'})):''}}" class="block py-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
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
                                            <input type="time" id="{{$day}}_end_time" name="{{$day}}_end_time" value="{{Auth::user()->doctor->{$day.'_end_time'} ? date('H:i',strtotime(Auth::user()->doctor->{$day.'_end_time'})):''}}" class="block py-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                                            <label for="{{$day}}_end_time" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.endService")}}</label>
                                            <small id="{{$day}}_end_time_message" class="text_error pl-2 italic"></small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-span-2 text-center md:text-right">  
                                <button class="button_success rounded-md px-10 py-2">{{__("messages.save")}}</button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div> 
    </div>
</div>