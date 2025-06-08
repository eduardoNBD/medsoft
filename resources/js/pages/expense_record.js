const containerItem = $("#itemsContainer");
const form = $("#form_expenseRecord");

function addItem() {
    itemCount++; 

    const div = document.createElement("div"); 

    div.id = `rowItem_${itemCount}`;
    div.classList = "grid grid-cols-12 rowItem border-2 rounded-lg mb-4 p-4 pt-6 md:border-0";
    div.innerHTML = `
        <div class="col-span-12 md:col-span-5 px-2">
            <div class="relative mb-2 group">
                <input type="text" autocomplete="off" name="item_${itemCount}" id="item_${itemCount}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                <label for="item_${itemCount}" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">${textExpense}</label>
                <small id="item_message_${itemCount}" class="text_error pl-2 italic"></small>
            </div> 
        </div>
        <div class="col-span-6 xs:col-span-3 md:col-span-2 px-2">
            <div class="relative z-0 mb-2 group">
                <input type="number" autocomplete="off" name="qty_${itemCount}" id="qty_${itemCount}" value="1" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" onChange="calcTotal()"/>
                <label for="qty_${itemCount}" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">${qtyText}</label>
                <small id="qty_message_${itemCount}" class="text_error pl-2 italic"></small>
            </div>
        </div>
        <div class="col-span-6 xs:col-span-4 md:col-span-2 px-2">
            <div class="relative z-0 mb-2 group">
                <input type="text" autocomplete="off" name="price_${itemCount}" id="price_${itemCount}" value="0" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" onChange="calcTotal()"/>
                <label for="price_${itemCount}" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">${priceText}</label>
                <small id="price_message_${itemCount}" class="text_error pl-2 italic"></small>
            </div>
        </div>
        <div class="col-span-10 xs:col-span-4 md:col-span-2 px-2">
            <div class="relative z-0 mb-2 group">
                <input type="text" autocomplete="off" readonly name="total_${itemCount}" id="total_${itemCount}" class="block py-2.5 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                <label for="total_${itemCount}" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Total</label>
                <small id="total_message_${itemCount}" class="text_error pl-2 italic"></small>
            </div>
        </div>
        <div class="col-span-2 xs:col-span-1 px-2">
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
    const itemInputs = Array.from(document.querySelectorAll(`input[name^="item_"]:not([id="item_${inputID}"])`))
    let exist        = false;
    
    for (let element of itemInputs) {
        if (element.value === inp.value) { 
            $(`#qty_${element.id.replace("item_","")}`).value ++;
            exist = true;
            break; 
        }
    } 
    
    if(!exist){  
        calcTotal();
    }else{ 
        inp.parentElement.parentElement.parentElement.querySelector("button").click();
    }
}

function calcTotal(){
    const rows = document.querySelectorAll(".rowItem");
    let total  = 0;

    rows.forEach(row => {
        const id = row.id.replace("rowItem_","");
        row.querySelector(`#total_${id}`).value = row.querySelector(`#price_${id}`).value*$(`#qty_${id}`).value;
        total+= row.querySelector(`#price_${id}`).value*$(`#qty_${id}`).value
    });
  
    $("#total").value = total;
}

function save(){ 
    form.querySelectorAll("label").forEach(element => {
        element.classList.remove("text_error");
    });

    form.querySelectorAll("input,select").forEach(element => {
        element.classList.remove("border-red-500");
    });

    form.querySelectorAll("small").forEach(element => {
        element.innerHTML = "";
    });
    
    const data  = new FormData();
    const rows  = document.querySelectorAll(".rowItem");
    const items = [];
    let total   = 0;

    rows.forEach(row => { 
        const id = row.id.replace("rowItem_","");
        
        if(row.querySelector(`#item_${id}`).value){
            total+= row.querySelector(`#price_${id}`).value*$(`#qty_${id}`).value;
            
            const object  = JSON.parse(row.querySelector(`#item_${id}`).dataset.object);
            
            object.qty = $(`#qty_${id}`).value;
            object.price = row.querySelector(`#price_${id}`).value;
            items.push(object);
        }
    });  
    
    if($("#date").value){
        const date  = $("#date").value.split("/");
         
        data.set("date",`${date[2]}-${date['1']}-${date['0']}`);
    }

    data.append("items",JSON.stringify(items)); 
    data.append("medical_unit",$("#medical_unit").value); 
    data.append("notes",$("#notes").value);  
    data.append("payment_method",$("#payment_method").value);  

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
            location.href = redirect+"?msg="+json.message+"_success"; 
        }else{
            Object.keys(json.message).forEach(key => { 
                if(key.includes("items.")){ 
                    const match = key.match(/items\.(\d+)\.(.+)/);

                    if (match) {
                        const index = match[1];  
                        const field = match[2];  
                         
                        const inputId = `${field}_${parseInt(index) + 1}`;  
                        const errorId = `${field}_message_${parseInt(index) + 1}`;
                         
                        const inputElement = document.getElementById(inputId);
                        const errorElement = document.getElementById(errorId);

                        if (inputElement) {
                            inputElement.classList.add("border-red-500");
                        }
                        if (errorElement) {
                            errorElement.innerHTML = json.message[key];
                        }
                    }
                }else{
                    form.querySelector(`#${key}_message`).innerHTML = json.message[key];
                    form.querySelector(`#${key}`)?.classList.add("border-red-500");
                    form.querySelector(`#${key}+label`)?.classList.add("text_error");
                }
            });
        }
    })
    .catch((err) => console.error("error:", err)); 
}


window.addEventListener('load', () => { 
    const rows = document.querySelectorAll(".rowItem");
    
    rows.forEach(row => {
        const id = row.id.replace("rowItem_","");
        
        autocomplete(
            row.querySelector(`#item_${id}`),
            items,
            noResultsText,
            setPrice,
            ['name','barcode']
        );
    });
 
    
    calcTotal(); 
});