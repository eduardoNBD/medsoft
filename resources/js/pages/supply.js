const form = $("#form_supply");   
const role = $("#role");

function handleChangeImage(){
    $("#img-supply").src = URL.createObjectURL(event.target.files[0]);
    $("#delMain").classList.remove("hidden");
}

$("#delMain").addEventListener("click",(event) => {
    $("#img-supply").src = defaultImg;
    $("#delMain").classList.add("hidden");
    $("#imgSupply").value = "";

    if($("#maindeleted")){
        $("#maindeleted").checked = true;
    }
});

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
 