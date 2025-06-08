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
        data.forEach(appointment => {  
            let rowHTML = ` 
                <td class="px-4 py-3 font-medium table_text font-bold text-[#526270]">
                    ${appointment.fullnamePatient}  
                    <small class="block ${appointmentStatusColors[appointment.status]} flex-1"><i>${appointmentStatus[appointment.status]}</i></small>
                </td> 
                <td class="px-4 py-3 font-medium table_text font-bold">${appointment.fullnameDoctor}</td>
                <td class="px-4 py-3 font-medium table_text font-bold">${appointment.subject}</td>
                <td class="px-4 py-3 font-medium table_text font-bold hidden md:table-cell text-center ">${localeApp == "es" ? reformatDate(appointment.date, "h:i, d c M Y") : reformatDate(appointment.date,"h:i, M d Y")}</td>
                <td class="px-4 py-3 table_text hidden md:table-cell"> 
                    <div class="flex justify-evenly"> 
                        <strong>Subtotal:</strong> $ ${customNumberFormat(appointment.subtotal)}
                    </div> 
                    <div class="flex justify-evenly"> 
                        <strong>${discountText}:</strong> $ ${customNumberFormat(appointment.discount)}
                    </div>  
                </td> 
                <td class="px-4 py-3">
                    <div class="flex items-center justify-end">
                        <div class="group relative">
                            <button class="inline-flex items-center p-0.5 text-sm font-medium text-center table_text rounded-lg focus:outline-none" type="button">
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                </svg>
                            </button>
                            <div class="absolute left-[-143px] top-[-7px] group-hover:block hidden z-10 w-36 table_submenu rounded divide-y divide-gray-100 shadow border-[1px] dark:border-slate-800 overflow-hidden">
                                <ul class="text-sm table_text">
                                    <li>
                                        <button onclick='detailAppointment(${JSON.stringify(appointment)})' class="block w-full text-left submenu_text font-medium py-2 px-4 button_table_submenu flex items-center gap-2">
                                            <svg  xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                            ${detailText}
                                        </button>
                                    </li>  
                                    ${appointment.status == 1 ? `<li>
                                        <a href="${appointmentEditURL+appointment.id}" class="block w-full text-left submenu_text font-medium py-2 px-4 button_table_submenu flex items-center gap-2">
                                            <svg  xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                            ${editText}
                                        </a>
                                    </li>` : ""}
                                    ${appointment.status == 1 && pr != 3 ?
                                    `<li>
                                        <button onclick="confirmAppointment('${appointment.id}')" class="w-full text-left submenu_text font-medium py-2 px-4 button_table_submenu flex items-center gap-2">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="20"  height="20"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 11l3 3l8 -8" /><path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" /></svg>
                                            ${confirmText}
                                        </button>
                                    </li>` : ""} 
                                    ${(appointment.status != 3 && appointment.status != 0) &&  pr != 3 ?
                                    `<li>
                                        <button onclick="cancelAppointment('${appointment.id}')" class="w-full text-left submenu_text font-medium py-2 px-4 button_table_submenu flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32" stroke="currentColor" stroke-width="2"><path d="M 15 4 C 14.478 4 13.9405 4.1845 13.5625 4.5625 C 13.1855 4.9395 13 5.478 13 6 L 13 7 L 7 7 L 7 9 L 8 9 L 8 25 C 8 26.645 9.355 28 11 28 L 23 28 C 24.645 28 26 26.645 26 25 L 26 9 L 27 9 L 27 7 L 21 7 L 21 6 C 21 5.478 20.8155 4.9405 20.4375 4.5625 C 20.0605 4.1855 19.522 4 19 4 L 15 4 z M 15 6 L 19 6 L 19 7 L 15 7 L 15 6 z M 10 9 L 24 9 L 24 25 C 24 25.555 23.555 26 23 26 L 11 26 C 10.445 26 10 25.555 10 25 L 10 9 z M 17 12 L 13 16 L 16 16 L 16 23 L 18 23 L 18 16 L 21 16 L 17 12 z"/></svg>
                                            ${deleteText}
                                        </button>
                                    </li>` : ""} 
                                    ${appointment.status == 2 ? `<li>
                                        <button onclick="createEncounter('${appointment.id}')" class="w-full text-left submenu_text font-medium py-2 px-4 button_table_submenu flex items-center gap-2 text-[12px]">
                                            <svg xmlns="http://www.w3.org/2000/svg"  width="18"  height="18"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M10 14h4" /><path d="M12 12v4" /></svg>
                                            ${generateEncounterText}
                                        </button>
                                    </li>` : ""}
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
                                        <svg class="mx-auto" xmlns="http://www.w3.org/2000/svg" width="60" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.5 21h-4.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v3" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h10" /><path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18 16.5v1.5l.5 .5" /></svg>
                                        ${withoutAppointmentsSearch}
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

function cancelAppointment(id){
    currentItem = id;

    $("#deleteModal textarea").value = ""; 
    $("#deleteModal label").classList.remove("text_error"); 
    $("#deleteModal small").innerHTML = ""; 
    
    openModal("#deleteModal");
}

function confirmAppointment(id){
    currentItem = id;
    openModal("#confirmModal");
}

function confirmDelete(){ 
    $("#deleteModal").querySelectorAll("label").forEach(element => {
        element.classList.remove("text_error");
    });

    $("#deleteModal").querySelectorAll("input,select").forEach(element => {
        element.classList.remove("border-red-500");
    });

    $("#deleteModal").querySelectorAll("small").forEach(element => {
        element.innerHTML = "";
    });
    
    const data = new FormData();
    data.set("cancellation_reason",$("#cancellation_reason").value);

    fetch(urlDel+currentItem, { 
        headers: { 
            "X-CSRF-Token": $('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json', 
        },   
        method: "POST",
        body: data
    })
    .then(res => error419(res))
    .then((json) => { 
        if(json.status){
            currentItem = null;
            closeModal("#deleteModal");
            createAlert(json.message,"success");
            getPagination(currentPage);
        }else{
            if(typeof json.message == "object"){
                Object.keys(json.message).forEach(key => { 
                  $("#deleteModal").querySelector(`#${key}_message`).innerHTML = json.message[key];
                  $("#deleteModal").querySelector(`#${key}`)?.classList.add("border-red-500");
                  $("#deleteModal").querySelector(`#${key}+label`)?.classList.add("text_error");
                });
            }else{
                createAlert(json.message, "error")
            }
        }
    })
    .catch((err) => console.error("error:", err)); 
}

