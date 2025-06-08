const containerItem = $("#itemsContainer");
let selectedFiles = [];
let inputsHeaders = [];

function showTab(item,button){ 
    $("#tabList button").forEach(element => {
        element.classList = 'h-full inline-flex items-center px-4 py-3 rounded-t-lg w-full tab_text tab_background';
    });

    $(".tab-item").forEach(element => {
        element.classList.add("hidden");
    });

    $(item).classList.remove("hidden");
    button.classList = 'h-full inline-flex items-center px-4 py-3 rounded-t-lg  w-full tab_text_active tab_background_active';
} 

function addItem() {
    itemCount++; 

    const div = document.createElement("div"); 

    div.id = `rowItem_${itemCount}`;
    div.classList = "grid grid-cols-12 rowItems";
    div.innerHTML = `
        <div class="col-span-5 px-2">
            <div class="relative mb-2 group">
                <input type="text" autocomplete="off" name="item_${itemCount}" id="item_${itemCount}" class="block py-2.5 px-0 w-full text-sm input_text input_border bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                <label for="item_${itemCount}" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">${supply_or_serviceText}</label>
                <small id="item_message_${itemCount}" class="text_error pl-2 italic"></small>
            </div> 
        </div>
        <div class="col-span-2 px-2">
            <div class="relative z-0 mb-2 group">
                <input type="number" autocomplete="off" name="qty_${itemCount}" id="qty_${itemCount}" value="1" min="1" class="block py-2.5 px-0 w-full text-sm input_text input_border bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer" placeholder="" onChange="calcTotal()"/>
                <label for="qty_${itemCount}" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">${qtyText}</label>
                <small id="qty_message_${itemCount}" class="text_error pl-2 italic"></small>
            </div>
        </div>
        <div class="col-span-2 px-2">
            <div class="relative z-0 mb-2 group">
                <input type="text" autocomplete="off" readonly name="price_${itemCount}" id="price_${itemCount}" class="block py-2.5 px-0 w-full text-sm input_text input_border bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                <label for="price_${itemCount}" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">${priceText}</label>
                <small id="price_message_${itemCount}" class="text_error pl-2 italic"></small>
            </div>
        </div>
        <div class="col-span-2 px-2">
            <div class="relative z-0 mb-2 group">
                <input type="text" autocomplete="off" readonly name="total_${itemCount}" id="total_${itemCount}" class="block py-2.5 px-0 w-full text-sm input_text input_border bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                <label for="total_${itemCount}" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Total</label>
                <small id="total_message_${itemCount}" class="text_error pl-2 italic"></small>
            </div>
        </div>
        <div class="col-span-1 px-2">
            <button type="button" class="button_error rounded-md mt-4 p-1" onclick="removeItem(this)">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="16"  height="16"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
            </button>
        </div>
    `;
    
    containerItem.append(div);

    setTimeout(() => {
        autocomplete(
            $(`#item_${itemCount}`),
            items,
            noResultsText,
            setPrice,
            ['name','barcode']
        );
    }, 100);
}

function removeItem(element){
    element.parentElement.parentElement.remove();
    calcTotal();
}

function setPrice(inp){
    const inputID    = inp.id.replace("item_","");
    const itemInputs = Array.from(document.querySelectorAll(`#tab-encounter input[name^="item_"]:not([id="item_${inputID}"])`))
    let exist        = false;
     
    for (let element of itemInputs) {
        if (element.value === inp.value) { 
            const totlaQty = $(`#qty_${element.id.replace("item_","")}`).value+1;
            if(totlaQty <= $(`#tab-encounter [id="qty_${inputID}"]`).max){
                $(`#qty_${element.id.replace("item_","")}`).value =totlaQty;
            }

            exist = true;
            break; 
        }
    }

    if(!exist){
        const object  = JSON.parse(inp.dataset.object);

        $(`#price_${inputID}`).value = object.price;
        $(`#total_${inputID}`).value = $(`#qty_${inputID}`).value*object.price;

        calcTotal();
         
        if(object.remaining){
            $(`#tab-encounter [id="qty_${inputID}"]`).max = object.remaining;

            if($(`#tab-encounter [id="qty_${inputID}"]`).value > object.remaining){
                $(`#tab-encounter [id="qty_${inputID}"]`).value = object.remaining;
            }
        }else{
            $(`#tab-encounter [id="qty_${inputID}"]`).max = '';
        }
    }
    else{ 
        inp.parentElement.parentElement.parentElement.querySelector("button").click();
    }
}

