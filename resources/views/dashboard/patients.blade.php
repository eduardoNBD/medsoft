@extends('layouts.dashboard',[ 'current_route'  => '/dashboard/patients'])

@section('title', __('routes.patients')) 

@section('breadcrumbs')
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="{{$_['baseURL'].$_['routes']['dashboard']['root']}}" class="inline-flex items-center text-sm font-medium breadcrumbs_text">
                    <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                    </svg>
                    {{__('routes.dashboard')}}
                </a>
            </li> 
            <li class="inline-flex items-center">
                <svg class="w-4 h-4 inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7l5 5l-5 5" /><path d="M13 7l5 5l-5 5" /></svg>
            </li>
            <li class="inline-flex items-center">
                <a href="{{$_['baseURL'].$_['routes']['patients']['root']}}" class="inline-flex items-center text-sm font-medium breadcrumbs_text">
                    <svg class="w-4 h-4 mr-2.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" fill="currentColor"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M48 0C21.5 0 0 21.5 0 48L0 256l144 0c8.8 0 16 7.2 16 16s-7.2 16-16 16L0 288l0 64 144 0c8.8 0 16 7.2 16 16s-7.2 16-16 16L0 384l0 80c0 26.5 21.5 48 48 48l217.9 0c-6.3-10.2-9.9-22.2-9.9-35.1c0-46.9 25.8-87.8 64-109.2l0-95.9L320 48c0-26.5-21.5-48-48-48L48 0zM152 64l16 0c8.8 0 16 7.2 16 16l0 24 24 0c8.8 0 16 7.2 16 16l0 16c0 8.8-7.2 16-16 16l-24 0 0 24c0 8.8-7.2 16-16 16l-16 0c-8.8 0-16-7.2-16-16l0-24-24 0c-8.8 0-16-7.2-16-16l0-16c0-8.8 7.2-16 16-16l24 0 0-24c0-8.8 7.2-16 16-16zM512 272a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM288 477.1c0 19.3 15.6 34.9 34.9 34.9l218.2 0c19.3 0 34.9-15.6 34.9-34.9c0-51.4-41.7-93.1-93.1-93.1l-101.8 0c-51.4 0-93.1 41.7-93.1 93.1z"/></svg>
                    {{__('routes.patients')}}
                </a>
            </li> 
        </ol>
    </nav>
@stop

@section('styles')   
    <link href="{{ asset('/resources/css/autocomplete.css') }}" rel="stylesheet"> 
    <style>.autocomplete-items{margin-top:-20px;}</style>
@stop

@section('content')
<div class="rounded-lg overflow-hidden" id="pdf-preview" class="h-0">
            