function acceptConfirm(){ 
    fetch(urlConfirm+currentItem, { 
        headers: { 
            "X-CSRF-Token": $('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json', 
        },   
    })
    .then(res => error419(res))
    .then((json) => { 
        if(json.status){
            currentItem = null;
            closeModal("#confirmModal");
            createAlert(json.message,"success");
            getPagination(currentPage);
        }else{
            currentItem = null;
            closeModal("#confirmModal");
            createAlert(json.message,"error");
        }
    })
    .catch((err) => console.error("error:", err)); 
}

function createEncounter(id){ 
    fetch(urlGenerateEncounter+id, { 
        headers: { 
            "X-CSRF-Token": $('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json', 
        },   
    })
    .then(res => error419(res))
    .then((json) => { 
        if(json.status){ 
            createAlert(json.message,"success");

            setTimeout(() => {
                location.href = urlEcounter+json.id; 
            }, 3000);
        }else{
            createAlert(json.message,"error");
        }
    })
    .catch((err) => console.error("error:", err)); 
}

function detailAppointment(appointment){  
    $("#allergiesRow").classList.add("hidden");
    $("#addictionsRow").classList.add("hidden");
    $("#medicationsRow").classList.add("hidden");
    $("#surgeriesRow").classList.add("hidden");

    $('#dateText').innerHTML = localeApp == "es" ? reformatDate(appointment.date, "h:i, d c M Y") : reformatDate(appointment.date,"h:i, M d Y");
    $('#patientText').innerHTML = appointment.fullnamePatient;
    $('#doctorText').innerHTML = appointment.fullnameDoctor;
    $("#statusText").innerHTML = appointmentStatus[appointment.status];
    $("#statusText").classList = appointmentStatusColors[appointment.status];
    $("#dobText").innerHTML = localeApp == "es" ? reformatDate(appointment.patient_dob, "d c M Y") : reformatDate(appointment.patient_dob,"M d Y");
    $("#bloodTypeText").innerHTML = appointment.patient_blood_type;

    let hideDetail = false;

    if(appointment.allergies){
        $("#allergiesRow").classList.remove("hidden");
        $("#allergiesText").innerHTML = appointment.allergies_text
        hideDetail = true;
    }

    if(appointment.addictions){
        $("#addictionsRow").classList.remove("hidden");
        $("#addictionsText").innerHTML = appointment.addictions_text
        hideDetail = true;
    }

    if(appointment.medications){
        $("#medicationsRow").classList.remove("hidden");
        $("#medicationsText").innerHTML = appointment.medications_text
        hideDetail = true;
    }

    if(appointment.surgeries){
        $("#surgeriesRow").classList.remove("hidden");
        $("#surgeriesText").innerHTML = appointment.surgeries_text
        hideDetail = true;
    }
    
    if(!hideDetail){
        $("#titleDetail").classList.add("hidden");
    }

    if(appointment.status == 0){
        $("#cancelationRow").classList.remove("hidden");
        $("#reasonCancelText").innerHTML = appointment.cancellation_reason;
    }
    
    openModal("#detailAppointment");    
}


getPagination(currentPage);