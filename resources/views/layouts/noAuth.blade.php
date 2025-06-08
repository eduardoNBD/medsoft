<html lang="{{app()->getLocale()}}">
    <head>
        <title>@yield('title') - {{config('app.name')}}</title>
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width,initial-scale=1.0"> 
        <meta name="csrf-token" content="{{ csrf_token() }}"> 
        <link href="{{ asset('/resources/img/brand/iso.svg') }}" rel="icon" media="(prefers-color-scheme: light)">
        <link href="{{ asset('/resources/img/brand/iso_white.svg') }}" rel="icon" media="(prefers-color-scheme: dark)">
        <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.7/dist/tailwind.min.css" rel="stylesheet"> --->
        <link rel="stylesheet" href="{{ asset('/resources/css/build.css') }}"> 
        <link rel="stylesheet" href="{{ asset('/resources/css/noAuth.css') }}"> 
        <link rel="stylesheet" href="{{ asset('/resources/css/theme.css') }}"> 
        @yield('styles') 
    </head>
    <body>  
        @yield('content')
        <div id="loader" class="hidden flex justify-center items-center h-screen w-screen top-0 absolute left-0 z-40">
            <div class="rounded-full h-20 w-20 bg-violet-800 animate-ping"></div>
        </div> 
        <div id="alert-container" class="fixed top-[30%] right-4 space-y-4 z-30"></div>
    </body>
    <script> 
        const textReload419 = "{{__('messages.expiredPage')}}"; 
    </script>
    <script src="{{ asset('/resources/js/utils.js') }}"></script> 
    <script src="{{ asset('/resources/js/loader.js') }}"></script> 
    <script>const baseURL = "{{$_['baseURL']}}";</script>
    @yield('scripts') 
</html>