let totalPages = 0; 
const supplyReloadForm = $("#supplyReloadForm");
const startDateInput = $('#datepicker-range-start');
const endDateInput = $('#datepicker-range-end');

function getPagination(currentPage){ 
    const status = Array.from(document.querySelectorAll("[name='status']:checked")).map(checked => { return "status[]="+checked.value }).join("&");
    
    const startDate = startDateInput.datepicker?.getDate();
    const endDate = endDateInput.datepicker?.getDate();

    const dateString = startDate && endDate ? `&start_date=${reformatDate(startDate,"y-m-d")}&end_date=${reformatDate(endDate,"y-m-d")}` : "";

    fetch(url+currentPage+"&"+status+dateString, { 
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
        data.forEach(reload => {   

            let rowHTML = ` 
                <td class="px-2 md:px-4 py-3 table_text"> 
                    ${localeApp == "es" ? reformatDate(reload.created_at , "d c M y") : reformatDate(reload.created_at ,"M d, y")}<br>
                    ${reload.status == "0" ? `<small class="block text_error flex-1"><i>${deletedText}</i></small>` : ""} 
                    ${reload.is_expired ? `<small class="block text_error flex-1"><i>${expiredText}</i></small>` : ""} 

                </td> 
                <td class="px-2 md:px-4 py-3 table_text font-bold"> 
                    ${reload.remaining}/${reload.quantity}
                </td>   
                <td class="px-2 md:px-4 py-3 table_text font-bold hidden md:table-cell">
                    ${reload.expiration 
                        ? localeApp == "es" ? reformatDate(reload.expiration , "d c M y") : reformatDate(reload.expiration ,"M d, y")
                        : "N/A"
                    } 
                </td>
                <td class="px-2 md:px-4 py-3 table_text"> 
                        <div class="text-center"><strong>${priceText}:</strong> <span>$ ${reload.price}</span></div>
                        ${reload.cost ? `<div class="text-center"><strong>${costText}:</strong> $ ${reload.cost}</div>` : ""}
                </td> 
                <td class="px-2 md:px-4 py-3">
                    <div class="flex items-center justify-end">
                        ${pr == 1 && !reload.is_expired ?`<div class="group relative">
                            <button class="inline-flex items-center p-0.5 text-sm text-center table_text rounded-lg focus:outline-none" type="button">
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                </svg>
                            </button>
                            <div class="absolute left-[-143px] top-[-7px] group-hover:block hidden z-10 w-36 table_submenu rounded divide-y divide-gray-100 shadow border-[1px] dark:border-slate-800 overflow-hidden">
                                 <ul class="text-sm table_text"> 
                                    ${reload.status == 1 ?`<li>
                                        <button type="button" onclick="deleteSupplyReload('${reload.id}')" class="w-full text-left submenu_text font-medium py-2 px-4 button_table_submenu flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32" stroke="currentColor" stroke-width="2"><path d="M 15 4 C 14.478 4 13.9405 4.1845 13.5625 4.5625 C 13.1855 4.9395 13 5.478 13 6 L 13 7 L 7 7 L 7 9 L 8 9 L 8 25 C 8 26.645 9.355 28 11 28 L 23 28 C 24.645 28 26 26.645 26 25 L 26 9 L 27 9 L 27 7 L 21 7 L 21 6 C 21 5.478 20.8155 4.9405 20.4375 4.5625 C 20.0605 4.1855 19.522 4 19 4 L 15 4 z M 15 6 L 19 6 L 19 7 L 15 7 L 15 6 z M 10 9 L 24 9 L 24 25 C 24 25.555 23.555 26 23 26 L 11 26 C 10.445 26 10 25.555 10 25 L 10 9 z M 17 12 L 13 16 L 16 16 L 16 23 L 18 23 L 18 16 L 21 16 L 17 12 z"/></svg>
                                            ${deleteText}
                                        </button>
                                    </li>` : ""}
                                    ${reload.status == 0 ? 
                                    `<li>
                                        <button type="button" onclick="restoreSupply('${reload.id}')" class="w-full text-left submenu_text font-medium py-2 px-4 button_table_submenu flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg"  width="20"  height="20"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-refresh"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" /><path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" /></svg>
                                            ${restoreText}
                                        </button>
                                    </li> ` : ''}
                                </ul> 
                            </div>` :""}
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
                            <td colspan="7">
                                <div  class="m-10 md:m-20">
                                    <h1 class="text-center text-2xl md:text-3xl table_text">
                                        <svg class="mx-auto" xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M9 3m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v1a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M10 6v.98c0 .877 -.634 1.626 -1.5 1.77c-.866 .144 -1.5 .893 -1.5 1.77v8.48a2 2 0 0 0 2 2h6a2 2 0 0 0 2 -2v-8.48c0 -.877 -.634 -1.626 -1.5 -1.77a1.795 1.795 0 0 1 -1.5 -1.77v-.98" /><path d="M7 12h10" /><path d="M7 18h10" /><path d="M11 15h2" /> <path d="M18 3v6" /><path d="M15 6h6" /></svg>  
                                        ${withoutSupplyReloadsSearch}
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
    window.history.pushState({}, title, currentURL+currentPage);
}

function search(){  
    const s = $("#simple-search").value;
    window.history.pushState({}, title, currentURL+currentPage);
    getPagination(currentPage);
}

function deleteSupplyReload(id){
    currentItem = id;
    openModal("#deleteModal");
}

function restoreSupply(id){
    currentItem = id;
    openModal("#restoreModal");
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

supplyReloadForm.addEventListener("submit", (e) => {
    e.preventDefault();
    
    const data = new FormData(e.target);  
    const urlItemReaload = $("#reload_id").value ? baseURL+"/items_reloads/update/" : baseURL+"/items_reloads/create";
    
    if($("#expiration").value){
        const expiration  = $("#expiration").value.split("/");

        data.set("expiration",`${expiration[2]}-${expiration['1']}-${expiration['0']}`);
    }

    fetch(urlItemReaload, { 
        method: "post", 
        body: data,
        headers: { 
            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },  
    })
    .then(res => error419(res))
    .then((json) => { 
        if(json.status){
            supplyReloadForm.reset();
            currentItem = null;
            closeModal("#itemReload");
            createAlert(json.message,"success");
            getPagination(currentPage);
            
        }else{
            if(typeof json.message == "object"){
                Object.keys(json.message).forEach(key => {  
                   supplyReloadForm.querySelector(`#${key}_message`).innerHTML = json.message[key];
                   supplyReloadForm.querySelector(`#${key}`)?.classList.add("border-red-500");
                   supplyReloadForm.querySelector(`#${key}+label`)?.classList.add("text_error");
                });
            }else{
                createAlert(json.message, "error")
            }
        }
    })
    .catch((err) => console.error("error:", err)); 
});

startDateInput.addEventListener('change', (event) => {
    getPagination(currentPage);
    $("#clear-daterange").classList.remove("hidden");
});

endDateInput.addEventListener('change', (event) => {
    getPagination(currentPage);
    $("#clear-daterange").classList.remove("hidden");
});

$("#clear-daterange").addEventListener("click", function () {  
    startDateInput.datepicker.rangepicker.setDates({clear:true})
    $("#clear-daterange").classList.add("hidden");
    getPagination(currentPage);
});

getPagination(currentPage);