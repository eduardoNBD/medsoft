<h3 class="text-lg font-semibold text-gray-700 dark:text-white m-2">Logos</h3>
<hr class="mb-4">
<form id="logosForms" class="grid grid-cols-2 px-0 md:px-8">
    <div class="col-span-2 md:col-span-1 relative">
        <h3 class="text-xl font-semibold text-gray-700 dark:text-white m-2">{{__('messages.lightMode')}}</h3>
        <button type="button" id="del_logo_light" class="bg-red-500 p-2 text-white rounded-full absolute right-[36%] top-[3%] {{$logos->logo_light ? "" : "hidden"}}" onClick="delLight()">
            <svg  xmlns="http://www.w3.org/2000/svg"  width="18"  height="18"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
        </button> 
        <div class="px-2 col-span-2 mb-4">
            <div class="py-2 "> 
                <img id="logo_light_img" width="200" height="200" alt="Image picture" class="m-auto h-[200px] w-[200px] rounded-lg mb-4 bg_secondary shadow" src="{{ $logos->logo_light ? asset("resources/img/brand/").'/'.$logos->logo_light : asset('/resources/img/brand/logo.svg') }}" /> 
            </div>
            <div class="relative w-10/12  m-auto">
                <label title="Click to upload" for="logo_light" class=" flex items-center justify-center gap-4 px-4 py-2 before:border-gray-400/60 hover:before:border-gray-300 group before:bg-gray-100 before:dark:bg-gray-700 before:absolute before:inset-0 before:rounded-3xl before:border before:border-dashed before:transition-transform before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95">
                    <div class="w-max relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 dark:text-gray-200" viewBox="0 0 64 64" fill="none">
                            <path d="M32.381 18.167V45.166" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M41.381 24.167L32.381 18.167L23.382 24.167" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M32.382 58.334C47.1098 58.334 59.049 46.3948 59.049 31.667C59.049 16.9392 47.1098 5 32.382 5C17.6542 5 5.715 16.9392 5.715 31.667C5.715 46.3948 17.6542 58.334 32.382 58.334Z" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="relative">
                        <span class="block text-base font-semibold relative text-gray-600 dark:text-gray-200 text-sm ">Logo</span> 
                    </div>
                </label>
                <input value="{{ $logos->logo_light ? asset("resources/img/brand/").'/'.$logos->logo_light : null }}" class="opacity-0 absolute top-0 w-full h-full cursor-pointer" onChange="changeLight()" type="file" name="logo_light" id="logo_light" />
                <input type="hidden" id="del_logo_light_check" name="del_logo_light_check">
            </div>
        </div>
    </div>
    <div class="col-span-2 md:col-span-1 relative">
        <h3 class="text-xl font-semibold text-gray-700 dark:text-white m-2">{{__('messages.darkMode')}}</h3>
        <button type="button" id="del_logo_dark" class="bg-red-500 p-2 text-white rounded-full absolute right-[36%] top-[3%] {{$logos->logo_dark ? "" : "hidden"}}"  onClick="delDark()">
            <svg  xmlns="http://www.w3.org/2000/svg"  width="18"  height="18"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
        </button> 
        <div class="px-2 col-span-2 mb-4">
            <div class="dark py-2 "> 
                <img id="logo_dark_img" width="200" height="200" alt="Image picture" class="m-auto h-[200px] w-[200px] rounded-lg mb-4 bg_secondary filter drop-shadow-lg shadow-lg" src="{{ $logos->logo_dark ? asset("resources/img/brand/").'/'.$logos->logo_dark : asset('/resources/img/brand/logo_white.svg') }}" /> 
            </div>
            <div class="relative w-10/12  m-auto">
                <label title="Click to upload" for="logo_dark" class=" flex items-center justify-center gap-4 px-4 py-2 before:border-gray-400/60 hover:before:border-gray-300 group before:bg-gray-100 before:dark:bg-gray-700 before:absolute before:inset-0 before:rounded-3xl before:border before:border-dashed before:transition-transform before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95">
                    <div class="w-max relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 dark:text-gray-200" viewBox="0 0 64 64" fill="none">
                            <path d="M32.381 18.167V45.166" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M41.381 24.167L32.381 18.167L23.382 24.167" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M32.382 58.334C47.1098 58.334 59.049 46.3948 59.049 31.667C59.049 16.9392 47.1098 5 32.382 5C17.6542 5 5.715 16.9392 5.715 31.667C5.715 46.3948 17.6542 58.334 32.382 58.334Z" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="relative">
                        <span class="block text-base font-semibold relative text-gray-600 dark:text-gray-200 text-sm ">Logo</span> 
                    </div>
                </label>
                <input autocomplete="off" class="opacity-0 absolute top-0 w-full h-full cursor-pointer" onChange="changeDark()" type="file" name="logo_dark" id="logo_dark" />
                <input type="hidden" id="del_logo_dark_check" name="del_logo_dark_check">
            </div>
        </div>
    </div> 
    <div class="col-span-2 md:col-span-1 relative">
        <h3 class="text-xl font-semibold text-gray-700 dark:text-white m-2">{{__('messages.lightMode')}} Favicon</h3>
        <button type="button" id="del_logo_favicon_light" class="bg-red-500 p-2 text-white rounded-full absolute right-[36%] top-[3%] {{$logos->logo_favicon_light ? "" : "hidden"}}" onClick="delFaviconLight()">
            <svg  xmlns="http://www.w3.org/2000/svg"  width="18"  height="18"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
        </button> 
        <div class="px-2 col-span-2 mb-4">
            <div class="py-2 "> 
                <img id="logo_favicon_light_img" width="200" height="200" alt="Image picture" class="m-auto h-[200px] w-[200px] rounded-lg mb-4 bg_secondary shadow" src="{{ $logos->logo_favicon_light ? asset("resources/img/brand/").'/'.$logos->logo_favicon_light : asset('/resources/img/brand/iso.svg') }}" /> 
            </div>
            <div class="relative w-10/12  m-auto">
                <label title="Click to upload" for="logo_favicon_light" class=" flex items-center justify-center gap-4 px-4 py-2 before:border-gray-400/60 hover:before:border-gray-300 group before:bg-gray-100 before:dark:bg-gray-700 before:absolute before:inset-0 before:rounded-3xl before:border before:border-dashed before:transition-transform before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95">
                    <div class="w-max relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 dark:text-gray-200" viewBox="0 0 64 64" fill="none">
                            <path d="M32.381 18.167V45.166" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M41.381 24.167L32.381 18.167L23.382 24.167" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M32.382 58.334C47.1098 58.334 59.049 46.3948 59.049 31.667C59.049 16.9392 47.1098 5 32.382 5C17.6542 5 5.715 16.9392 5.715 31.667C5.715 46.3948 17.6542 58.334 32.382 58.334Z" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="relative">
                        <span class="block text-base font-semibold relative text-gray-600 dark:text-gray-200 text-sm ">Logo</span> 
                    </div>
                </label>
                <input value="{{ $logos->logo_favicon_light ? asset("resources/img/brand/").'/'.$logos->logo_favicon_light : null }}" class="opacity-0 absolute top-0 w-full h-full cursor-pointer" onChange="changeFaviconLight()" type="file" name="logo_favicon_light" id="logo_favicon_light" />
                <input type="hidden" id="del_logo_favicon_light_check" name="del_logo_favicon_light_check">
            </div>
        </div>
    </div>
    <div class="col-span-2 md:col-span-1 relative">
        <h3 class="text-xl font-semibold text-gray-700 dark:text-white m-2">{{__('messages.darkMode')}} Favicon</h3>
        <button type="button" id="del_logo_favicon_dark" class="bg-red-500 p-2 text-white rounded-full absolute right-[36%] top-[3%] {{$logos->logo_favicon_dark ? "" : "hidden"}}"  onClick="delFaviconDark()">
            <svg  xmlns="http://www.w3.org/2000/svg"  width="18"  height="18"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
        </button> 
        <div class="px-2 col-span-2 mb-4">
            <div class="dark py-2 "> 
                <img id="logo_favicon_dark_img" width="200" height="200" alt="Image picture" class="m-auto h-[200px] w-[200px] rounded-lg mb-4 bg_secondary filter drop-shadow-lg shadow-lg" src="{{ $logos->logo_favicon_dark ? asset("resources/img/brand/").'/'.$logos->logo_favicon_dark : asset('/resources/img/brand/iso_white.svg') }}" /> 
            </div>
            <div class="relative w-10/12  m-auto">
                <label title="Click to upload" for="logo_favicon_dark" class=" flex items-center justify-center gap-4 px-4 py-2 before:border-gray-400/60 hover:before:border-gray-300 group before:bg-gray-100 before:dark:bg-gray-700 before:absolute before:inset-0 before:rounded-3xl before:border before:border-dashed before:transition-transform before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95">
                    <div class="w-max relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 dark:text-gray-200" viewBox="0 0 64 64" fill="none">
                            <path d="M32.381 18.167V45.166" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M41.381 24.167L32.381 18.167L23.382 24.167" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M32.382 58.334C47.1098 58.334 59.049 46.3948 59.049 31.667C59.049 16.9392 47.1098 5 32.382 5C17.6542 5 5.715 16.9392 5.715 31.667C5.715 46.3948 17.6542 58.334 32.382 58.334Z" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="relative">
                        <span class="block text-base font-semibold relative text-gray-600 dark:text-gray-200 text-sm ">Logo</span> 
                    </div>
                </label>
                <input autocomplete="off" class="opacity-0 absolute top-0 w-full h-full cursor-pointer" onChange="changeFaviconDark()" type="file" name="logo_favicon_dark" id="logo_favicon_dark" />
                <input type="hidden" id="del_logo_favicon_dark_check" name="del_logo_favicon_dark_check">
            </div>
        </div>
    </div> 
    <div class="col-span-2 md:col-span-1 relative">
        <h3 class="text-xl font-semibold text-gray-700 dark:text-white m-2 mb-4">{{__('messages.public')}}</h3>
        <button type="button" id="del_logo_public" class="bg-red-500 p-2 text-white rounded-full absolute right-[36%] top-[3%] {{$logos->logo_public ? "" : "hidden"}}"  onClick="delPublic()">
            <svg  xmlns="http://www.w3.org/2000/svg"  width="18"  height="18"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
        </button> 
        <div class="px-2 col-span-2 mb-4">
            <img id="logo_public_img" width="200" height="200" alt="Image picture" class="m-auto h-[200px] w-[200px] mb-4 filter drop-shadow-lg shadow-lg" src="{{ $logos->logo_public ? asset("resources/img/brand/").'/'.$logos->logo_public : asset('/resources/img/brand/logo_public.svg') }}" /> 
            <div class="relative w-10/12  m-auto">
                <label title="Click to upload" for="logo_public" class=" flex items-center justify-center gap-4 px-4 py-2 before:border-gray-400/60 hover:before:border-gray-300 group before:bg-gray-100 before:dark:bg-gray-700 before:absolute before:inset-0 before:rounded-3xl before:border before:border-dashed before:transition-transform before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95">
                    <div class="w-max relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 dark:text-gray-200" viewBox="0 0 64 64" fill="none">
                            <path d="M32.381 18.167V45.166" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M41.381 24.167L32.381 18.167L23.382 24.167" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M32.382 58.334C47.1098 58.334 59.049 46.3948 59.049 31.667C59.049 16.9392 47.1098 5 32.382 5C17.6542 5 5.715 16.9392 5.715 31.667C5.715 46.3948 17.6542 58.334 32.382 58.334Z" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="relative">
                        <span class="block text-base font-semibold relative text-gray-600 dark:text-gray-200 text-sm ">Logo</span> 
                    </div>
                </label>
                <input autocomplete="off" class="opacity-0 absolute top-0 w-full h-full cursor-pointer" onChange="changePublic()" type="file" name="logo_public" id="logo_public" />
                <input type="hidden" id="del_logo_public_check" name="del_logo_public_check">
            </div>
        </div>
    </div> 
    <div class="px-2 col-span-2 text-right mt-8"> 
        <button class="text-white button_success focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-8 py-2">
            {{__("messages.save")}}
        </button>
    </div> 
</form>