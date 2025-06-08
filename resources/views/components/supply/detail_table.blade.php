<div class="bg_Secondary relative shadow-md rounded-lg">
    <div class="pt-4 px-4 table_text flex flex-col xs:flex-row justify-between gap-2">
        <div class="flex items-center gap-2">
            {{__("routes.supply_reloads")}} 
            <span id="total" class="text-center md:inline-block rounded-lg text-[10px] text-white bg-gray-600 py-1 px-2 font-bold">0</span>
        </div>
        <div class="md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
            <button type="button" onclick="openModal('#itemReload')" class=" flex items-center justify-center button_success focus:ring-4 font-medium rounded-lg text-sm px-4 py-2">
                <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path clipRule="evenodd" fillRule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                </svg>
                {{__("messages.addSupplyReload")}}
            </button> 
        </div>
    </div>
    <div class="flex flex-col items-center justify-between space-y-3 p-4">
        <div class="w-full"> 
            <div id="date-range-picker" date-rangepicker  class="flex items-center">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                    </div>
                    <input id="datepicker-range-start" name="start" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{__('messages.start')}}">
                </div>
                <span class="mx-4 text-gray-500">-</span>
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                    </div>
                    <input id="datepicker-range-end" name="end" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{__('messages.end')}}">
                </div>
                <button id="clear-daterange" type="button" class="hidden ml-4 bg-red-500 text-white px-4 py-2 rounded-lg">
                    {{__("messages.clear")}}
                </button>
            </div> 
        </div>
        <ul class="items-center w-full text-sm font-medium dark:border-gray-700 border rounded-lg flex">
            <li class="w-full ">
                <div class="flex items-center ps-3">
                    <input id="cancel" name="status" type="checkbox" onclick="if(checkedInputs()){ getPagination(currentPage) }else{ this.checked = true;}" value="0" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                    <label for="cancel" class="w-full py-2 ms-2 text-sm font-medium paragraph_text">{{__("messages.allInactived_his")}}</label>
                </div>
            </li>
            <li class="w-full ">
                <div class="flex items-center ps-3">
                    <input id="pending" name="status" type="checkbox" onclick="if(checkedInputs()){ getPagination(currentPage) }else{ this.checked = true;}" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" checked>
                    <label for="pending" class="w-full py-2 ms-2 text-sm font-medium paragraph_text">{{__("messages.allActive_his")}}</label>
                </div>
            </li> 
        </ul>  
    </div> 
    <table class="w-full text-sm text-left">
        <thead class="text-xs uppercase table_header text_table_header">
            <tr>  
                <th scope="col" class="px-2 md:px-4 py-3 table-cell">{{__("messages.date")}}</th> 
                <th scope="col" class="px-2 md:px-4 py-3 table-cell">{{__('messages.qty')}}</th>  
                <th scope="col" class="px-2 md:px-4 py-3 table-cell hidden md:table-cell">{{__("messages.expiration")}}</th> 
                <th scope="col" class="px-2 md:px-4 py-3 text-center">{{__("messages.price")}}</th>  
                <th scope="col" class="px-2 md:px-4 py-3 table-cell">
                    <span class="sr-only">Actions</span>
                </th>
            </tr>
        </thead>
        <tbody> 
        </tbody>
    </table>  
    <nav id="pagination" class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">
    </nav>
</div>