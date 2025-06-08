<html lang="{{app()->getLocale()}}">
    <head>
        <title>@yield('title') - {{config('app.name')}}</title> 
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width,initial-scale=1.0"> 
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.7/dist/tailwind.min.css" rel="stylesheet"> -->
        <link href="{{ asset('/resources/img/brand/iso.svg') }}" rel="icon" media="(prefers-color-scheme: light)">
        <link href="{{ asset('/resources/img/brand/iso_white.svg') }}" rel="icon" media="(prefers-color-scheme: dark)">
        <link href="{{ asset('/resources/css/build.css') }}" rel="stylesheet"> 
        <link href="{{ asset('/resources/css/style.css') }}" rel="stylesheet"> 
        <link href="{{ asset('/resources/css/theme.css') }}" rel="stylesheet"> 
        @yield('styles') 
    </head> 
    <body class="antialiased">
        <nav class="top-0 fixed z-50 w-full flex flex-wrap items-center justify-between navbar-expand-lg bg-white shadow">
            <div class="w-full flex justify-end items-center bg-purple-950"> 
                <div class="ml-2 w-12 sm:w-fit group relative flex items-center justify-center px-4 py-2 text-sm font-medium transition-all duration-200 rounded-lg">
                    {!!app()->getLocale() == "es" ? "🇲🇽<span class='ml-2 hidden sm:inline-block  text-white '>Español</span>" : ""!!}
                    {!!app()->getLocale() == "en" ? "🇺🇸<span class='ml-2 hidden sm:inline-block  text-white '>English</span>" : ""!!}
                    <div class="z-10 hidden group-hover:block text-left w-32 border-[1px] border-gray-300 dark:border-slate-800 absolute right-1 top-[33px] bg_secondary rounded-md">
                        <div class="triangle absolute top-[-9px] right-[-102px] mb-[-9px]"></div>
                        <a href="{{$_['baseURL']}}/lang/es" class="{{app()->getLocale() == 'es' ? 'hidden' : ''}} w-full rounded-lg px-2 py-2 block flex items-center">
                            🇲🇽&emsp;Español
                        </a> 
                        <a href="{{$_['baseURL']}}/lang/en" class="{{app()->getLocale() == 'en' ? 'hidden' : ''}} w-full rounded-lg px-2 py-2 block flex items-center">
                            🇺🇸&emsp;English
                        </a> 
                    </div>
                </div>
            </div> 
            <div class="w-full md:container px-4 mx-auto md:flex items-center justify-between">
                <div class="w-full relative flex justify-between lg:w-auto lg:static lg:block lg:justify-start" >
                    <a class="text-sm font-bold leading-relaxed inline-block mr-4 py-2 whitespace-nowrap uppercase" href="{{$_['baseURL']}}" >
                        <img class="w-32" src="{{ $logos->logo_public ? asset("resources/img/brand/").'/'.$logos->logo_public : asset('/resources/img/brand/logo_public.svg') }}" alt="">
                    </a>
                    <button class="mr-10 cursor-pointer text-xl leading-none px-3 py-1 border border-solid border-transparent rounded bg-transparent block lg:hidden outline-none focus:outline-none" type="button" onclick="toggleNavbar('collapse-navbar')">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-menu-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 6l16 0" /><path d="M4 12l16 0" /><path d="M4 18l16 0" /></svg>
                    </button>
                </div> 
                <div class="lg:flex flex-grow items-center bg-white lg:bg-opacity-0 lg:shadow-none hidden" id="collapse-navbar">
                    <ul class="flex flex-col lg:flex-row list-none lg:ml-auto gap-2" >
                        <li class="header_background rounded-lg flex items-center">
                            <a class="{{ $current_route == 'home' ? 'text-purple-950' : 'text-gray-900'}} px-4 py-3 text-xs uppercase font-bold" href="{{$_['baseURL']}}" >
                                {{__("routes.home")}}
                                <span class="{{ $current_route == 'home' ? 'border-purple-950' : 'border-transparent'}} border-b-2 block"></span>
                            </a>
                        </li>
                        <li class="header_background rounded-lg flex items-center">
                            <a class="{{ $current_route == 'medicals' ? 'text-purple-950' : 'text-gray-900'}} px-4 py-3 text-xs uppercase font-bold" href="{{$_['baseURL']}}/medicals">
                                {{__("routes.medicals")}} 
                                <span class="{{ $current_route == 'medicals' ? 'border-purple-950' : 'border-transparent'}} border-b-2 block"></span>
                            </a>
                        </li>
                        <!--<li class="header_background rounded-lg flex items-center">
                            <a class="{{ $current_route == 'contact' ? 'text-purple-950' : 'text-gray-900'}} px-4 py-3 text-xs uppercase font-bold" href="{{$_['baseURL']}}/contact">
                                {{__("messages.contact")}}
                                <span class="{{ $current_route == 'contact' ? 'border-purple-950' : 'border-transparent'}} border-b-2 block"></span>
                            </a>
                        </li> -->
                        @if(Auth::user())
                            @if(Auth::user()->role == 3)
                                <li class="hidden md:flex items-center">
                                    <div class="group relative flex items-center justify-center px-4 py-3 text-sm font-medium text-gray-900 dark:text-gray-200 transition-all duration-200 rounded-lg header_background">
                                        <div class="text-gray-300 text-center flex-shrink-0 object-cover w-[30px] h-[30px] mr-3 rounded-full text-lg">
                                            <img src={{Auth::user()->image ? asset("/storage/app/").'/'.Auth::user()->image : asset('/resources/img/user.png')}} alt="profile" class="rounded-full w-full h-full">
                                        </div>
                                        @auth{{Auth::user()->username}}   @endauth 
                                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 group-hover:hidden text-gray-600 dark:text-gray-100" width="15"  height="15"  viewBox="0 0 24 24"  fill="currentColor"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 9c.852 0 1.297 .986 .783 1.623l-.076 .084l-6 6a1 1 0 0 1 -1.32 .083l-.094 -.083l-6 -6l-.083 -.094l-.054 -.077l-.054 -.096l-.017 -.036l-.027 -.067l-.032 -.108l-.01 -.053l-.01 -.06l-.004 -.057v-.118l.005 -.058l.009 -.06l.01 -.052l.032 -.108l.027 -.067l.07 -.132l.065 -.09l.073 -.081l.094 -.083l.077 -.054l.096 -.054l.036 -.017l.067 -.027l.108 -.032l.053 -.01l.06 -.01l.057 -.004l12.059 -.002z" /></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 group-hover:inline hidden text-gray-600 dark:text-gray-100" width="15"  height="15"  viewBox="0 0 24 24"  fill="currentColor"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11.293 7.293a1 1 0 0 1 1.32 -.083l.094 .083l6 6l.083 .094l.054 .077l.054 .096l.017 .036l.027 .067l.032 .108l.01 .053l.01 .06l.004 .057l.002 .059l-.002 .059l-.005 .058l-.009 .06l-.01 .052l-.032 .108l-.027 .067l-.07 .132l-.065 .09l-.073 .081l-.094 .083l-.077 .054l-.096 .054l-.036 .017l-.067 .027l-.108 .032l-.053 .01l-.06 .01l-.057 .004l-.059 .002h-12c-.852 0 -1.297 -.986 -.783 -1.623l.076 -.084l6 -6z" /></svg>
                                        <div class="z-10 hidden group-hover:block text-left border-[1px] border-gray-300 dark:border-slate-800 absolute right-0 top-[50px] bg-white dark:bg-[#070F26] rounded-md">
                                            <div class="triangle absolute top-[-9px] right-[-109px] mb-[-9px]"></div>  
                                            <a href="{{$_['baseURL']}}/profile" class="text-gray-700 w-full rounded-tl-md rounded-tr-md px-2 py-2 block header_background flex items-center">
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="20"  height="20"  viewBox="0 0 24 24"  fill="currentColor"  class="mr-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 2a5 5 0 1 1 -5 5l.005 -.217a5 5 0 0 1 4.995 -4.783z" /><path d="M14 14a5 5 0 0 1 5 5v1a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-1a5 5 0 0 1 5 -5h4z" /></svg>
                                                {{__("routes.profile")}}
                                            </a>  
                                            <a href="{{$_['baseURL']}}/auth/logout" class="text-gray-700 w-full rounded-bl-md rounded-br-md px-2 py-2 block header_background flex items-center">
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="20"  height="20"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="mr-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" /><path d="M9 12h12l-3 -3" /><path d="M18 15l3 -3" /></svg>
                                                {{__("routes.logout")}}
                                            </a> 
                                        </div>
                                    </div>  
                                </li>
                                <li class="inline md:hidden text-gray-900 header_background rounded-lg flex items-center">
                                    <a class=" px-4 py-3 flex items-center text-xs uppercase font-bold" href="{{$_['baseURL']}}/profile">
                                        {{__("routes.profile")}}
                                    </a>
                                </li> 
                                <li class="inline md:hidden text-gray-900 header_background rounded-lg flex items-center">
                                    <a class="text-gray-900 px-4 py-3 text-xs uppercase font-bold" href="{{$_['baseURL']}}/auth/logout">
                                        {{__("routes.logout")}}
                                    </a>
                                </li>
                            @else
                                <li class="header_background rounded-lg flex items-center">
                                    <a class="text-gray-900 px-4 py-3 text-xs uppercase font-bold" href="{{$_['baseURL']}}/auth/logout">
                                        {{__('routes.logout')}}
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="header_background rounded-lg flex items-center">
                                <a class="link_text  px-4 py-3 flex items-center text-xs uppercase font-bold" href="{{$_['baseURL']}}/login">
                                    {{__('messages.login')}}
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
                @if(Auth::check())
                    <div class="absolute top-[50px] right-[16px] md:static w-fit sm:w-fit group px-2 py-3 text-sm font-medium header_text transition-all duration-200 rounded-lg header_background">
                        <div class="relative">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="26"  height="26"  viewBox="0 0 24 24"  fill="currentColor"  class="text_regular"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14.235 19c.865 0 1.322 1.024 .745 1.668a3.992 3.992 0 0 1 -2.98 1.332a3.992 3.992 0 0 1 -2.98 -1.332c-.552 -.616 -.158 -1.579 .634 -1.661l.11 -.006h4.471z" /><path d="M12 2c1.358 0 2.506 .903 2.875 2.141l.046 .171l.008 .043a8.013 8.013 0 0 1 4.024 6.069l.028 .287l.019 .289v2.931l.021 .136a3 3 0 0 0 1.143 1.847l.167 .117l.162 .099c.86 .487 .56 1.766 -.377 1.864l-.116 .006h-16c-1.028 0 -1.387 -1.364 -.493 -1.87a3 3 0 0 0 1.472 -2.063l.021 -.143l.001 -2.97a8 8 0 0 1 3.821 -6.454l.248 -.146l.01 -.043a3.003 3.003 0 0 1 2.562 -2.29l.182 -.017l.176 -.004z" /></svg>
                            <div id="notificationCount" class="hidden z-10 absolute top-[7px] right-[1px] bg-red-600 text-white text-[10px] font-bold  w-[16px] h-[16px] rounded-full flex items-center justify-center">
                                <span></span>
                            </div>
                            <div class="z-10 hidden group-hover:block text-left w-64 border-[1px] border-gray-300 dark:border-slate-800 absolute right-0 top-[44px] bg_secondary rounded-md">
                                <div class="triangle absolute top-[-9px] right-[-226px] mb-[-9px]"></div> 
                                <div id="notificationsContent">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </nav> 
        @yield("content") 
        <div id="loader" class="flex justify-center items-center h-screen w-screen top-0 fixed bg-[#000000aa] left-0 z-50">
            <div class="rounded-full h-20 w-20 bg-violet-800 animate-ping"></div>
        </div>   
        <div id="alert-container" class="fixed top-[30%] right-4 space-y-4 z-50"></div> 
        <div id="notifications-container" class="fixed top-[30%] right-4 space-y-4 z-50"></div>
        <footer class="relative bg-purple-950 pt-8 pb-6">
            <div class="bottom-0 top-[1px] left-0 right-0 w-full absolute pointer-events-none overflow-hidden -mt-20 h-20" style="transform: translateZ(0)">
                <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0"><polygon class="text-purple-950 fill-current" points="2560 0 2560 100 0 100" ></polygon></svg>
            </div>
            <div class="container mx-auto px-4  text-white">
                <div class="flex flex-wrap text-center lg:text-left">
                    <div class="w-full  px-4">
                        <h4 class="text-3xl font-semibold">{{__("otherText.followUs")}}</h4>
                        <hr class="my-4">
                        <h5 class="text-lg mt-0 mb-2 text-cyan-600 font-bold">{{__('otherText.followUsSub')}}</h5>
                        <div class="mt-6 lg:mb-0 mb-6 flex justify-center md:justify-start"> 
                            <a href="https://www.facebook.com/UnidadMedicaVPH/" target="_blank" class="bg-white text-blue-600 shadow-lg font-normal h-10 w-10 flex items-center justify-center align-center rounded-full outline-none focus:outline-none mr-2">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-brand-facebook"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" /></svg>
                            </a>
                            <a href="https://www.instagram.com/unidad_viruspapiloma/?hl=es-la" target="_blank" class="bg-white text-pink-400 shadow-lg font-normal h-10 w-10 flex items-center justify-center align-center rounded-full outline-none focus:outline-none mr-2">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-brand-instagram"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 8a4 4 0 0 1 4 -4h8a4 4 0 0 1 4 4v8a4 4 0 0 1 -4 4h-8a4 4 0 0 1 -4 -4z" /><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /><path d="M16.5 7.5v.01" /></svg>
                            </a> 
                        </div>
                    </div> 
                </div>
                <hr class="my-6" />
                <div class="flex flex-wrap items-center md:justify-between justify-center">
                    <div class="w-full md:w-4/12 px-4 mx-auto text-center">
                        <div class="text-sm font-semibold py-1">
                            Copyright © {{date("Y")}} - Unidad Medica VPH
                        </div>
                    </div>
                </div>
            </div>
        </footer> 
    </body>
    <script>
        const textReload419 = "{{__('messages.expiredPage')}}"; 
        const isLogged = {{Auth::check()}};
    </script>
    <script src="{{ asset('/resources/js/utils.js') }}"></script>  
    <script src="{{ asset('/resources/js/loader.js') }}"></script> 
    <script src="{{ asset('/resources/js/public.js') }}"></script> 
    <script> 
        const baseURL = "{{$_['baseURL']}}"; 
        const title = "@yield('title') - {{config('app.name')}}"; 
        const conector = "{{__('messages.connector')}}"; 
        const localeApp = "{{app()->getLocale()}}";
        const monthsName = @json($months);
        const defaultImg = "{{asset('/resources/img/noimg.jpg')}}"; 
        const defaultUsrImg = "{{asset('/resources/img/user.png')}}"; 
        const logo_light = "{{asset('/resources/img/brand/logo.svg')}}"; 
        const logo_dark = "{{asset('/resources/img/brand/logo_white.svg')}}"; 
        const storegeBase = "{{asset("/storage/app/")}}";
    
        function toggleNavbar(collapseID) {
            document.getElementById(collapseID).classList.toggle("hidden");
            document.getElementById(collapseID).classList.toggle("block");
        } 
    </script>
    @yield('scripts') 
</html>