let totalPages = 0; 

function getPagination(currentPage){ 
    const status = Array.from(document.querySelectorAll("[name='status']:checked")).map(checked => { return "status[]="+checked.value }).join("&");
    const s = $("#simple-search").value;

    fetch(url+currentPage+'&s='+s+'&'+status, { 
        headers: { 
            "X-CSRF-Token": $('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json', 
        },   
    })
    .then(res => error419(res))
    .then((json) => { 
        if(json.status){
            $("#total").innerHTML = json.items.total;
            totalPages = Math.ceil(json.items.total/json.items.per_page);
            currentPage = json.items.current_page;

            $("#pagination").innerHTML = "";

            if(totalPages > 1){
                setPages(currentPage, totalPages);
            }

            setRows(json.items.data);
        }else{
            
        }
    })
    .catch((err) => console.error("error:", err)); 
}

function setRows(data){ 
    $("table tbody").innerHTML = "";

    if(data.length){
        data.forEach(patient => {  
            let rowHTML = ` 
                <td class="px-4 py-3 font-medium table_text font-bold">
                    <div class="flex">
                        <div class="text-center flex-shrink-0 object-cover w-[30px] h-[30px] mr-3 rounded-full">
                            <img src="${patient.image ? `${storegeBase}/${patient.image}` : defaultUsrImg}" alt="profile" class="rounded-full w-full h-full">
                        </div>
                        <div>
                            <a class="text-xs sm:text-base" href="${patientDetailURL+patient.id}">${patient.fullname}</a>  
                            ${patient.status == "0" ? `<small class="block text_error flex-1"><i>${deletedText}</i></small>` : ""}
                        </div>
                    </div>
                </td> 
                <td class="px-2 md:px-4 py-3 font-medium table_text font-bold hidden md:table-cell">
                    ${patient.fullnameDoctor ?? ""} 
                </td>
                <td class="px-2 md:px-4 py-3 font-medium table_text font-bold">
                    <div class="flex gap md:gap-2 items-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="hidden sm:flex" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-at"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M16 12v1.5a2.5 2.5 0 0 0 5 0v-1.5a9 9 0 1 0 -5.5 8.28" /></svg> 
                        ${patient.email}
                    </div>
                    <div class="flex gap md:gap-2 items-center"> 
                        <svg xmlns="http://www.w3.org/2000/svg" class="hidden sm:flex" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-device-mobile"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 5a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2v-14z" /><path d="M11 4h2" /><path d="M12 17v.01" /></svg> 
                        ${patient.phone ?? ""}
                    </div> 
                </td> 
                <td class="px-2 md:px-4 py-3 font-medium table_text font-bold hidden md:table-cell">${patient.fulladdress}</td> 
                <td class="px-2 md:px-4 py-3 table_text text-xs md:text-md hidden md:table-cell"> 
                    <p> ${localeApp == "es" ? reformatDate(patient.dob, "d c M y") : reformatDate(patient.dob,"M d, y")}</p>  
                    (${patient.age} ${localeApp == "es" ? "Años" : "Years"})
                </td> 
                <td class="px-2 md:px-4 py-3"> 
                    <div class=" flex items-center justify-end">
                        <div class="group relative">
                            <button class="inline-flex items-center p-0.5 text-sm font-medium text-center table_text rounded-lg focus:outline-none" type="button">
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                </svg>
                            </button>
                            <div class="absolute left-[-174px] ${patient.status == 1 ? "top-[-120px]" : 'top-0'} group-hover:block hidden z-10 w-44 table_submenu rounded divide-y divide-gray-100 shadow border-[1px] border-gray-300 dark:border-slate-800 overflow-hidden">
                                 <ul class="text-sm table_text">
                                    ${patient.status == 1 ? `
                                    <li>
                                        <a href="${patientDetailURL+patient.id}" class="block w-full text-left submenu_text font-medium py-2 px-4 button_table_submenu flex items-center gap-2">
                                            <svg  xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                            ${detailText}
                                        </a>
                                    </li>  
                                    <li>
                                        <button onclick='createConsentPRP(${JSON.stringify(patient)})' class="text-xs w-full text-left submenu_text font-medium py-2 px-4 button_table_submenu flex items-center gap-2">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="20"  height="20"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" /><path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" /><path d="M17 18h2" /><path d="M20 15h-3v6" /><path d="M11 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1z" /></svg>
                                            ${consentPRPText}
                                        </button>
                                    </li>
                                    <li>
                                        <button onclick='prepareTLF(${JSON.stringify(patient)})' class="text-xs w-full text-left submenu_text font-medium py-2 px-4 button_table_submenu flex items-center gap-2">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="20"  height="20"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" /><path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" /><path d="M17 18h2" /><path d="M20 15h-3v6" /><path d="M11 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1z" /></svg>
                                            ${consentFLTText}
                                        </button>
                                    </li>
                                    <li>
                                        <a href='${medicalCertificateURL+'?patient_id='+patient.id}' class="text-xs w-full text-left submenu_text font-medium py-2 px-4 button_table_submenu flex items-center gap-2">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="20"  height="20"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 20h-11a3 3 0 0 1 0 -6h11a3 3 0 0 0 0 6h1a3 3 0 0 0 3 -3v-11a2 2 0 0 0 -2 -2h-10a2 2 0 0 0 -2 2v8" /></svg>
                                            ${medicalCertificateText}
                                        </a> 
                                    </li>
                                    <li>
                                        <a href="${patientRecordURL+patient.id}" class="block w-full text-left submenu_text font-medium py-2 px-4 button_table_submenu flex items-center gap-2">
                                            <svg  xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                            ${recordText}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="${EditURL+patient.user_id}" class="block w-full text-left submenu_text font-medium py-2 px-4 button_table_submenu flex items-center gap-2">
                                            <svg  xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                            ${editText}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="${`${appointmentURL}/?patient=${patient.id}`}" class="block w-full text-left submenu_text font-medium py-2 px-4 button_table_submenu flex items-center gap-2">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="18"  height="18"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.5 21h-4.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v3" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h10" /><path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18 16.5v1.5l.5 .5" /></svg>
                                            ${appointmentText}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="${`${encounterURL}/?patient=${patient.id}`}" class="block w-full text-left submenu_text font-medium py-2 px-4 button_table_submenu flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg"  width="18"  height="18"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M10 14h4" /><path d="M12 12v4" /></svg>
                                            ${encounterText}
                                        </a>
                                    </li>` : ""}
                                    ${patient.user_id != ci && patient.status == 1 ?`<li>
                                        <button onclick="deleteUser('${patient.user_id}')" class="w-full text-left submenu_text font-medium py-2 px-4 button_table_submenu flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32" stroke="currentColor" stroke-width="2"><path d="M 15 4 C 14.478 4 13.9405 4.1845 13.5625 4.5625 C 13.1855 4.9395 13 5.478 13 6 L 13 7 L 7 7 L 7 9 L 8 9 L 8 25 C 8 26.645 9.355 28 11 28 L 23 28 C 24.645 28 26 26.645 26 25 L 26 9 L 27 9 L 27 7 L 21 7 L 21 6 C 21 5.478 20.8155 4.9405 20.4375 4.5625 C 20.0605 4.1855 19.522 4 19 4 L 15 4 z M 15 6 L 19 6 L 19 7 L 15 7 L 15 6 z M 10 9 L 24 9 L 24 25 C 24 25.555 23.555 26 23 26 L 11 26 C 10.445 26 10 25.555 10 25 L 10 9 z M 17 12 L 13 16 L 16 16 L 16 23 L 18 23 L 18 16 L 21 16 L 17 12 z"/></svg>
                                            ${deleteText}
                                        </button>
                                    </li>` : ""}
                                    ${patient.status == 0 ? 
                                    `<li>
                                        <button onclick="restoreUser('${patient.user_id}')" class="w-full text-left submenu_text font-medium py-2 px-4 button_table_submenu flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg"  width="20"  height="20"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-refresh"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" /><path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" /></svg>
                                            ${restoreText}
                                        </button>
                                    </li> ` : ''}
                                </ul> 
                            </div>
                        </div>
                    </div>
                </td>`;
            
            let tr       = document.createElement('tr');
            tr.classList = "border-b border-gray-200"
            tr.innerHTML = rowHTML;

            $("table tbody").append(tr); 
        });      
    }else{
        let rowHTML = `<tr>
                            <td colspan="6">
                                <div  class="m-10 md:m-20">
                                    <h1 class="text-center text-2xl md:text-3xl table_text">
                                        <svg class="mx-auto" xmlns="http://www.w3.org/2000/svg" width="60"  height="60" viewBox="0 0 576 512" fill="currentColor"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M48 0C21.5 0 0 21.5 0 48L0 256l144 0c8.8 0 16 7.2 16 16s-7.2 16-16 16L0 288l0 64 144 0c8.8 0 16 7.2 16 16s-7.2 16-16 16L0 384l0 80c0 26.5 21.5 48 48 48l217.9 0c-6.3-10.2-9.9-22.2-9.9-35.1c0-46.9 25.8-87.8 64-109.2l0-95.9L320 48c0-26.5-21.5-48-48-48L48 0zM152 64l16 0c8.8 0 16 7.2 16 16l0 24 24 0c8.8 0 16 7.2 16 16l0 16c0 8.8-7.2 16-16 16l-24 0 0 24c0 8.8-7.2 16-16 16l-16 0c-8.8 0-16-7.2-16-16l0-24-24 0c-8.8 0-16-7.2-16-16l0-16c0-8.8 7.2-16 16-16l24 0 0-24c0-8.8 7.2-16 16-16zM512 272a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM288 477.1c0 19.3 15.6 34.9 34.9 34.9l218.2 0c19.3 0 34.9-15.6 34.9-34.9c0-51.4-41.7-93.1-93.1-93.1l-101.8 0c-51.4 0-93.1 41.7-93.1 93.1z"/></svg>
                                        ${withoutPatientsSearch}
                                    </h1>
                                </div>
                            </td>
                        </tr>`;
        let tr       = document.createElement('tr');
        tr.classList = "border-b border-gray-200"
        tr.innerHTML = rowHTML;

        $("table tbody").append(tr); 
    }       
}

function setPages(currentPage, totalPages) { 
    const pagesToShow = 2;  
    const maxPagesToShow = pagesToShow * 2 + 1; 

    let startPage = Math.max(1, currentPage - pagesToShow);
    let endPage = Math.min(totalPages, currentPage + pagesToShow);

    if (currentPage - pagesToShow <= 1) {
        endPage = Math.min(startPage + maxPagesToShow - 1, totalPages);
    }

    if (currentPage + pagesToShow >= totalPages) {
        startPage = Math.max(endPage - maxPagesToShow + 1, 1);
    }

    startPage = Math.max(1, startPage);
    endPage = Math.min(totalPages, endPage);

    let paginationHTML = ` 
        <li class="page-item">
            <button ${currentPage === 1 ? 'disabled' : ''} 
                class="flex items-center justify-center text-sm py-2 px-3 pagination_text pagination_background border border-gray-300" 
                onclick="changePage(${currentPage - 1})">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M14 6l-6 6l6 6v-12" />
                </svg>
            </button>
        </li>`;

    for (let page = startPage; page <= endPage; page++) {
        paginationHTML += `
            <li class="page-item${currentPage === page ? ' active' : ''}">
                <button 
                    class="flex items-center justify-center text-sm py-[7px] px-3 border border-gray-300 ${
                        currentPage === page 
                            ? 'pagination_background_active text-white' 
                            : 'pagination_text pagination_background'
                    }" 
                    onclick="changePage(${page})">
                    ${page}
                </button>
            </li>`;
    }

    paginationHTML += `
            <li class="page-item">
                <button ${currentPage === totalPages ? 'disabled' : ''} 
                    class="flex items-center justify-center text-sm py-2 px-3 pagination_text pagination_background border border-gray-300" 
                    onclick="changePage(${currentPage + 1})">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M10 18l6 -6l-6 -6v12" />
                    </svg>
                </button>
            </li>`;
 
    const ul = document.createElement('ul');
    ul.innerHTML = paginationHTML;
    ul.classList = "inline-flex ml-auto items-stretch -space-x-px";
    
    $("#pagination").append(ul);
}

function changePage(page)
{
    currentPage = page;
    getPagination(currentPage);
    const s = $("#simple-search").value;
    window.history.pushState({}, title, currentURL+currentPage+"?s="+s);
}

function search(){  
    const s = $("#simple-search").value;
    window.history.pushState({}, title, currentURL+currentPage+"?s="+s);
    getPagination(currentPage);
}

function deleteUser(id){
    currentItem = id;
    openModal("#deleteModal");
}

function restoreUser(id){
    currentItem = id;
    openModal("#restoreModal");
}

function prepareTLF(patient){
    currentItem = patient; 
    
    $("#medicalUnit_message").innerHTML = "";
    $("#area_message").innerHTML = "";
    $(`#area`).value = ""; 

    let currentDoctor = doctors.find(doctor => doctor.id = patient.doctor_id); 
    currentDoctor.medical_units = typeof currentDoctor.medical_units != "string" ? currentDoctor.medical_units : JSON.parse(currentDoctor.medical_units);
  
    $("#prepareTLF #doctor").value = patient.doctor_id;
    $("#prepareTLF #medicalUnit").innerHTML = 
        '<option value=""></option>'+
        medicalUnits.filter(medicalUnit => currentDoctor.medical_units.includes(medicalUnit.id)).map(medicalUnit => 
            `<option value="${medicalUnit.id}">${medicalUnit.name}</option>`
        ).join("");

    openModal("#prepareTLF");
}

function confirmDelete(){ 

    fetch(urlDel+currentItem, { 
        headers: { 
            "X-CSRF-Token": $('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json', 
        },   
    })
    .then(res => error419(res))
    .then((json) => { 
        if(json.status){
            currentItem = null;
            closeModal("#deleteModal");
            createAlert(json.message,"success");
            getPagination(currentPage);
        }else{
            currentItem = null;
            closeModal("#deleteModal");
            createAlert(json.message,"error");
        }
    })
    .catch((err) => console.error("error:", err)); 
}

function confirmRestore(){ 

    fetch(urlRes+currentItem, { 
        headers: { 
            "X-CSRF-Token": $('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json', 
        },   
    })
    .then(res => error419(res))
    .then((json) => { 
        if(json.status){
            currentItem = null;
            closeModal("#restoreModal");
            createAlert(json.message,"success");
            getPagination(currentPage);
        }else{
            currentItem = null;
            closeModal("#restoreModal");
            createAlert(json.message,"error");
        }
    })
    .catch((err) => console.error("error:", err)); 
} 

getPagination(currentPage);