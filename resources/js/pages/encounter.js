const form = $("#form_encounter");  

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
    
    if($("#dob").value){
        const dob  = $("#dob").value.split("/");

        data.set("dob",`${dob[2]}-${dob['1']}-${dob['0']}`);
    }
    
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
            createAlert(json.message,"success");

            setTimeout(() => {
                location.href = urlEncounter+json.id; 
            }, 3000);
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

function handleRadioChange(event) { 
    appHour = event.target.value.substring(0,5); 
    $("#appDateHour").innerHTML = `${appDate ? appDate : ''}${appHour ? " - "+appHour : ''}`;
    $("input[name='hour']").value = event.target.value.substring(0,5);
} 

$("#doctor").addEventListener('change', (event) => {  
    if(event.target.value != ""){
        //$("#subtotal").value = "$ "+customNumberFormat(doctors.filter(doctors => doctors.id == event.target.value )[0].encounter_price); 
        
        $("#patient").innerHTML = `<option value=""></option>
            ${patients.filter(patient => patient.doctor_id == event.target.value ).map(
                patient => `
                    <option value="${patient.id}">${patient.first_name} ${patient.last_name}</option>
                `
            ).join(",")}`;
        
        const currentDoctor = doctors.find(element => element.id == event.target.value);
          
        $("#medical_unit").innerHTML = `<option value=""></option>
            ${currentDoctor.medical_units.map( medicalunit => 
                `<option value="${medicalunit.id}" ${medicalunit.id == encounter.medical_unit_id ? "selected" : ""}>${medicalunit.name}</option>`
            ).join(",")}`;
    }else{ 
        $("#patient").innerHTML = "";
        $("#first_name").value = "";
        $("#last_name").value  = "";
        $("#email").value      = "";
        $("#phone").value      = "";
        $("#dob").value        = "";
        $("#bloodType").value  = "";
        $("#gender").value     = "";
        $("#language").value     = "";
        
        if($("#usePatientInfoCheck").checked){
            $("#usePatientInfoCheck").checked = false;
        }
        
        $("#usePatientInfo").classList.add("hidden");
        
        const radio = document.querySelector('input[name="timetable"]:checked'); 

        if (radio) {
            radio.checked = false;  
        } 
    }
});
 
$("#patient").addEventListener('change', (event) => { 
    if(event.target.value != ""){
        currentPatient = patients.filter(patients => patients.id == event.target.value )[0];
        $("#usePatientInfo").classList.remove("hidden");
    }else{
        currentPatient = {};
        $("#usePatientInfo").classList.add("hidden");
    }
});

$("#usePatientInfoCheck").addEventListener('click', (event) => {  
    if($("#usePatientInfoCheck").checked){ 
        $("#first_name").value = currentPatient.first_name;
        $("#last_name").value  = currentPatient.last_name;
        $("#email").value      = currentPatient.email;
        $("#phone").value      = currentPatient.phone;
        $("#dob").value        = reformatDate(currentPatient.dob,"d/m/y");
        $("#bloodType").value  = currentPatient.blood_type; 
        $("#gender").value     = currentPatient.gender;
        $("#language").value   = currentPatient.language;
    }else{ 
        $("#first_name").value = "";
        $("#last_name").value  = "";
        $("#email").value      = "";
        $("#phone").value      = "";
        $("#dob").value        = "";
        $("#bloodType").value  = "";
        $("#gender").value     = "";
        $("#language").value     = "";
    }
});

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
    $("#subtotal").value = customNumberFormat(price);
}

window.addEventListener('load', () => {   
    if($("#patient").value != ""){
        currentPatient = patients.find(patients => patients.id == $("#patient").value);
        $("#usePatientInfo").classList.remove("hidden");
    }else{ 
        $("#usePatientInfo").classList.add("hidden");
    } 
    
    if($("#allergies").checked){  
        $("#allergies_text_row").classList.remove("hidden");
    }else{  
        $("#allergies_text_row").classList.add("hidden");
    }
    
    if($("#surgeries").checked){  
        $("#surgeries_text_row").classList.remove("hidden");
    }else{  
        $("#surgeries_text_row").classList.add("hidden");
    }
    
    if($("#addictions").checked){  
        $("#addictions_text_row").classList.remove("hidden");
    }else{  
        $("#addictions_text_row").classList.add("hidden");
    }
    
    if($("#medications").checked){  
        $("#medications_text_row").classList.remove("hidden");
    }else{  
        $("#medications_text_row").classList.add("hidden");
    } 

    if(doctor && $("#doctor").value == ""){ 
        $("#doctor").value = doctor;
        $("#doctor").trigger("change");
    }

    if(currentPatient.id){
        $("#doctor").value = currentPatient.doctor_id;
        $("#doctor").trigger("change");

        setTimeout(() => {
            $("#patient").value = currentPatient.id;
            $("#patient").trigger("change");
        }, 100);
    }
}); 
 