<form id="form_user" class="grid grid-cols-1 md:grid-cols-7 gap-y-4 gap-x-0 md:gap-4 mx-4"> 
    @if($id)    
        <input autocomplete="off" id="maindeleted" name="maindeleted" type="checkbox"  class="hidden"/>
    @endif 
    <section class="bg_secondary px-3 md:px-7 pt-5 pb-5 w-full rounded-lg col-span-6 md:col-span-3 relative">
        <button type="button" id="delMain" class="button_error p-2 rounded-full absolute right-[36%] top-[3%] {{$user->image ? "" : "hidden"}}" >
            <svg  xmlns="http://www.w3.org/2000/svg"  width="18"  height="18"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
        </button> 
        <div class="px-2 col-span-2 mb-4">
            <img id="img-user" width="200" height="200" alt="Image picture" class="border-2 b-[#444444] m-auto h-[150px] w-[150px] mb-4 rounded-full" src="{{ $user->image ? asset("/storage/app/").'/'.$user->image : asset('/resources/img/noimg.jpg') }}" /> 
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
        @include('../components/user/formPatient')
        @include('../components/user/formDoctor')
    </section>
    <section class="bg_secondary px-3 md:px-7 pt-5 pb-5 w-full rounded-lg col-span-6 md:col-span-4 h-fit">
        @csrf <!-- {{ csrf_field() }} --> 
        <h1 class="text-center text-2xl font-bold title_text mb-4">{{__($title)}}</h1>
        <hr>
        <div class="grid grid-cols-1 md:grid-cols-2 sm:mx-10 mt-4">  
            <div class="px-2 col-span-2 md:col-span-1">
                <div class="relative z-0 mb-2 group">
                    <input type="text" autocomplete="off" name="username" id="username" value="{{$user->username}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                    <label for="username" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.username")}}</label>
                    <small id="username_message" class="text_error pl-2 italic"></small>
                </div>
            </div> 
            <div class="px-2 col-span-2 md:col-span-1">
                <div class="relative z-0 mb-2 group">
                    <input type="text" autocomplete="off" name="first_name" id="first_name" value="{{$user->first_name}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                    <label for="first_name" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.first_name")}}</label>
                    <small id="first_name_message" class="text_error pl-2 italic"></small>
                </div>
            </div>  
            <div class="px-2 col-span-2 md:col-span-1">
                <div class="relative z-0 mb-2 group">
                    <input type="text" autocomplete="off" name="last_name" id="last_name" value="{{$user->last_name}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                    <label for="last_name" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.last_name")}}</label>
                    <small id="last_name_message" class="text_error pl-2 italic"></small>
                </div>
            </div>  
            <div class="px-2 col-span-2 md:col-span-1">
                <div class="relative z-0 mb-2 group">
                    <input type="text" autocomplete="off" name="email" id="email" value="{{$user->email}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                    <label for="email" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">E-mail</label>
                    <small id="email_message" class="text_error pl-2 italic"></small>
                </div>
            </div>  
            <div class="px-2 col-span-2 md:col-span-1">
                <div class="relative z-0 mb-2 group">
                    <input type="text" autocomplete="off" name="phone" id="phone" value="{{$user->phone}}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                    <label for="phone" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.phone")}}</label>
                    <small id="phone_message" class="text_error pl-2 italic"></small>
                </div>
            </div>   
            <div class="px-2 col-span-2 md:col-span-1">
                <div class="relative z-0 group mb-2">
                    <select name="role" id="role" {{$user->role || isset($_GET['role']) ? "disabled": ""}} class="bg_secondary block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                        <option value=""></option>
                        @foreach ($roles as $key => $item) 
                            @if($key == 1 && Auth::user()->role != 1)
                                @continue;
                            @endif
                            <option value="{{$key}}" {{($key == $user->role && $user->role != null) || (isset($_GET['role']) && $_GET['role'] == $key )? "selected" : ""}}>{{$item}}</option>
                        @endforeach
                    </select> 
                    <label for="role" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.role")}}</label>
                    <small id="role_message" class="text_error pl-2 italic"></small>
                </div>
            </div> 
            <div class="px-2 col-span-2 md:col-span-1">
                <div class="relative z-0 group mb-2">
                    <select name="language" id="language" class="bg_secondary block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                        <option value=""></option>
                        <option value="es" {{"es" == $user->language ? "selected" : ""}}> 🇲🇽 {{__("language.es")}}</option>
                        <option value="en" {{"en" == $user->language ? "selected" : ""}}> 🇺🇸 {{__("language.en")}}</option>
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
                            <option value="{{$key}}" {{($key == $user->gender && $user->gender != null)? "selected" : ""}}>{{$item}}</option>
                        @endforeach
                    </select> 
                    <label for="gender" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.gender")}}</label>
                    <small id="gender_message" class="text_error pl-2 italic"></small>
                </div>
            </div> 
            @if (!$user->id)
                <div class="px-2 col-span-2 md:col-span-1 mb-2">
                    <div class="col-span-2 md:col-span-1 flex items-center ">
                        <div class="relative z-10 group w-full ">
                            <input autocomplete="off" type="password" name="password" id="password" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                            <label for="password" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.password")}}</label>
                        </div>
                        <button type="button" onclick="seePasswordInput($('#password'),this)" class="-ml-8 -mb-[5px] text-sm font-medium focus:outline-none z-20 button_secondary p-2 rounded-sm" title="{{__("messages.addType")}}">
                            <svg  xmlns="http://www.w3.org/2000/svg"  class="h-4 w-4" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                        </button> 
                        <button type="button" onclick="hidePasswordInput($('#password'),this)" class="hidden -ml-8 -mb-[5px] text-sm font-medium focus:outline-none z-20 button_secondary p-2 rounded-sm" title="{{__("messages.addType")}}">
                            <svg  xmlns="http://www.w3.org/2000/svg"  class="h-4 w-4" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye-off"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" /><path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" /><path d="M3 3l18 18" /></svg>
                        </button> 
                    </div> 
                    <small id="password_message" class="text_error pl-2 italic"></small>
                </div>  
                <div class="px-2 col-span-2 md:col-span-1">
                    <div class="col-span-2 md:col-span-1 flex items-center">
                        <div class="relative z-10 group w-full">
                            <input autocomplete="off" type="password" name="password_confirmation" id="password_confirmation" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                            <label for="password_confirmation" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.password_confirmation")}}</label>
                        </div>
                        <button type="button" onclick="seePasswordInput($('#password_confirmation'),this)" class="-ml-8 -mb-[5px] text-sm font-medium focus:outline-none z-20 button_secondary p-2 rounded-sm" title="{{__("messages.addType")}}">
                            <svg  xmlns="http://www.w3.org/2000/svg"  class="h-4 w-4" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                        </button> 
                        <button type="button" onclick="hidePasswordInput($('#password_confirmation'),this)" class="hidden -ml-8 -mb-[5px] text-sm font-medium focus:outline-none z-20 button_secondary p-2 rounded-sm" title="{{__("messages.addType")}}">
                            <svg  xmlns="http://www.w3.org/2000/svg"  class="h-4 w-4" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye-off"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" /><path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" /><path d="M3 3l18 18" /></svg>
                        </button> 
                    </div> 
                    <small id="password_confirmation_message" class="text_error pl-2 italic"></small>
                </div>   
            @endif
            <div class="col-span-2 text-center md:text-right">  
                <button class="button_success rounded-md px-10 py-2">{{__("messages.save")}}</button>
            </div>
        </div>
    </section>
</form>