function calcTotal(){
    const rows = document.querySelectorAll(".rowItems");
    let total  = 0;

    rows.forEach(row => {
        const id = row.id.replace("rowItem_","");
        row.querySelector(`#total_${id}`).value = row.querySelector(`#price_${id}`).value*$(`#qty_${id}`).value;
        total+= row.querySelector(`#price_${id}`).value*$(`#qty_${id}`).value
    });

    $("#supplies_or_service").value = total;

    total+= subtotal-$("#discount").value;
    $("#total").value = total;
}

function pay(){
    const data  = new FormData();
    const rows  = document.querySelectorAll(".rowItems");
    const items = [];
    let total   = 0;

    rows.forEach(row => { 
        const id = row.id.replace("rowItem_","");
        
        if(row.querySelector(`#item_${id}`).value){
            total+= row.querySelector(`#price_${id}`).value*$(`#qty_${id}`).value;
            
            const object  = JSON.parse(row.querySelector(`#item_${id}`).dataset.object);
            
            object.qty = $(`#qty_${id}`).value;
            items.push(object);
        }
    });

    data.append("items",JSON.stringify(items));
    data.append("total",total);
    data.append("diagnosis",$("#diagnosis").value);
    data.append("discount",$("#discount").value);
    data.append("notes",$("#notes").value);
    data.append("payment_method",$("#payment_method").value);
    data.append("treatment",$("#treatment").value);

    selectedFiles.forEach((file,index) => { 
        data.append(`files[${index}]`, file); 
        data.append(`filesHeader[${index}]`, inputsHeaders[index].value); 
    });
    
    fetch(urlPay, { 
        method:"POST",
        body: data,
        headers: { 
            "X-CSRF-Token": $('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json', 
        },   
    })
    .then(res => error419(res))
    .then((json) => { 
        if(json.status){ 
            createAlert(json.message,"success")
            setTimeout(() => { 
                location.reload();
            }, 1000);
        }else{
            Object.keys(json.message).forEach(key => { 
                document.querySelector(`#${key}_message`).innerHTML = json.message[key];
                document.querySelector(`#${key}`)?.classList.add("border-red-500");
                document.querySelector(`#${key}+label`)?.classList.add("text_error");
             });
        }
    })
    .catch((err) => console.error("error:", err)); 
}

function save(){
    const data  = new FormData();
    const rows  = document.querySelectorAll(".rowItems");
    const items = [];
    let total   = 0;

    rows.forEach(row => { 
        const id = row.id.replace("rowItem_","");
        
        if(row.querySelector(`#item_${id}`).value){
            total+= row.querySelector(`#price_${id}`).value*$(`#qty_${id}`).value;
            
            const object  = JSON.parse(row.querySelector(`#item_${id}`).dataset.object);
            
            object.qty = $(`#qty_${id}`).value;
            items.push(object);
        }
    }); 

    selectedFiles.forEach((file,index) => { 
        data.append(`files[${index}]`, file); 
        data.append(`filesHeader[${index}]`, inputsHeaders[index].value); 
    });

    data.append("items",JSON.stringify(items));
    data.append("total",total);
    data.append("diagnosis",$("#diagnosis").value);
    data.append("discount",$("#discount").value);
    data.append("notes",$("#notes").value);
    data.append("payment_method",$("#payment_method").value);
    data.append("treatment",$("#treatment").value);

    fetch(url, { 
        method:"POST",
        body: data,
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
                location.reload();
            }, 1000);
        }else{
            
        }
    })
    .catch((err) => console.error("error:", err)); 
}

