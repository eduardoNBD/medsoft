const form = $("form");
 
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

$('.tab-button').forEach(button => {
    button.addEventListener("click", (e) => {
        const element = button.dataset.element; 
        $("#bg-tab").style.left = `calc(${element*50}% ${element == 0 ? "-" : "+"} 8px)`;

        $('.tab-button').forEach(button => {
            button.classList.remove("text-white"); 
        })

        button.classList.add("text-white");  

        if(element == "0"){
            $("#role").value = 3;
            $("#patientTab").classList.remove("hidden");
            $("#doctorTab").classList.add("hidden");
        }else{
            $("#role").value = 2;
            $("#patientTab").classList.add("hidden");
            $("#doctorTab").classList.remove("hidden"); 
        }
    });
});