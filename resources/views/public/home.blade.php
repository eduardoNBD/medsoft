@extends('layouts.public',[ 'current_route'  => 'home'])

@section('title', __('routes.home')) 

@section('content')  
<section>
    <div class=" bg-[url('../img/publicImg/doctor.jpg')] bg-fixed bg-no-repeat bg-cover bg-center">
        <div class="container mx-auto">   
            <div class="absolute inset-0 bg-slate-900/60"></div>
            <div class="relative z-10 text-center text-white flex flex-col items-center justify-center h-full px-4">
                <h1 class="text-5xl md:text-7xl font-bold mb-4">{{__("messages.login_title")}} <span class="text-fuchsia-800 mt-4 block drop-shadow-[0_1px_0_rgba(255,255,255,0.25)]">Unidad Medica VPH</span></h1>
                <p class="text-lg md:text-xl mb-8 font-bold px-10 md:px-28 my-6">{{__("otherText.bannerTitle")}}</p>
                <div class="flex flex-wrap justify-center gap-4"> 
                    <!--<a  href="{{$_['baseURL']}}/contacts" class="border border-white px-6 py-3 rounded-md hover:bg-white hover:text-fuchsia-900 font-bold">
                        {{__("otherText.contactUs")}}
                    </a> -->
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container mx-auto py-20">
        <h2 class="text-3xl md:text-5xl font-bold mb-4 text-center text-slate-700">{{__("routes.medical_units")}}</h2>
        <div class="grid grid-cols-4 gap-2">
            @foreach ($medicalUnits as $medicalUnit) 
                <div class="col-span-4 md:col-span-2"> 
                    <a href="medicals/?medicalUnit={{$medicalUnit->id}}">
                        <div class="bg-white border border-gray-200 rounded-lg shadow m-4">
                            <div class="flex flex-col items-center pb-10 mt-8">
                                <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="{{$medicalUnit->logo ? asset("/storage/app/").'/'.$medicalUnit->logo : asset('/resources/img/user.png')}}" alt="{{$medicalUnit->name}}"/>
                                <h5 class="mb-1  mx-4 text-xl font-medium text-gray-900 dark:text-white">{{$medicalUnit->name}}</h5>
                                <h5 class="mb-1  mx-4 text-sm font-medium text-gray-600 dark:text-white text-center">{{$medicalUnit->fulladdress}}</h5>  
                            </div>
                        </div>
                    </a>
                </div>  
            @endforeach
        </div> 
    </div>
</section>
<section>
    <div class=" bg-[url('../img/publicImg/bg_services.jpg')] bg-fixed bg-no-repeat bg-cover bg-center relative">
        <div class="absolute inset-0 bg-cyan-900/80"></div>
        <div class="container mx-auto">   
            <div class="py-32 relative z-10 ">
                <div class="grid grid-cols-3">
                    <div class="col-span-3 md:col-span-1 p-5">
                        <svg  xmlns="http://www.w3.org/2000/svg" class="bg-white rounded-full text-cyan-800 p-2 m-auto" width="70"  height="70"  viewBox="0 0 24 24"  fill="currentColor"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.496 13.983l1.966 3.406a1.001 1.001 0 0 1 -.705 1.488l-.113 .011l-.112 -.001l-2.933 -.19l-1.303 2.636a1.001 1.001 0 0 1 -1.608 .26l-.082 -.094l-.072 -.11l-1.968 -3.407a8.994 8.994 0 0 0 6.93 -3.999z" /><path d="M11.43 17.982l-1.966 3.408a1.001 1.001 0 0 1 -1.622 .157l-.076 -.1l-.064 -.114l-1.304 -2.635l-2.931 .19a1.001 1.001 0 0 1 -1.022 -1.29l.04 -.107l.05 -.1l1.968 -3.409a8.994 8.994 0 0 0 6.927 4.001z" /><path d="M12 2l.24 .004a7 7 0 0 1 6.76 6.996l-.003 .193l-.007 .192l-.018 .245l-.026 .242l-.024 .178a6.985 6.985 0 0 1 -.317 1.268l-.116 .308l-.153 .348a7.001 7.001 0 0 1 -12.688 -.028l-.13 -.297l-.052 -.133l-.08 -.217l-.095 -.294a6.96 6.96 0 0 1 -.093 -.344l-.06 -.271l-.049 -.271l-.02 -.139l-.039 -.323l-.024 -.365l-.006 -.292a7 7 0 0 1 6.76 -6.996l.24 -.004z" /></svg>
                        <h4 class="text-center text-3xl text-white my-4">{{__("messages.excellentService")}}</h4>
                        <p class="text-white text-lg text-center">
                            {{__("messages.excellentServiceText")}}
                        </p>
                    </div> 
                    <div class="col-span-3 md:col-span-1 p-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="bg-white rounded-full text-cyan-800 p-2 m-auto" width="70"  height="70"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20.984 12.53a9 9 0 1 0 -7.552 8.355" /><path d="M12 7v5l3 3" /><path d="M19 16l-2 3h4l-2 3" /></svg>
                        <h4 class="text-center text-3xl text-white my-4">{{__("messages.effectiveAttention")}}</h4>
                        <p class="text-white text-lg text-center">
                            {{__("messages.effectiveAttentionText")}}
                        </p>
                    </div>
                    <div class="col-span-3 md:col-span-1 p-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="bg-white rounded-full text-cyan-800 p-2 m-auto" width="70"  height="70"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                        <h4 class="text-center text-3xl text-white my-4">{{__("messages.alwaysAvailable")}}</h4>
                        <p class="text-white text-lg text-center">
                            {{__("messages.alwaysAvailableText")}}
                        </p>
                    </div>
                </div> 
            </div> 
        </div>
    </div>
</section>
@stop