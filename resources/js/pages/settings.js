const pricesForm = $("#pricesForm");
const specialtiesForm = $("#specialtiesForm");
const colorsForms = $("#colorsForms");
const logosForms = $("#logosForms");

function changeLight(){ 
    $("#logo_light_img").src = URL.createObjectURL(event.target.files[0]);
    $("#del_logo_light").classList.remove("hidden");
}

function changeDark(){ 
    $("#logo_dark_img").src = URL.createObjectURL(event.target.files[0]);
    $("#del_logo_dark").classList.remove("hidden");
}

function changeFaviconLight(){ 
    $("#logo_favicon_light_img").src = URL.createObjectURL(event.target.files[0]);
    $("#del_logo_favicon_light").classList.remove("hidden");
}

function changeFaviconDark(){ 
    $("#logo_favicon_dark_img").src = URL.createObjectURL(event.target.files[0]);
    $("#del_logo_favicon_dark").classList.remove("hidden");
}

function changePublic(){ 
    $("#logo_public_img").src = URL.createObjectURL(event.target.files[0]);
    $("#del_logo_public").classList.remove("hidden");
}

function delLight(){
    $("#logo_light_img").src = logo_light;
    $("#del_logo_light").classList.add("hidden");

    if(currentLogos.logo_light){
        $("#del_logo_light_check").value = 1;
    }

    $("#logo_light").value = ""; 
}

function delDark(){
    $("#logo_dark_img").src = logo_dark;
    $("#del_logo_dark").classList.add("hidden");

    if(currentLogos.logo_dark){
        $("#del_logo_dark_check").value = 1;
    }

    $("#logo_dark").value = ""; 
}

function delLight(){
    $("#logo_light_img").src = logo_light;
    $("#del_logo_light").classList.add("hidden");

    if(currentLogos.logo_light){
        $("#del_logo_light_check").value = 1;
    }

    $("#logo_light").value = ""; 
}

function delDark(){
    $("#logo_dark_img").src = logo_dark;
    $("#del_logo_dark").classList.add("hidden");

    if(currentLogos.logo_dark){
        $("#del_logo_dark_check").value = 1;
    }

    $("#logo_dark").value = ""; 
}

function delFaviconLight(){
    $("#logo_favicon_light_img").src = logo_favicon_light;
    $("#del_logo_favicon_light").classList.add("hidden");

    if(currentLogos.logo_favicon_light){
        $("#del_logo_favicon_light_check").value = 1;
    }

    $("#logo_favicon_light").value = ""; 
}

function delFaviconDark(){
    $("#logo_favicon_dark_img").src = logo_favicon_dark;
    $("#del_logo_favicon_dark").classList.add("hidden");

    if(currentLogos.logo_favicon_dark){
        $("#del_logo_favicon_dark_check").value = 1;
    }

    $("#logo_favicon_dark").value = ""; 
}

function delPublic(){
    $("#logo_public_img").src = logo_public;
    $("#del_logo_public").classList.add("hidden");

    if(currentLogos.logo_public){
        $("#del_logo_public_check").value = 1;
    }

    $("#logo_public").value = ""; 
}

function showTab(item,button){ 
    $("#tabList button").forEach(element => {
        element.classList = 'h-full inline-flex items-center px-4 py-3 rounded-t-lg w-full tab_background tab_text';
    });

    $(".tab-item").forEach(element => {
        element.classList.add("hidden");
    });

    $(item).classList.remove("hidden");
    button.classList = 'h-full inline-flex items-center px-4 py-3 rounded-t-lg w-full tab_background_active tab_text_active';
} 

pricesForm.addEventListener("submit",(event) => { 
    event.preventDefault();

    const data = new FormData(event.target);   
    
    fetch(urlPrices, {  
        method: "post", 
        body: data,
        headers: { 
            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },  
    })
    .then(res => error419(res))
    .then((json) => {
        hideLoader();
         
        if(json.status){ 
            createAlert(json.message,"success");
            setTimeout(() => {
                location.reload(true);    
            }, 1000);
        } else{ 
            createAlert(json.message,"error");
        }
    })
    .catch((err) => { hideLoader(); console.error("error:", err)});
})

specialtiesForm.addEventListener("submit",(event) => { 
    event.preventDefault();

    const data = new FormData(event.target);   
    
    fetch(urlSpecialties, {  
        method: "post", 
        body: data,
        headers: { 
            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },  
    })
    .then(res => error419(res))
    .then((json) => {
        hideLoader();
         
        if(json.status){ 
            createAlert(json.message,"success");
            
            setTimeout(() => {
                location.reload(true);    
            }, 1000);
        } else{ 
            createAlert(json.message,"error");
        }
    })
    .catch((err) => { hideLoader(); console.error("error:", err)});
})

