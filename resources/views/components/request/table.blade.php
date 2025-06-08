<div class="bg_Secondary relative shadow-md rounded-lg">
    <div class="pt-4 px-4 table_text flex flex-col xs:flex-row justify-between gap-2">
        <div class="flex items-center gap-2">
            {{__("routes.requests")}} 
            <span id="total" class="text-center md:inline-block rounded-lg text-[10px] text-white bg-gray-600 py-1 px-2 font-bold">0</span>
        </div> 
    </div>
    <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
        <div class="w-full">
            <div class="flex items-center">
                <label  for="simple-search" class="sr-only">{{__("messages.search")}}</label>
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-[#526270] dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fillRule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clipRule="evenodd" />
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        id="simple-search" 
                        class="table_background focus:outline-none dark:border-gray-700 border border-gray-300 table_text text-sm rounded-lg block w-full pl-10 p-2" 
                        placeholder="{{__("messages.search")}}"
                        autocomplete="off"
                        onkeyup="search()"
                        value="{{isset($_GET['s']) ? $_GET['s'] : ""}}"
                    />
                </div>
            </div>
        </div>
        <ul class="items-center w-full flex-col md:flex-row text-sm font-medium dark:border-gray-700 border rounded-lg flex">
            <li class="w-full ">
                <div class="flex items-center ps-3">
                    <input id="cancel" name="status" type="checkbox" onclick="if(checkedInputs()){ getPagination(currentPage) }else{ this.checked = true;}" value="0" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                    <label for="cancel" class="w-full py-2 ms-2 text-sm font-medium paragraph_text">{{__("messages.refused_her")}}</label>
                </div>
            </li>
            <li class="w-full ">
                <div class="flex items-center ps-3">
                    <input id="pending" name="status" type="checkbox" onclick="if(checkedInputs()){ getPagination(currentPage) }else{ this.checked = true;}" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" checked>
                    <label for="pending" class="w-full py-2 ms-2 text-sm font-medium paragraph_text">{{__("messages.pendings")}}</label>
                </div>
            </li> 
            <li class="w-full ">
                <div class="flex items-center ps-3">
                    <input id="pending" name="status" type="checkbox" onclick="if(checkedInputs()){ getPagination(currentPage) }else{ this.checked = true;}" value="2" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" checked>
                    <label for="pending" class="w-full py-2 ms-2 text-sm font-medium paragraph_text">{{__("messages.generated_her")}}</label>
                </div>
            </li> 
        </ul>
    </div> 
    <table class="w-full text-sm text-left">
        <thead class="text-xs uppercase table_header text_table_header">
            <tr>  
                <th scope="col" class="px-4 py-3">{{__('routes.patient')}}</th>
                <th scope="col" class="px-4 py-3 hidden md:table-cell">{{__("messages.notes")}}</th>   
                <th scope="col" class="px-4 py-3">
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