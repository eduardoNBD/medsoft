const form = $("#form"); 
const marital_status = $("#marital_status");
const smoking = $("#smoking");
const passive_smoking = $("#passive_smoking");
const alcohol_usage = $("#alcohol_usage");
const has_allergies = $("#has_allergies");
const has_surgeries = $("#has_surgeries");
const drug_usage = $("#drug_usage");
const urinary_incontinence = $("#urinary_incontinence");
const has_family_diseases = $("#has_family_diseases");
const has_vih_test = $("#has_vih_test");
const has_insurance = $("#has_insurance");
const has_had_sex = $("#has_had_sex");
const sexual_pain = $("#sexual_pain");
const metrorrhagia = $("#metrorrhagia");
const leukorrhea = $("#leukorrhea");
const pruritus = $("#pruritus");
const urinary_incontinence_treatement = $("#urinary_incontinence_treatement");
const has_blood_transfusion = $("#has_blood_transfusion");

marital_status.addEventListener("change", () => {
    if(marital_status.value == "single" || marital_status.value == ""){
        $("#spouse_occupation_row").classList.add("hidden");
    }else{ 
        $("#spouse_occupation_row").classList.remove("hidden");
    }
});

smoking.addEventListener("change", () => {
    if(smoking.checked || passive_smoking.checked ){
        $("#smoking_details_row").classList.remove("hidden");
    }else{ 
        $("#smoking_details_row").classList.add("hidden");
    }
});

passive_smoking.addEventListener("change", () => {
    if(smoking.checked || passive_smoking.checked ){
        $("#smoking_details_row").classList.remove("hidden");
    }else{ 
        $("#smoking_details_row").classList.add("hidden");
    }
});

alcohol_usage.addEventListener("change", () => {
    if(alcohol_usage.checked){
        $("#alcohol_details_row").classList.remove("hidden");
    }else{
        $("#alcohol_details_row").classList.add("hidden");
    }
});

has_allergies.addEventListener("change", () => {
    if(has_allergies.checked){
        $("#allergies_row").classList.remove("hidden");
    }else{ 
        $("#allergies_row").classList.add("hidden");
    }
});

has_surgeries.addEventListener("change", () => {
    if(has_surgeries.checked){
        $("#surgery_details_row").classList.remove("hidden");
    }else{ 
        $("#surgery_details_row").classList.add("hidden");
    }
});

drug_usage.addEventListener("change", () => {
    if(drug_usage.checked){
        $(".drug_details_row").forEach(element => {
            element.classList.remove("hidden");
        });
    }else{ 
        $(".drug_details_row").forEach(element => {
            element.classList.add("hidden");
        });
    }
});

urinary_incontinence.addEventListener("change", () => {
    if(urinary_incontinence.checked){
        $(".urinary_incontinence_details_row").forEach(element => {
            element.classList.remove("hidden");
        });
    }else{ 
        $(".urinary_incontinence_details_row").forEach(element => {
            element.classList.add("hidden");
        });
    }
});

has_family_diseases.addEventListener("change", () => {
    if(has_family_diseases.checked){
        $("#family_diseases_details_row").classList.remove("hidden");
    }else{ 
        $("#family_diseases_details_row").classList.add("hidden");
    }
});

has_vih_test.addEventListener("change", () => {
    if(has_vih_test.checked){
        $(".has_vih_test_row").forEach(element => {
            element.classList.remove("hidden");
        });
    }else{ 
        $(".has_vih_test_row").forEach(element => {
            element.classList.add("hidden");
        });
    }
});

has_insurance.addEventListener("change", () => {
    if(has_insurance.checked){
        $(".has_insurance_row").forEach(element => {
            element.classList.remove("hidden");
        });
    }else{ 
        $(".has_insurance_row").forEach(element => {
            element.classList.add("hidden");
        });
    }
}); 

has_had_sex.addEventListener("change", () => {
    if(has_had_sex.checked){
        $(".has_had_sex_row").forEach(element => {
            element.classList.remove("hidden");
        });
    }else{ 
        $(".has_had_sex_row").forEach(element => {
            element.classList.add("hidden");
        });
    }
}); 

urinary_incontinence_treatement.addEventListener("change", ()=> {
    if(urinary_incontinence_treatement.checked){
        $(".urinary_incontinence_treatement_row").classList.remove("hidden"); 
    }else{ 
        $(".urinary_incontinence_treatement_row").classList.add("hidden");
    }
});

has_blood_transfusion.addEventListener("change", ()=> {
    if(has_blood_transfusion.checked){
        $(".transfusion_row").classList.remove("hidden"); 
    }else{ 
        $(".transfusion_row").classList.add("hidden");
    }
});

