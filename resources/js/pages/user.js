const form = $("#form_user");   
const role = $("#role");

function handleChangeImage(){
    $("#img-user").src = URL.createObjectURL(event.target.files[0]);
    $("#delMain").classList.remove("hidden");
}

$("#delMain").addEventListener("click",(event) => {
    $("#img-user").src = defaultImg;
    $("#delMain").classList.add("hidden");
    $("#imgUser").value = "";

    if($("#maindeleted")){
        $("#maindeleted").checked = true;
    }
});

role.addEventListener("change",(event) => {
    if(event.target.value == 1 || event.target.value == ""){
        $("#formPatient").classList = "hidden";
        $("#formDoctor").classList = "hidden";
    }else if(event.target.value == 2){ 
        $("#formPatient").classList = "hidden";
        $("#formDoctor").classList = "";
    }else{
        $("#formPatient").classList = "";
        $("#formDoctor").classList = "hidden";
    }
});

form.addEventListener("submit", (event) => {
    
    role.disabled = false;

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
        role.disabled = true;
        if(json.status){ 
            form.reset();  
            location.href = json.redirect+"?msg="+json.message+"_success"; 
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

window.addEventListener('load', function() {
    if(role.value == 1 || role.value == ""){
        $("#formPatient").classList = "hidden";
        $("#formDoctor").classList = "hidden";
    }else if(role.value == 2){ 
        $("#formPatient").classList = "hidden";
        $("#formDoctor").classList = "";
    }else{
        $("#formPatient").classList = "";
        $("#formDoctor").classList = "hidden";
    }
 
    if(doctor && $("#doctor").value == ""){ 
        $("#doctor").value = doctor;
    }
}); 
 