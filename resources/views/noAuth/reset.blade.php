@extends('layouts.noAuth')
 
@section('title', __('messages.login')) 

@section('content')
<main class="bg-gray-100 flex flex-col md:justify-between"> 
    <section class="flex flex-col flex-col-reverse md:flex-row w-full bg-gray-50 mx-auto md:my-10 md:my-auto shadow-lg overflow-hidden  h-screen w-screen ">
        <div class="w-full md:w-1/2 py-5 md:py-20 px-8 sm:px-20 h-full flex justify-between bg-white">
            <div class="my-2 md:my-auto w-full"> 
                <header class="w-full pb-10"> 
                    <div class="float-right">  
                        <button type="button" class="border-b-2 group relative flex items-center justify-center px-4 py-1 text-sm font-medium text-gray-900 transition-all duration-200  hover:bg-gray-200">
                            {!!app()->getLocale() == "es" ? "🇲🇽<span class='ml-2'>Español</span>" : ""!!}
                            {!!app()->getLocale() == "en" ? "🇺🇸<span class='ml-2'>English</span>" : ""!!}
                            <div class="z-10 hidden group-hover:block text-left w-32 border-[1px] border-gray-300 absolute -right-3 top-7 bg-white rounded-md overflow-hidden">
                                @if(app()->getLocale() == "en")     
                                    <a href="{{$_['baseURL']}}/lang/es" class="w-64 px-2 py-2 block hover:bg-gray-100 flex items-center">
                                        🇲🇽&emsp;Español
                                    </a> 
                                @endif
                                @if(app()->getLocale() == "es") 
                                    <a href="{{$_['baseURL']}}/lang/en" class="w-64 px-2 py-2 block hover:bg-gray-100 flex items-center">
                                        🇺🇸&emsp;English
                                    </a> 
                                @endif
                            </div>
                        </button>
                    </div>
                </header> 
                <h2 class="text-center text-3xl mb-4 text-gray-700">{{ __('messages.newPassword') }}</h2>
                <div class="px-0 md:px-28">
                    <form action=""> 
                        <div class="relative z-0 mt-2 md:mt-5">
                            <input type="password" autocomplete="off" id="newPassword" name="newPassword" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                            <label for="newPassword" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-[#4D4E8D] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">{{ __('messages.newPassword') }}</label>
                            <small id="newPassword_message" class="text_error pl-2 italic"></small>
                        </div>  
                        <div class="relative z-0 mt-2 md:mt-5">
                            <input type="password" autocomplete="off" id="newPassword_confirmation" name="newPassword_confirmation" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                            <label for="newPassword_confirmation" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-[#4D4E8D] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">{{ __('messages.newPassword_confirmation') }}</label>
                            <small id="newPassword_confirmation_message" class="text_error pl-2 italic"></small>
                        </div>  
                        <div class="flex flex-col md:flex-row mt-5">
                            <input type="hidden" name="token" value="{{$token}}" >
                            <button class="bg-[#4D4E8D] py-1.5 px-6 text-white rounded-sm flex-grow">{{ __('messages.changePassword') }}</button>
                        </div>
                    </form>
                    <div class="text-center">
                        <hr class="mt-10">
                        <div class="-mt-[14px] mb-6 bg-white w-12 mx-auto font-[500] text-[#666666]">{{__("messages.or")}}</div>
                    </div>
                    <div class="text-center">
                        <a href="{{$_['baseURL']}}/login" class="my-2 font-[500] text-[#666666] hover:text-[#4D4E8D]">
                            {{__("messages.login")}}
                        </a>
                    </div>
                </div> 
            </div>
        </div>
        <div class="w-full h-fit md:w-1/2 bg-[#4D4E8D] md:h-full flex justify-between py-10 px-4">
            <div class="m-auto">
                <h1 class="text-3xl sm:text-4xl text-center text-white">{{ __('messages.login_title') }} {{ config('app.name') }}</h1>
                <div class="text-center">
                    <span class="w-[300px] h-[100px] mb-10 mt-2  inline-block text-white">
                        <img class="w-10/12 m-auto" src="{{ $logos->logo_public ? asset("resources/img/brand/").'/'.$logos->logo_public : asset('/resources/img/brand/logo_public.svg') }}" alt="">
                    </span> 
                </div>
                <p class="text-xl text-center text-white px-4">{{ __('messages.login_subtitle') }}</p>
            </div>
        </div>
    </section>
</main>
 
@stop

@section('scripts')
    <script>
        const url = "{{$_['routes']['auth']['reset']}}";  
    </script>
    <script src="{{ asset('/resources/js/pages/reset.js') }}"></script> 
@stop
 