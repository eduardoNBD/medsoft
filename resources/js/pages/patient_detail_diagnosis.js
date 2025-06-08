function getPaginationDiagnosisEncounters(currentPageDiagnosisEncounters){  

    fetch(urlEncounters+currentPageDiagnosisEncounters+"&type=diagnosis", { 
        headers: { 
            "X-CSRF-Token": $('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json', 
        },   
    })
    .then(res => error419(res))
    .then((json) => { 
        if(json.status){ 
            totalPagesEncounters = Math.ceil(json.items.total/json.items.per_page);
            currentPageDiagnosisEncounters = json.items.current_page;

            $("#paginationDiagnosisEncounters").innerHTML = "";

            if(totalPagesEncounters > 1){
                setPagesDiagnosisEncounters(currentPageDiagnosisEncounters, totalPagesEncounters);
            }

            setRowsDiagnosticsEncounters(json.items.data);
        }else{
            
        }
    })
    .catch((err) => console.error("error:", err)); 
}

function setRowsDiagnosticsEncounters(data){ 
    $("#encountersDiagnosisTable tbody").innerHTML = "";

    if(data.length){
        data.forEach(encounter => {  
            let rowHTML = ` 
                <td class="px-4 py-3 table_text">
                    <span class="text-[14px]">${encounter.diagnosis}</span>
                </td>  
                <td class="px-4 py-3 table_text">
                    <span class="text-[14px]">${reformatDate(encounter.date)}</span> 
                </td>`;
            
            let tr       = document.createElement('tr');
            tr.classList = "border-b border-gray-200"
            tr.innerHTML = rowHTML;

            $("#encountersDiagnosisTable tbody").append(tr); 
        });      
    }else{
        let rowHTML = `<tr><td colspan="5"><h1 class="text-center text-3xl m-20 table_text">${withoutDiagnostics}</h1></td></tr>`;
        let tr       = document.createElement('tr');
        tr.classList = "border-b border-gray-200"
        tr.innerHTML = rowHTML;

        $("#encountersDiagnosisTable tbody").append(tr); 
    }       
}

function setPagesDiagnosisEncounters(currentPageDiagnosisEncounters, totalPagesEncounters) { 
    const pagesToShow = 2;  
    const maxPagesToShow = pagesToShow * 2 + 1; 

    let startPage = Math.max(1, currentPageDiagnosisEncounters - pagesToShow);
    let endPage = Math.min(totalPagesEncounters, currentPageDiagnosisEncounters + pagesToShow);

    if (currentPageDiagnosisEncounters - pagesToShow <= 1) {
        endPage = Math.min(startPage + maxPagesToShow - 1, totalPagesEncounters);
    }

    if (currentPageDiagnosisEncounters + pagesToShow >= totalPagesEncounters) {
        startPage = Math.max(endPage - maxPagesToShow + 1, 1);
    }

    startPage = Math.max(1, startPage);
    endPage = Math.min(totalPagesEncounters, endPage);

    let paginationHTML = ` 
        <li class="page-item">
            <button ${currentPageDiagnosisEncounters === 1 ? 'disabled' : ''} 
                class="flex items-center justify-center text-sm py-2 px-3 pagination_text pagination_background border border-gray-300" 
                onclick="changePageDiagnosisEncounter(${currentPageDiagnosisEncounters - 1})">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M14 6l-6 6l6 6v-12" />
                </svg>
            </button>
        </li>`;

    for (let page = startPage; page <= endPage; page++) {
        paginationHTML += `
            <li class="page-item${currentPageDiagnosisEncounters === page ? ' active' : ''}">
                <button 
                    class="flex items-center justify-center text-sm py-[7px] px-3 border border-gray-300 ${
                        currentPageDiagnosisEncounters === page 
                            ? 'pagination_background_active text-white' 
                            : 'pagination_text pagination_background'
                    }" 
                    onclick="changePageDiagnosisEncounter(${page})">
                    ${page}
                </button>
            </li>`;
    }

    paginationHTML += `
            <li class="page-item">
                <button ${currentPageDiagnosisEncounters === totalPagesEncounters ? 'disabled' : ''} 
                    class="flex items-center justify-center text-sm py-2 px-3 pagination_text pagination_background border border-gray-300" 
                    onclick="changePageDiagnosisEncounter(${currentPageDiagnosisEncounters + 1})">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M10 18l6 -6l-6 -6v12" />
                    </svg>
                </button>
            </li>`;
 
    const ul = document.createElement('ul');
    ul.innerHTML = paginationHTML;
    ul.classList = "inline-flex ml-auto items-stretch -space-x-px";

    $("#paginationDiagnosisEncounters").append(ul); 
}

function changePageDiagnosisEncounter(page)
{
    currentPageDiagnosisEncounters = page;
    getPaginationDiagnosisEncounters(currentPageDiagnosisEncounters); 
}

//
//Treatment
//
function getPaginationTreatmentEncounters(currentPageTreatmentEncounters){  

    fetch(urlEncounters+currentPageTreatmentEncounters+"&type=treatment", { 
        headers: { 
            "X-CSRF-Token": $('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json', 
        },   
    })
    .then(res => error419(res))
    .then((json) => { 
        if(json.status){ 
            totalPagesEncounters = Math.ceil(json.items.total/json.items.per_page);
            currentPageTreatmentEncounters = json.items.current_page;

            $("#paginationTreatmentEncounters").innerHTML = "";

            if(totalPagesEncounters > 1){
                setPagesTreatmentEncounters(currentPageTreatmentEncounters, totalPagesEncounters);
            }

            setRowsTreatmentsEncounters(json.items.data);
        }else{
            
        }
    })
    .catch((err) => console.error("error:", err)); 
}

function setRowsTreatmentsEncounters(data){ 
    $("#encountersTreatmentTable tbody").innerHTML = "";

    if(data.length){
        data.forEach(encounter => {  
            let rowHTML = ` 
                <td class="px-4 py-3 table_text">
                    <span class="text-[14px]">${encounter.treatment}</span>
                </td>  
                <td class="px-4 py-3 table_text">
                    <span class="text-[14px]">${reformatDate(encounter.date)}</span> 
                </td>`;
            
            let tr       = document.createElement('tr');
            tr.classList = "border-b border-gray-200"
            tr.innerHTML = rowHTML;

            $("#encountersTreatmentTable tbody").append(tr); 
        });      
    }else{
        let rowHTML = `<tr><td colspan="5"><h1 class="text-center text-3xl m-20 table_text">${withoutTreatments}</h1></td></tr>`;
        let tr       = document.createElement('tr');
        tr.classList = "border-b border-gray-200"
        tr.innerHTML = rowHTML;

        $("#encountersTreatmentTable tbody").append(tr); 
    }       
}

function setPagesTreatmentEncounters(currentPageTreatmentEncounters, totalPagesEncounters) { 
    const pagesToShow = 2;  
    const maxPagesToShow = pagesToShow * 2 + 1; 

    let startPage = Math.max(1, currentPageTreatmentEncounters - pagesToShow);
    let endPage = Math.min(totalPagesEncounters, currentPageTreatmentEncounters + pagesToShow);

    if (currentPageTreatmentEncounters - pagesToShow <= 1) {
        endPage = Math.min(startPage + maxPagesToShow - 1, totalPagesEncounters);
    }

    if (currentPageTreatmentEncounters + pagesToShow >= totalPagesEncounters) {
        startPage = Math.max(endPage - maxPagesToShow + 1, 1);
    }

    startPage = Math.max(1, startPage);
    endPage = Math.min(totalPagesEncounters, endPage);

    let paginationHTML = ` 
        <li class="page-item">
            <button ${currentPageTreatmentEncounters === 1 ? 'disabled' : ''} 
                class="flex items-center justify-center text-sm py-2 px-3 pagination_text pagination_background border border-gray-300" 
                onclick="changePageTreatmentEncounter(${currentPageTreatmentEncounters - 1})">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M14 6l-6 6l6 6v-12" />
                </svg>
            </button>
        </li>`;

    for (let page = startPage; page <= endPage; page++) {
        paginationHTML += `
            <li class="page-item${currentPageTreatmentEncounters === page ? ' active' : ''}">
                <button 
                    class="flex items-center justify-center text-sm py-[7px] px-3 border border-gray-300 ${
                        currentPageTreatmentEncounters === page 
                            ? 'pagination_background_active text-white' 
                            : 'pagination_text pagination_background'
                    }" 
                    onclick="changePageTreatmentEncounter(${page})">
                    ${page}
                </button>
            </li>`;
    }

    paginationHTML += `
            <li class="page-item">
                <button ${currentPageTreatmentEncounters === totalPagesEncounters ? 'disabled' : ''} 
                    class="flex items-center justify-center text-sm py-2 px-3 pagination_text pagination_background border border-gray-300" 
                    onclick="changePageTreatmentEncounter(${currentPageTreatmentEncounters + 1})">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M10 18l6 -6l-6 -6v12" />
                    </svg>
                </button>
            </li>`;
 
    const ul = document.createElement('ul');
    ul.innerHTML = paginationHTML;
    ul.classList = "inline-flex ml-auto items-stretch -space-x-px";

    $("#paginationTreatmentEncounters").append(ul); 
}

function changePageTreatmentEncounter(page)
{
    currentPageTreatmentEncounters = page;
    getPaginationTreatmentEncounters(currentPageTreatmentEncounters); 
}


//
//NOTES
//
function getPaginationNotesEncounters(currentPageNotesEncounters){  

    fetch(urlEncounters+currentPageNotesEncounters+"&type=notes", { 
        headers: { 
            "X-CSRF-Token": $('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json', 
        },   
    })
    .then(res => error419(res))
    .then((json) => { 
        if(json.status){ 
            totalPagesEncounters = Math.ceil(json.items.total/json.items.per_page);
            currentPageNotesEncounters = json.items.current_page;

            $("#paginationNotesEncounters").innerHTML = "";

            if(totalPagesEncounters > 1){
                setPagesNotesEncounters(currentPageNotesEncounters, totalPagesEncounters);
            }

            setRowsNotesEncounters(json.items.data);
        }else{
            
        }
    })
    .catch((err) => console.error("error:", err)); 
}

function setRowsNotesEncounters(data){ 
    $("#encountersNotesTable tbody").innerHTML = "";

    if(data.length){
        data.forEach(encounter => {  
            let rowHTML = ` 
                <td class="px-4 py-3 table_text">
                    <span class="text-[14px]">${encounter.notes}</span>
                </td>  
                <td class="px-4 py-3 table_text">
                    <span class="text-[14px]">${reformatDate(encounter.date)}</span> 
                </td>`;
            
            let tr       = document.createElement('tr');
            tr.classList = "border-b border-gray-200"
            tr.innerHTML = rowHTML;

            $("#encountersNotesTable tbody").append(tr); 
        });      
    }else{
        let rowHTML = `<tr><td colspan="5"><h1 class="text-center text-3xl m-20 table_text">${withoutNotes}</h1></td></tr>`;
        let tr       = document.createElement('tr');
        tr.classList = "border-b border-gray-200"
        tr.innerHTML = rowHTML;

        $("#encountersNotesTable tbody").append(tr); 
    }       
}

function setPagesNotesEncounters(currentPageNotesEncounters, totalPagesEncounters) { 
    const pagesToShow = 2;  
    const maxPagesToShow = pagesToShow * 2 + 1; 

    let startPage = Math.max(1, currentPageNotesEncounters - pagesToShow);
    let endPage = Math.min(totalPagesEncounters, currentPageNotesEncounters + pagesToShow);

    if (currentPageNotesEncounters - pagesToShow <= 1) {
        endPage = Math.min(startPage + maxPagesToShow - 1, totalPagesEncounters);
    }

    if (currentPageNotesEncounters + pagesToShow >= totalPagesEncounters) {
        startPage = Math.max(endPage - maxPagesToShow + 1, 1);
    }

    startPage = Math.max(1, startPage);
    endPage = Math.min(totalPagesEncounters, endPage); 

    let paginationHTML = ` 
        <li class="page-item">
            <button ${currentPageNotesEncounters === 1 ? 'disabled' : ''} 
                class="flex items-center justify-center text-sm py-2 px-3 pagination_text pagination_background border border-gray-300" 
                onclick="changePageNotesEncounter(${currentPageNotesEncounters - 1})">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M14 6l-6 6l6 6v-12" />
                </svg>
            </button>
        </li>`;

    for (let page = startPage; page <= endPage; page++) {
        paginationHTML += `
            <li class="page-item${currentPageNotesEncounters === page ? ' active' : ''}">
                <button 
                    class="flex items-center justify-center text-sm py-[7px] px-3 border border-gray-300 ${
                        currentPageNotesEncounters === page 
                            ? 'pagination_background_active text-white' 
                            : 'pagination_text pagination_background'
                    }" 
                    onclick="changePageNotesEncounter(${page})">
                    ${page}
                </button>
            </li>`;
    }

    paginationHTML += `
            <li class="page-item">
                <button ${currentPageNotesEncounters === totalPagesEncounters ? 'disabled' : ''} 
                    class="flex items-center justify-center text-sm py-2 px-3 pagination_text pagination_background border border-gray-300" 
                    onclick="changePageNotesEncounter(${currentPageNotesEncounters + 1})">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M10 18l6 -6l-6 -6v12" />
                    </svg>
                </button>
            </li>`;
 
    const ul = document.createElement('ul');
    ul.innerHTML = paginationHTML;
    ul.classList = "inline-flex ml-auto items-stretch -space-x-px";

    $("#paginationNotesEncounters").append(ul); 
}

function changePageNotesEncounter(page)
{
    currentPageNotesEncounters = page;
    getPaginationNotesEncounters(currentPageNotesEncounters); 
}