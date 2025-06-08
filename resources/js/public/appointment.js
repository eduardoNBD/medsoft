const form = $("#form_appointment");  

form.addEventListener("submit", (event) => {
    
    form.querySelectorAll("label").forEach(element => {
        element.classList.remove("text_error");
    });

    form.querySelectorAll("input,select").forEach(element => {
        element.classList.remove("border-red-500");
    });

    form.querySelectorAll("small").forEach(element => {
        element.innerHTML = "";
    });
    
    showLoader();

    event.preventDefault();

    const data = new FormData(event.target);   
    
    /*if($("#dob").value){
        const dob  = $("#dob").value.split("/");

        data.set("dob",`${dob[2]}-${dob['1']}-${dob['0']}`);
    }*/
    
    fetch(url, {  
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
            form.reset();  
            location.href = redirect+"?msg="+json.message+"_success#tab-appointments"; 
        } else{ 
            if(typeof json.message == "object"){
                Object.keys(json.message).forEach(key => {  
                   form.querySelector(`#${key}_message`).innerHTML = json.message[key];
                   form.querySelector(`#${key}`)?.classList.add("border-red-500");
                   form.querySelector(`#${key}+label`)?.classList.add("text_error");
                });
            }else{
                createAlert(json.message, "error")
            }
        }
    })
    .catch((err) => { hideLoader(); console.error("error:", err)});
});

$("#datepicker").addEventListener('changeDate', (event) => {  
    if(event.detail.date != undefined){
        if(checkDate(event.detail.date)){
            appDate = localeApp == "es" ? reformatDate(event.detail.date, "d c M y") : reformatDate(event.detail.date,"M d, y")
            $("#appDateHour").innerHTML = `${appDate ? appDate : ''}${appHour ? " - "+appHour : ''}`;
            $("input[name='date']").value = reformatDate(event.detail.date, "y-m-d");

            const formData = new FormData();
            formData.append("date",reformatDate(event.detail.date, "y-m-d"));
            //formData.append("id",id);
            formData.append("timezone",Intl.DateTimeFormat().resolvedOptions().timeZone);
            fetch(urlGetAvailable, { 
                method: "POST",
                body: formData,
                headers: { 
                    "X-CSRF-Token": $('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json', 
                },   
            })
            .then(res => error419(res))
            .then((json) => { 
                $("#timetable").innerHTML = "";
                
                if(json.availableSlots.length){
                    $("#timetable").innerHTML = json.availableSlots.map(slot => `
                        <li>
                            <input type="radio" id="${slot.replace(":","-")}" value="${slot}" class="hidden peer" name="timetable" onchange="handleRadioChange(event)">
                            <label for="${slot.replace(":","-")}" class="inline-flex items-center justify-center w-full p-2 text-xs md:text-sm font-medium text-center bg-white border rounded-lg cursor-pointer text-blue-600 border-blue-600 dark:hover:text-white dark:border-blue-500 dark:peer-checked:border-blue-500 peer-checked:border-blue-600 peer-checked:bg-blue-600 hover:text-white peer-checked:text-white hover:bg-blue-500 dark:text-blue-500 dark:bg-gray-900 dark:hover:bg-blue-600 dark:hover:border-blue-600 dark:peer-checked:bg-blue-500">
                                ${slot}
                            </label>
                        </li> 
                    `).join("");
                }
                else{
                    createAlert(withoutAppointmentsSearch,"error");
                    event.detail.datepicker.picker.controls.clearBtn.click();
                    $("#appDateHour").innerHTML = ""; 
                    $("input[name='hour']").value = "";
                    $("input[name='date']").value = "";
                    appDate = "";
                    appHour = "";
                }
            })
            .catch((err) => console.error("error:", err)); 

        }else{ 
            createAlert(date_after,"error");
            event.detail.datepicker.picker.controls.clearBtn.click();
            $("#appDateHour").innerHTML = ""; 
            $("input[name='hour']").value = "";
            $("input[name='date']").value = "";
            appDate = "";
            appHour = "";
            $("#timetable").innerHTML = ""; 
        }
    }
});

function handleRadioChange(event) { 
    appHour = event.target.value.substring(0,5); 
    $("#appDateHour").innerHTML = `${appDate ? appDate : ''}${appHour ? " - "+appHour : ''}`;
    $("input[name='hour']").value = event.target.value.substring(0,5);
} 

$("#allergies").addEventListener('click', (event) => {  
    if($("#allergies").checked){  
        $("#allergies_text_row").classList.remove("hidden");
    }else{  
        $("#allergies_text_row").classList.add("hidden");
    }
});

$("#surgeries").addEventListener('click', (event) => {  
    if($("#surgeries").checked){  
        $("#surgeries_text_row").classList.remove("hidden");
    }else{  
        $("#surgeries_text_row").classList.add("hidden");
    }
});

$("#addictions").addEventListener('click', (event) => {  
    if($("#addictions").checked){  
        $("#addictions_text_row").classList.remove("hidden");
    }else{  
        $("#addictions_text_row").classList.add("hidden");
    }
});

$("#medications").addEventListener('click', (event) => {  
    if($("#medications").checked){  
        $("#medications_text_row").classList.remove("hidden");
    }else{  
        $("#medications_text_row").classList.add("hidden");
    }
});

function setPrice(){
    const price = prices.filter(element => element.key == $("#subject").value)[0].value.replaceAll('"',"");
    const time = times.filter(element => element.key == $("#subject").value+"_time")[0].value.replaceAll('"',"");
    $("#subtotal").value = customNumberFormat(price);
    $("#timeslot").value = time;
}