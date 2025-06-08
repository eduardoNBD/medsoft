const formProfile = $("#formProfile");
const formDoctor = $("#formDoctor");
const password_form = $("#password_form");
const schedules_form = $("#schedules_form");

function handleChangeImage(){
    $("#img-user").src = URL.createObjectURL($("#imgUser").files[0]);
    $("#delMain").classList.remove("hidden");

    const data = new FormData();

    data.append("imgUser",$("#imgUser").files[0]);

    changePhoto(data)
}

$("#delMain").addEventListener("click",(event) => {
    $("#img-user").src = defaultUsrImg;
    $("#delMain").classList.add("hidden");
    $("#imgUser").value = "";

    const data = new FormData();

    data.append("imgUser",$("#imgUser").files[0]);
    changePhoto(data)
});

function showTab(item,button){ 
    $("#tabList button").forEach(element => {
        element.classList = 'text-xs inline-flex items-center px-4 py-3 rounded-lg w-full tab_text tab_background';
    });

    $(".tab-item").forEach(element => {
        element.classList.add("hidden");
    });

    $(item).classList.remove("hidden");
    button.classList = 'text-xs inline-flex items-center px-4 py-3 rounded-lg  w-full tab_text_active tab_background_active';
} 

 
function changePhoto(data){
    fetch(urlLogoImage,{
        method:"POST",
        body:data,
        headers: { 
            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },  
    })
    .then(response => response.json())
    .then(json => {
        createAlert(json.message,"success");
        
        setTimeout(() => {
            location.reload();
        }, 1000);
    });
}

function removeAuth(){
  fetch(urlDesAuth)
  .then(response => response.json())
  .then(json => {
    createAlert(json.message,"success");
    
    setTimeout(() => {
      location.reload();
    }, 1000);
  });
}

password_form.addEventListener("submit", () => { 
  password_form.querySelectorAll("label").forEach(element => {
    element.classList.remove("text_error");
  });

  password_form.querySelectorAll("input,select").forEach(element => {
      element.classList.remove("border-red-500");
  });

  password_form.querySelectorAll("small").forEach(element => {
      element.innerHTML = "";
  });

  showLoader();

  event.preventDefault();

  const data = new FormData(password_form);    

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
          password_form.reset();
      } else{ 
          if(typeof json.message == "object"){
              Object.keys(json.message).forEach(key => {  
                password_form.querySelector(`#${key}_message`).innerHTML = json.message[key];
                password_form.querySelector(`#${key}`)?.classList.add("border-red-500");
                password_form.querySelector(`#${key}+label`)?.classList.add("text_error");
              });
          }else{
              createAlert(json.message, "error")
          }
      }
  })
  .catch((err) => { hideLoader(); console.error("error:", err)});
});

formProfile.addEventListener("submit", () => { 
  formProfile.querySelectorAll("label").forEach(element => {
    element.classList.remove("text_error");
  });

  formProfile.querySelectorAll("input,select").forEach(element => {
      element.classList.remove("border-red-500");
  });

  formProfile.querySelectorAll("small").forEach(element => {
      element.innerHTML = "";
  });

  showLoader();

  event.preventDefault();

  const data = new FormData(formProfile);    

  fetch(urlProfile, {  
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
      } else{ 
          if(typeof json.message == "object"){
              Object.keys(json.message).forEach(key => {  
                formProfile.querySelector(`#${key}_message`).innerHTML = json.message[key];
                formProfile.querySelector(`#${key}`)?.classList.add("border-red-500");
                formProfile.querySelector(`#${key}+label`)?.classList.add("text_error");
              });
          }else{
              createAlert(json.message, "error")
          }
      }
  })
  .catch((err) => { hideLoader(); console.error("error:", err)});
});

if(formDoctor){
    formDoctor.addEventListener("submit", () => { 
        formDoctor.querySelectorAll("label").forEach(element => {
            element.classList.remove("text_error");
        });

        formDoctor.querySelectorAll("input,select").forEach(element => {
            element.classList.remove("border-red-500");
        });

        formDoctor.querySelectorAll("small").forEach(element => {
            element.innerHTML = "";
        });

        showLoader();

        event.preventDefault();

        const data = new FormData(formDoctor);    

        fetch(urlProfileDoctor, {  
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
            } else{ 
                if(typeof json.message == "object"){
                    Object.keys(json.message).forEach(key => {  
                        formDoctor.querySelector(`#${key}_message`).innerHTML = json.message[key];
                        formDoctor.querySelector(`#${key}`)?.classList.add("border-red-500");
                        formDoctor.querySelector(`#${key}+label`)?.classList.add("text_error");
                    });
                }else{
                    createAlert(json.message, "error")
                }
            }
        })
        .catch((err) => { hideLoader(); console.error("error:", err)});
    });
}
if(schedules_form){
    schedules_form.addEventListener("submit", () => { 
        schedules_form.querySelectorAll("label").forEach(element => {
            element.classList.remove("text_error");
        });

        schedules_form.querySelectorAll("input,select").forEach(element => {
            element.classList.remove("border-red-500");
        });

        schedules_form.querySelectorAll("small").forEach(element => {
            element.innerHTML = "";
        });

        showLoader();

        event.preventDefault();

        const data = new FormData(schedules_form);    

        fetch(urlSchedules, {  
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
            } else{ 
                if(typeof json.message == "object"){
                    Object.keys(json.message).forEach(key => {  
                        schedules_form.querySelector(`#${key}_message`).innerHTML = json.message[key];
                        schedules_form.querySelector(`#${key}`)?.classList.add("border-red-500");
                        schedules_form.querySelector(`#${key}+label`)?.classList.add("text_error");
                    });
                }else{
                    createAlert(json.message, "error")
                }
            }
        })
        .catch((err) => { hideLoader(); console.error("error:", err)});
    });
}

window.addEventListener('load', async() => { 
     
});