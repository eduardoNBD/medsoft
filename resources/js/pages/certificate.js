const form = $("#form_certificate");  
const doctor = $("#doctor");

form.addEventListener("submit", (event) => {
    $("#doctor").disabled = false;
    $("#patient").disabled = false;

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

    if($("#expires_at").value){
        const expires_at  = $("#expires_at").value.split("/");

        data.set("expires_at",`${expires_at[2]}-${expires_at[1]}-${expires_at[0]}`);
    }
    
    data.set("content",editor.getHTMLCode());
   
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
            location.href = redirect+"?msg="+json.message+"_success"; 
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

doctor.addEventListener('change', () => {  
    $("#medical_unit").innerHTML = "";
    $("#patient").innerHTML = "";

    if(doctor.value){
        fetch(urlGet+doctor.value, {   
            headers: { 
                "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },  
        })
        .then(res => error419(res))
        .then((json) => {
            hideLoader();
            if(json.status){
                $("#medical_unit").innerHTML = `<option></option>${json.medical_units.map(row =>
                    `<option ${medical_unit == row.id ? 'selected' : ''} value="${row.id}">${row.name}</option>`
                )}`;

                $("#patient").innerHTML = `<option></option>${json.patients.map(row =>
                    `<option ${patient == row.patient_id ? 'selected' : ''} value="${row.patient_id}">${row.fullname}</option>`
                )}`;
            } 
        })
        .catch((err) => { hideLoader(); console.error("error:", err)});
    }
}); 

window.addEventListener('load', () => {  
    doctor.trigger("change");
}); 
 