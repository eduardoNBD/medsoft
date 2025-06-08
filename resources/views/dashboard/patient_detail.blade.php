@extends('layouts.dashboard',[ 'current_route'  => '/dashboard/patients'])

@section('title', __('messages.detail')) 

@section('breadcrumbs')
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="{{$_['baseURL'].$_['routes']['dashboard']['root']}}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
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
                <a href="{{$_['baseURL'].$_['routes']['patients']['root']}}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <svg class="w-4 h-4 text-gray-400 mx-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" fill="currentColor"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M48 0C21.5 0 0 21.5 0 48L0 256l144 0c8.8 0 16 7.2 16 16s-7.2 16-16 16L0 288l0 64 144 0c8.8 0 16 7.2 16 16s-7.2 16-16 16L0 384l0 80c0 26.5 21.5 48 48 48l217.9 0c-6.3-10.2-9.9-22.2-9.9-35.1c0-46.9 25.8-87.8 64-109.2l0-95.9L320 48c0-26.5-21.5-48-48-48L48 0zM152 64l16 0c8.8 0 16 7.2 16 16l0 24 24 0c8.8 0 16 7.2 16 16l0 16c0 8.8-7.2 16-16 16l-24 0 0 24c0 8.8-7.2 16-16 16l-16 0c-8.8 0-16-7.2-16-16l0-24-24 0c-8.8 0-16-7.2-16-16l0-16c0-8.8 7.2-16 16-16l24 0 0-24c0-8.8 7.2-16 16-16zM512 272a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM288 477.1c0 19.3 15.6 34.9 34.9 34.9l218.2 0c19.3 0 34.9-15.6 34.9-34.9c0-51.4-41.7-93.1-93.1-93.1l-101.8 0c-51.4 0-93.1 41.7-93.1 93.1z"/></svg>
                    {{__('routes.patients')}}
                </a>
            </li> 
            <li class="inline-flex items-center">
                <svg class="w-4 h-4 inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7l5 5l-5 5" /><path d="M13 7l5 5l-5 5" /></svg>
            </li>
            <li class="inline-flex items-center">
                <span class="text-sm font-medium text-gray-700 hover:text-[#4D4E8D] dark:text-gray-400 dark:hover:text-white">{{__('messages.detail')}}</span>
            </li> 
        </ol>
    </nav>
@stop

@section('styles')  
@stop

@section('content') 
    @include('../components/patient/detail')   
    <img src="{{ asset('/resources/img/PDFimg/logo.png') }}" alt="logoImgPap" id="logoImgPap" class="hidden">
    <img src="{{ asset('/resources/img/PDFimg/fondoPDF.jpg') }}" alt="imgPap" id="imgPap" class="hidden">
@stop

