<div class="text-right">
<!--<button type="button" onclick="recordMedical({{$patient}})" class="text-emerald-500 border-2 border-emerald-500 hover:bg-emerald-500 hover:text-white p-1 rounded-lg" title="Crear PDF">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-printer"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"></path><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"></path><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z"></path></svg>
    </button>-->
</div> 
<div class="grid grid-cols-6 gap-2">  
    <section class="bg_modal px-3 pt-5 pb-5 w-full rounded-lg col-span-6 md:col-span-2 relative shadow-lg">
        <h2 class="text-xl px-2 title_text mb-2">{{__("messages.payments")}}</h2>    
        <hr class="pb-2">
        <div class="flex justify-between px-2 items-center my-4">
            <h3 class="text-xl title_text">Total</h3>
            <strong class="text-xs text-[#fafafa] dark:text-gray-300 rounded-full dark:bg-blue-700 bg-blue-500 p-1 text-center">$ {{$totalCombinedSum ? number_format($totalCombinedSum, 2, '.', ',') : "0.00"}}</strong>
        </div> 
        <hr>
    </section> 
    <section class="bg_modal px-3 pt-5 pb-5 w-full rounded-lg col-span-6 md:col-span-2 relative h-fit shadow-lg">
        <div class="flex justify-between px-2 items-center px-2 pb-2">
            <h2 class="text-xl title_text">{{__("routes.appointments")}}</h2>
            @if(!$hiddeButton)
                <a href="{{$_['baseURL'].$_['routes']['appointments']['new']}}/?patient={{$patient->id}}" class="flex items-center justify-center text-white bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-800 dark:hover:bg-emerald-900 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-xs px-2 py-1">
                    {{__("messages.addAppointment")}}
                </a> 
            @endif
        </div>
        <hr class="pb-4">
        <div class="flex justify-between px-2 items-center">
            <h3 class="text-md title_text">{{__("messages.totalAppointments")}}:</h3>
            <strong class="text-sm text-[#fafafa] dark:text-gray-300 rounded-full dark:bg-blue-700 bg-blue-500 px-2 h-[19px] text-center">{{$patient->appointments}}</strong>
        </div>
        <div class="flex justify-between px-2 items-center mb-2">
            <h3 class="text-md title_text">{{__("messages.lastAppointment")}}:</h3>
            @if($lastAppointmentDate->count())
                <strong class="text-sm title_text">{{date("d/m/Y", strtotime($lastAppointmentDate->get()[0]->date))}}</strong>
            @endif
        </div> 
        <hr>
    </section> 
    <section class="bg_modal px-3 pt-5 pb-5 w-full rounded-lg col-span-6 md:col-span-2 relative h-fit shadow-lg">
        <div class="flex justify-between px-2 items-center px-2 pb-2">
            <h2 class="text-xl title_text">{{__("routes.encounters")}}</h2>
            @if(!$hiddeButton)    
                <a href="{{$_['baseURL'].$_['routes']['encounters']['new']}}/?patient={{$patient->id}}" class="flex items-center justify-center text-white bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-800 dark:hover:bg-emerald-900 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-xs px-2 py-1">
                    {{__("messages.addEncounter")}}
                </a> 
            @endif
        </div> 
        <hr class="pb-4">
        <div class="flex justify-between px-2 items-center">
            <h3 class="text-md title_text">{{__("messages.totalEncounters")}}:</h3>
            <strong class="text-sm text-[#fafafa] dark:text-gray-300 rounded-full dark:bg-blue-700 bg-blue-500 px-2 h-[19px] text-center">{{$patient->encounters}}</strong>
        </div>
        <div class="flex justify-between px-2 items-center mb-2">
            <h3 class="text-md title_text">{{__("messages.lastEncounter")}}:</h3>
            @if($lastEncounterDate->count())
                <strong class="text-sm title_text">{{date("d/m/Y", strtotime($lastEncounterDate->get()[0]->date))}}</strong>
            @endif
        </div> 
        <hr>
    </section>
    <section class="bg_modal px-3 pt-5 pb-5 w-full rounded-lg col-span-6 relative shadow-lg">
        <h2 class="text-xl title_text">{{__("messages.notes")}}</h2>
        <hr class="pb-4">
        <table class="w-full text-sm text-left" id="encountersNotesTable">
            <thead class="text-xs uppercase table_header text_table_header">
                <tr>  
                    <th scope="col" class="px-2 md:px-4 py-3">{{__("messages.notes")}}</th>    
                    <th scope="col" class="px-2 md:px-4 py-3">{{__('messages.date')}}</th> 
                </tr>
            </thead>
            <tbody> 
            </tbody>
        </table>  
        <nav id="paginationNotesEncounters" class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">
        </nav>
    </section> 
    <section class="bg_modal px-3 pt-5 pb-5 w-full rounded-lg col-span-6 md:col-span-3 relative shadow-lg">
        <h2 class="text-xl title_text">{{__("messages.diagnosis")}}</h2>
        <hr class="pb-4">
        <table class="w-full text-sm text-left" id="encountersDiagnosisTable">
            <thead class="text-xs uppercase table_header text_table_header">
                <tr>  
                    <th scope="col" class="px-2 md:px-4 py-3">{{__("messages.diagnosis")}}</th>    
                    <th scope="col" class="px-2 md:px-4 py-3">{{__('messages.date')}}</th> 
                </tr>
            </thead>
            <tbody> 
            </tbody>
        </table>  
        <nav id="paginationDiagnosisEncounters" class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">
        </nav>
    </section> 
    <section class="bg_modal px-3 pt-5 pb-5 w-full rounded-lg col-span-6 md:col-span-3 relative shadow-lg">
        <h2 class="text-xl title_text">{{__("messages.treatment")}}</h2>
        <hr class="pb-4">
        <table class="w-full text-sm text-left" id="encountersTreatmentTable">
            <thead class="text-xs uppercase table_header text_table_header">
                <tr>  
                    <th scope="col" class="px-2 md:px-4 py-3">{{__("messages.treatment")}}</th>    
                    <th scope="col" class="px-2 md:px-4 py-3">{{__('messages.date')}}</th> 
                </tr>
            </thead>
            <tbody> 
            </tbody>
        </table>  
        <nav id="paginationTreatmentEncounters" class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">
        </nav>
    </section> 
    <section class="bg_modal px-3 pt-5 pb-5 w-full rounded-lg col-span-6 relative shadow-lg">
        <h2 class="text-xl title_text">{{__("routes.services")}}</h2>
        <hr class="pb-4">
        <table class="w-full text-sm text-left" id="encountersServicesTable">
            <thead class="text-xs uppercase table_header text_table_header">
                <tr>  
                    <th scope="col" class="px-2 md:px-4 py-3">{{__("routes.service")}}</th>    
                    <th scope="col" class="px-2 md:px-4 py-3">{{__('messages.qty')}}</th>   
                    <th scope="col" class="px-2 md:px-4 py-3">Total</th> 
                </tr>
            </thead>
            <tbody> 
            </tbody>
        </table>  
        <nav id="paginationServicesEncounters" class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">
        </nav>
    </section> 
    <section class="bg_modal px-3 pt-5 pb-5 w-full rounded-lg col-span-6 relative shadow-lg">
        <h2 class="text-xl title_text">{{__("routes.supplies")}}</h2>
        <hr class="pb-4">
        <table class="w-full text-sm text-left" id="encountersSuppliesTable">
            <thead class="text-xs uppercase table_header text_table_header">
                <tr>  
                    <th scope="col" class="px-2 md:px-4 py-3">{{__("routes.supply")}}</th>    
                    <th scope="col" class="px-2 md:px-4 py-3">{{__('messages.qty')}}</th>   
                    <th scope="col" class="px-2 md:px-4 py-3">Total</th> 
                </tr>
            </thead>
            <tbody> 
            </tbody>
        </table>  
        <nav id="paginationSuppliesEncounters" class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">
        </nav>
    </section> 
    <section class="bg_modal px-3 pt-5 pb-5 w-full rounded-lg col-span-6 relative shadow-lg">
        <h2 class="text-xl title_text">{{__("messages.files")}}</h2>
        <hr class="pb-4">
        <table class="w-full text-sm text-left" id="filesTable">
            <thead class="text-xs uppercase table_header text_table_header">
                <tr>  
                    <th scope="col" class="px-2 md:px-4 py-3">{{__('messages.file')}}</th>
                    <th scope="col" class="px-2 md:px-4 py-3">{{__("messages.note")}}</th>    
                    <th scope="col" class="px-2 md:px-4 py-3">{{__('messages.date')}}</th> 
                </tr>
            </thead>
            <tbody> 
            </tbody>
        </table>  
        <nav id="paginationFiles" class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">
        </nav>
    </section> 
</div>