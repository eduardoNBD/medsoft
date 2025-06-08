const form = $("form");
 
form.addEventListener("submit", (event) => {
    
    form.querySelectorAll("label").forEach(element => {
        element.classList.remove("text_error");
    });

    form.querySelectorAll("input").forEach(element => {
        element.classList.remove("border-red-500");
    });

    form.querySelectorAll("small").forEach(element => {
        element.innerHTML = "";
    });
     
    showLoader();

    event.preventDefault();

    const data = new FormData(event.target); 

    data.append("timezone",Intl.DateTimeFormat().resolvedOptions().timeZone);

    fetch(baseURL+url, {  
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
            location.href = baseURL+"/login?msg="+json.message+"_success";
        } else{ 
            if(typeof json.message == "object"){
                Object.keys(json.message).forEach(key => { 
                    $(`#${key}_message`).innerHTML = json.message[key];
                    $(`#${key}`)?.classList.add("border-red-500");
                    $(`#${key}+label`)?.classList.add("text_error");
                });
            }else{
                createAlert(json.message,"error")
            }
        }
    })
    .catch((err) => { hideLoader(); console.error("error:", err)});
});