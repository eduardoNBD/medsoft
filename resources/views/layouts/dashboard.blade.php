<html lang="{{app()->getLocale()}}">
    <head>
        <title>@yield('title') - {{config('app.name')}}</title> 
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width,initial-scale=1.0"> 
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.7/dist/tailwind.min.css" rel="stylesheet"> -->
        <link href="{{ $logos->logo_favicon_light ? asset("resources/img/brand/").'/'.$logos->logo_favicon_light : asset('/resources/img/brand/iso.svg') }}" rel="icon" media="(prefers-color-scheme: light)">
        <link href="{{ $logos->logo_favicon_dark ? asset("resources/img/brand/").'/'.$logos->logo_favicon_dark : asset('/resources/img/brand/iso_white.svg') }}" rel="icon" media="(prefers-color-scheme: dark)">
        <link href="{{ asset('/resources/css/build.css') }}" rel="stylesheet"> 
        <link href="{{ asset('/resources/css/style.css') }}" rel="stylesheet"> 
        <link href="{{ asset('/resources/css/theme.css') }}" rel="stylesheet"> 
        @yield('styles') 
    </head>
    <body class="flex h-screen relative overflow-hidden"> 
        <aside class="w-[48px] md:w-64 h-full overflow-x-hidden fixed md:static bg_secondary transition-all duration-100 z-20  pb-20 md:pb-0" id="main-navbar"> 
            <section class="h-14">
                <div class="px-2 py-2 w-64 md:w-full flex">
                    <button class="pl-1.5 border-1 mr-[-29px] md:hidden sm:block" id="buttonNav" onclick="openNavbar()"> 
                        <span class="w-5 h-5 text-[#4D4E8D] dark:text-gray-300" id="btnOpen">
                            {!!file_get_contents(asset('/resources/img/menuIconOpen.svg'))!!} 
                        </span>
                        <span class="w-5 h-5 text-[#4D4E8D] dark:text-gray-300 hidden" id="btnClose">
                            {!!file_get_contents(asset('/resources/img/menuIconClose.svg'))!!} 
                        </span>
                    </button>
                    <a href="{{$_['baseURL']}}/dashboard" class="m-auto"> 
                        <img width="81px" class="dark:hidden inline" src="{{ $logos->logo_light ? asset("resources/img/brand/").'/'.$logos->logo_light : asset('/resources/img/brand/logo.svg') }}" alt="logo">  
                        <img width="81px" class="dark:inline hidden" src="{{ $logos->logo_dark ? asset("resources/img/brand/").'/'.$logos->logo_dark : asset('/resources/img/brand/logo_white.svg') }}" alt="logo">
                    </a>
                </div>
                <hr class="border-gray-100 dark:border-[#070F26]">
            </section>
            <section class="p-1.5 mb-10">
                @foreach ($_['menu'][Auth::user()->role] as $key => $group)
                    <nav class="flex-1">
                        @foreach ($group as $keyR => $route)
                            <div class="group mb-1">
                                <a href="{{$_['baseURL'].$route['route']}}" {{isset($route['subMenu']) ? 'onclick=event.preventDefault() onTouchend=doubleTap(event) ondblclick=toggleMenuMovil(event)' : ""}} class="{{$route['route'] == $current_route ? "link_background_active link_text_active" : "link_text link_background"}} group flex items-center px-1.5 py-1.5 text-sm font-medium transition-all duration-200 rounded-md">
                                    {!! $route['icon'] !!}
                                    <span>{{__($route['title'])}}</span>
                                    @if (isset($route['button']))
                                        <button onClick="goToURL('{{$_['baseURL'].$route['button']['url']}}', event)" class="group-hover:opacity-100 ml-auto add_button rounded-lg opacity-100 md:opacity-0 p-2">
                                            {!! $route['button']['icon'] !!}
                                        </button>
                                    @endif
                                </a>
                                @if (isset($route['subMenu']) && is_array($route['subMenu']))
                                    <ul class="bg-gray-200 dark:bg-gray-800 {{$route['route'] != $current_route ? "h-[0px]" : ""}} overflow-hidden group-hover:h-fit transition-all duration-200 -mt-1 subMenu">
                                        @foreach ($route['subMenu'] as $subKey => $subRoute)
                                            <li>
                                                <a href="{{$_['baseURL'].$subRoute['url']}}" class="pl-9 flex items-center block text-[#526270] dark:text-gray-300 hover:text-gray-300 hover:bg-[#4D4E8D] px-4 py-2 text-sm">
                                                    <span>{{ __($subKey) }}</span>
                                                    @if(isset($subRoute['button']))
                                                        <button onClick="goToURL('{{$_['baseURL'].$subRoute['button']."/"}}', event)" class="group-hover:opacity-100 ml-auto bg-[#3a3e51] text-gray-300 rounded-lg opacity-0 p-1.5">
                                                            {!! $route['button']['icon'] !!}
                                                        </button>
                                                    @endif
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @endforeach
                        <hr class="border-gray-300 dark:border-slate-800 mb-2" />
                    </nav>
                @endforeach
                <a href="{{$_['baseURL']}}/auth/logout" class="link_text link_background group flex items-center px-1.5 py-1.5 text-sm font-medium transition-all duration-200 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 mr-3 w-6 h-6" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"></path><path d="M9 12h12l-3 -3"></path><path d="M18 15l3 -3"></path></svg>
                    <span>{{__("routes.logout")}}</span> 
                </a>
            </section> 
        </aside>
        <main class="w-full h-fit ml-[45px] md:ml-0 bg_main h-full overflow-auto pb-20 md:pb-2">
            <header class="bg_main "> 
                <div class="w-full flex justify-end items-center bg_secondary"> 
                    @include('components/toggle', ["class" => ""])   
                    <div class="ml-2 w-12 sm:w-fit group relative flex items-center justify-center px-4 py-3 text-sm font-medium header_text transition-all duration-200 rounded-lg header_background">
                        {!!app()->getLocale() == "es" ? "🇲🇽<span class='ml-2 hidden sm:inline-block'>Español</span>" : ""!!}
                        {!!app()->getLocale() == "en" ? "🇺🇸<span class='ml-2 hidden sm:inline-block'>English</span>" : ""!!}
                        <div class="z-10 hidden group-hover:block text-left w-32 border-[1px] border-gray-300 dark:border-slate-800 absolute -right-1 top-[44px] bg_secondary rounded-md">
                            <div class="triangle absolute top-[-9px] right-[-102px] mb-[-9px]"></div>
                            <a href="{{$_['baseURL']}}/lang/es" class="{{app()->getLocale() == 'es' ? 'hidden' : ''}} w-full rounded-lg px-2 py-2 block header_background flex items-center">
                                🇲🇽&emsp;Español
                            </a> 
                            <a href="{{$_['baseURL']}}/lang/en" class="{{app()->getLocale() == 'en' ? 'hidden' : ''}} w-full rounded-lg px-2 py-2 block header_background flex items-center">
                                🇺🇸&emsp;English
                            </a> 
                        </div>
                    </div>   
                   
                    <div class="w-fit sm:w-fit group relative flex items-center justify-center px-2 py-3 text-sm font-medium header_text transition-all duration-200 rounded-lg header_background">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="26"  height="26"  viewBox="0 0 24 24"  fill="currentColor"  class="text_regular"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14.235 19c.865 0 1.322 1.024 .745 1.668a3.992 3.992 0 0 1 -2.98 1.332a3.992 3.992 0 0 1 -2.98 -1.332c-.552 -.616 -.158 -1.579 .634 -1.661l.11 -.006h4.471z" /><path d="M12 2c1.358 0 2.506 .903 2.875 2.141l.046 .171l.008 .043a8.013 8.013 0 0 1 4.024 6.069l.028 .287l.019 .289v2.931l.021 .136a3 3 0 0 0 1.143 1.847l.167 .117l.162 .099c.86 .487 .56 1.766 -.377 1.864l-.116 .006h-16c-1.028 0 -1.387 -1.364 -.493 -1.87a3 3 0 0 0 1.472 -2.063l.021 -.143l.001 -2.97a8 8 0 0 1 3.821 -6.454l.248 -.146l.01 -.043a3.003 3.003 0 0 1 2.562 -2.29l.182 -.017l.176 -.004z" /></svg>
                        <div id="notificationCount" class="hidden z-10 absolute top-[7px] right-[1px] bg-red-600 text-white text-[10px] font-bold  w-[16px] h-[16px] rounded-full flex items-center justify-center">
                            <span></span>
                        </div>
                        <div class="z-10 hidden group-hover:block text-left w-64 border-[1px] border-gray-300 dark:border-slate-800 absolute -right-24 top-[44px] bg_secondary rounded-md">
                            <div class="triangle absolute top-[-9px] right-[-131px] mb-[-9px]"></div> 
                            <div id="notificationsContent">
                                
                            </div>
                        </div>
                    </div>
                      
                    <div class="group relative flex items-center justify-center px-4 py-3 text-sm font-medium text-gray-900 dark:text-gray-200 transition-all duration-200 rounded-lg header_background">
                        <div class="text-gray-300 text-center flex-shrink-0 object-cover w-[30px] h-[30px] mr-3 rounded-full text-lg">
                            <img src="{{Auth::user()->image ? asset("/storage/app/").'/'.Auth::user()->image : asset('/resources/img/user.png')}}" alt="profile" class="rounded-full w-full h-full">
                        </div>
                        <span class="hidden md:block">
                            @auth{{Auth::user()->username}}   @endauth 
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 group-hover:hidden text-gray-600 dark:text-gray-100" width="15"  height="15"  viewBox="0 0 24 24"  fill="currentColor"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 9c.852 0 1.297 .986 .783 1.623l-.076 .084l-6 6a1 1 0 0 1 -1.32 .083l-.094 -.083l-6 -6l-.083 -.094l-.054 -.077l-.054 -.096l-.017 -.036l-.027 -.067l-.032 -.108l-.01 -.053l-.01 -.06l-.004 -.057v-.118l.005 -.058l.009 -.06l.01 -.052l.032 -.108l.027 -.067l.07 -.132l.065 -.09l.073 -.081l.094 -.083l.077 -.054l.096 -.054l.036 -.017l.067 -.027l.108 -.032l.053 -.01l.06 -.01l.057 -.004l12.059 -.002z" /></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 group-hover:inline hidden text-gray-600 dark:text-gray-100" width="15"  height="15"  viewBox="0 0 24 24"  fill="currentColor"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11.293 7.293a1 1 0 0 1 1.32 -.083l.094 .083l6 6l.083 .094l.054 .077l.054 .096l.017 .036l.027 .067l.032 .108l.01 .053l.01 .06l.004 .057l.002 .059l-.002 .059l-.005 .058l-.009 .06l-.01 .052l-.032 .108l-.027 .067l-.07 .132l-.065 .09l-.073 .081l-.094 .083l-.077 .054l-.096 .054l-.036 .017l-.067 .027l-.108 .032l-.053 .01l-.06 .01l-.057 .004l-.059 .002h-12c-.852 0 -1.297 -.986 -.783 -1.623l.076 -.084l6 -6z" /></svg>
                        <div class="z-10 hidden group-hover:block text-left w-52 border-[1px] border-gray-300 dark:border-slate-800 absolute right-1 top-[50px] bg-white dark:bg-[#070F26] rounded-md">
                            <div class="triangle absolute top-[-9px] right-[-179px] mb-[-5px]"></div>
                            <div class="p-2">
                                {{Auth::user()->first_name}} {{Auth::user()->last_name}}  
                                <small class="block pl-2">{{$roles[Auth::user()->role]}}</small>
                            </div> 
                            <hr class="border-gray-300 dark:border-slate-800"/>
                            <a href="{{$_['baseURL']."/dashboard/profile"}}" class="w-full px-2 py-2 block header_background flex items-center">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="20"  height="20"  viewBox="0 0 24 24"  fill="currentColor"  class="mr-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 2a5 5 0 1 1 -5 5l.005 -.217a5 5 0 0 1 4.995 -4.783z" /><path d="M14 14a5 5 0 0 1 5 5v1a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-1a5 5 0 0 1 5 -5h4z" /></svg>
                                {{__("routes.profile")}}
                            </a> 
                            <a href="{{$_['baseURL']}}/auth/logout" class="w-full rounded-bl-lg rounded-br-lg px-2 py-2 block header_background flex items-center">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="20"  height="20"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="mr-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" /><path d="M9 12h12l-3 -3" /><path d="M18 15l3 -3" /></svg>
                                {{__("routes.logout")}}
                            </a> 
                        </div>
                    </div>    
                </div>
                <hr class="border-gray-100 dark:border-[#070F26]">
                <div class="flex flex-col sm:flex-row mx-4 my-4 md:mx-6">
                    <div class="flex-1">
                        @yield('breadcrumbs') 
                    </div> 
                </div>
            </header>
            @yield('content') 
        </main>
        <div class="fixed md:hidden bottom-0 left-0 z-50 w-full h-[52px] bg_secondary border-t border-gray-200 dark:border-gray-600">
            <div class=" h-full flex mx-auto font-medium">
                @foreach ($_['menuBottom'][Auth::user()->role] as $route)
                    <a href="{{$_['baseURL'].$route['route']}}" class="flex-1 text-center inline-flex flex-col items-center justify-center px-2 {{$route['route'] == $current_route ? "link_text_active link_background_active" : "link_text link_background"}} group">
                        {!! $route['icon'] !!}  
                        <span class="text-xs sm:text-sm">{{__($route['title'])}}</span>
                    </a>
                @endforeach
            </div>
        </div>
        <div id="loader" class="flex justify-center items-center h-screen w-screen top-0 absolute bg-[#000000aa] left-0 z-40">
            <div class="rounded-full h-32 w-32 bg_loader animate-ping flex justify-center items-center">
                <img class="w-[200px]" src="{{ $logos->logo_public ? asset("resources/img/brand/").'/'.$logos->logo_public : asset('/resources/img/brand/logo_public.svg') }}" alt="">
            </div>
        </div>   
        <div id="alert-container" class="fixed top-[30%] right-4 space-y-4 z-50"></div> 
        <div id="notifications-container" class="fixed top-[30%] right-4 space-y-4 z-50"></div>
        @if(Auth::user()->role == 2)
            @if((!Auth::user()->doctor->google_access_token && !Auth::user()->doctor->google_credentials_remember) && ($current_route != '/dashboard/profile'))
                <div id="googleCredentials" tabindex="-1" class="flex bg-[#0000006b] overflow-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                         <div class="relative bg_modal rounded-lg shadow ">
                            <button onclick="closeModal('#googleCredentials')" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="googleCredentials">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <div class="p-4 md:p-5 text-center">
                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                                 <h3 class="mb-5 text-lg font-normal title_text">{!!__("messages.googleCredentialsGet")!!}</h3>
                                <a href="{{$_['baseURL']}}{{$_['routes']['profile']}}" data-modal-hide="googleCredentials" type="button" class="button_error focus:ring-4 focus:outline-none font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                    {{__("messages.yes")}}
                                </a>
                                <button onclick="dontRemember()" data-modal-hide="googleCredentials" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium inverted button_regular focus:outline-none rounded-lg border focus:z-10 focus:ring-4 ">{{__("messages.noShowAgain")}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </body> 
    <script>
        const textReload419 = "{{__('messages.expiredPage')}}"; 
        const withoutNotificationsText = "{{__('messages.withoutNotifications')}}";
        const baseURL = "{{$_['baseURL']}}"; 
    </script> 
    <script src="{{ asset('/resources/js/pushNotifications.js') }}"></script> 
    <script src="{{ asset('/resources/js/utils.js') }}"></script> 
    <script src="{{ asset('/resources/js/app.js') }}"></script> 
    <script src="{{ asset('/resources/js/loader.js') }}"></script> 
    <script> 
        const title = "@yield('title') - {{config('app.name')}}"; 
        const pr = "{{Auth::user()->role}}";
        const ci = "{{Auth::user()->id}}"; 
        const conector = "{{__('messages.connector')}}"; 
        const localeApp = "{{app()->getLocale()}}";
        const monthsName = @json($months);
        const defaultImg = "{{asset('/resources/img/noimg.jpg')}}"; 
        const defaultUsrImg = "{{asset('/resources/img/user.png')}}"; 
        const logo_light = "{{asset('/resources/img/brand/logo.svg')}}"; 
        const logo_dark = "{{asset('/resources/img/brand/logo_white.svg')}}";  
        const logo_favicon_light = "{{asset('/resources/img/brand/iso.svg')}}"; 
        const logo_favicon_dark = "{{asset('/resources/img/brand/iso_white.svg')}}"; 
        const logo_public= "{{asset('/resources/img/brand/logo_public.svg')}}"; 
        const storegeBase = "{{asset("/storage/app/")}}";

        function dontRemember(){ 
            fetch("{{$_['baseURL']}}/users/setNoRemember", {   
                headers: { 
                    "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },  
            })
            .then(res => error419(res))
            .then((json) => { 
                closeModal('#googleCredentials');
            })
            .catch((err) => { hideLoader(); console.error("error:", err)});
        }
    </script>
    @yield('scripts') 
</html>
 