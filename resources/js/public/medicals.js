let totalPages = 0; 

function getPagination(currentPage){ 
    const status = "status[]=1";
    const medicalUnit = "&medicalUnit="+$("#medical_unit").value;
    const especialty = "&specialty="+$("#specialty").value;
    const s = $("#name").value;

    fetch(url+currentPage+'&s='+s+'&'+status+medicalUnit+especialty, { 
        headers: { 
            "X-CSRF-Token": $('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json', 
        },   
    })
    .then(res => error419(res))
    .then((json) => { 
        if(json.status){
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
    $("#medicalsContent").innerHTML = "";

    if(data.length){
        data.forEach(medical => {  
            let rowHTML = ` 
                <div class="bg-white border border-gray-200 rounded-lg shadow m-4 h-full">
                    <div class="flex flex-col items-center mt-8">
                        <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="${medical.image ? storegeBase+'/'+medical.image : defaultUsrImg}" alt="${medical.fullname}"/>
                        <h5 class="mb-1  mx-4 text-xl font-medium text-gray-800">${medical.title} ${medical.fullname}</h5> 
                        <div class="flex flex-col md:flex-row gap-2 mx-10"> 
                            ${JSON.parse(medical.specialties).map(specialty => `<span class="text-sm text-gray-100 bg-blue-900 rounded py-1 px-2 flex items-center justify-center">
                                ${specialty}
                            </span>`).join("")} 
                        </div>
                        <hr class="w-full border-t border-gray-200 mt-4 mb-2">
                        <div class="mx-10"> 
                            <h5 class="mb-1  mx-4 text-xl font-medium text-gray-800 text-center">
                                ${medical.medical_units.length != 0 && medical.medical_units.length == 1 ? address : addresses}
                            </h5> 
                            ${medical.medical_units.map(medical_unit => `<div class="text-sm text-gray-900 flex items-center justify-center mt-">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="16"  height="16"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /><path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z" /></svg>
                                ${medical_unit.fulladdress}
                            </div>`).join("")} 
                            <div class="text-sm text-gray-900 flex items-center justify-center mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg"  width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M6 5a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2v-14z"></path><path d="M11 4h2"></path><path d="M12 17v.01"></path></svg> 
                                ${medical.phone}
                            </div>
                        </div>
                        <a href="${baseURL}/appointment/${medical.id}?medicalUnit=${$("#medical_unit").value}" class="button_secondary rounded py-2 px-4 mt-4">${addAppointmentText}</a>
                    </div>
                </div>   
            `;
            
            let div       = document.createElement('div');
            div.classList = "col-span-2 md:col-span-1"
            div.innerHTML = rowHTML;

            $("#medicalsContent").append(div); 
        });      
    }else{
        let rowHTML = `<h1 class="text-center text-2xl md:text-3xl m-10 md:m-20">
                            <svg class="mx-auto" xmlns="http://www.w3.org/2000/svg" width="60"  height="60" viewBox="0 0 448 512" fill="currentColor"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-96 55.2C54 332.9 0 401.3 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7c0-81-54-149.4-128-171.1l0 50.8c27.6 7.1 48 32.2 48 62l0 40c0 8.8-7.2 16-16 16l-16 0c-8.8 0-16-7.2-16-16s7.2-16 16-16l0-24c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 24c8.8 0 16 7.2 16 16s-7.2 16-16 16l-16 0c-8.8 0-16-7.2-16-16l0-40c0-29.8 20.4-54.9 48-62l0-57.1c-6-.6-12.1-.9-18.3-.9l-91.4 0c-6.2 0-12.3 .3-18.3 .9l0 65.4c23.1 6.9 40 28.3 40 53.7c0 30.9-25.1 56-56 56s-56-25.1-56-56c0-25.4 16.9-46.8 40-53.7l0-59.1zM144 448a24 24 0 1 0 0-48 24 24 0 1 0 0 48z"/></svg>
                            ${withoutMedicalsSearch}
                        </h1>`;
        let div       = document.createElement('div');
        div.classList = "col-span-2"
        div.innerHTML = rowHTML;

        $("#medicalsContent").append(div); 
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

    let paginationHTML = '<ul class="inline-flex ml-auto items-stretch -space-x-px">';
    
    paginationHTML += '<li class="page-item">';
    paginationHTML += '<button ' + (currentPage === 1 ? ' disabled' : '') + ' class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-[#526270] bg-white border border-gray-300 hover:bg-violet-500 hover:border-y-violet-500 hover:text-white hover:text-gray-700" onclick="changePage(' + (currentPage - 1) + ')"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="18"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round" ><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 6l-6 6l6 6v-12" /></svg></button>';
    paginationHTML += '</li>';

    for (let page = startPage; page <= endPage; page++) {
        paginationHTML += '<li class="page-item' + (currentPage === page ? ' active' : '') + '">';
        paginationHTML += '<button class="flex items-center justify-center text-sm py-2 px-3 leading-tight ' + (currentPage === page ? 'border border-violet-500 bg-violet-500 text-white' : 'text-[#526270] bg-white border hover:bg-violet-500 hover:border-y-violet-500 hover:text-white hover:text-gray-700 border-gray-300 ') + '" onclick="changePage(' + page + ')">' + page + '</button>';
        paginationHTML += '</li>';
    }

    paginationHTML += '<li class="page-item">';
    paginationHTML += '<button ' + (currentPage === totalPages ? ' disabled' : '') + ' class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-[#526270] bg-white border border-gray-300 hover:bg-violet-500 hover:border-y-violet-500 hover:text-white hover:text-gray-700" onclick="changePage(' + (currentPage + 1) + ')"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="18"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round" ><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 18l6 -6l-6 -6v12" /></svg></button>';
    paginationHTML += '</li>';

    paginationHTML += '</ul>';

    var temp       = document.createElement('div');
    temp.innerHTML = (paginationHTML);

    $("#pagination").appendChild(temp.childNodes[0]); 
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

window.addEventListener('load', (event) => {
    getPagination(currentPage);
    
    $("#medical_unit").addEventListener("change", () => {
        getPagination(currentPage);
    });

    $("#name").addEventListener("keyup", () => {
        getPagination(currentPage);
    });

    $("#specialty").addEventListener("change", () => {
        getPagination(currentPage);
    });
}); 