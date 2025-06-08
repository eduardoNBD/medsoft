let totalPagesAppointments = 0; 
const startDateInput = $('#datepicker-range-start');
const endDateInput = $('#datepicker-range-end');
 
function getPagination(currentPageAppointments){ 
    const status = Array.from(document.querySelectorAll("[name='status']:checked")).map(checked => { return "status[]="+checked.value }).join("&");
    
    const startDate = startDateInput.datepicker?.getDate();
    const endDate = endDateInput.datepicker?.getDate();

    const dateString = startDate && endDate ? `&start_date=${reformatDate(startDate,"y-m-d")}&end_date=${reformatDate(endDate,"y-m-d")}` : "";

    fetch(urlAppointments+currentPageAppointments+'&'+status+dateString, { 
        headers: { 
            "X-CSRF-Token": $('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json', 
        },   
    })
    .then(res => error419(res))
    .then((json) => { 
        if(json.status){
            //$("#total").innerHTML = json.items.total;
            totalPagesAppointments = Math.ceil(json.items.total/json.items.per_page);
            currentPageAppointments = json.items.current_page;

            $("#tab-appointments #pagination").innerHTML = "";

            if(totalPagesAppointments > 1){
                setPages(currentPageAppointments, totalPagesAppointments);
            }

            setRows(json.items.data);
        }else{
            
        }
    })
    .catch((err) => console.error("error:", err)); 
}

function setRows(data){ 
    $("#tab-appointments table tbody").innerHTML = "";

    if(data.length){
        data.forEach(appointment => {  
            let rowHTML = ` 
                <td class="px-4 py-3 font-medium text-gray-900 dark:text-gray-200 font-bold text-[#526270]">
                    ${appointment.fullnameDoctor}<br>
                    ${appointment.subject}
                </td> 
                <td class="px-4 py-3 font-medium text-gray-900 dark:text-gray-200 font-bold text-[#526270] hidden md:table-cell text-center ">${localeApp == "es" ? reformatDate(appointment.date, "h:i, d c M Y") : reformatDate(appointment.date,"h:i, M d Y")}</td>
                <td class="px-4 py-3 text-gray-900 dark:text-gray-200 hidden md:table-cell"> 
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
                            <button class="inline-flex items-center p-0.5 text-sm font-medium text-center text-[#526270] hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                </svg>
                            </button>
                            <div class="absolute left-[-143px] top-[-7px] group-hover:block hidden z-10 w-36 bg-white dark:bg-slate-950 rounded divide-y divide-gray-100 shadow border-[1px] border-gray-300 dark:border-slate-800 overflow-hidden">
                                 <ul class="text-sm table_text">
                                    <li>
                                        <button onclick='detailAppointment(${JSON.stringify(appointment)})' class="block w-full text-left text-gray-800 dark:text-gray-200 py-2 px-4 hover:bg-gray-100 dark:hover:bg-[#070F26] flex items-center gap-2">
                                            <svg  xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                            ${detailText}
                                        </button>
                                    </li>   
                                    ${appointment.status != 3  ?
                                    `<li>
                                        <button onclick="cancelAppointment('${appointment.id}')" class="w-full text-left text-gray-800 dark:text-gray-200 py-2 px-4 hover:bg-gray-100 dark:hover:bg-[#070F26] flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32" stroke="currentColor" stroke-width="2"><path d="M 15 4 C 14.478 4 13.9405 4.1845 13.5625 4.5625 C 13.1855 4.9395 13 5.478 13 6 L 13 7 L 7 7 L 7 9 L 8 9 L 8 25 C 8 26.645 9.355 28 11 28 L 23 28 C 24.645 28 26 26.645 26 25 L 26 9 L 27 9 L 27 7 L 21 7 L 21 6 C 21 5.478 20.8155 4.9405 20.4375 4.5625 C 20.0605 4.1855 19.522 4 19 4 L 15 4 z M 15 6 L 19 6 L 19 7 L 15 7 L 15 6 z M 10 9 L 24 9 L 24 25 C 24 25.555 23.555 26 23 26 L 11 26 C 10.445 26 10 25.555 10 25 L 10 9 z M 17 12 L 13 16 L 16 16 L 16 23 L 18 23 L 18 16 L 21 16 L 17 12 z"/></svg>
                                            ${deleteText}
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

            $("#tab-appointments table tbody").append(tr); 
        });      
    }else{
        let rowHTML = `<tr>
                            <td colspan="6">
                                <h1 class="text-center text-2xl md:text-3xl m-10 md:m-20">
                                    <svg class="mx-auto" xmlns="http://www.w3.org/2000/svg" width="60" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.5 21h-4.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v3" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h10" /><path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M18 16.5v1.5l.5 .5" /></svg>
                                    ${withoutAppointmentsSearch}
                                </h1>
                            </td>
                        </tr>`;
        let tr       = document.createElement('tr');
        tr.classList = "border-b border-gray-200"
        tr.innerHTML = rowHTML;

        $("#tab-appointments table tbody").append(tr); 
    }       
}

function setPages(currentPageAppointments, totalPagesAppointments) { 
    const pagesToShow = 2;  
    const maxPagesToShow = pagesToShow * 2 + 1; 

    let startPage = Math.max(1, currentPageAppointments - pagesToShow);
    let endPage = Math.min(totalPagesAppointments, currentPageAppointments + pagesToShow);

    if (currentPageAppointments - pagesToShow <= 1) {
        endPage = Math.min(startPage + maxPagesToShow - 1, totalPagesAppointments);
    }

    if (currentPageAppointments + pagesToShow >= totalPagesAppointments) {
        startPage = Math.max(endPage - maxPagesToShow + 1, 1);
    }

    startPage = Math.max(1, startPage);
    endPage = Math.min(totalPagesAppointments, endPage);

    let paginationHTML = '<ul class="inline-flex ml-auto items-stretch -space-x-px">';
    
    paginationHTML += '<li class="page-item">';
    paginationHTML += '<button ' + (currentPageAppointments === 1 ? ' disabled' : '') + ' class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-[#526270] bg-white border border-gray-300 hover:bg-violet-500 hover:border-y-violet-500 hover:text-white hover:text-gray-700" onclick="changePage(' + (currentPageAppointments - 1) + ')"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="18"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round" ><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 6l-6 6l6 6v-12" /></svg></button>';
    paginationHTML += '</li>';

    for (let page = startPage; page <= endPage; page++) {
        paginationHTML += '<li class="page-item' + (currentPageAppointments === page ? ' active' : '') + '">';
        paginationHTML += '<button class="flex items-center justify-center text-sm py-2 px-3 leading-tight ' + (currentPageAppointments === page ? 'border border-violet-500 bg-violet-500 text-white' : 'text-[#526270] bg-white border hover:bg-violet-500 hover:border-y-violet-500 hover:text-white hover:text-gray-700 border-gray-300 ') + '" onclick="changePage(' + page + ')">' + page + '</button>';
        paginationHTML += '</li>';
    }

    paginationHTML += '<li class="page-item">';
    paginationHTML += '<button ' + (currentPageAppointments === totalPagesAppointments ? ' disabled' : '') + ' class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-[#526270] bg-white border border-gray-300 hover:bg-violet-500 hover:border-y-violet-500 hover:text-white hover:text-gray-700" onclick="changePage(' + (currentPageAppointments + 1) + ')"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="18"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round" ><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 18l6 -6l-6 -6v12" /></svg></button>';
    paginationHTML += '</li>';

    paginationHTML += '</ul>';

    var temp       = document.createElement('div');
    temp.innerHTML = (paginationHTML);

    $("#tab-appointments #pagination").appendChild(temp.childNodes[0]); 
}

function changePage(page)
{
    currentPageAppointments = page;
    getPagination(currentPageAppointments);
    const s = $("#simple-search").value;
    window.history.pushState({}, title, currentURL+currentPageAppointments+"?s="+s);
}

function search(){  
    const s = $("#simple-search").value;
    window.history.pushState({}, title, currentURL+currentPageAppointments+"?s="+s);
    getPagination(currentPageAppointments);
}

function cancelAppointment(id){
    currentItem = id;
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
            getPagination(currentPageAppointments);
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
            getPagination(currentPageAppointments);
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
    //$('#patientText').innerHTML = appointment.fullnamePatient;
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

    openModal("#detailAppointment");    
}
 
getPagination(currentPageAppointments);

startDateInput.addEventListener('change', (event) => {
    getPagination(currentPageAppointments);
    $("#clear-daterange").classList.remove("hidden");
});

endDateInput.addEventListener('change', (event) => {
    getPagination(currentPageAppointments);
    $("#clear-daterange").classList.remove("hidden");
});

$("#clear-daterange").addEventListener("click", function () {  
    startDateInput.datepicker.rangepicker.setDates({clear:true})
    $("#clear-daterange").classList.add("hidden");
    getPagination(currentPageAppointments);
});