function showPreview(files) {
    const previewContainer = $("#file-preview");
    previewContainer.innerHTML = ''; // Limpiar los previos existentes
    
    Object.values(files).forEach(file => { 
        const input = document.createElement('input');
        input.classList.add("my-2",'z-10', 'w-[95%]', "top-6", "absolute","header-input", "shadow", "rounded-md", "p-1");
        input.value = file.header ?? "";

        if (file.type.startsWith('image/')) { 
                const imgContainer = document.createElement('div');
                imgContainer.classList.add('relative', 'group', 'overflow-hidden', 'rounded-lg', 'bg-gray-200', 'h-44', 'flex', 'items-center', 'justify-center', 'col-span-1', 'border', "shadow");
                
                const img = document.createElement('img');
                img.src = storegeBase + "/public/" + file.path; 
                img.classList.add('object-cover', 'w-full', 'h-full', 'transition-transform', 'duration-300', 'group-hover:scale-110');
                
                img.addEventListener("click", () => {
                    $("#imgReview img").src = img.src;
                    openModal("#imgReview"); 
                });

                imgContainer.appendChild(input);
                imgContainer.appendChild(img);

                if(enStatus == 1){
                    const deleteButton = document.createElement('button');
                    deleteButton.textContent = 'x';
                    deleteButton.classList.add('absolute', 'top-1', 'right-1', 'rounded-md', 'text-xs', 'px-2', 'py-1', 'button_error');
                    deleteButton.onclick = () => {
                        // Eliminar archivo del array
                        confirmDeleteFile(file.path);
                        currentContent = imgContainer;  
                    };
                    
                    imgContainer.appendChild(deleteButton);
                }else{
                    input.readOnly = "readOnly";
                }

                previewContainer.appendChild(imgContainer); 
        }
        // Vista previa de PDF
        else if (file.type === 'application/pdf') {
            const pdfContainer = document.createElement('div');
            pdfContainer.classList.add('relative', 'group', 'overflow-hidden', 'rounded-lg', 'bg-gray-200', 'h-44', 'flex', 'items-center', 'justify-center', 'col-span-1', 'border', "shadow");
            
            const pdfIcon = document.createElement('div');
            pdfIcon.classList.add('text-4xl', 'text-gray-600');
            pdfIcon.innerHTML = '📄'; // Puedes usar un ícono como este o una imagen de un ícono de PDF
            
            const pdfLink = document.createElement('a');
            pdfLink.href = storegeBase + "/public/" + file.path;
            pdfLink.target = '_blank';
            pdfLink.classList.add('absolute', 'bottom-2', 'text-sm', 'text-blue-600', 'underline');
            pdfLink.textContent = 'Ver PDF';

            pdfContainer.appendChild(input);
            
            if(enStatus == 1){ 
                const deleteButton = document.createElement('button');
                deleteButton.textContent = 'x';
                deleteButton.classList.add('absolute', 'top-1', 'right-1', 'rounded-md', 'text-xs', 'px-2', 'py-1', 'button_error');
                deleteButton.onclick = () => {
                    // Eliminar archivo del array
                    confirmDeleteFile(file.path);
                    currentContent = pdfContainer; 
                }; 

                pdfContainer.appendChild(deleteButton);
            }else{
                input.readOnly = "readOnly";
            }
            pdfContainer.appendChild(pdfIcon);
            pdfContainer.appendChild(pdfLink); 

            previewContainer.appendChild(pdfContainer);
        }

        selectedFiles.push(file.path);
        inputsHeaders.push(input);
    });
}

function deleteFile() {
    const data = new FormData();
    data.append("path",currentFile);

    fetch(delteFileUrl, {
        method: 'POST',
        headers: { 
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Para Laravel
        },
        body: data
    })
    .then(response => response.json())
    .then(json => {
        if(json.status){
            createAlert(json.message,"success");
            closeModal("#deleteModal");

            const index = selectedFiles.indexOf(currentFile);
            
            if (index !== -1) {
                selectedFiles.splice(index, 1); // Eliminar de selectedFiles
                inputsHeaders.splice(index, 1); // Eliminar de inputsHeaders
            }

            currentContent.remove();
        }else{
            createAlert(json.message,"error");
        }
    })
    .catch(error => {
        console.error('Hubo un problema con la solicitud de eliminación:', error);
    });
}

function confirmDeleteFile(path){
    openModal("#deleteModal");
    currentFile = path;
}