@section('scripts')   
    <script src="{{ asset('/resources/libs/jsPDF/jspdf.umd.min.js') }}"></script>    
    <script>  
        const redirect = "{{$_['baseURL'].$_['routes']['patients']['detail']($id)}}"; 
        const urlFiles = '{{$_['baseURL']."/encounters/fileList/".$id."?page="}}'; 
        const urlEncounters = '{{$_['baseURL']."/encounters/diagnosisList/".$id."?page="}}';
        const urlItems = '{{$_['baseURL']."/encounters/items/".$patient->id }}';
        const days   = {!! json_encode($days) !!};
        const months = [];
        const msg = "{{isset($_GET['msg']) ? $_GET['msg'] : ""}}";
        const currentURL = "{{$_['baseURL'].$_['routes']['patients']['detail']($id)}}";
        const { jsPDF } = window.jspdf;
        let doc       = new jsPDF(); 
        let currentPageFiles = 1;
        let currentPageDiagnosisEncounters = 1; 
        let currentPageTreatmentsEncounters = 1;
        let currentPageNotesEncounters = 1;
        let currentPageServicesEncounters = 1;
        let currentPageSuppliesEncounters = 1;

        const withoutServices = '{{__("messages.withoutServices")}}';
        const withoutSupplies = '{{__("messages.withoutSupplies")}}';
        const withoutFilesSearch = '{{__("messages.withoutFiles")}}'; 
        const withoutDiagnostics = '{{__("messages.withoutDiagnostics")}}';
        const withoutTreatments = '{{__("messages.withoutTreatments")}}';
        const withoutNotes = '{{__("messages.withoutNotes")}}';

        if(msg){
            createAlert(...msg.split("_"));
            window.history.pushState({}, title, currentURL);
        }
        
        ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'].forEach(key => {
            months.push(@json($months)[key]);
        }); 
        
        async function recordMedical(patient){
            doc               = new jsPDF(); 
            const fondoBase64 = await getImageAsBase64($("#imgPap").src); 
            const {
                medical_histories,
                user,
                doctor
            } = patient;
            
            for (const key in medical_histories) {
                if (medical_histories[key] === null || medical_histories[key] === undefined) {
                    medical_histories[key] = "";
                }
            } 

            let oncologicLines = doc.splitTextToSize(`${(" ").repeat(75)} ${medical_histories.family_cancer_history}`,230).length; 
            let nonPathologic = doc.splitTextToSize(`${(" ").repeat(79)} ${medical_histories.other_non_pathological_history}`,230).length;
            let alcoholUsage = doc.splitTextToSize(`${(" ").repeat(50)} ${medical_histories.alcohol_details}`,230).length;
            let smokingUsage = doc.splitTextToSize(`${(" ").repeat(50)} ${medical_histories.smoking_details}`,230).length;
            let alergiesDetails = doc.splitTextToSize(`${(" ").repeat(30)} ${medical_histories.allergies_details}`,230).length;
            let surgeryDetails = doc.splitTextToSize(`${(" ").repeat(35)} ${medical_histories.surgery_details}`,230).length;
            let drugsDetails = doc.splitTextToSize(`${(" ").repeat(50)} ${medical_histories.drug_details}`,230).length;
            let urinaryDetails = doc.splitTextToSize(`${(" ").repeat(50)} ${medical_histories.urinary_incontinence_details}`,230).length;
            let urinaryTreatmentDetails = doc.splitTextToSize(`${(" ").repeat(50)} ${medical_histories.urinary_incontinence_treatement_detail}`,230).length;
            let familyDiseasesDetails = doc.splitTextToSize(`${(" ").repeat(60)} ${medical_histories.family_diseases_details}`,230).length;
            let metrorrhagiaDetails = doc.splitTextToSize(`${(" ").repeat(20)} ${medical_histories.metrorrhagia_detail}`,230).length;
            let leukorrheaDetails = doc.splitTextToSize(`${(" ").repeat(20)} ${medical_histories.leukorrhea_detail}`,230).length;
            let pruritusDetails = doc.splitTextToSize(`${(" ").repeat(20)} ${medical_histories.pruritus_detail}`,230).length;
            let menstrualRhythmDetails = doc.splitTextToSize(`${(" ").repeat(26)} ${medical_histories.menstrual_rhythm}`,230).length;
            let menarcheDetails = doc.splitTextToSize(`${(" ").repeat(20)} ${medical_histories.menarche}`,230).length;
            let gynecologicalHistoryDetails = doc.splitTextToSize(`${(" ").repeat(38)} ${medical_histories.gynecological_history}`,230).length;

            oncologicLines = oncologicLines ? oncologicLines : 1;
            nonPathologic = nonPathologic ? nonPathologic : 1;
            alcoholUsage = alcoholUsage ? alcoholUsage : 1;
            smokingUsage = smokingUsage ? smokingUsage : 1;
            alergiesDetails = alergiesDetails ? alergiesDetails : 1;
            surgeryDetails = surgeryDetails ? surgeryDetails : 1;
            drugsDetails = drugsDetails ? drugsDetails : 1;
            urinaryDetails = urinaryDetails ? urinaryDetails : 1;
            urinaryTreatmentDetails = urinaryTreatmentDetails ? urinaryTreatmentDetails : 1;
            familyDiseasesDetails = familyDiseasesDetails ? familyDiseasesDetails : 1;
            metrorrhagiaDetails = metrorrhagiaDetails ? metrorrhagiaDetails : 1;
            leukorrheaDetails = leukorrheaDetails ? leukorrheaDetails : 1;
            pruritusDetails = pruritusDetails ? pruritusDetails : 1;
            menstrualRhythmDetails = menstrualRhythmDetails ? menstrualRhythmDetails : 1;
            menarcheDetails = menarcheDetails ? menarcheDetails : 1;
            gynecologicalHistoryDetails = gynecologicalHistoryDetails ? gynecologicalHistoryDetails : 1;

            doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

            doc.setFontSize(13);
            doc.setFont("helvetica", "bold");
            doc.text("HISTORIA CLINICA", setMiddle(), 50, { align:'center',maxWidth: 160 });

            doc.setFontSize(12);
            doc.setFont("helvetica", "normal"); 
            doc.setLineHeightFactor(1.5);

            doc.setDrawColor(247,235,240); 
            doc.setFillColor(247,235,240); 
            doc.rect(calcWidth("No. de Expediente:")+20, 55, 165-calcWidth("No. de Expediente: "), 7, 'FD'); 
            doc.text("No. de Expediente:",30, 60);
            doc.setFont(undefined, "italic"); 
            doc.setFontSize(10);
            doc.setTextColor(50, 50, 50);
            doc.text(medical_histories.file_number, calcWidth("No. de Expediente:   ")+24,60)

            doc.setDrawColor(247,235,240); 
            doc.setFillColor(247,235,240); 
            doc.rect(calcWidth("Nombre:")+23, 63, 162-calcWidth("Nombre: "), 7, 'FD'); 
            doc.setFontSize(12);
            doc.setFont("helvetica", "normal"); 
            doc.setTextColor(0, 0, 0);
            doc.text("Nombre:",30, 68);
            doc.setFont(undefined, "italic"); 
            doc.setFontSize(10);
            doc.setTextColor(50, 50, 50); 
            doc.text(`${user.first_name} ${user.last_name}`,calcWidth("Nombre:   ")+24, 68); 

            doc.setDrawColor(247,235,240); 
            doc.setFillColor(247,235,240); 
            doc.rect(calcWidth("Edad: ")+20, 71, 10, 7, 'FD');  
            doc.setFontSize(12);
            doc.setFont("helvetica", "normal"); 
            doc.setTextColor(0, 0, 0); 
            doc.text(`Edad:           Estado civil:                     Sexo:`,30, 76); 
            doc.setFont(undefined, "italic"); 
            doc.setFontSize(10);
            doc.setTextColor(50, 50, 50);  
            doc.text(patient.age.toString(),calcWidth("Edad: ")+22, 76);

            doc.setDrawColor(247,235,240); 
            doc.setFillColor(247,235,240); 
            doc.rect(calcWidth("Edad:           Estado civil:  ")+26, 71, 20, 7, 'FD');  
            doc.setFont(undefined, "italic"); 
            doc.setFontSize(10);
            doc.setTextColor(50, 50, 50);  
            doc.text(medical_histories.marital_statusText,calcWidth("Edad:          Estado civil:   ")+28, 76);

            doc.setDrawColor(247,235,240); 
            doc.setFillColor(247,235,240); 
            doc.rect(calcWidth("Edad:           Estado civil:                       Sexo:     ")+28, 71, 68.5, 7, 'FD'); 
            doc.text(user.genderText,calcWidth("Edad:           Estado civil:                       Sexo:     ")+30, 76);
            
            doc.setFontSize(12);
            doc.setFont("helvetica", "normal"); 
            doc.setTextColor(0, 0, 0); 
            doc.text(`Ocupación: `,30, 84);

            doc.setDrawColor(247,235,240); 
            doc.setFillColor(247,235,240); 
            doc.rect(calcWidth("Ocupación:")+20, 79, 165-calcWidth("Ocupación: "), 7, 'FD'); 
            doc.setFont(undefined, "italic"); 
            doc.setFontSize(10);
            doc.text(medical_histories.occupation,calcWidth("Ocupación: ")+25, 84); 

            currentY = 92

            if(medical_histories.marital_statusText != "Soltero" && medical_histories.marital_statusText != 'Single'){
                doc.setFontSize(12);
                doc.setFont("helvetica", "normal"); 
                doc.setTextColor(0, 0, 0); 
                doc.text(`Ocupación del Conyugue: `,30, currentY);

                doc.setDrawColor(247,235,240); 
                doc.setFillColor(247,235,240); 
                doc.rect(calcWidth("Ocupación del Conyugue:")+20, currentY-5, 165-calcWidth("Ocupación del Conyugue: "), 7, 'FD'); 
                doc.setFont(undefined, "italic"); 
                doc.setFontSize(10);
                doc.text(medical_histories.spouse_occupation,calcWidth("Ocupación del Conyugue: ")+29, currentY);

                currentY+= 8;
            }
            
            doc.setDrawColor(247,235,240); 
            doc.setFillColor(247,235,240); 
            doc.rect(calcWidth("Domicilio: ")+22, currentY-5, 162-calcWidth("Domicilio: "), 7, 'FD'); 
            doc.setFontSize(12);
            doc.setFont("helvetica", "normal"); 
            doc.setTextColor(0, 0, 0); 
            doc.text(`Domicilio:`,30, currentY);
            doc.setFont(undefined, "italic"); 
            doc.setFontSize(10);
            doc.setTextColor(50, 50, 50);  
            doc.text(`${patient.address}, ${patient.city}, ${patient.zipcode}, ${patient.country}`,calcWidth("Domicilio:   ")+24, currentY);

            currentY+= 8;

            doc.setDrawColor(247,235,240); 
            doc.setFillColor(247,235,240); 
            doc.rect(calcWidth("Peso:")+22, currentY-5, 17, 7, 'FD'); 
            doc.rect(calcWidth("Peso:")+56, currentY-5, 17, 7, 'FD');  
            doc.rect(calcWidth("Peso:")+146, currentY-5, 17, 7, 'FD'); 
            doc.setFontSize(12);
            doc.setFont("helvetica", "normal"); 
            doc.setTextColor(0, 0, 0); 
            doc.text(`Peso:`,30, currentY);
            doc.text(`Altura:`,calcWidth("Peso:")+40, currentY); 
            doc.text(`¿Ha tenido transfusión de sangre?`,calcWidth("Peso:")+75, currentY);
            doc.setFont(undefined, "italic"); 
            doc.setFontSize(10);
            doc.setTextColor(50, 50, 50);  
            doc.text(`${medical_histories.weight} KG`,calcWidth("Peso: ")+24, currentY);
            doc.text(`${medical_histories.height} CM`,calcWidth("Peso: ")+57, currentY);
            doc.text(`${medical_histories.has_blood_transfusion ? "Si" : "No"}`,calcWidth("Peso: ")+150, currentY);
            
            currentY+= 8;

            doc.setDrawColor(247,235,240); 
            doc.setFillColor(247,235,240); 
            doc.rect(calcWidth("¿Ha tenido transfusión de sangre?")+35, currentY-5, 11, 7, 'FD');  
            doc.setFontSize(12);
            doc.setFont("helvetica", "normal"); 
            doc.setTextColor(0, 0, 0);  
            doc.text(`¿Ha tenido transfusión de sangre?`,30, currentY);
            doc.setFont(undefined, "italic"); 
            doc.setFontSize(10);
            doc.setTextColor(50, 50, 50);   
            doc.text(`${medical_histories.has_blood_transfusion ? "Si" : "No"}`,calcWidth("¿Ha tenido transfusión de sangre?")+39, currentY);

            if(medical_histories.has_blood_transfusion){
                doc.setDrawColor(247,235,240); 
                doc.setFillColor(247,235,240); 
                doc.rect(calcWidth("¿Ha tenido transfusión de sangre?")+88, currentY-5, 30, 7, 'FD');  
                doc.setFontSize(12);
                doc.setFont("helvetica", "normal"); 
                doc.setTextColor(0, 0, 0);  
                doc.text(`Ultima transfusión:`,calcWidth("¿Ha tenido transfusión de sangre?")+40, currentY);
                doc.setFont(undefined, "italic"); 
                doc.setFontSize(10);
                doc.setTextColor(50, 50, 50);   
                doc.text(`${reformatDate(medical_histories.last_blood_transfusion)}`,calcWidth("¿Ha tenido transfusión de sangre?")+92, currentY);
            }

            if(medical_histories.has_insurance){
                currentY+= 8;

                doc.setDrawColor(247,235,240); 
                doc.setFillColor(247,235,240); 
                doc.rect(calcWidth("Seguro:")+23, currentY-5, 162-calcWidth("Seguro: "), 7, 'FD'); 
                doc.setFontSize(12);
                doc.setFont("helvetica", "normal"); 
                doc.setTextColor(0, 0, 0);
                doc.text("Seguro:",30, currentY);
                doc.setFont(undefined, "italic"); 
                doc.setFontSize(10);
                doc.setTextColor(50, 50, 50); 
                doc.text(`${medical_histories.insurance_name}`,calcWidth("Seguro:   ")+24, currentY); 

                currentY+= 8;

                doc.setDrawColor(247,235,240); 
                doc.setFillColor(247,235,240); 
                doc.rect(calcWidth("Numero de seguro:   ")+23, currentY-5, 162-calcWidth("Numero de seguro:    "), 7, 'FD'); 
                doc.setFontSize(12);
                doc.setFont("helvetica", "normal"); 
                doc.setTextColor(0, 0, 0);
                doc.text("Numero de seguro:",30, currentY);
                doc.setFont(undefined, "italic"); 
                doc.setFontSize(10);
                doc.setTextColor(50, 50, 50); 
                doc.text(`${medical_histories.insurance_id}`,calcWidth("Numero de seguro:   ")+26, currentY); 
            }

            currentY+= 16;
            
            doc.setDrawColor(247,235,240); 
            doc.setFillColor(247,235,240); 

            for (let index = 1; index <= oncologicLines; index++) {
                
                let indexX = 30;
                let maxW   = 154;
                
                if(index == 1){
                    indexX = calcWidth("Antecedentes Familiares Oncológicos: ")+31;
                    maxW = 152-calcWidth("Antecedentes Familiares Oncológicos:");
                }   

                doc.rect(indexX, ((currentY-13)+(8*index)), maxW, 7, 'FD'); 
            }

            doc.setFontSize(12);
            doc.setFont("helvetica", "normal"); 
            doc.setTextColor(0, 0, 0); 
            doc.text(`Antecedentes Familiares Oncológicos:`,30, currentY);
            doc.setFont(undefined, "italic"); 
            doc.setFontSize(10);
            doc.setTextColor(50, 50, 50);   
            drawJustifiedText(doc,`${(" ").repeat(75)} ${medical_histories.family_cancer_history}`,32, currentY, 150, 8);

            currentY += (oncologicLines*8);

            if(currentY >= 266){
                doc.addPage();
                doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                currentY = 55;
            }
            
            doc.setDrawColor(247,235,240); 
            doc.setFillColor(247,235,240); 

            for (let index = 0; index < nonPathologic; index++) {
                
                let indexX = 30;
                let maxW   = 154;
                
                if(index == 0){
                    indexX = calcWidth("Antecedentes personales no patológicos: ")+31;
                    maxW = 152-calcWidth("Antecedentes personales no patológicos:");
                }   

                doc.rect(indexX, ((currentY)+(8*index))-5, maxW, 7, 'FD'); 
            }

            doc.setFontSize(12);
            doc.setFont("helvetica", "normal"); 
            doc.setTextColor(0, 0, 0); 
            doc.text(`Antecedentes personales no patológicos:`,30, currentY);  
            doc.setFont(undefined, "italic"); 
            doc.setFontSize(10);
            doc.setTextColor(50, 50, 50);   
            drawJustifiedText(doc,`${(" ").repeat(79)} ${medical_histories.other_non_pathological_history}`,32, currentY, 150, 8);
            
            currentY+= (nonPathologic*8);

            if(currentY >= 266){
                doc.addPage();
                doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                currentY = 55;
            }

            doc.setDrawColor(247,235,240); 
            doc.setFillColor(247,235,240); 
            doc.rect(calcWidth("¿Fuma?:")+24.5, currentY-5, 11, 7, 'FD');  
            doc.setFontSize(12);
            doc.setFont("helvetica", "normal"); 
            doc.setTextColor(0, 0, 0); 
            doc.text(`¿Fuma? `,30, currentY);  
            doc.setFont(undefined, "italic"); 
            doc.setFontSize(10);
            doc.setTextColor(50, 50, 50);   
            doc.text(`${medical_histories.smoking ? "Si" : "No"}`,calcWidth("`¿Fuma?:`  ")+24, currentY); 

            doc.setDrawColor(247,235,240); 
            doc.setFillColor(247,235,240); 
            doc.rect(calcWidth("`¿Fuma?:`  ")+82.5, currentY-5, 11, 7, 'FD');  
            doc.setFontSize(12);
            doc.setFont("helvetica", "normal"); 
            doc.setTextColor(0, 0, 0); 
            doc.text(`¿Es fumador pasivo? `,65, currentY);  
            doc.setFont(undefined, "italic"); 
            doc.setFontSize(10);
            doc.setTextColor(50, 50, 50);   
            doc.text(`${medical_histories.passive_smoking ? "Si" : "No"}`,calcWidth("`¿Fuma?:`  ")+86, currentY); 

            doc.setDrawColor(247,235,240); 
            doc.setFillColor(247,235,240); 
            doc.rect(calcWidth("`¿Fuma?:`  ")+142.5, currentY-5, 11, 7, 'FD');  
            doc.setFontSize(12);
            doc.setFont("helvetica", "normal"); 
            doc.setTextColor(0, 0, 0); 
            doc.text(`¿Consume alcohol? `,130, currentY);  
            doc.setFont(undefined, "italic"); 
            doc.setFontSize(10);
            doc.setTextColor(50, 50, 50);   
            doc.text(`${medical_histories.alcohol_usage ? "Si" : "No"}`,calcWidth("`¿Fuma?:`  ")+146, currentY); 
         
            currentY+= 8;

            if(medical_histories.smoking || medical_histories.passive_smoking){

                if(currentY+(smokingUsage*8) >= 266){
                    doc.addPage();
                    doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                    currentY = 55;
                }

                doc.setDrawColor(247,235,240); 
                doc.setFillColor(247,235,240);

                for (let index = 0; index < smokingUsage; index++) {
                    
                    let indexX = 30;
                    let maxW   = 154;
                    
                    if(index == 0){
                        indexX = calcWidth("Detalle de consumo de tabaco: ")+29;
                        maxW = 154-calcWidth("Detalle de consumo de tabaco:");
                    }   

                    doc.rect(indexX, (currentY+(8*index))-5, maxW, 7, 'FD'); 
                }

                doc.setFontSize(12);
                doc.setFont("helvetica", "normal"); 
                doc.setTextColor(0, 0, 0); 
                doc.text(`Detalle de consumo de tabaco:`,30, currentY);
                doc.setFont(undefined, "italic"); 
                doc.setFontSize(10);
                doc.setTextColor(50, 50, 50);   
                
                drawJustifiedText(doc,`${(" ").repeat(60)} ${medical_histories.smoking_details}`,32, currentY, 150, 8);
                
                currentY+= (smokingUsage*8);
            }

            if(medical_histories.alcohol_usage){

                if(currentY+(alcoholUsage*8) >= 266){
                    doc.addPage();
                    doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                    currentY = 55;
                }

                doc.setDrawColor(247,235,240); 
                doc.setFillColor(247,235,240);

                for (let index = 0; index < alcoholUsage; index++) {
                    
                    let indexX = 30;
                    let maxW   = 154;
                    
                    if(index == 0){
                        indexX = calcWidth("Detalle de consumo de alcohol: ")+29;
                        maxW = 154-calcWidth("Detalle de consumo de alcohol:");
                    }   

                    doc.rect(indexX, (currentY+(8*index))-5, maxW, 7, 'FD'); 
                }

                doc.setFontSize(12);
                doc.setFont("helvetica", "normal"); 
                doc.setTextColor(0, 0, 0); 
                doc.text(`Detalle de consumo de alcohol:`,30, currentY);
                doc.setFont(undefined, "italic"); 
                doc.setFontSize(10);
                doc.setTextColor(50, 50, 50);   
                
                drawJustifiedText(doc,`${(" ").repeat(60)} ${medical_histories.alcohol_details}`,32, currentY, 150, 8);
                
                currentY+= (alcoholUsage*8); 
            }

            if(currentY >= 266){
                doc.addPage();
                doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                currentY = 55;
            }
            
            doc.setDrawColor(247,235,240); 
            doc.setFillColor(247,235,240); 
            doc.rect(calcWidth("¿Tiene Alergias?:")+24.5, currentY-5, 11, 7, 'FD');  
            doc.setFontSize(12);
            doc.setFont("helvetica", "normal"); 
            doc.setTextColor(0, 0, 0); 
            doc.text(`¿Tiene Alergias? `,30, currentY);  
            doc.setFont(undefined, "italic"); 
            doc.setFontSize(10);
            doc.setTextColor(50, 50, 50);   
            doc.text(`${medical_histories.has_allergies ? "Si" : "No"}`,calcWidth("`¿Tiene Alergias?:`  ")+24, currentY); 

            currentY+= 8;

            if(currentY >= 266){
                doc.addPage();
                doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                currentY = 55;
            }

            if(medical_histories.has_allergies){

                if(currentY+(alergiesDetails*8) >= 266){
                    doc.addPage();
                    doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                    currentY = 55;
                }

                doc.setDrawColor(247,235,240); 
                doc.setFillColor(247,235,240);

                for (let index = 0; index < alergiesDetails; index++) {
                    
                    let indexX = 30;
                    let maxW   = 154;
                    
                    if(index == 0){
                        indexX = calcWidth("Detalle de alergias: ")+25;
                        maxW = 158-calcWidth("Detalle de alergias:");
                    }   

                    doc.rect(indexX, (currentY+(8*index))-5, maxW, 7, 'FD'); 
                }

                doc.setFontSize(12);
                doc.setFont("helvetica", "normal"); 
                doc.setTextColor(0, 0, 0); 
                doc.text(`Detalle de alergias:`,30, currentY);
                doc.setFont(undefined, "italic"); 
                doc.setFontSize(10);
                doc.setTextColor(50, 50, 50);   
                
                drawJustifiedText(doc,`${(" ").repeat(38)} ${medical_histories.allergies_details}`,32, currentY, 150, 8);
                
                currentY+= (alergiesDetails*8);
            }

            doc.setDrawColor(247,235,240); 
            doc.setFillColor(247,235,240); 
            doc.rect(calcWidth("¿Tiene Cirugias?:")+24.5, currentY-5, 11, 7, 'FD');  
            doc.setFontSize(12);
            doc.setFont("helvetica", "normal"); 
            doc.setTextColor(0, 0, 0); 
            doc.text(`¿Tiene Cirugias? `,30, currentY);  
            doc.setFont(undefined, "italic"); 
            doc.setFontSize(10);
            doc.setTextColor(50, 50, 50);   
            doc.text(`${medical_histories.has_allergies ? "Si" : "No"}`,calcWidth("`¿Tiene Cirugias?:`  ")+24, currentY); 

            currentY+= 8;

            if(medical_histories.has_surgeries){
                 
                if(currentY+(surgeryDetails*8) >= 266){
                    doc.addPage();
                    doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                    currentY = 55;
                }

                doc.setDrawColor(247,235,240); 
                doc.setFillColor(247,235,240);

                for (let index = 0; index < surgeryDetails; index++) {
                    
                    let indexX = 30;
                    let maxW   = 154;
                    
                    if(index == 0){
                        indexX = calcWidth("Detalle de cirugias: ")+25;
                        maxW = 158-calcWidth("Detalle de cirugias:");
                    }   

                    doc.rect(indexX, (currentY+(8*index))-5, maxW, 7, 'FD'); 
                }

                doc.setFontSize(12);
                doc.setFont("helvetica", "normal"); 
                doc.setTextColor(0, 0, 0); 
                doc.text(`Detalle de cirugias:`,30, currentY);
                doc.setFont(undefined, "italic"); 
                doc.setFontSize(10);
                doc.setTextColor(50, 50, 50);   
                
                drawJustifiedText(doc,`${(" ").repeat(38)} ${medical_histories.surgery_details}`,32, currentY, 150, 8);
                
                currentY+= (surgeryDetails*8);
            }

            doc.setDrawColor(247,235,240); 
            doc.setFillColor(247,235,240); 
            doc.rect(calcWidth("¿Consume Drogas?:")+26, currentY-5, 11, 7, 'FD');  
            doc.setFontSize(12);
            doc.setFont("helvetica", "normal"); 
            doc.setTextColor(0, 0, 0); 
            doc.text(`¿Consume Drogas? `,30, currentY);  
            doc.setFont(undefined, "italic"); 
            doc.setFontSize(10);
            doc.setTextColor(50, 50, 50);   
            doc.text(`${medical_histories.drug_usage ? "Si" : "No"}`,calcWidth("`¿Consume Drogas?:`  ")+26, currentY); 

            currentY+= 8;
             
            if(medical_histories.drug_usage){
                currentY-= 8;
                
                doc.setDrawColor(247,235,240); 
                doc.setFillColor(247,235,240); 
                doc.rect(calcWidth("¿Consume Drogas?:")+98, currentY-5, 42, 7, 'FD');  
                doc.setFontSize(12);
                doc.setFont("helvetica", "normal"); 
                doc.setTextColor(0, 0, 0); 
                doc.text(`Fecha de ultimo consumo `,90, currentY);  
                doc.setFont(undefined, "italic"); 
                doc.setFontSize(10);
                doc.setTextColor(50, 50, 50);   
                doc.text(reformatDate(medical_histories.last_drug_usage,"d/m/y"),calcWidth("`¿Consume Drogas?:`  ")+100, currentY); 

                currentY+= 8;

                if(currentY+(drugsDetails*8) >= 266){
                    doc.addPage();
                    doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                    currentY = 55;
                }

                doc.setDrawColor(247,235,240); 
                doc.setFillColor(247,235,240);

                for (let index = 0; index < drugsDetails; index++) {
                    
                    let indexX = 30;
                    let maxW   = 154;
                    
                    if(index == 0){
                        indexX = calcWidth("Detalle de consumo de drogas: ")+28;
                        maxW = 155-calcWidth("Detalle de consumo de drogas:");
                    }   

                    doc.rect(indexX, (currentY+(8*index))-5, maxW, 7, 'FD'); 
                }

                doc.setFontSize(12);
                doc.setFont("helvetica", "normal"); 
                doc.setTextColor(0, 0, 0); 
                doc.text(`Detalle de consumo de drogas:`,30, currentY);
                doc.setFont(undefined, "italic"); 
                doc.setFontSize(10);
                doc.setTextColor(50, 50, 50);   
                
                drawJustifiedText(doc,`${(" ").repeat(60)} ${medical_histories.drug_details}`,32, currentY, 150, 8);
                
                currentY+= (drugsDetails*8);
            }

            doc.setDrawColor(247,235,240); 
            doc.setFillColor(247,235,240); 
            doc.rect(calcWidth("¿Tiene incontinencia urinaria?")+35, currentY-5, 11, 7, 'FD');  
            doc.setFontSize(12);
            doc.setFont("helvetica", "normal"); 
            doc.setTextColor(0, 0, 0); 
            doc.text(`¿Tiene incontinencia urinaria? `,30, currentY);  
            doc.setFont(undefined, "italic"); 
            doc.setFontSize(10);
            doc.setTextColor(50, 50, 50);   
            doc.text(`${medical_histories.urinary_incontinence ? "Si" : "No"}`,calcWidth("`¿Tiene incontinencia urinaria?`  ")+34.5, currentY); 

            currentY+= 8;
             
            if(medical_histories.urinary_incontinence){
                currentY-= 8;
                
                doc.setDrawColor(247,235,240); 
                doc.setFillColor(247,235,240); 
                doc.rect(calcWidth("¿Tiene incontinencia urinaria?")+114, currentY-5, 11, 7, 'FD');  
                doc.setFontSize(12);
                doc.setFont("helvetica", "normal"); 
                doc.setTextColor(0, 0, 0); 
                doc.text(`¿Ha tenido tratamiento?`,115, currentY);  
                doc.setFont(undefined, "italic"); 
                doc.setFontSize(10);
                doc.setTextColor(50, 50, 50);   
                doc.text(`${medical_histories.urinary_incontinence_treatement ? "Si" : "No"}`,calcWidth("`¿Ha tenido tratamiento?`  ")+123, currentY); 

                currentY+= 8;

                if(currentY+(urinaryDetails*8) >= 266){
                    doc.addPage();
                    doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                    currentY = 55;
                }

                doc.setDrawColor(247,235,240); 
                doc.setFillColor(247,235,240);

                for (let index = 0; index < urinaryDetails; index++) {
                    
                    let indexX = 30;
                    let maxW   = 154;
                    
                    if(index == 0){
                        indexX = calcWidth("Detalle de incontinencia urinaria: ")+28;
                        maxW = 155-calcWidth("Detalle de incontinencia urinaria:");
                    }   

                    doc.rect(indexX, (currentY+(8*index))-5, maxW, 7, 'FD'); 
                }

                doc.setFontSize(12);
                doc.setFont("helvetica", "normal"); 
                doc.setTextColor(0, 0, 0); 
                doc.text(`Detalle de incontinencia urinaria:`,30, currentY);
                doc.setFont(undefined, "italic"); 
                doc.setFontSize(10);
                doc.setTextColor(50, 50, 50);   
                
                drawJustifiedText(doc,`${(" ").repeat(62)} ${medical_histories.urinary_incontinence_details}`,32, currentY, 150, 8);
                
                currentY+= (urinaryDetails*8);

                if(medical_histories.urinary_incontinence_treatement){
                    if(currentY+(urinaryTreatmentDetails*8) >= 266){
                        doc.addPage();
                        doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                        currentY = 55;
                    }

                    doc.setDrawColor(247,235,240); 
                    doc.setFillColor(247,235,240);
                    
                    for (let index = 0; index < urinaryTreatmentDetails; index++) {
                    
                        let indexX = 30;
                        let maxW   = 154;
                        
                        if(index == 0){
                            indexX = calcWidth("Tratamiento de incontinencia urinaria: ")+33;
                            maxW = 150-calcWidth("Tratamiento de incontinencia urinaria:");
                        }   

                        doc.rect(indexX, (currentY+(8*index))-5, maxW, 7, 'FD'); 
                    }

                    doc.setFontSize(12);
                    doc.setFont("helvetica", "normal"); 
                    doc.setTextColor(0, 0, 0); 
                    doc.text(`Tratamiento de incontinencia urinaria:`,30, currentY);
                    doc.setFont(undefined, "italic"); 
                    doc.setFontSize(10);
                    doc.setTextColor(50, 50, 50);   
                    
                    drawJustifiedText(doc,`${(" ").repeat(75)} ${medical_histories.urinary_incontinence_treatement_detail}`,32, currentY, 150, 8);
                    
                    currentY+= (urinaryTreatmentDetails*8);
                }
            }
            
            doc.setDrawColor(247,235,240); 
            doc.setFillColor(247,235,240); 
            doc.rect(calcWidth("¿Padece alguna enfermedad familiar? ")+31, currentY-5, 11, 7, 'FD');  
            doc.setFontSize(12);
            doc.setFont("helvetica", "normal"); 
            doc.setTextColor(0, 0, 0); 
            doc.text(`¿Padece alguna enfermedad familiar? `,30, currentY);  
            doc.setFont(undefined, "italic"); 
            doc.setFontSize(10);
            doc.setTextColor(50, 50, 50);   
            doc.text(`${medical_histories.drug_usage ? "Si" : "No"}`,calcWidth(`¿Padece alguna enfermedad familiar? `)+34, currentY); 

            currentY+= 8;
             
            if(medical_histories.has_family_diseases){ 

                if(currentY+(familyDiseasesDetails*8) >= 266){
                    doc.addPage();
                    doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                    currentY = 55;
                }

                doc.setDrawColor(247,235,240); 
                doc.setFillColor(247,235,240);

                for (let index = 0; index < familyDiseasesDetails; index++) {
                    
                    let indexX = 30;
                    let maxW   = 154;
                    
                    if(index == 0){
                        indexX = calcWidth("Detalle de enfermedades familiares: ")+30;
                        maxW = 153-calcWidth("Detalle de enfermedades familiares:");
                    }   

                    doc.rect(indexX, (currentY+(8*index))-5, maxW, 7, 'FD'); 
                }

                doc.setFontSize(12);
                doc.setFont("helvetica", "normal"); 
                doc.setTextColor(0, 0, 0); 
                doc.text(`Detalle de enfermedades familiares:`,30, currentY);
                doc.setFont(undefined, "italic"); 
                doc.setFontSize(10);
                doc.setTextColor(50, 50, 50);   
                
                drawJustifiedText(doc,`${(" ").repeat(70)} ${medical_histories.family_diseases_details}`,32, currentY, 150, 8);
                
                currentY+= (familyDiseasesDetails*8);
            }

            doc.setDrawColor(247,235,240); 
            doc.setFillColor(247,235,240); 
            doc.rect(calcWidth("¿Ha realizado una prueba de VIH? ")+31, currentY-5, 11, 7, 'FD');  
            doc.setFontSize(12);
            doc.setFont("helvetica", "normal"); 
            doc.setTextColor(0, 0, 0); 
            doc.text(`¿Ha realizado una prueba de VIH? `,30, currentY);  
            doc.setFont(undefined, "italic"); 
            doc.setFontSize(10);
            doc.setTextColor(50, 50, 50);   
            doc.text(`${medical_histories.has_vih_test ? "Si" : "No"}`,calcWidth(`¿Ha realizado una prueba de VIH? `)+34, currentY); 

            currentY+= 8;

            if(currentY >= 266){
                doc.addPage();
                doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                currentY = 55;
            }

            if(medical_histories.has_vih_test){
                if(currentY+8 >= 266){
                    doc.addPage();
                    doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                    currentY = 55;
                }

                doc.setDrawColor(247,235,240); 
                doc.setFillColor(247,235,240); 
                doc.rect(calcWidth("Fecha de ultima prueba:  ")+26, currentY-5, 24, 7, 'FD');  
                doc.rect(calcWidth("Fecha de ultima prueba:  ")+90, currentY-5, 43, 7, 'FD');  
                doc.setFontSize(12);
                doc.setFont("helvetica", "normal"); 
                doc.setTextColor(0, 0, 0); 
                doc.text(`Fecha de ultima prueba:`,30, currentY);  
                doc.text(`Resultado de VIH:`,calcWidth("Fecha de ultima prueba:  ")+46, currentY);  
                doc.setFont(undefined, "italic"); 
                doc.setFontSize(10);
                doc.setTextColor(50, 50, 50);   
                doc.text(`${reformatDate(medical_histories.vih_last_test_date)}`,calcWidth(`Fecha de ultima prueba:`)+30, currentY);
                doc.text(`${medical_histories.vih_result}`,calcWidth(`Fecha de ultima prueba:`)+93, currentY);

                currentY+= 8;
            }

            if(currentY >= 266){
                doc.addPage();
                doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                currentY = 55;
            }

            doc.setDrawColor(247,235,240); 
            doc.setFillColor(247,235,240); 
            doc.rect(calcWidth("¿Ha tenido relaciones sexuales? ")+31, currentY-5, 11, 7, 'FD');  
            doc.setFontSize(12);
            doc.setFont("helvetica", "normal"); 
            doc.setTextColor(0, 0, 0); 
            doc.text(`¿Ha tenido relaciones sexuales? `,30, currentY);  
            doc.setFont(undefined, "italic"); 
            doc.setFontSize(10);
            doc.setTextColor(50, 50, 50);   
            doc.text(`${medical_histories.has_had_sex ? "Si" : "No"}`,calcWidth(`¿Ha tenido relaciones sexuales? `)+34, currentY); 

            currentY+= 8;

            if(medical_histories.has_had_sex){

                currentY-= 8;
                
                doc.setDrawColor(247,235,240); 
                doc.setFillColor(247,235,240); 
                doc.rect(calcWidth("¿Ha tenido relaciones sexuales? ")+75, currentY-5, 46, 7, 'FD');  
                doc.setFontSize(12);
                doc.setFont("helvetica", "normal"); 
                doc.setTextColor(0, 0, 0); 
                doc.text(`¿Usa condon? `,calcWidth("¿Ha tenido relaciones sexuales? ")+35, currentY);  
                doc.setFont(undefined, "italic"); 
                doc.setFontSize(10);
                doc.setTextColor(50, 50, 50);   
                doc.text(`${medical_histories.condom_usage ? "Si" : "No"}`,calcWidth("¿Ha tenido relaciones sexuales? ")+85, currentY); 

                currentY+= 8;

                if(currentY >= 266){
                    doc.addPage();
                    doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                    currentY = 55;
                }

                doc.setDrawColor(247,235,240); 
                doc.setFillColor(247,235,240); 
                doc.rect(calcWidth("Edad de inicio de actividad sexual: ")+30, currentY-5, 11, 7, 'FD');  
                doc.rect(calcWidth("Edad de inicio de actividad sexual: ")+103, currentY-5, 15, 7, 'FD');  
                doc.setFontSize(12);
                doc.setFont("helvetica", "normal"); 
                doc.setTextColor(0, 0, 0); 
                doc.text(`Edad de inicio de actividad sexual: `,30, currentY);  
                doc.text(`Numero de parejas sexuales: `,calcWidth("Edad de inicio de actividad sexual: ")+35, currentY);  
                doc.setFont(undefined, "italic"); 
                doc.setFontSize(10);
                doc.setTextColor(50, 50, 50);   
                doc.text(`${medical_histories.sexual_start_age}`,calcWidth("Edad de inicio de actividad sexual: ")+32, currentY);
                doc.text(`${medical_histories.sexual_partners_count}`,calcWidth("Edad de inicio de actividad sexual: ")+106, currentY); 


                currentY+= 8;

                if(currentY >= 266){
                    doc.addPage();
                    doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                    currentY = 55;
                }

                doc.setDrawColor(247,235,240); 
                doc.setFillColor(247,235,240); 
                doc.rect(calcWidth("Fecha de ultima relación sexual con quien no es su pareja  ")+37, currentY-5, 43.5, 7, 'FD');   
                doc.setFontSize(12);
                doc.setFont("helvetica", "normal"); 
                doc.setTextColor(0, 0, 0); 
                doc.text(`Fecha de ultima relación sexual con quien no es su pareja:`,30, currentY);   
                doc.setFont(undefined, "italic"); 
                doc.setFontSize(10);
                doc.setTextColor(50, 50, 50);   
                doc.text(`${reformatDate(medical_histories.last_sex_with_other)}`,calcWidth(`Fecha de ultima relación sexual con quien no es su pareja   `)+40, currentY); 

                currentY+= 8;

                if(currentY >= 266){
                    doc.addPage();
                    doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                    currentY = 55;
                }

                doc.setDrawColor(247,235,240); 
                doc.setFillColor(247,235,240); 
                doc.rect(calcWidth("¿Tiene pareja estable? ")+26, currentY-5, 7, 7, 'FD');  
                doc.setFontSize(12);
                doc.setFont("helvetica", "normal"); 
                doc.setTextColor(0, 0, 0); 
                doc.text(`¿Tiene pareja estable? `,30, currentY);  
                doc.setFont(undefined, "italic"); 
                doc.setFontSize(10);
                doc.setTextColor(50, 50, 50);   
                doc.text(`${medical_histories.has_stable_partner ? "Si" : "No"}`,calcWidth(`¿Tiene pareja estable? `)+27.5, currentY); 

                if(medical_histories.has_stable_partner){
                    doc.setDrawColor(247,235,240); 
                    doc.setFillColor(247,235,240); 
                    doc.rect(calcWidth("¿Tienes pareja estable? ")+115, currentY-5, 19.5, 7, 'FD');  
                    doc.setFontSize(12);
                    doc.setFont("helvetica", "normal"); 
                    doc.setTextColor(0, 0, 0); 
                    doc.text(`Fecha de ultima relación sexual con pareja: `,calcWidth("¿Tienes pareja estable? ")+25, currentY);  
                    doc.setFont(undefined, "italic"); 
                    doc.setFontSize(10);
                    doc.setTextColor(50, 50, 50);   
                    doc.text(reformatDate(medical_histories.last_sex_with_partner),calcWidth(`¿Tienes pareja estable? `)+116, currentY);
                }

                currentY+= 8;

                if(currentY >= 266){
                    doc.addPage();
                    doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                    currentY = 55;
                }

                doc.setDrawColor(247,235,240); 
                doc.setFillColor(247,235,240); 
                doc.rect(calcWidth("¿Siente dolor al realizar actividad sexual? ")+32, currentY-5, 7, 7, 'FD');  
                doc.setFontSize(12);
                doc.setFont("helvetica", "normal"); 
                doc.setTextColor(0, 0, 0); 
                doc.text(`¿Siente dolor al realizar actividad sexual? `,30, currentY);  
                doc.setFont(undefined, "italic"); 
                doc.setFontSize(10);
                doc.setTextColor(50, 50, 50);   
                doc.text(`${medical_histories.sexual_pain ? "Si" : "No"}`,calcWidth(`¿Siente dolor al realizar actividad sexual? `)+34, currentY); 

                currentY+= 8;

                if(user.gender == "female"){
                    if(currentY >= 266){
                        doc.addPage();
                        doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                        currentY = 55;
                    }

                    doc.setDrawColor(247,235,240); 
                    doc.setFillColor(247,235,240); 
                    doc.rect(calcWidth("¿Siente sensibilidad de placer en el coito?")+32, currentY-5, 7, 7, 'FD');  
                    doc.setFontSize(12);
                    doc.setFont("helvetica", "normal"); 
                    doc.setTextColor(0, 0, 0); 
                    doc.text(`¿Siente sensibilidad de placer en el coito?`,30, currentY);  
                    doc.setFont(undefined, "italic"); 
                    doc.setFontSize(10);
                    doc.setTextColor(50, 50, 50);   
                    doc.text(`${medical_histories.sexual_sensibility ? "Si" : "No"}`,calcWidth(`¿Siente sensibilidad de placer en el coito?`)+34, currentY); 

                    currentY+= 8;

                    if(currentY >= 266){
                        doc.addPage();
                        doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                        currentY = 55;
                    }

                    doc.setDrawColor(247,235,240); 
                    doc.setFillColor(247,235,240); 
                    doc.rect(calcWidth("¿Siente resequedad durante el coito?")+32, currentY-5, 7, 7, 'FD');  
                    doc.setFontSize(12);
                    doc.setFont("helvetica", "normal"); 
                    doc.setTextColor(0, 0, 0); 
                    doc.text(`¿Siente resequedad durante el coito?`,30, currentY);  
                    doc.setFont(undefined, "italic"); 
                    doc.setFontSize(10);
                    doc.setTextColor(50, 50, 50);   
                    doc.text(`${medical_histories.sexual_dryness ? "Si" : "No"}`,calcWidth(`¿Siente resequedad durante el coito?`)+34, currentY); 

                    currentY+= 8;
                }

                if(currentY >= 266){
                    doc.addPage();
                    doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                    currentY = 55;
                }

                doc.setDrawColor(247,235,240); 
                doc.setFillColor(247,235,240); 
                doc.rect(calcWidth("¿Siente molestia durante el coito? ")+32, currentY-5, 7, 7, 'FD');  
                doc.setFontSize(12);
                doc.setFont("helvetica", "normal"); 
                doc.setTextColor(0, 0, 0); 
                doc.text(`¿Siente molestia durante el coito? `,30, currentY);  
                doc.setFont(undefined, "italic"); 
                doc.setFontSize(10);
                doc.setTextColor(50, 50, 50);   
                doc.text(`${medical_histories.sexual_discomfort ? "Si" : "No"}`,calcWidth(`¿Siente molestia durante el coito? `)+34, currentY); 

                if(medical_histories.sexual_discomfort || medical_histories.sexual_pain){
                    currentY+= 8;

                    if(currentY >= 266){
                        doc.addPage();
                        doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                        currentY = 55;
                    }

                    doc.setDrawColor(247,235,240); 
                    doc.setFillColor(247,235,240); 
                    doc.rect(calcWidth("Frecuencia del dolor ")+26, currentY-5, 160-calcWidth("Frecuencia del dolor   "), 7, 'FD');  
                    doc.setFontSize(12);
                    doc.setFont("helvetica", "normal"); 
                    doc.setTextColor(0, 0, 0); 
                    doc.text(`Frecuencia del dolor: `,30, currentY);  
                    doc.setFont(undefined, "italic"); 
                    doc.setFontSize(10);
                    doc.setTextColor(50, 50, 50);   
                    doc.text(`${medical_histories.sexual_pain_frequency}`,calcWidth(`Frecuencia del dolor `)+28, currentY); 
                }

                currentY+= 8;
            }
            
            if(user.gender == "female"){
                if(medical_histories.metrorrhagia){
                    if(currentY >= 266){
                        doc.addPage();
                        doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                        currentY = 55;
                    }  
 

                    doc.setDrawColor(247,235,240); 
                    doc.setFillColor(247,235,240);

                    for (let index = 0; index < metrorrhagiaDetails; index++) {
                        
                        let indexX = 30;
                        let maxW   = 154;
                        
                        if(index == 0){
                            indexX = calcWidth("Metrorragia: ")+22;
                            maxW = 161-calcWidth("Metrorragia:");
                        }   

                        doc.rect(indexX, (currentY+(8*index))-5, maxW, 7, 'FD'); 
                    }

                    doc.setFontSize(12);
                    doc.setFont("helvetica", "normal"); 
                    doc.setTextColor(0, 0, 0); 
                    doc.text(`Metrorragia:`,30, currentY);
                    doc.setFont(undefined, "italic"); 
                    doc.setFontSize(10);
                    doc.setTextColor(50, 50, 50);   
                    
                    drawJustifiedText(doc,`${(" ").repeat(25)} ${medical_histories.metrorrhagia_detail}`,32, currentY, 150, 8);
                    
                    currentY+= (metrorrhagiaDetails*8);
                }

                if(medical_histories.leukorrhea){
                    if(currentY >= 266){
                        doc.addPage();
                        doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                        currentY = 55;
                    }  
 

                    doc.setDrawColor(247,235,240); 
                    doc.setFillColor(247,235,240);

                    for (let index = 0; index < leukorrheaDetails; index++) {
                        
                        let indexX = 30;
                        let maxW   = 154;
                        
                        if(index == 0){
                            indexX = calcWidth("Leucorrea: ")+21;
                            maxW = 162-calcWidth("Leucorrea:");
                        }   

                        doc.rect(indexX, (currentY+(8*index))-5, maxW, 7, 'FD'); 
                    }

                    doc.setFontSize(12);
                    doc.setFont("helvetica", "normal"); 
                    doc.setTextColor(0, 0, 0); 
                    doc.text(`Leucorrea:`,30, currentY);
                    doc.setFont(undefined, "italic"); 
                    doc.setFontSize(10);
                    doc.setTextColor(50, 50, 50);   
                    
                    drawJustifiedText(doc,`${(" ").repeat(20)} ${medical_histories.leukorrhea_detail}`,32, currentY, 150, 8);
                    
                    currentY+= (leukorrheaDetails*8);
                }

                if(medical_histories.pruritus){
                    if(currentY >= 266){
                        doc.addPage();
                        doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                        currentY = 55;
                    }  
 

                    doc.setDrawColor(247,235,240); 
                    doc.setFillColor(247,235,240);

                    for (let index = 0; index < pruritusDetails; index++) {
                        
                        let indexX = 30;
                        let maxW   = 154;
                        
                        if(index == 0){
                            indexX = calcWidth("Prutitos: ")+21;
                            maxW = 162-calcWidth("Pruritos:");
                        }   

                        doc.rect(indexX, (currentY+(8*index))-5, maxW, 7, 'FD'); 
                    }

                    doc.setFontSize(12);
                    doc.setFont("helvetica", "normal"); 
                    doc.setTextColor(0, 0, 0); 
                    doc.text(`Pruritos:`,30, currentY);
                    doc.setFont(undefined, "italic"); 
                    doc.setFontSize(10);
                    doc.setTextColor(50, 50, 50);   
                    
                    drawJustifiedText(doc,`${(" ").repeat(18)} ${medical_histories.pruritus_detail}`,32, currentY, 150, 8);
                    
                    currentY+= (pruritusDetails*8);
                }

                if(currentY >= 266){
                    doc.addPage();
                    doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                    currentY = 55;
                }

                doc.setDrawColor(247,235,240); 
                doc.setFillColor(247,235,240);

                for (let index = 0; index < menstrualRhythmDetails; index++) {
                    
                    let indexX = 30;
                    let maxW   = 154;
                    
                    if(index == 0){
                        indexX = calcWidth("Ritmo mestrual: ")+24;
                        maxW = 160-calcWidth("Ritmo mestrual: ");
                    }   

                    doc.rect(indexX, (currentY+(8*index))-5, maxW, 7, 'FD'); 
                }

                doc.setFontSize(12);
                doc.setFont("helvetica", "normal"); 
                doc.setTextColor(0, 0, 0); 
                doc.text(`Ritmo mestrual:`,30, currentY);
                doc.setFont(undefined, "italic"); 
                doc.setFontSize(10);
                doc.setTextColor(50, 50, 50);   
                
                drawJustifiedText(doc,`${(" ").repeat(32)} ${medical_histories.menstrual_rhythm}`,32, currentY, 150, 8);
                
                currentY+= (menstrualRhythmDetails*8);

                if(currentY >= 266){
                    doc.addPage();
                    doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                    currentY = 55;
                }

                doc.setDrawColor(247,235,240); 
                doc.setFillColor(247,235,240);

                for (let index = 0; index < menarcheDetails; index++) {
                    
                    let indexX = 30;
                    let maxW   = 154;
                    
                    if(index == 0){
                        indexX = calcWidth("Menarquia: ")+22;
                        maxW = 162-calcWidth("Menarquia: ");
                    }   

                    doc.rect(indexX, (currentY+(8*index))-5, maxW, 7, 'FD'); 
                }

                doc.setFontSize(12);
                doc.setFont("helvetica", "normal"); 
                doc.setTextColor(0, 0, 0); 
                doc.text(`Menarquia:`,30, currentY);
                doc.setFont(undefined, "italic"); 
                doc.setFontSize(10);
                doc.setTextColor(50, 50, 50);   
                
                drawJustifiedText(doc,`${(" ").repeat(23)} ${medical_histories.menarche}`,32, currentY, 150, 8);
                
                currentY+= (menarcheDetails*8);

                if(currentY >= 266){
                    doc.addPage();
                    doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                    currentY = 55;
                }

                doc.setDrawColor(247,235,240); 
                doc.setFillColor(247,235,240);

                for (let index = 0; index < gynecologicalHistoryDetails; index++) {
                    
                    let indexX = 30;
                    let maxW   = 154;
                    
                    if(index == 0){
                        indexX = calcWidth("Detalles ginecologicos: ")+26;
                        maxW = 158-calcWidth("Detalles ginecologicos: ");
                    }   

                    doc.rect(indexX, (currentY+(8*index))-5, maxW, 7, 'FD'); 
                }

                doc.setFontSize(12);
                doc.setFont("helvetica", "normal"); 
                doc.setTextColor(0, 0, 0); 
                doc.text(`Detalles ginecologicos:`,30, currentY);
                doc.setFont(undefined, "italic"); 
                doc.setFontSize(10);
                doc.setTextColor(50, 50, 50);   
                
                drawJustifiedText(doc,`${(" ").repeat(44)} ${medical_histories.gynecological_history}`,32, currentY, 150, 8);
                
                currentY+= (gynecologicalHistoryDetails*8);

                if(currentY >= 266){
                    doc.addPage();
                    doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                    currentY = 55;
                }

                doc.setDrawColor(247,235,240); 
                doc.setFillColor(247,235,240); 
                doc.rect(calcWidth("Ultima mestruación ")+26, currentY-5, 24, 7, 'FD');  
                doc.setFontSize(12);
                doc.setFont("helvetica", "normal"); 
                doc.setTextColor(0, 0, 0); 
                doc.text(`Ultima mestruación: `,30, currentY);  
                doc.setFont(undefined, "italic"); 
                doc.setFontSize(10);
                doc.setTextColor(50, 50, 50);   
                doc.text(`${medical_histories.last_menstrual ? reformatDate(medical_histories.last_menstrual) : "Nunca"}`,calcWidth(`Ultima mestruación `)+28, currentY); 

                currentY+= 8;

                if(currentY >= 266){
                    doc.addPage();
                    doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                    currentY = 55;
                }

                doc.setDrawColor(247,235,240); 
                doc.setFillColor(247,235,240); 
                doc.rect(calcWidth("Gestaciones ")+24, currentY-5, 10, 7, 'FD');  
                doc.rect(calcWidth("Nacimientos ")+68, currentY-5, 10, 7, 'FD');  
                doc.rect(calcWidth("Abortos ")+110, currentY-5, 10, 7, 'FD');   
                doc.rect(calcWidth("Cesareas ")+146, currentY-5, 10, 7, 'FD');  
                doc.setFontSize(12);
                doc.setFont("helvetica", "normal"); 
                doc.setTextColor(0, 0, 0); 
                doc.text(`Gestaciones: `,30, currentY);   
                doc.text(`Nacimientos: `,calcWidth("Nacimientos ")+35, currentY);  
                doc.text(`Abortos: `,calcWidth("Nacimientos ")+80, currentY);   
                doc.text(`Cesareas: `,calcWidth("Nacimientos ")+114, currentY);  
                doc.setFont(undefined, "italic"); 
                doc.setFontSize(10);
                doc.setTextColor(50, 50, 50);   
                doc.text(`${medical_histories.gestation}`,calcWidth(`Gestaciones `)+26, currentY); 
                doc.text(`${medical_histories.birth}`,calcWidth(`Gestaciones `)+70, currentY); 
                doc.text(`${medical_histories.abortion}`,calcWidth(`Gestaciones `)+105, currentY);  
                doc.text(`${medical_histories.cesarean}`,calcWidth(`Gestaciones `)+144, currentY); 

                currentY+= 8;
            }

            currentY+= 8;

            if(currentY >= 260){
                doc.addPage();
                doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                currentY = 55;
            }

            doc.setFontSize(12);
            doc.setFont("helvetica", "normal"); 
            doc.setTextColor(0, 0, 0); 
            doc.text(`MÉDICO QUIEN REALIZA LA HISTORIA CLÍNICA: `,30, currentY);

            doc.setDrawColor(247,235,240); 
            doc.setFillColor(247,235,240); 
            doc.rect(calcWidth("MÉDICO QUIEN REALIZA LA HISTORIA CLÍNICA:")+20, currentY-5, 165-calcWidth("MÉDICO QUIEN REALIZA LA HISTORIA CLÍNICA: "), 7, 'FD'); 
            doc.setFont(undefined, "italic"); 
            doc.setFontSize(10);
            doc.text(`${doctor.user.first_name} ${doctor.user.last_name}`,calcWidth("MÉDICO QUIEN REALIZA LA HISTORIA CLÍNICA: ")+37, currentY);

            currentY+= 12;

            if(currentY >= 260){
                doc.addPage();
                doc.addImage(fondoBase64, 'PNG', 1, 1, doc.internal.pageSize.getWidth()-1, doc.internal.pageSize.getHeight()-1);

                currentY = 55;
            }

            doc.setFontSize(12);
            doc.setFont("helvetica", "normal"); 
            doc.setTextColor(0, 0, 0); 
            doc.text(`NOMBRE Y FIRMA DE LA PACIENTE: `,30, currentY);

            doc.setDrawColor(247,235,240); 
            doc.setFillColor(247,235,240); 
            doc.rect(calcWidth("NOMBRE Y FIRMA DE LA PACIENTE:")+20, currentY-5, 165-calcWidth("NOMBRE Y FIRMA DE LA PACIENTE: "), 7, 'FD'); 
            doc.setFont(undefined, "italic"); 
            doc.setFontSize(10);
            doc.text(`${user.first_name} ${user.last_name}`,calcWidth("NOMBRE Y FIRMA DE LA PACIENTE: ")+32, currentY);

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

            doc.save("Historia clinica.pdf");
            /*const pdfBlob = doc.output('blob');
                const url = URL.createObjectURL(pdfBlob);

                const container = $('#pdf-preview'); 
                container.classList.remove("h-0");
                container.classList.add("h-[500px]");
                container.innerHTML = `<div class="bg-white h-[41px] p-2">
                                            <button type="button" onclick="closePreview()" class="border-red-700 text-white bg-red-700 border-2 ml-4 float-right p-1 rounded-lg" title="Cerrar PDF">
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="14"  height="14"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                                            </button>
                                        </div>
                                        <iframe src="${url}" width="100%" height="450px" type="application/pdf" ></iframe>`;*/
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

            const lines = text.split('\n')
                              .flatMap(line => doc.splitTextToSize(line, maxWidth))
                              .filter(line => line.trim() !== "");  

         
            const textHeight = (lines.length / (doc.getLineHeightFactor())) * (doc.getFontSize()*0.65);
         
            return textHeight;
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
        function overflowPage(currentY,heightPage,callback){
            if(currentY >= heightPage){
                callback();
                return 60;
            }

            return currentY;
        }
    </script>
    <script src="{{ asset('/resources/libs/flowbite/datepicker.min.js') }}"></script> 
    <script src="{{ asset('/resources/js/pages/patient_detail_files.js') }}"></script> 
    <script src="{{ asset('/resources/js/pages/patient_detail_diagnosis.js') }}"></script> 
    <script src="{{ asset('/resources/js/pages/patient_detail_items.js') }}"></script> 
    <script src="{{ asset('/resources/js/pages/patient_detail.js') }}"></script> 
@stop