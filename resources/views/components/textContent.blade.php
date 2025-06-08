<div class="{{$color}} relative shadow-md rounded-lg p-4 overflow-hidden">
    <a href="{{$url}}">
        <h2 class="text-lg font-bold flex justify-between {{$colorText}}">{!! $title !!}</h2>
        <div class="flex items-center">
            <p class="text-3xl font-bold py-4 {{$colorText}}">{{$subtitle}}</p>
            {!!$icon!!}
        </div>
    </a>
</div>