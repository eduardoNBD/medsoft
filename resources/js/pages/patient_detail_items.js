//----------------------------------------Supplies-----------------------------------------
function getPaginationSupplies(currentPageSuppliesEncounters){ 
    //const s = '$("#simple-search").value';

    fetch(urlItems+"/?type=supply&page="+currentPageSuppliesEncounters, { 
        headers: { 
            "X-CSRF-Token": $('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json', 
        },   
    })
    .then(res => error419(res))
    .then((json) => { 
        if(json.status){
            //$("#total").innerHTML = json.items.total;
            totalPagesSupplies = Math.ceil(json.pagination.total_items/json.pagination.per_page);
            currentPageSuppliesEncounters = parseInt(json.pagination.current_page);
            
            $("#paginationSuppliesEncounters").innerHTML = "";
             
            if(totalPagesSupplies > 1){
                setPagesSupplies(currentPageSuppliesEncounters, totalPagesSupplies);
            }

            setRowsSupplies(json.items);
        }else{
            
        }
    })
    .catch((err) => console.error("error:", err)); 
}

function setRowsSupplies(data){ 
    $("#encountersSuppliesTable tbody").innerHTML = "";

    if(data.length){
        data.forEach(supply => {  
            let rowHTML = ` 
                <td class="px-2 md:px-4 py-3 font-medium table_text flex">
                    ${supply.name} 
                </td> 
                <td class="px-2 md:px-4 py-3 font-medium table_text"> 
                    ${supply.qty}
                </td>
                <td class="px-2 md:px-4 py-3 font-medium table_text"> 
                    ${supply.total_price}
                </td>`;
            
            let tr       = document.createElement('tr');
            tr.classList = "border-b border-gray-200"
            tr.innerHTML = rowHTML;

            $("#encountersSuppliesTable tbody").append(tr); 
        });      
    }else{
        let rowHTML = `<tr><td colspan="5"><h1 class="text-center text-3xl m-20 table_text">${withoutSupplies}</h1></td></tr>`;
        let tr       = document.createElement('tr');
        tr.classList = "border-b border-gray-200"
        tr.innerHTML = rowHTML;

        $("#encountersSuppliesTable tbody").append(tr); 
    }       
}

function setPagesSupplies(currentPageSuppliesEncounters, totalPagesSupplies) {  
    const pagesToShow = 2;  
    const maxPagesToShow = pagesToShow * 2 + 1; 

    let startPage = Math.max(1, currentPageSuppliesEncounters - pagesToShow);
    let endPage = Math.min(totalPagesSupplies, currentPageSuppliesEncounters + pagesToShow);

    if (currentPageSuppliesEncounters - pagesToShow <= 1) {
        endPage = Math.min(startPage + maxPagesToShow - 1, totalPagesSupplies);
    }

    if (currentPageSuppliesEncounters + pagesToShow >= totalPagesSupplies) {
        startPage = Math.max(endPage - maxPagesToShow + 1, 1);
    }

    startPage = Math.max(1, startPage);
    endPage = Math.min(totalPagesSupplies, endPage); 

    let paginationHTML = ` 
        <li class="page-item">
            <button ${currentPageSuppliesEncounters === 1 ? 'disabled' : ''} 
                class="flex items-center justify-center text-sm py-2 px-3 pagination_text pagination_background border border-gray-300" 
                onclick="changePageSupplies(${currentPageSuppliesEncounters - 1})">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M14 6l-6 6l6 6v-12" />
                </svg>
            </button>
        </li>`;

    for (let page = startPage; page <= endPage; page++) {
        paginationHTML += `
            <li class="page-item${currentPageSuppliesEncounters === page ? ' active' : ''}">
                <button 
                    class="flex items-center justify-center text-sm py-[7px] px-3 border border-gray-300 ${
                        currentPageSuppliesEncounters === page 
                            ? 'pagination_background_active text-white' 
                            : 'pagination_text pagination_background'
                    }" 
                    onclick="changePageSupplies(${page})">
                    ${page}
                </button>
            </li>`;
    }

    paginationHTML += `
            <li class="page-item">
                <button ${currentPageSuppliesEncounters === totalPagesSupplies ? 'disabled' : ''} 
                    class="flex items-center justify-center text-sm py-2 px-3 pagination_text pagination_background border border-gray-300" 
                    onclick="changePageSupplies(${currentPageSuppliesEncounters + 1})">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M10 18l6 -6l-6 -6v12" />
                    </svg>
                </button>
            </li>`;
 
    const ul = document.createElement('ul');
    ul.innerHTML = paginationHTML;
    ul.classList = "inline-flex ml-auto items-stretch -space-x-px";

    $("#paginationSuppliesEncounters").append(ul);
}

function changePageSupplies(page)
{
    currentPageSuppliesEncounters = page;
    getPaginationSupplies(currentPageSuppliesEncounters);
    //const s = $("#simple-search").value;
    //window.history.pushState({}, title, currentURL+currentPageSuppliesEncounters+"?s="+s);
}

function search(){  
    //const s = $("#simple-search").value;
    //window.history.pushState({}, title, currentURL+currentPageSuppliesEncounters+"?s="+s);
    getPaginationSupplies(currentPageSuppliesEncounters);
}

//----------------------------------------Services-----------------------------------------

function getPaginationServices(currentPageServicesEncounters){ 
    //const s = '$("#simple-search").value';

    fetch(urlItems+"/?type=service&page="+currentPageServicesEncounters, { 
        headers: { 
            "X-CSRF-Token": $('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json', 
        },   
    })
    .then(res => error419(res))
    .then((json) => { 
        if(json.status){
            //$("#total").innerHTML = json.items.total;
            totalPagesServices = Math.ceil(json.pagination.total_items/json.pagination.per_page);
            currentPageServicesEncounters = parseInt(json.pagination.current_page);
            
            $("#paginationServicesEncounters").innerHTML = "";
             
            if(totalPagesServices > 1){
                setPagesServices(currentPageServicesEncounters, totalPagesServices);
            }

            setRowsServices(json.items);
        }else{
            
        }
    })
    .catch((err) => console.error("error:", err)); 
}

function setRowsServices(data){ 
    $("#encountersServicesTable tbody").innerHTML = "";

    if(data.length){
        data.forEach(supply => {  
            let rowHTML = ` 
                <td class="px-2 md:px-4 py-3 font-medium table_text flex">
                    ${supply.name} 
                </td> 
                <td class="px-2 md:px-4 py-3 font-medium table_text"> 
                    ${supply.qty}
                </td>
                <td class="px-2 md:px-4 py-3 font-medium table_text"> 
                    ${supply.total_price}
                </td>`;
            
            let tr       = document.createElement('tr');
            tr.classList = "border-b border-gray-200"
            tr.innerHTML = rowHTML;

            $("#encountersServicesTable tbody").append(tr); 
        });      
    }else{
        let rowHTML = `<tr><td colspan="5"><h1 class="text-center text-3xl m-20 table_text">${withoutServices}</h1></td></tr>`;
        let tr       = document.createElement('tr');
        tr.classList = "border-b border-gray-200"
        tr.innerHTML = rowHTML;

        $("#encountersServicesTable tbody").append(tr); 
    }       
}

function setPagesServices(currentPageServicesEncounters, totalPagesServices) {  
    const pagesToShow = 2;  
    const maxPagesToShow = pagesToShow * 2 + 1; 

    let startPage = Math.max(1, currentPageServicesEncounters - pagesToShow);
    let endPage = Math.min(totalPagesServices, currentPageServicesEncounters + pagesToShow);

    if (currentPageServicesEncounters - pagesToShow <= 1) {
        endPage = Math.min(startPage + maxPagesToShow - 1, totalPagesServices);
    }

    if (currentPageServicesEncounters + pagesToShow >= totalPagesServices) {
        startPage = Math.max(endPage - maxPagesToShow + 1, 1);
    }

    startPage = Math.max(1, startPage);
    endPage = Math.min(totalPagesServices, endPage);

    let paginationHTML = ` 
        <li class="page-item">
            <button ${currentPageServicesEncounters === 1 ? 'disabled' : ''} 
                class="flex items-center justify-center text-sm py-2 px-3 pagination_text pagination_background border border-gray-300" 
                onclick="changePageServices(${currentPageServicesEncounters - 1})">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M14 6l-6 6l6 6v-12" />
                </svg>
            </button>
        </li>`;

    for (let page = startPage; page <= endPage; page++) {
        paginationHTML += `
            <li class="page-item${currentPageServicesEncounters === page ? ' active' : ''}">
                <button 
                    class="flex items-center justify-center text-sm py-[7px] px-3 border border-gray-300 ${
                        currentPageServicesEncounters === page 
                            ? 'pagination_background_active text-white' 
                            : 'pagination_text pagination_background'
                    }" 
                    onclick="changePageServices(${page})">
                    ${page}
                </button>
            </li>`;
    }

    paginationHTML += `
            <li class="page-item">
                <button ${currentPageServicesEncounters === totalPagesServices ? 'disabled' : ''} 
                    class="flex items-center justify-center text-sm py-2 px-3 pagination_text pagination_background border border-gray-300" 
                    onclick="changePageServices(${currentPageServicesEncounters + 1})">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M10 18l6 -6l-6 -6v12" />
                    </svg>
                </button>
            </li>`;
 
    const ul = document.createElement('ul');
    ul.innerHTML = paginationHTML;
    ul.classList = "inline-flex ml-auto items-stretch -space-x-px";

    $("#paginationServicesEncounters").append(ul); 
}

function changePageServices(page)
{
    currentPageServicesEncounters = page;
    getPaginationServices(currentPageServicesEncounters);
    //const s = $("#simple-search").value;
    //window.history.pushState({}, title, currentURL+currentPageServicesEncounters+"?s="+s);
}

function search(){  
    //const s = $("#simple-search").value;
    //window.history.pushState({}, title, currentURL+currentPageServicesEncounters+"?s="+s);
    getPaginationServices(currentPageServicesEncounters);
}