</div>
    <section class="mx-2 md:m-4">
        <div class="mx-auto px-2"> 
            @include('../components/patient/table')
        </div>
    </section> 
    <div id="deleteModal" tabindex="-1" class="hidden flex bg-[#0000006b] overflow-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg_modal rounded-lg shadow ">
                <button onclick="closeModal('#deleteModal')" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="deleteModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal title_text">{{__("messages.patientDeleteAsk")}}</h3>
                    <button  onclick="confirmDelete()" data-modal-hide="deleteModal" type="button" class="button_error focus:ring-4 focus:outline-none font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        {{__("messages.yes")}}
                    </button>
                    <button onclick="closeModal('#deleteModal')" data-modal-hide="deleteModal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium inverted button_regular focus:outline-none rounded-lg border focus:z-10 focus:ring-4">{{__("messages.no")}}, {{__("messages.cancel")}}</button>
                </div>
            </div>
        </div>
    </div>
    <div id="restoreModal" tabindex="-1" class="hidden flex bg-[#0000006b] overflow-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg_modal rounded-lg shadow ">
                <button onclick="closeModal('#restoreModal')" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="restoreModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal title_text">{{__("messages.patientRestoreAsk")}}</h3>
                    <button  onclick="confirmRestore()" data-modal-hide="restoreModal" type="button" class="button_success focus:ring-4 focus:outline-none font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        {{__("messages.yes")}}
                    </button>
                    <button onclick="closeModal('#restoreModal')" data-modal-hide="restoreModal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium inverted button_regular focus:outline-none rounded-lg border focus:z-10 focus:ring-4">{{__("messages.no")}}, {{__("messages.cancel")}}</button>
                </div>
            </div>
        </div>
    </div> 
    <div id="prepareTLF" tabindex="-1" class="hidden flex bg-[#0000006b] overflow-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg_modal rounded-lg shadow ">
                <button onclick="closeModal('#prepareTLF')" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="prepareTLF">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">  
                    <h3 class="mb-5 text-lg font-normal title_text">{{__('messages.consentFLT')}}</h3>
                    <div class="hidden">
                        <div class="relative mt-4  group mb-2 mt-0 md:mt-11 text-left">
                            <select name="doctor" id="doctor" class="bg_modal block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                                <option value=""></option>
                                @foreach($doctors as $doctor)
                                    <option value="{{$doctor->id}}">{{$doctor->first_name}} {{$doctor->last_name}}</option>
                                @endforeach
                            </select> 
                            <label for="doctor" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-[#4D4E8D] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("routes.medical")}}</label>
                        </div>
                    </div> 
                    <div class="relative mt-4  group mb-2 mt-0 md:mt-11 text-left">
                        <select name="medicalUnit" id="medicalUnit" class="bg_modal block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                            <option value=""></option> 
                        </select> 
                        <label for="medicalUnit" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-[#4D4E8D] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("routes.medical_unit")}}</label>
                        <small id="medicalUnit_message" class="text_error pl-2 italic"></small>
                    </div> 
                    <div class="relative group mb-2 text-left">
                        <select name="area" id="area" class="bg_modal block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                            <option value=""></option>
                            @foreach($areas as $area)
                                <option value="{{$area['id']}}">{{$area['name']}}</option>
                            @endforeach
                        </select> 
                        <label for="area" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-[#4D4E8D] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.area")}}</label>
                        <small id="area_message" class="text_error pl-2 italic"></small>
                    </div>
                    <button onclick="createConsentTLF(currentItem)" data-modal-hide="prepareTLF" type="button" class="button_success focus:ring-4 focus:outline-none font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        {{__("messages.download")}}
                    </button> 
                </div>
            </div>
        </div>
    </div> 
    <img src="{{ asset('/resources/img/PDFimg/logo.png') }}" alt="logoImgPap" id="logoImgPap" class="hidden">
    <img src="{{ asset('/resources/img/PDFimg/fondoPDF.jpg') }}" alt="imgPap" id="imgPap" class="hidden">
    <img src="{{ $logos->logo_public ? asset("resources/img/brand/").'/'.$logos->logo_public : asset('/resources/img/brand/logo_public.svg') }}" alt="hiddenImag" id="hiddenImag" class="hidden">
@stop

@section('scripts')
    <script src="{{ asset('/resources/libs/jsPDF/jspdf.umd.min.js') }}"></script>   
    <script src="{{ asset('/resources/js/fontawsomeB64.js') }}"></script>   
    <script src="{{ asset('/resources/libs/autocomplete/autocomplete.js') }}"></script>  
    <script> 
        const url = '{{$_['baseURL']."/patients/list?page="}}'; 
        const urlDel = '{{$_['baseURL']."/patients/delete/"}}';
        const urlRes = '{{$_['baseURL']."/patients/restore/"}}';
        const detailText = "{{__('messages.record')}}";
        const editText = "{{__('messages.edit')}} {{__('messages.profile')}}";  
        const recordText = "{{__('messages.editRecord')}}";  
        const appointmentText = "{{__('messages.addAppointment')}}"; 
        const encounterText = "{{__('messages.addEncounter')}}"; 
        const deleteText = "{{__('messages.delete')}}";
        const restoreText = "{{__('messages.restore')}}";
        const deletedText = "{{__('messages.deleted_his')}}"
        const withoutPatientsSearch = "{{__('messages.withoutPatients')}}";
        const EditURL = "{{$_['baseURL'].$_['routes']['users']['edit']('')}}";
        const appointmentURL = "{{$_['baseURL'].$_['routes']['appointments']['new']}}";
        const encounterURL = "{{$_['baseURL'].$_['routes']['encounters']['new']}}";
        const patientDetailURL = "{{$_['baseURL'].$_['routes']['patients']['detail']('')}}";
        const patientRecordURL = "{{$_['baseURL'].$_['routes']['patients']['record']('')}}";
        const medicalCertificateURL = "{{$_['baseURL'].$_['routes']['certificates']['new']}}";
        const medicalCertificateText = "{{__('messages.medicalCertificate')}}";
        let currentPage = {{$page}}; 
        const msg = "{{isset($_GET['msg']) ? $_GET['msg'] : ""}}";
        const currentURL = "{{$_['baseURL'].$_['routes']['patients']['root']}}/";
        const medicalUnits = {!!json_encode($medicalUnits)!!};
        const doctors = {!!json_encode($doctors)!!};
        const priceText = '{{__("messages.price")}}';
        const noResultsText = '{{__("messages.noResults")}}'; 
        const areas = {!!json_encode($areas)!!};
        const consentFLTText = "{{__('messages.consentFLT')}}";
        const consentPRPText = "{{__('messages.consentPRP')}}";

        const { jsPDF } = window.jspdf;
        let doc       = new jsPDF(); 

        if(msg){
            createAlert(...msg.split("_"));
            window.history.pushState({}, title, currentURL);
        }
        
        async function createConsentPRP(patient){ 
            doc       = new jsPDF(); 
            const fondoBase64 = await getImageAsBase64($("#imgPap").src); 

            doc.addFileToVFS("{{ asset('/resources/libs/fontawesome/webfonts/fa-solid-400.ttf') }}", fontAwesomeBase64);
            doc.addFont("{{ asset('/resources/libs/fontawesome/webfonts/fa-solid-400.ttf') }}", "FontAwesome", "normal");
            doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);
    
            doc.setFontSize(13);
            doc.setFont("helvetica", "italic");
            doc.text("CONSENTIMIENTO INFORMADO PARA APLICACIÓN DE PLASMA RICO EN PLAQUETAS", setMiddle(), 55, { align:'center',maxWidth: 150 });

            doc.setFontSize(11.5);
            doc.setFont("helvetica", "normal");
            doc.text("INSTRUCCIONES:", 30, 70);

            doc.setFontSize(11);
            doc.setLineHeightFactor(1.4);
            drawJustifiedText(doc,`Este es un documento de consentimiento informado que fue preparado para ayudar a su información sobre la aplicación de plasma rico en plaquetas autólogo (propio), sus riesgos y los tratamientos alternativos.`, 30, 75, 155, 5);
            drawJustifiedText(doc,`Es importante que Ud. lea esta información cuidadosa y completamente. Por favor escriba sus iniciales en cada página, indicando que Ud. ha leído la página y firme el consentimiento para el procedimiento o cirugía indicada por su médico.`, 30, 90, 155, 5);
 
            doc.setFontSize(11.5);
            doc.setFont("helvetica", "normal");
            doc.text("INTRODUCCIÓN:", 30, 108);
 
            doc.setFontSize(11);
            doc.setFont("helvetica", "normal");
            doc.setLineHeightFactor(1.4);
            drawJustifiedText(doc,`Esta práctica consiste en la administración de un concentrado de plaquetas suprafisiológico obtenido a través de la centrifugación de la propia sangre del paciente. El objetivo de este preparado es lograr la liberación de múltiples factores de crecimiento contenidos en las plaquetas, y con esto promover el aumento de la migración, proliferación y diferenciación de células madres, fibroblastos y otras estirpes celulares, aumentar la síntesis de matriz extracelular, facilitar la angiogénesis y la síntesis de colágeno. En síntesis, lo que se busca con el PRP es mejorar las condiciones de la piel a través de diferentes mecanismos.`, 30, 113, 155, 5);
            
            doc.text("Sus ventajas son que es", 30, 153);
            doc.setFontSize(11);
            doc.setFont("helvetica", "normal");
            doc.setLineHeightFactor(1.4);
            doc.text([ 
                "Biocompatible",
                "Mejora la coagulación y cicatrización de heridas.",
                "Aporte de factor de crecimiento derivado de las plaquetas (PDGFplateletderived growth factor).",
                "Obtención rápida y sencilla.",
                "Ambulatorio."
            ], 40, 158,{ maxWidth: 140 });

            const check = "\uf00c";
            doc.setFontSize(11);
            doc.setFont("FontAwesome", "normal");
            doc.setLineHeightFactor(1.4);
            doc.text([
                check,
                check,
                check,
                "",
                check,
                check
            ], 34, 158,{ maxWidth: 140 });

            doc.setFontSize(11.5);
            doc.setFont("helvetica", "normal");
            doc.text("TRATAMIENTOS ALTERNATIVOS", 30, 195);
 
            doc.setFontSize(11);
            doc.setFont("helvetica", "normal");
            doc.setLineHeightFactor(1.4);
            doc.text(`Tratamientos alternativos consisten en la colocación de cremas con estrógenos o cicatrizantes que NO logran el mismo efecto, ya que no estimulan los propios factores de la piel.`, 30, 200, { maxWidth: 163 });

            doc.setFontSize(11.5);
            doc.setFont("helvetica", "bold");
            doc.text("RIESGOS DEL PROCEDIMIENTO:", 30, 216);

            doc.setFontSize(11);
            doc.setFont("helvetica", "normal");
            doc.setLineHeightFactor(1.4);
            drawJustifiedText(doc,`Cada procedimiento incluye ciertos riesgos, y es importante que Ud. entienda estos riesgos. La elección de cada individuo de someterse a un procedimiento debe basarse en la comparación de sus riesgos y sus potenciales beneficios. A pesar que la mayoría de los pacientes no experimentan estas complicaciones, Ud. debe discutir cada uno de estos riesgos con su cirujano para asegurarse que entendió los riesgos, sus potenciales complicaciones y consecuencias del procedimiento.`, 30, 221, 160,  5);
            
            doc.addPage();
            doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

            doc.setFont("helvetica", "bold");
            doc.text("Sangrado.", 30, 55);

            doc.setFont("helvetica", "normal");

            drawJustifiedText(doc, "                   Es posible, aunque inusual, que Ud. experimente sangrado durante o después del procedimiento. Si ocurre sangrado, Ud. puede requerir un tratamiento de emergencia para drenar la sangre acumulada (hematoma).", 30, 55, 160, 5);

            drawJustifiedText(doc,"No debe tomar ninguna medicación que altere la coagulación, aspirina o antiinflamatorios no esteroideos (salvo paracetamol) durante 10 días antes del procedimiento, ya que esto contribuye a mayor riesgo de sangrado o hematomas.", 30, 75, 160, 5);

            drawJustifiedText(doc,"Coméntelo con su cirujano si esta tomando estas medicaciones antes de dejar de consumirlas.", 30, 90, 160, 5);

            doc.setFont("helvetica", "bold");
            doc.text("Infección.", 30, 100); //original 30
            
            doc.setFont("helvetica", "normal");
            drawJustifiedText(doc, "             Es infrecuente luego de este procedimiento. Pero si ocurre, Ud. deberá realizar tratamiento con antibióticos o cirugía en los casos necesarios.", 30, 100, 160, 5);

            doc.setFont("helvetica", "bold");
            doc.text("Dolor.", 30, 110);

            doc.setFont("helvetica", "normal");
            drawJustifiedText(doc, "            Raramente, puede ocurrir dolor crónico en el sitio de inyección.", 30, 110, 160, 5);

            doc.setFont("helvetica", "bold");
            doc.text("Biopsias:", 30, 115);

            doc.setFont("helvetica", "normal");
            drawJustifiedText(doc, "             Es posible que sea necesario biopsiar el área ante hallazgos anormales. Sin embargo no hay razón para pensar que la transferencia de plasma rico en plaquetas puede causar cáncer de vulva.", 30, 115, 160, 5);

            doc.setFont("helvetica", "bold");
            doc.text("Daño a estructuras profundas.", 30, 130);

            doc.setFont("helvetica", "normal");
            drawJustifiedText(doc, "                                           Estructuras profundas como nervios, vasos sanguíneos o músculos pueden dañarse mediante este procedimiento. Estos daños pueden ser permanentes o temporarios y dependerán en parte de la zona a tratar.", 30, 130, 160, 5);

            doc.setFont("helvetica", "bold");
            doc.text("Resultado insatisfactorio.", 30, 145);

            doc.setFont("helvetica", "normal");
            drawJustifiedText(doc, "                                         Existe la posibilidad de que el resultado del procedimiento sea insatisfactorio, resultando en necrosis de piel o pérdida de la sensibilidad, o que ningún cambio ocurra, ni en beneficio ni en detrimento. Ud. puede estar decepcionada con los resultados.", 30, 145, 160, 5);

            doc.setFont("helvetica", "normal");
            drawJustifiedText(doc, "He sido informado y me han explicado en detalle que la intervención será realizada en el contexto de un curso de formación profesional para médicos de la especialidad, y que van a estar presentes en el quirófano aprendiendo la técnica quirúrgica otros profesionales y que la intervención será transmitida en vivo hacia un salón cerrado, con un grupo cerrado de profesionales, que toman el curso presencialmente.", 30, 165, 160, 5);

            drawJustifiedText(doc, "Es importante que Ud. lea atentamente esta información y realice todas las preguntas pertinentes a su médico antes de firmar el consentimiento.", 30, 200, 160, 5);

            doc.setFontSize(13);
            doc.setFont("helvetica", "italic");
            doc.text("CONSENTIMIENTO PARA CIRUGÍA, PROCEDIMIENTO O TRATAMIENTO", setMiddle()+5, 220, { align:'center',maxWidth: 160 });

            doc.setFontSize(11);
            doc.setFont("helvetica", "normal");
            doc.setLineHeightFactor(1.4);
            drawJustifiedText(doc, `Yo en pleno uso de mis facultades y voluntariamente, autorizo al ${patient.fullnameDoctor} y su equipo a realizar el siguiente procedimiento:`, 30, 230, 160, 5);
            
            doc.setFont("helvetica", "bold");
            doc.text("Aplicación vulvar de Plasma Rico en Plaquetas Autólogo", 30, 241, { maxWidth: 160 });

            doc.addPage();
            doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);
            
            doc.setFont("helvetica", "normal");
            doc.text("Yo he recibido la información por escrito:", 30, 55, { maxWidth: 160 });

            doc.setFontSize(13);
            doc.setFont("helvetica", "italic");
            doc.text("“CONSENTIMIENTO INFORMADO PARA APLICACIÓN DE PLASMA RICO EN PLAQUETAS”", 30, 60, { maxWidth: 160 });
            
            doc.setFontSize(11);
            doc.setFont("helvetica", "normal");
            doc.setLineHeightFactor(1.4); 

            drawJustifiedText(doc,"Yo reconozco que no he recibido garantías por ninguna persona sobre los resultados a obtener.", 42, 88, 140, 5);

            drawJustifiedText(doc,"Doy mi consentimiento para ser fotografiado, filmado y/o televisado durante el procedimiento, incluyendo que se vean las partes de mi cuerpo, para fines médicos o científicos o educacionales, siempre que no sea revelada mi identidad por las fotos y/o videos", 42, 98.5, 140, 5);
 
            doc.setLineHeightFactor(1.4);
            doc.text([
                "1.-",
                "",
                "2.-", 
            ], 32, 88,{ maxWidth: 140 });

            drawJustifiedText(doc, "Para propósitos de avance de la educación médica, doy mi consentimiento para que haya observadores en la sala de operaciones. He sido informado y me han explicado en detalle que la intervención será realizada en el contexto de un curso de formación profesional para médicos de la especialidad, y que van a estar presentes en el quirófano aprendiendo la técnica quirúrgica otros profesionales y que la intervención será transmitida en vivo hacia un salón cerrado, con un grupo cerrado de profesionales, que toman el curso presencialmente.", 30, 121, 160, 5);

            drawJustifiedText(doc,"Yo reconozco que no he recibido garantías por ninguna persona sobre los resultados a obtener.", 42, 155, 148, 5);

            doc.setLineHeightFactor(1.4);
            doc.text("3.-", 32, 155,{ maxWidth: 140 });

            doc.text([ 
                "Los procedimientos o tratamientos a los cuales me someteré",
                "Existen alternativas a estos procedimientos",
                "Existen riesgos en el procedimiento al cual seré sometida.",
            ], 54, 165,{ maxWidth: 140 });

            doc.setLineHeightFactor(1.4);
            doc.text([
                "a.",
                "b.",
                "c.", 
            ], 48, 165,{ maxWidth: 140 });
            
            drawJustifiedText(doc,"He sido informado y me han explicado en detalle que la intervención será realizada en el contexto de un curso de formación profesional para médicos de la especialidad, y que van a estar presentes en el quirófano aprendiendo la técnica quirúrgica otros profesionales y que la intervención será transmitida en vivo hacia un salón cerrado, con un grupo cerrado de profesionales, que toman el curso presencialmente.", 42, 185, 148, 5);

            doc.setLineHeightFactor(1.4);
            doc.text("4.-", 32, 185,{ maxWidth: 160 });

            drawJustifiedText(doc,"He sido informado que este consentimiento podrá ser revocado en cualquier momento anterior a la realización efectiva de la práctica o procedimiento. Asimismo doy mi consentimiento para la publicación de mis datos y fotografías, resguardando mi intimidad e identidad, para la realización de este curso de perfeccionamiento científico, el cual se me ha detallado.", 30, 215, 160, 5);

            doc.addPage();
            doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

            doc.rect(30, 60, 160, 55, "S");

            drawJustifiedText(doc,"Yo doy mi consentimiento para realizar el procedimiento y los ítems (1-4) arriba citados. Yo estoy satisfecha con las explicaciones recibidas.", 35, 70, 150, 5);

            doc.line(35, 91, 132, 91);
            doc.text("Firma del paciente o persona autorizada por el paciente",35,95,{maxWidth: 150})

            doc.line(48, 108, 100, 108);
            doc.text("Fecha:",35,108,{maxWidth: 150})

            doc.line(125, 108, 182, 108);
            doc.text("Testigo:",110,108,{maxWidth: 150})

            doc.setFont("helvetica", "bold");

            drawJustifiedText(doc,"Autorizo a ser fotografiada y/o antes, durante y despues del procedimiento, siempre resguardando mi identidad y para ser usado con fines didacticos y o terpareuticos de seguimiento", 30, 140, 160, 5);

            doc.text("Firma del paciente",35,170,{maxWidth: 150}) 
            doc.text("Firma del médico",110,170,{maxWidth: 150})

            const totalPages = doc.internal.getNumberOfPages();
    
            for (let i = 1; i <= totalPages; i++) {  
                doc.setPage(i); 
                
                const logoBase64  = await getImageAsBase64($("#logoImgPap").src); 
                const logo = $("#logoImgPap"); 
                
                doc.addImage(
                    logoBase64, 
                    'PNG', 
                    (186-(logo.width*0.065)), 
                    8, 
                    logo.width*0.065, logo.height*0.065
                );

                doc.setFontSize(14); 
                const text = i+"/"+totalPages;
                const pageSize = doc.internal.pageSize;
                const pageHeight = pageSize.height || pageSize.getHeight();
                const textWidth = doc.getStringUnitWidth(text.toString()) * doc.internal.getFontSize() / doc.internal.scaleFactor;
                const textHeight = doc.internal.getLineHeight() / doc.internal.scaleFactor;
                const x = (pageSize.width - (textWidth+17));
                const y = pageHeight - 12;  

                doc.text(text.toString(), x, y);
            }

            doc.save("Consentimiento_Informado_PRP.pdf");
            /*const pdfBlob = doc.output('blob');
                const url = URL.createObjectURL(pdfBlob);

                const container = $('#pdf-preview'); 
                container.classList.remove("h-0");
                container.classList.add("h-[500px]");
                container.innerHTML = `<div class="bg-white h-[41px] p-2">
                                            <button onclick="closePreview()" class="border-red-700 text-white bg-red-700 border-2 ml-4 float-right p-1 rounded-lg" title="Cerrar PDF">
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="14"  height="14"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                                            </button>
                                        </div>
                                        <iframe src="${url}" width="100%" height="450px" type="application/pdf" ></iframe>`;*/

        }

        async function createConsentTLF(patient){

            if($("#medicalUnit").value == ""){
                $("#medicalUnit_message").innerHTML = "{!!__('rules.medical_unit_required')!!}";
                return;
            }

            if($("#area").value == ""){
                $("#area_message").innerHTML = "{!!__('rules.area_required')!!}";
                return;
            }

            doc               = new jsPDF(); 
            const fondoBase64 = await getImageAsBase64($("#imgPap").src); 
            
            doc.addFileToVFS("{{ asset('/resources/libs/fontawesome/webfonts/fa-solid-400.ttf') }}", fontAwesomeBase64);
            doc.addFont("{{ asset('/resources/libs/fontawesome/webfonts/fa-solid-400.ttf') }}", "FontAwesome", "normal");
            doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

            doc.setFontSize(13);
            doc.setFont("helvetica", "bold");
            doc.text("CONSENTIMIENTO INFORMADO", setMiddle(), 50, { align:'center',maxWidth: 160 });

            doc.setFontSize(12);
            doc.setFont("helvetica", "normal"); 
            doc.setLineHeightFactor(1.5);

            let currentMedicalUnit = medicalUnits.find(medicalUnit => $("#medicalUnit").value == medicalUnit.id);
            let currentArea = areas.find(area => $("#area").value == area.id);

            const paragraph1 = `En la Ciudad de:  ${currentMedicalUnit.city}  a los  ${reformatDate(new Date(),"d")}  dias del mes  ${reformatDate(new Date(),"M")}  del año  ${reformatDate(new Date(),"y")}.\nYo  ${patient.fullname}  ${patient.gender == 'female' ? "Mexicana" : "Mexicano"},  contando con  ${patient.age}  años de edad, con dirección en  ${patient.fulladdress}.`;
            const paragraph2 = `Autorizo  ${patient.doctor_gender == "female" ? "a la Médica" :"al Médico"}  ${patient.fullnameDoctor}  quien se encuentra en formación en Medicina regenerativa laser para que realice: aplicación de LASER CO2 FRACCIONADO en  ${currentArea.name}.`;
            const paragraph3 = `En el año 2004 los láseres entraron en una nueva era bajo el concepto de la fototermólisis fraccionada. A partir de fraccionar el haz de láser en patrones de zonas microscópicas de daño térmico, el paradigma de la restauración cutánea cambió de fondo, ya que en este proceso no se eliminan capas completas de piel en las áreas tratadas, sino que se estimula la reparación del daño a través de detritos epidérmicos necróticos microscópicos (mends), que se desprenden en forma de descamación microscópica controlada en cuatro a siete días en el rostro y siete a 12 días en el cuerpo. La reparación se realiza eficazmente a partir de las células vecinas al área dañada. Con bajo índice de complicaciones y con la posibilidad de tratar casi cualquier área del cuerpo. Se utilizan principalmente para la remodelación dérmica, eficaz en cicatrices atróficas profundas por acné, varicela o herpes zoster facial y en envejecimiento cronológico. Con varias sesiones de fluencias bajas, se logran buenos resultados sin ser agresivos para el paciente.`;
            const paragraph4 = `Otro de los logros fundamentales de la aplicación de laser CO2, es el tratamiento ginecológico de Incontinencia urinaria, síndrome de laxitud vaginal y síndrome genitourinario del climaterio, procedimientos que cuentan con sustento bibliográfico internacional y que en todos los casos de procedimientos ginecológicos antes mencionados requieren la introducción en vagina de una pieza ginecológica, llamada espéculo láser, para la correcta realización de los procedimientos ginecológicos antes mencionados.`;
            const paragraph5 = `El que suscribe  ${patient.fullnameDoctor}, que ejerce la profesión dentro del marco legal establecido en la República Mexicana, con cedula de especialidad ${patient.license} con domicilio fiscal para oír y recibir notificaciones en  ${currentMedicalUnit.fulladdress}`;
            const paragraph6 = `Ante usted y de la manera más atenta expreso:\nEn cumplimiento de la Norma Oficial NOM-004-SSA3-2012 del expediente clínico se realiza este consentimiento informado.`;
            const paragraph7 = `Quienes con nuestras firmas validamos este documento, manifestamos que con un lenguaje simple, el medico me explico el plan de manejo propuesto y aclaro cada una de las preguntas que como paciente le he planteado, de tal forma que para ambos queda perfectamente claro que se tomaron en consideración las características físicas e individuales de mi persona, para que el acto médico que se requiere, consista en lo que a continuación se expresa:`;
            const paragraph8 = `Acto médico que se propone: Fototermólisis selectiva con laser CO2 Fraccionado en ${currentArea.name}`;
            const paragraph9 = `El paciente y/o su representante legal hace constar y manifiesta que:\nComo un hecho sobresaliente debo señalar que la explicación del médico fue lo suficientemente clara para evidenciar los beneficios, así como los riesgos que se deriven del acto médico.`;
            const paragraphA = `Declaro bajo protesta de decir verdad que se me ha explicado de manera amplia y detallada el procedimiento al cual seré sometido(a), y se han contestado todas las preguntas que han surgido como dudas durante la explicación que el medico antes referido me ha brindado, así mismo, declaro que no existe ninguna duda sobre el procedimiento que me será efectuado, por lo que reconozco que dentro de los riesgos que se me explicaron fueron los siguientes:`;
            const paragraphB = `Cualquier procedimiento médico entraña un cierto grado de riesgo y es importante que yo en mi condición de paciente comprenda los riesgos asociados. La decisión individual de someterme a una intervención con láser se basa en la comparación del riesgo con el beneficio potencial. Aunque la mayoría de las mujeres y/o hombres no experimentan las siguientes complicaciones, debo de conocer y considerar cada una de ellas para asegurarme de que comprendo los riesgos, complicaciones potenciales y consecuencias de la aplicación de láser CO2 fraccionado en los cuales son:`;
            const paragraphC = `En forma complementaria, como paciente manifiesto también, que el médico me explico los beneficios de la aplicación de láser Co2 fraccionado en ${currentArea.name}, decido otorgar mi consentimiento, el médico tratante queda facultado para actuar y resolver la contingencia o urgencia que eventualmente se pudiera presentar, así como para actuar o dejar de hacerlo, si así requiere o hay riesgos. Yo como paciente declaro que se me ha informado que la aplicación de laser CO2 fraccionado es un procedimiento electivo, así mismo se me ha informado que existen muchas condiciones variables que pueden influenciar los resultados a largo plazo del acto médico que se menciona. La práctica de la Medicina y la Medicina estética y regenerativa no son una ciencia exacta, y aunque se esperan buenos resultados, no hay garantía explícita o implícita sobre los resultados que puedan obtenerse.`;
            const paragraphD = `Yo paciente manifiesto que el médico me explico suficientemente, que en caso de aceptar el acto médico propuesto, cuento con la absoluta libertad para revocar este consentimiento en el momento que así lo considere pertinente, siempre que el procedimiento no se encuentre realizado, reiterando así el absoluto respeto a mi libre toma de decisiones.`;
            const paragraphE = `Yo como paciente refrendo que he leído y comprendido totalmente este documento, las explicaciones al respecto, así como que los espacios en blanco han sido rellenados antes de firmar, y en tal circunstancia, otorgo mi consentimiento para que se me realice el procedimiento de aplicación de laser CO2 fraccionado en ${currentArea.name} yo paciente hago constar que la información que me ha proporcionado el médico tratante es suficiente para razonadamente tomar mi decisión sobre el consentimiento solicitado, y la manifiesto libremente con mi nombre y firma en el espacio correspondiente.`;
            const paragraphF = `En el entendido que es necesario la toma de fotografías, videos antes, durante y después del procedimiento autorizo al Dr. o a quien el considere la toma de las mismas y su uso para fines del expediente clínicofotográfico, de enseñanza, presentaciones en Congresos, así como para cualquier otro fin que no sea en detrimento de mi persona y dignidad.`;
            const paragraphG = `Así mismo autorizo al personal de la sede en la que se llevará a cabo el procedimiento descrito en esta carta de consentimiento, para la atención de contingencias y urgencias derivadas del acto autorizado. Lo anterior para dar cumplimiento de la Norma Oficial NOM-004-SSA3-2012 del expediente clínico.`;
            const paragraphH = `Por lo señalado anteriormente, otorgo mi consentimiento de manera libre y voluntaria para los efectos señalados en las páginas anteriores y firma tanto quien emite el presente consentimiento como el médico encargado del procedimiento y los testigos, en todas y cada una de las hojas que integran el presente consentimiento bajo información.`;
            
            drawJustifiedText(doc, paragraph1,30, 60, 155, 6); 

            currentY = 60+getHeight(paragraph1, { maxWidth: 150 })+5;
            
            drawJustifiedText(doc, paragraph2,30, currentY, 150, 6); 

            currentY += getHeight(paragraph2, { maxWidth: 150 })+10;
            
            drawJustifiedText(doc, paragraph3, 30, currentY, 150, 6); 

            currentY += getHeight(paragraph3, { maxWidth: 150 })+22;

            drawJustifiedText(doc, paragraph4, 30, currentY, 150, 6);  

            doc.addPage();
            doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

            drawJustifiedText(doc, paragraph5,30, 60, 155, 6); 

            currentY = 60+getHeight(paragraph5, { maxWidth: 150 })+5;
            
            doc.text(paragraph6.split("\n")[0],30,currentY+5);

            drawJustifiedText(doc, paragraph6.split("\n")[1],30, currentY+11, 155, 6); 

            currentY += getHeight(paragraph6, { maxWidth: 150 })+5;

            drawJustifiedText(doc, paragraph7,30, currentY+11, 155, 6); 

            currentY+= getHeight(paragraph7, { maxWidth: 150 })+16;

            doc.text("Diagnóstico:",30,currentY);

            drawJustifiedText(doc, paragraph8,30, currentY+16, 155, 6); 

            currentY+= getHeight(paragraph8, { maxWidth: 150 })+16;

            doc.setDrawColor(247,235,240); 
            doc.setFillColor(247,235,240);  
            doc.rect(30, currentY, 155, 7, 'FD');  
            
            doc.setTextColor(180, 180, 180);

            drawJustifiedText(doc, "(Nombre y firma de puño y letra del paciente)\n",30, currentY+12, 155, 6); 

            doc.setTextColor(0, 0, 0);

            doc.text(paragraph9.split("\n")[0],30,currentY+20);

            drawJustifiedText(doc, paragraph9.split("\n")[1],30, currentY+26, 155, 6); 

            currentY += getHeight(paragraph9, { maxWidth: 150 })+10;
 
            drawJustifiedText(doc, `Fototermólisis selectiva con laser Co2 Fraccionado en  ${currentArea.name}`,30, currentY+13, 155, 6); 
            
            currentY += getHeight(`Fototermólisis selectiva con laser Co2 Fraccionado en  ${currentArea.name}`, { maxWidth: 155 })+12;

            drawJustifiedText(doc, paragraphA,30, currentY+3, 155, 6); 
            
            doc.addPage();
            doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

            doc.text("RIESGOS DE LA APLICACIÓN DE LASER CO2 FRACCIONADO",30, 60); 
            
            drawJustifiedText(doc, paragraphB,30, 70, 155, 6); 

            currentY = getHeight(paragraphB, { maxWidth: 150 })+80;

            doc.text([
                "Inflamación extrema.",
                "Hiperpigmentación postinflamatoria.",
                "Infección posterior al procedimiento.",
                "Cicatrización anómala permanente.",
            ],40,currentY);

            const check = "\uf101";
            doc.setFontSize(12);
            doc.setFont("FontAwesome", "normal");
            doc.setLineHeightFactor(1.5);
            doc.text([
                check,
                check,
                check, 
                check
            ],33,currentY);

            doc.setFont("helvetica", "normal");

            doc.text("BENEFICIOS DEL PROCEDIMIENTO CON LASER CO2 FRACCIONADO",30, currentY+30); 

            drawJustifiedText(doc, paragraphC,30, currentY+45, 155, 6);  

            doc.addPage();
            doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

            drawJustifiedText(doc, paragraphD,30, 55, 155, 6); 

            currentY = 55+getHeight(paragraphD, { maxWidth: 150 })+4;

            drawJustifiedText(doc, paragraphE,30, currentY, 155, 6); 

            currentY += getHeight(paragraphE, { maxWidth: 150 })+6;

            drawJustifiedText(doc, paragraphF,30, currentY, 155, 6); 

            currentY += getHeight(paragraphF, { maxWidth: 150 })+3;

            drawJustifiedText(doc, paragraphG,30, currentY, 155, 6); 

            currentY += getHeight(paragraphG, { maxWidth: 150 })+3;

            drawJustifiedText(doc, paragraphH,30, currentY, 155, 6); 

            currentY += getHeight(paragraphH, { maxWidth: 150 })+5;

            drawJustifiedText(doc, `El presente Consentimiento se firma en ${currentMedicalUnit.fulladdress} a los ${reformatDate(new Date(),"d")} días del mes de ${reformatDate(new Date(),"M")} del ${reformatDate(new Date(),"y")}.`,30, currentY, 155, 6);
            
            doc.setDrawColor(247,235,240);  
            doc.setFillColor(247,235,240);  
            doc.setGState(new doc.GState({ opacity: 0.5 }));
            doc.rect(30, currentY+20, ((155/3)-4), 15, 'FD'); 
            doc.rect((33+((155/3))), currentY+20, ((155/3)-4), 15, 'FD'); 
            doc.rect((35+((155/3))*2), currentY+20, ((155/3)-4), 15, 'FD'); 
            doc.rect(30, currentY+50, ((155/3)-4), 15, 'FD'); 
            doc.rect((33+((155/3))), currentY+50, ((155/3)-4), 15, 'FD'); 
            doc.setGState(new doc.GState({ opacity: 1}));
            doc.setFontSize(6);
            doc.text("Nombre, firma y/o huella digital del paciente",31,currentY+39)
            drawJustifiedText(doc, "Nombre, firma y/o huella digital del representante legal",34+((155/3)),currentY+39, ((155/3)-5),3);
            doc.text("Nombre, firma y/o huella digital del médico",(36+((155/3))*2), currentY+39)
            doc.text("Testigo nombre, firma y/o huella digital",31,currentY+69)
            doc.text("Testigo nombre, firma y/o huella digital",34+((155/3)),currentY+69)

            doc.setFont("helvetica", "normal");

            const totalPages = doc.internal.getNumberOfPages();

            for (let i = 1; i <= totalPages; i++) {  
                doc.setPage(i); 
                
                const logoBase64  = await getImageAsBase64($("#logoImgPap").src); 
                const logo = $("#logoImgPap"); 
                
                doc.addImage(
                    logoBase64, 
                    'PNG', 
                    (186-(logo.width*0.065)), 
                    8, 
                    logo.width*0.065, logo.height*0.065
                );

                doc.setFontSize(14); 
                const text = i+"/"+totalPages;
                const pageSize = doc.internal.pageSize;
                const pageHeight = pageSize.height || pageSize.getHeight();
                const textWidth = doc.getStringUnitWidth(text.toString()) * doc.internal.getFontSize() / doc.internal.scaleFactor;
                const textHeight = doc.internal.getLineHeight() / doc.internal.scaleFactor;
                const x = (pageSize.width - (textWidth+17));
                const y = pageHeight - 12;  

                doc.text(text.toString(), x, y);
            }

            closeModal('#prepareTLF');
            doc.save("consentimiento informado TLF.pdf");
             /*const pdfBlob = doc.output('blob');
                const url = URL.createObjectURL(pdfBlob);

                const container = $('#pdf-preview'); 
                container.classList.remove("h-0");
                container.classList.add("h-[500px]");
                container.innerHTML = `<div class="bg-white h-[41px] p-2">
                                            <button onclick="closePreview()" class="border-red-700 text-white bg-red-700 border-2 ml-4 float-right p-1 rounded-lg" title="Cerrar PDF">
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="14"  height="14"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                                            </button>
                                        </div>
                                        <iframe src="${url}" width="100%" height="450px" type="application/pdf" ></iframe>`;*/
        }

        async function medicalJustify(patient){ 
            doc               = new jsPDF(); 

            doc.setFontSize(10);

            doc.text(patient.fullnameDoctor,30,60);
            doc.text(reformatDate(new Date(),"d/m/y"),setPositionRight((reformatDate(new Date(),"d/m/y")),180),60);
            doc.text(`Ced. P. ${patient.license}`,30,70);
            doc.text(`Nombre: ${patient.first_name}`,30,80);
            doc.text(`Apellido: ${patient.last_name}`,30,90);

            doc.text(patient.fullnameDoctor,setMiddle(),190,{ align:'center',maxWidth: 160 })
            doc.text(`Ced. P. ${patient.license}`,setMiddle(),200,{ align:'center',maxWidth: 160 })
            
            doc.line((setMiddle()-(calcWidth(patient.fullnameDoctor)/2))-10, 185, (setMiddle()+(calcWidth(patient.fullnameDoctor)/2))+10 ,185);
            doc.setFont("helvetica", "italic");
            drawJustifiedText(doc,`Por medio de la presente me permito informar que el paciente ${patient.fullname.toUpperCase()} no se encuentra en capacidad de llevar a cabo sus actividades laborales debido a una complicación infecciosa del área quirúrgica secundaria a una Freniloplastia realizado el día ${'10/08/20'} la cual se requiere un tiempo de reposo recomendado de 5 días a partir del día en que se realiza el presente documento, A la espera de mejoría del paciente para continuar sus labores sin que sea vulnerable su recuperación.`,30,120,150, 5);
            
            doc.rect(10,10,doc.internal.pageSize.getWidth()-20, doc.internal.pageSize.getHeight()-20, 'S');
            doc.rect(11,11,doc.internal.pageSize.getWidth()-22, doc.internal.pageSize.getHeight()-22, 'S');
            
            const img = $("#hiddenImag"); 
            
            var canvas = document.createElement('canvas');
            var ctx = canvas.getContext('2d');
            canvas.width = img.width;
            canvas.height = img.height;
            ctx.fillStyle = "#4d4e8d";
            ctx.fillRect(0, 0, canvas.width, canvas.height); 
            ctx.globalCompositeOperation = "destination-in";
            ctx.drawImage(img, 0, 0);
            var dataURL = canvas.toDataURL('image/png');
            doc.addImage(dataURL, 'PNG', 30, 20, img.width*0.055, img.height*0.055); 

            doc.setFontSize(18);
            doc.setFont("helvetica", "italic");
            doc.text("JUSTIFICANTE MEDICO", setMiddle(), 30, { align:'center',maxWidth: 160 });

            const pdfBlob = doc.output('blob');
            const url = URL.createObjectURL(pdfBlob);

            const container = $('#pdf-preview'); 
            container.classList.remove("h-0");
            container.classList.add("h-[500px]");
            container.innerHTML = `<div class="bg-white h-[41px] p-2">
                                        <button onclick="closePreview()" class="border-red-700 text-white bg-red-700 border-2 ml-4 float-right p-1 rounded-lg" title="Cerrar PDF">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="14"  height="14"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                                        </button>
                                    </div>
                                    <iframe src="${url}" width="100%" height="450px" type="application/pdf" ></iframe>`;
        }

        function calcWidth(text,initLine = 10){ 
            return (doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor)+initLine+2;
        }

        function setPositionRight(text,rightLimit = 200){
            return (rightLimit-(doc.getStringUnitWidth(text) * (doc.internal.getFontSize()+1) / doc.internal.scaleFactor));
        }

        function setMiddle(width = 210){ 
            return (width/2);
        }

        function getHeight(text, options){
            const { maxWidth = 210 } = options;
;
            const lines = text.split('\n')
                              .flatMap(line => doc.splitTextToSize(line, maxWidth))
                              .filter(line => line.trim() !== "");  

         
            const textHeight = (lines.length / (doc.getLineHeightFactor())) * (doc.getFontSize()*0.65);
         
            return textHeight;
        }

        function setFooter(text){
            doc.setFontSize(11); 
            const pageSize = doc.internal.pageSize;
            const pageHeight = pageSize.height || pageSize.getHeight();
            const textWidth = doc.getStringUnitWidth(text.toString()) * doc.internal.getFontSize() / doc.internal.scaleFactor;
            const textHeight = doc.internal.getLineHeight() / doc.internal.scaleFactor;
            const x = (pageSize.width - textWidth) / 2;
            const y = pageHeight - 10;  

            doc.text(text.toString(), x, y);
        }

        function setHeader(){
            doc.setDrawColor(200, 200, 200);
            doc.line(8, 22, 200, 22);
            doc.setFontSize(23); 
            doc.setFont(undefined,"bold");
            doc.setTextColor(80,80,80);
            doc.text("{{__("routes.encounter_detail")}}",setPositionRight("{{__("routes.encounter_detail")}}"), 16); 
            
            const img = $("#hiddenImag"); 
            
            var canvas = document.createElement('canvas');
            var ctx = canvas.getContext('2d');
            canvas.width = img.width;
            canvas.height = img.height;
            ctx.fillStyle = "#4d4e8d";
            ctx.fillRect(0, 0, canvas.width, canvas.height); 
            ctx.globalCompositeOperation = "destination-in";
            ctx.drawImage(img, 0, 0);
            var dataURL = canvas.toDataURL('image/png');
            doc.addImage(dataURL, 'PNG', 10, 3, img.width*0.055, img.height*0.055); 
        }

        function drawJustifiedText(doc, text, x, y, maxWidth, lineHeight) {
            const lines = doc.splitTextToSize(text, maxWidth); // Divide el texto en líneas ajustadas al ancho máximo

            lines.forEach((line, index) => {
                const words = line.split(" "); // Divide la línea en palabras
                 
                if (index === lines.length - 1 || words.length === 1) {
                    // Última línea o línea con una sola palabra: texto alineado a la izquierda
                    doc.text(line, x, y);
                } else {
                    // Justificar la línea
                    const totalWordWidth = words.reduce((sum, word) => sum + doc.getTextWidth(word), 0);
                    const totalSpaceWidth = maxWidth - totalWordWidth;
                    const spaceWidth = totalSpaceWidth / (words.length - 1);

                    let currentX = x;
                    
                    words.forEach((word, i) => {
                        doc.text(word, currentX, y);

                        if (i < words.length - 1) {
                            currentX += doc.getTextWidth(word) + spaceWidth;
                        }
                    });
                }
                y += lineHeight; // Moverse a la siguiente línea
            });
        }
        async function getImageAsBase64(url) {
            const response = await fetch(url);
            const blob = await response.blob();
            return new Promise((resolve) => {
                const reader = new FileReader();
                reader.onloadend = () => resolve(reader.result);
                reader.readAsDataURL(blob);
            });
        }
    </script>
    <script src="{{ asset('/resources/js/pages/patients.js') }}"></script> 
@stop