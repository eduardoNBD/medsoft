const formprofile = $("#formprofile");
const formuser    = $("#formuser");
const formpassword = $("#formpassword");
const documentform = $("#documentform");

function showTab(item,button){ 
    $(".tabList button").forEach(element => {
        element.classList.remove("link_text_active");
        element.classList.remove("link_background_active");
        element.classList.add("link_text","link_background");
    });

    $(".tab-item").forEach(element => {
        element.classList.add("hidden");
    });
     
    $(item).classList.remove("hidden");

    $(".tabList ."+button).forEach(element => {
        element.classList.add("link_background_active","link_text_active");
    }); 

    window.history.pushState({}, title, urlTab+item);
}  

formprofile.addEventListener("submit", (e) => {
    e.preventDefault();

    formprofile.querySelectorAll("label").forEach(element => {
        element.classList.remove("text_error");
    });

    formprofile.querySelectorAll("input,select").forEach(element => {
        element.classList.remove("border-red-500");
    });

    formprofile.querySelectorAll("small").forEach(element => {
        element.innerHTML = "";
    });
    
    showLoader();

    const data = new FormData(formprofile);
    
    if($("#dob").value){
        const dob  = $("#dob").value.split("/");

        data.set("dob",`${dob[2]}-${dob['1']}-${dob['0']}`);
    }
    
    fetch(urlProfile, {
        method: "POST",
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
        }else{
            if(typeof json.message == "object"){
                Object.keys(json.message).forEach(key => { 
                   formprofile.querySelector(`#${key}_message`).innerHTML = json.message[key];
                   formprofile.querySelector(`#${key}`)?.classList.add("border-red-500");
                   formprofile.querySelector(`#${key}+label`)?.classList.add("text_error");
                });
            }else{
                createAlert(json.message, "error")
            }
        }
    })
    .catch(error => {
        createAlert(error,"error");
        hideLoader();
    });

});

formuser.addEventListener("submit", (e) => {
    e.preventDefault();

    formuser.querySelectorAll("label").forEach(element => {
        element.classList.remove("text_error");
    });

    formuser.querySelectorAll("input,select").forEach(element => {
        element.classList.remove("border-red-500");
    });

    formuser.querySelectorAll("small").forEach(element => {
        element.innerHTML = "";
    });
    
    showLoader();

    const data = new FormData(formuser);
    
    fetch(urlUser, {
        method: "POST",
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
        }else{
            if(typeof json.message == "object"){
                Object.keys(json.message).forEach(key => {  
                   formuser.querySelector(`#${key}_message`).innerHTML = json.message[key];
                   formuser.querySelector(`#${key}`)?.classList.add("border-red-500");
                   formuser.querySelector(`#${key}+label`)?.classList.add("text_error");
                });
            }else{
                createAlert(json.message, "error")
            }
        }
    })
    .catch(error => {
        createAlert(error,"error");
        hideLoader();
    });
});

formpassword.addEventListener("submit", () => { 
    formpassword.querySelectorAll("label").forEach(element => {
      element.classList.remove("text_error");
    });
  
    formpassword.querySelectorAll("input,select").forEach(element => {
        element.classList.remove("border-red-500");
    });
  
    formpassword.querySelectorAll("small").forEach(element => {
        element.innerHTML = "";
    });
  
    showLoader();
  
    event.preventDefault();
  
    const data = new FormData(formpassword);    
  
    fetch(urlPassword, {  
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
            formpassword.reset();
        } else{ 
            if(typeof json.message == "object"){
                Object.keys(json.message).forEach(key => { 
                  formpassword.querySelector(`#${key}_message`).innerHTML = json.message[key];
                  formpassword.querySelector(`#${key}`)?.classList.add("border-red-500");
                  formpassword.querySelector(`#${key}+label`)?.classList.add("text_error");
                });
            }else{
                createAlert(json.message, "error")
            }
        }
    })
    .catch((err) => { hideLoader(); console.error("error:", err)});
});

documentform.addEventListener("submit", (e) => {
    e.preventDefault();

    documentform.querySelectorAll("label").forEach(element => {
        element.classList.remove("text_error");
    });

    documentform.querySelectorAll("input,select").forEach(element => {
        element.classList.remove("border-red-500");
    });

    documentform.querySelectorAll("small").forEach(element => {
        element.innerHTML = "";
    });
    
    showLoader();

    const data = new FormData(documentform);
    
    fetch(urlDocument, {
        method: "POST",
        body: data,
        headers: { 
            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
    })
    .then(res => error419(res))
    .then((json) => { 
        hideLoader();

        if(json.status){
            closeModal('#newDocument');
            createAlert(json.message,"success");

            setTimeout(() => { 
                location.reload();
            }, 2000);
        }else{
            if(typeof json.message == "object"){
                Object.keys(json.message).forEach(key => {  
                   documentform.querySelector(`#${key}_message`).innerHTML = json.message[key];
                   documentform.querySelector(`#${key}`)?.classList.add("border-red-500");
                   documentform.querySelector(`#${key}+label`)?.classList.add("text_error");
                });
            }else{
                createAlert(json.message, "error")
            }
        }
    })
    .catch(error => {
        createAlert(error,"error");
        hideLoader();
    });
});

window.addEventListener("load", (e) => {
    const fragment = window.location.hash;
    const cleanFragment = fragment.replace('#', '');

    if(cleanFragment){
        showTab(`#${cleanFragment}`,cleanFragment.replace("tab-",""));
    }else{
        window.history.pushState({}, title, urlTab+"#tab-appointments");
    }
});