colorsForms.addEventListener("submit",(event) => { 
    event.preventDefault();

    const data = new FormData(event.target);   
    
    fetch(urlColors, {  
        method: "post", 
        body: data,
        headers: { 
            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },  
    })
    .then(res => error419(res))
    .then((json) => {
        hideLoader();
         
        if(json.status){ 
            createAlert(json.message,"success");
            
            setTimeout(() => {
                //location.reload(true);    
            }, 1000);
        } else{ 
            createAlert(json.message,"error");
        }
    })
    .catch((err) => { hideLoader(); console.error("error:", err)});
});

logosForms.addEventListener("submit",(event) => { 
    event.preventDefault();

    const data = new FormData(event.target);   
    
    fetch(urlLogos, {  
        method: "post", 
        body: data,
        headers: { 
            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },  
    })
    .then(res => error419(res))
    .then((json) => {
        hideLoader();
         
        if(json.status){ 
            createAlert(json.message,"success");
            
            setTimeout(() => {
                location.reload(true);    
            }, 1000);
        } else{ 
            createAlert(json.message,"error");
        }
    })
    .catch((err) => { hideLoader(); console.error("error:", err)});
});

function addSpecialty(){ 
    $("#specialtiesForm>.grid.grid-cols-2").innerHTML += '<div class="col-span-2 grid grid-cols-2">'+languages.map( lang => `
        <div class="col-span-1">
            <div class="relative z-0 mb-2 md:mb-4 group mx-2">
                <input onKeyUp="searchValue(event)" type="text" id="new_${lang}" name="lang[${lang}][new]" value="" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="">
                <label for="new_${lang}" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">${nameText}</label>
            </div>
        </div>
    `).join("")+'</div>';
}

function addEncounter(){ 
    $("#pricesForm>.grid.grid-cols-4").innerHTML += '<div class="col-span-4 grid grid-cols-4">'+languages.map( lang => `
        <div class="col-span-1">
            <div class="relative z-0 mb-2 md:mb-4 group mx-2">
                <input onKeyUp="searchValue(event)" type="text" id="new_${lang}" name="lang[${lang}][new]" value="" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="">
                <label for="new_${lang}" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">${nameText}</label>
            </div>
        </div>
    `).join("")+`
        <div class="col-span-1">
            <div class="relative z-0 mb-2 md:mb-4 group mx-2">
                <input type="number" id="new_price" name="key[newPrice]" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="">
                <label for="new_price" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">${priceText}</label>
            </div>
        </div>
        <div class="col-span-1">
            <div class="relative z-0 mb-2 md:mb-4 group mx-2">
                <input type="number" id="new_time" name="key[newTime]" class="block py-2 px-0 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="">
                <label for="new_time" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">${timeText}</label>
            </div>
        </div>
    </div>`;
}

function searchValue(event){
    const rowTarget = event.target.parentElement.parentElement.parentElement;
    const inputEn = rowTarget.querySelector('input[id$="_en"]');
    const inputEs = rowTarget.querySelector('input[id$="_es"]');
    const inputePrice =  rowTarget.querySelectorAll('input[type="number"]');
    
    const newKey = inputEn.value.replace("_en");
     
    inputEn.id = newKey.replaceAll(" ","_").toLowerCase()+"_en";
    inputEs.id = newKey.replaceAll(" ","_").toLowerCase()+"_es";

    inputEn.name = "lang[en]["+newKey.replaceAll(" ","_").toLowerCase()+"]";
    inputEs.name = "lang[es]["+newKey.replaceAll(" ","_").toLowerCase()+"]";

    if(inputePrice.length){
        inputePrice[0].id = newKey.replaceAll(" ","_").toLowerCase();
        inputePrice[0].name = `key[${newKey.replaceAll(" ","_").toLowerCase()}][price]`;
        inputePrice[1].id = newKey.replaceAll(" ","_").toLowerCase();
        inputePrice[1].name = `key[${newKey.replaceAll(" ","_").toLowerCase()}][time]`;
    }
}


function deleteRow(key,form){ 
    $("#"+form+" #"+key).parentElement.remove();
    $("#"+form+" #"+key+"_time").parentElement.parentElement.remove();
    $("#"+form+" #"+key+"_es").parentElement.remove();
    $("#"+form+" #"+key+"_en").parentElement.remove();
}

window.addEventListener('load', async() => { 
     
});