$('#files').addEventListener('change', function(event) {
    const files = event.target.files;  // Archivos seleccionados
    const previewContainer = $('#file-preview');
    
    Array.from(files).forEach(file => { 

        const fileReader = new FileReader();
        
        const input = document.createElement('input');
        input.classList.add("my-2",'z-10', 'w-[95%]', "top-6", "absolute","header-input", "shadow", "rounded-md", "p-1");

        if (file.type.startsWith('image/')) {
            fileReader.onload = function(e) {
                const imgContainer = document.createElement('div');
                imgContainer.classList.add('relative', 'group', 'overflow-hidden', 'rounded-lg', 'bg-gray-200', 'h-44', 'flex', 'items-center', 'justify-center', 'col-span-1', 'border', "shadow");
                
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = file.name;
                img.classList.add('object-cover', 'w-full', 'h-full', 'transition-transform', 'duration-300', 'group-hover:scale-110');
                
                img.addEventListener("click", () => {
                    $("#imgReview img").src = img.src;
                    openModal("#imgReview"); 
                });
                
                imgContainer.appendChild(input);
                imgContainer.appendChild(img);

                const deleteButton = document.createElement('button');
                deleteButton.textContent = 'x';
                deleteButton.classList.add('absolute', 'top-1', 'right-1', 'rounded-md', 'text-xs', 'px-2', 'py-1', 'button_error');
                deleteButton.onclick = () => {
                    const index = selectedFiles.findIndex(f => 
                        (f.name && f.name === file.name && f.size === file.size) || f === file.path
                    );
                
                    if (index !== -1) {
                        selectedFiles.splice(index, 1);  // Eliminar archivo de selectedFiles
                        inputsHeaders.splice(index, 1);  // Eliminar el header correspondiente
                    }

                    imgContainer.remove(); // Eliminar la vista previa
                };
                
                imgContainer.appendChild(deleteButton);
                previewContainer.appendChild(imgContainer);
            };
            fileReader.readAsDataURL(file);
        } 
        else if (file.type === 'application/pdf') {
            const pdfContainer = document.createElement('div');
            pdfContainer.classList.add('relative', 'group', 'overflow-hidden', 'rounded-lg', 'bg-gray-200', 'h-44', 'flex', 'items-center', 'justify-center', 'col-span-1', 'border', "shadow");
            
            const pdfIcon = document.createElement('div');
            pdfIcon.classList.add('text-4xl', 'text-gray-600');
            pdfIcon.innerHTML = '📄'; // Puedes usar un ícono como este o una imagen de un ícono de PDF
            
            const pdfLink = document.createElement('a');
            pdfLink.href = URL.createObjectURL(file);
            pdfLink.target = '_blank';
            pdfLink.classList.add('absolute', 'bottom-2', 'text-sm', 'text-blue-600', 'underline');
            pdfLink.textContent = 'Ver PDF';
            
            // Botón de eliminar para el archivo PDF
            const deleteButton = document.createElement('button');
            deleteButton.textContent = 'x';
            deleteButton.classList.add('absolute', 'top-1', 'right-1', 'rounded-md', 'text-xs', 'px-2', 'py-1', 'button_error');
            deleteButton.onclick = () => {
                const index = selectedFiles.findIndex(f => 
                    (f.name && f.name === file.name && f.size === file.size) || f === file.path
                );
            
                if (index !== -1) {
                    selectedFiles.splice(index, 1);  // Eliminar archivo de selectedFiles
                    inputsHeaders.splice(index, 1);  // Eliminar el header correspondiente
                }

                pdfContainer.remove(); // Eliminar la vista previa
            };
                
            pdfContainer.appendChild(input);
            pdfContainer.appendChild(pdfIcon);
            pdfContainer.appendChild(pdfLink);
            pdfContainer.appendChild(deleteButton);
            
            previewContainer.appendChild(pdfContainer);
        }

        selectedFiles.push(file);
        inputsHeaders.push(input);
    });
});

window.addEventListener('load', () => { 
    const rows = document.querySelectorAll(".rowItems");
    
    rows.forEach(row => {
        const id = row.id.replace("rowItem_","");
        
        autocomplete(
            row.querySelector(`#item_${id}`),
            items,
            noResultsText,
            setPrice,
            ['name','barcode']
        );

        setPrice(row.querySelector(`#item_${id}`));
    });

    $("textarea").forEach(element =>{
        element.addEventListener('input', () => {
            element.style.height = 'auto'; // Restablece la altura
            element.style.height = `${element.scrollHeight+5}px`; // Ajusta según el contenido
        });

        element.trigger("input");
    });

    showPreview(currentFiles);
    getPaginationFiles(currentPageFiles);
    getPaginationTreatmentEncounters(currentPageTreatmentsEncounters);
    getPaginationDiagnosisEncounters(currentPageDiagnosisEncounters);
    getPaginationNotesEncounters(currentPageNotesEncounters);
    getPaginationSupplies(currentPageSuppliesEncounters);
    getPaginationServices(currentPageServicesEncounters);
});

