 <div class="bg_secondary relative shadow-md rounded-lg h-full"> 
    <h2 class="px-4 py-3 title_text font-medium">{{$title}}</h2> 
    <hr> 
    <table class="w-full text-sm text-left rtl:text-right mb-2">
        <thead class="text-xs table_text uppercase ">
            <tr>
                @foreach ($headers as $key => $header)
                    <th class="px-6 py-3 text-center {{$header}}">{{ $key }}</th>
                @endforeach 
            </tr>
        </thead>
        <tbody>
            @forelse ($rows as $row)
                <tr class="odd:bg-white odd:dark:bg-gray-700 even:bg-gray-100 even:dark:bg-gray-600 border-t dark:border-gray-700 table_text">
                @foreach ($row as $key => $cell)
                    <td  class="p-4 {{$classTd[$key]}}">{!! $cell !!}</td>
                @endforeach
                </tr> 
            @empty
                <tr>
                    <td  class="py-10 px-4 text-center text-2xl" colspan="{{ count($headers) }}" class="text-center">{{$noData}}</td>
                </tr>
            @endforelse
        </tbody>
    </table>  
</div>