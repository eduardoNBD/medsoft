function getPaginationFiles(currentPageFiles){ 
    //const s = '$("#simple-search").value';

    fetch(urlFiles+currentPageFiles, { 
        headers: { 
            "X-CSRF-Token": $('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json', 
        },   
    })
    .then(res => error419(res))
    .then((json) => { 
        if(json.status){
            //$("#total").innerHTML = json.items.total;
            totalPagesFiles = Math.ceil(json.pagination.total_items/json.pagination.per_page);
            currentPageFiles = parseInt(json.pagination.current_page);
            
            $("#paginationFiles").innerHTML = "";
             
            if(totalPagesFiles > 1){
                setPagesFiles(currentPageFiles, totalPagesFiles);
            }

            setRowsFiles(json.items);
        }else{
            
        }
    })
    .catch((err) => console.error("error:", err)); 
}

function setRowsFiles(data){ 
    $("#filesTable tbody").innerHTML = "";

    if(data.length){
        data.forEach(file => {  
            let rowHTML = ` 
                <td class="px-2 md:px-4 py-3 font-medium table_text flex">
                    <a href="${storegeBase}/public/${file.path}" target="_blank">${file.type == "application/pdf" ? "📄" : "🖼️"}</a> 
                </td> 
                <td class="px-2 md:px-4 py-3 font-medium table_text"> 
                    ${file.header ?? ''}
                </td>
                <td class="px-2 md:px-4 py-3 font-medium table_text"> 
                    ${reformatDate(file.encounter_date)}
                </td>`;
            
            let tr       = document.createElement('tr');
            tr.classList = "border-b border-gray-200"
            tr.innerHTML = rowHTML;

            $("#filesTable tbody").append(tr); 
        });      
    }else{
        let rowHTML = `<tr><td colspan="5"><h1 class="text-center text-3xl m-20 table_text">${withoutFilesSearch}</h1></td></tr>`;
        let tr       = document.createElement('tr');
        tr.classList = "border-b border-gray-200"
        tr.innerHTML = rowHTML;

        $("#filesTable tbody").append(tr); 
    }       
}

function setPagesFiles(currentPageFiles, totalPagesFiles) {  
    const pagesToShow = 2;  
    const maxPagesToShow = pagesToShow * 2 + 1; 

    let startPage = Math.max(1, currentPageFiles - pagesToShow);
    let endPage = Math.min(totalPagesFiles, currentPageFiles + pagesToShow);

    if (currentPageFiles - pagesToShow <= 1) {
        endPage = Math.min(startPage + maxPagesToShow - 1, totalPagesFiles);
    }

    if (currentPageFiles + pagesToShow >= totalPagesFiles) {
        startPage = Math.max(endPage - maxPagesToShow + 1, 1);
    }

    startPage = Math.max(1, startPage);
    endPage = Math.min(totalPagesFiles, endPage); 

    let paginationHTML = ` 
        <li class="page-item">
            <button ${currentPageFiles === 1 ? 'disabled' : ''} 
                class="flex items-center justify-center text-sm py-2 px-3 pagination_text pagination_background border border-gray-300" 
                onclick="changePageFiles(${currentPageFiles - 1})">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M14 6l-6 6l6 6v-12" />
                </svg>
            </button>
        </li>`;

    for (let page = startPage; page <= endPage; page++) {
        paginationHTML += `
            <li class="page-item${currentPageFiles === page ? ' active' : ''}">
                <button 
                    class="flex items-center justify-center text-sm py-[7px] px-3 border border-gray-300 ${
                        currentPageFiles === page 
                            ? 'pagination_background_active text-white' 
                            : 'pagination_text pagination_background'
                    }" 
                    onclick="changePageFiles(${page})">
                    ${page}
                </button>
            </li>`;
    }

    paginationHTML += `
            <li class="page-item">
                <button ${currentPageFiles === totalPagesFiles ? 'disabled' : ''} 
                    class="flex items-center justify-center text-sm py-2 px-3 pagination_text pagination_background border border-gray-300" 
                    onclick="changePageFiles(${currentPageFiles + 1})">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M10 18l6 -6l-6 -6v12" />
                    </svg>
                </button>
            </li>`;
 
    const ul = document.createElement('ul');
    ul.innerHTML = paginationHTML;
    ul.classList = "inline-flex ml-auto items-stretch -space-x-px";

    $("#paginationFiles").append(ul); 
}

function changePageFiles(page)
{
    currentPageFiles = page;
    getPaginationFiles(currentPageFiles);
    //const s = $("#simple-search").value;
    //window.history.pushState({}, title, currentURL+currentPageFiles+"?s="+s);
}

function search(){  
    //const s = $("#simple-search").value;
    //window.history.pushState({}, title, currentURL+currentPageFiles+"?s="+s);
    getPaginationFiles(currentPageFiles);
}