if(gender == "female"){
    sexual_pain.addEventListener("change", ()=> {
        if(sexual_pain.checked){
            $(".sexual_pain_row").forEach(element => {
                element.classList.remove("hidden");
            });
        }else{ 
            $(".sexual_pain_row").forEach(element => {
                element.classList.add("hidden");
            });
        }
    });
    
    metrorrhagia.addEventListener("change", ()=> {
        if(metrorrhagia.checked){
            $(".metrorrhagia_row").classList.remove("hidden"); 
        }else{ 
            $(".metrorrhagia_row").classList.add("hidden");
        }
    });
    
    leukorrhea.addEventListener("change", ()=> {
        if(leukorrhea.checked){
            $(".leukorrhea_row").classList.remove("hidden"); 
        }else{ 
            $(".leukorrhea_row").classList.add("hidden");
        }
    });
    
    pruritus.addEventListener("change", ()=> {
        if(pruritus.checked){
            $(".pruritus_row").classList.remove("hidden"); 
        }else{ 
            $(".pruritus_row").classList.add("hidden");
        }
    });
}

form.addEventListener("submit", (event) => { 

    form.querySelectorAll("label").forEach(element => {
        element.classList.remove("text_error");
    });

    form.querySelectorAll("input,select,textarea").forEach(element => {
        element.classList.remove("border-red-500");
    });

    form.querySelectorAll("small").forEach(element => {
        element.innerHTML = "";
    });
    
    showLoader();

    event.preventDefault();

    const data = new FormData(event.target);   
    
    if($("#last_drug_usage").value){
        let dateInput = $("#last_drug_usage").value.split("/");

        data.set("last_drug_usage",`${dateInput[2]}-${dateInput['1']}-${dateInput['0']}`);
    }

    if($("#vih_last_test_date").value){
        let dateInput = $("#vih_last_test_date").value.split("/");

        data.set("vih_last_test_date",`${dateInput[2]}-${dateInput['1']}-${dateInput['0']}`);
    }

    if($("#last_sex_with_partner").value){
        let dateInput = $("#last_sex_with_partner").value.split("/");

        data.set("last_sex_with_partner",`${dateInput[2]}-${dateInput['1']}-${dateInput['0']}`);
    }

    if($("#last_sex_with_other").value){
        let dateInput = $("#last_sex_with_other").value.split("/");

        data.set("last_sex_with_other",`${dateInput[2]}-${dateInput['1']}-${dateInput['0']}`);
    }

    if($("#last_blood_transfusion").value){
        let dateInput = $("#last_blood_transfusion").value.split("/");

        data.set("last_blood_transfusion",`${dateInput[2]}-${dateInput['1']}-${dateInput['0']}`);
    }

    if(gender == "female"){
        if($("#last_menstrual").value){
            let dateInput = $("#last_menstrual").value.split("/");

            data.set("last_menstrual",`${dateInput[2]}-${dateInput['1']}-${dateInput['0']}`);
        }
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
            //form.reset();  
            location.href = redirect+"?msg="+json.message+"_success"; 
        } else{ 
            if(typeof json.message == "object"){
                Object.keys(json.message).forEach(key => {  
                   form.querySelector(`#${key}_message`).innerHTML = json.message[key];
                   form.querySelector(`#${key}`)?.classList.add("border-red-500");
                   form.querySelector(`#${key}+label`)?.classList.add("text_error");
                   form.querySelector(`[for="${key}"]`)?.classList.add("text_error");
                });
            }else{
                createAlert(json.message, "error")
            }
        }
    })
    .catch((err) => { hideLoader(); console.error("error:", err)});
});

window.addEventListener("load", () => {
    marital_status.trigger("change");
    smoking.trigger("change");
    passive_smoking.trigger("change");
    alcohol_usage.trigger("change");
    has_allergies.trigger("change");
    has_surgeries.trigger("change");
    drug_usage.trigger("change");
    urinary_incontinence.trigger("change");
    has_family_diseases.trigger("change");
    has_vih_test.trigger("change");
    has_insurance.trigger("change");
    has_had_sex.trigger("change");
    urinary_incontinence_treatement.trigger("change");
    has_blood_transfusion.trigger("change");

    if(gender == "female"){
        sexual_pain.trigger("change");
        metrorrhagia.trigger("change");
        leukorrhea.trigger("change");
        pruritus.trigger("change");
    }

    $("textarea").forEach(element =>{
        element.addEventListener('input', () => {
            element.style.height = 'auto'; // Restablece la altura
            element.style.minHeight = "62px";
            element.style.height = `${element.scrollHeight+5}px`; // Ajusta según el contenido
        });

        element.trigger("input");
    })
});