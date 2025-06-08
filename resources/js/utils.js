const $ = ele => document.querySelectorAll(ele).length < 2 ? document.querySelector(ele) : document.querySelectorAll(ele);
let lastNotification = null;
let isFirstTime = true;

function seePasswordInput(input,button){button.classList.add("hidden");button.nextElementSibling.classList.remove("hidden");input.type = input.type == "password" ? "text" : "password";}
function hidePasswordInput(input,button){button.classList.add("hidden");button.previousElementSibling.classList.remove("hidden");input.type = input.type == "password" ? "text" : "password";}

function createAlert(message, type = "success") {
    const alert = document.createElement('div');
    alert.setAttribute('role', 'alert');

    if(type == "error"){ 
        alert.className = 'shadow-[2px_2px_8px_0_#00000055] dark:shadow-md flex items-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800 opacity-0 transform scale-90 transition-all duration-500';
        alert.innerHTML = `
            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="currentColor"  class="flex-shrink-0 w-4 h-4"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 2c5.523 0 10 4.477 10 10s-4.477 10 -10 10s-10 -4.477 -10 -10s4.477 -10 10 -10m3.6 5.2a1 1 0 0 0 -1.4 .2l-2.2 2.933l-2.2 -2.933a1 1 0 1 0 -1.6 1.2l2.55 3.4l-2.55 3.4a1 1 0 1 0 1.6 1.2l2.2 -2.933l2.2 2.933a1 1 0 0 0 1.6 -1.2l-2.55 -3.4l2.55 -3.4a1 1 0 0 0 -.2 -1.4" /></svg>
            <div class="ms-3 text-sm font-medium pr-10">${message}</div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text_error rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700" aria-label="Close">
                <span class="sr-only">Dismiss</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>`;
    }else if(type == "success"){
        alert.className = 'shadow-[2px_2px_8px_0_#00000055] dark:shadow-md flex items-center p-4 mb-4 text-emerald-800 border-t-4 border-emerald-300 bg-emerald-50 dark:text-emerald-400 dark:bg-gray-800 dark:border-emerald-800 opacity-0 transform scale-90 transition-all duration-500';
        alert.innerHTML = `
            <svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"  fill="currentColor"  class="flex-shrink-0 w-4 h-4"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12.01 2.011a3.2 3.2 0 0 1 2.113 .797l.154 .145l.698 .698a1.2 1.2 0 0 0 .71 .341l.135 .008h1a3.2 3.2 0 0 1 3.195 3.018l.005 .182v1c0 .27 .092 .533 .258 .743l.09 .1l.697 .698a3.2 3.2 0 0 1 .147 4.382l-.145 .154l-.698 .698a1.2 1.2 0 0 0 -.341 .71l-.008 .135v1a3.2 3.2 0 0 1 -3.018 3.195l-.182 .005h-1a1.2 1.2 0 0 0 -.743 .258l-.1 .09l-.698 .697a3.2 3.2 0 0 1 -4.382 .147l-.154 -.145l-.698 -.698a1.2 1.2 0 0 0 -.71 -.341l-.135 -.008h-1a3.2 3.2 0 0 1 -3.195 -3.018l-.005 -.182v-1a1.2 1.2 0 0 0 -.258 -.743l-.09 -.1l-.697 -.698a3.2 3.2 0 0 1 -.147 -4.382l.145 -.154l.698 -.698a1.2 1.2 0 0 0 .341 -.71l.008 -.135v-1l.005 -.182a3.2 3.2 0 0 1 3.013 -3.013l.182 -.005h1a1.2 1.2 0 0 0 .743 -.258l.1 -.09l.698 -.697a3.2 3.2 0 0 1 2.269 -.944zm3.697 7.282a1 1 0 0 0 -1.414 0l-3.293 3.292l-1.293 -1.292l-.094 -.083a1 1 0 0 0 -1.32 1.497l2 2l.094 .083a1 1 0 0 0 1.32 -.083l4 -4l.083 -.094a1 1 0 0 0 -.083 -1.32z" /></svg>
            <div class="ms-3 text-sm font-medium pr-10">${message}</div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-emerald-50 text-emerald-500 rounded-lg focus:ring-2 focus:ring-emerald-400 p-1.5 hover:bg-emerald-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-emerald-400 dark:hover:bg-gray-700" aria-label="Close">
                <span class="sr-only">Dismiss</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>`;
    }
 
    $("#alert-container").appendChild(alert);
 
     // Trigger the fade-in effect
     setTimeout(() => {
        alert.classList.remove('opacity-0', 'transform', 'scale-90');
        alert.classList.add('opacity-100', 'transform', 'scale-100');
    }, 10);

    // Automatically remove the alert after 5 seconds
    setTimeout(() => {
        alert.classList.remove('opacity-100', 'transform', 'scale-100');
        alert.classList.add('opacity-0', 'transform', 'scale-90');
        setTimeout(() => {
            alert.remove();
        }, 500);
    }, 5000);

    // Add event listener to the close button
    alert.querySelector('button[aria-label="Close"]').addEventListener('click', () => {
        alert.classList.remove('opacity-100', 'transform', 'scale-100');
        alert.classList.add('opacity-0', 'transform', 'scale-90');
        setTimeout(() => {
            alert.remove();
        }, 500);
    });
}

function reformatDate(datetime,format = "d/m/y"){  
    let finalDate;

    // Convertir la fecha de manera compatible con todos los navegadores
    if (typeof datetime === "string") {
        let parts = null;

        if(datetime.includes(" ")){
            parts = datetime.split(" ");
        }else if(datetime.includes("T")){ 
            parts = datetime.split("T");
        }else{
            parts = datetime.split(" ");
        }

        const dateParts = parts[0].split("-");
        if (dateParts.length === 3) {
            // Asegurarse de que los componentes de la fecha sean numéricos
            const [year, month, day] = dateParts.map(part => parseInt(part, 10));
            if(parts.length == 2){
                const [hours,min] = parts[1].split(":")
                finalDate = new Date(year, month - 1, day, hours, min);
            }else{ 
                finalDate = new Date(year, month - 1, day);
            }
        } else {
            throw new Error("El formato de fecha no es válido. Use 'YYYY-MM-DD'.");
        }
    } else if (datetime instanceof Date) {
        finalDate = datetime;
    } else {
        throw new Error("El argumento 'datetime' debe ser una cadena o un objeto Date.");
    }

    // Validar que finalDate sea una fecha válida
    if (isNaN(finalDate.getTime())) {
        throw new Error("La fecha no es válida.");
    }

    let finalString = "";
    
    for(var i = 0; i < format.length; i++ ){
        switch(format[i]){
            case "y":
                finalString+= finalDate.getFullYear();
            break;
            case "Y":
                let current = new Date();
                finalString+= current.getFullYear() != finalDate.getFullYear() ? finalDate.getFullYear()  : "";
            break;
            case "m": 
                finalString+= (finalDate.getMonth()+1)  < 10 ? "0"+(finalDate.getMonth()+1) : (finalDate.getMonth()+1);
            break;
            case "M": 
                let monthsIndex = (finalDate.getMonth()+1)  < 10 ? "0"+(finalDate.getMonth()+1) : (finalDate.getMonth()+1); 
                finalString+= monthsName[monthsIndex];
            break;
            case "d":
                finalString+= finalDate.getDate() < 10 ? "0"+finalDate.getDate() : finalDate.getDate();
            break;
            case "h": 
                finalString+= finalDate.getHours() < 10 ? "0"+finalDate.getHours() : finalDate.getHours();
            break;
            case "i":
                finalString+= finalDate.getMinutes() < 10 ? "0"+finalDate.getMinutes() : finalDate.getMinutes();
            break;
            case "s":
                finalString+= finalDate.getSeconds() < 10 ? "0"+finalDate.getSeconds() : finalDate.getSeconds();
            break;
            case "c":
                finalString+= conector;
            break;
            default:
                finalString+=format[i];
            break
        }
    }
    

    return finalString;
}

function checkDate(date) {
    const selectedDate = typeof date == "string" ? new Date(date.split("-")) : date; 
    const today = new Date(); 
    
    today.setHours(0, 0, 0, 0);
    selectedDate.setHours(0, 0, 0, 0);
 
    if (selectedDate < today) {
        return false;
    }

    return true;
}

function getLastElement(idenfity){
    var elements = document.querySelectorAll(idenfity);
 
    return elements[elements.length-1];
 } 

 function customNumberFormat(number,noDecimal = 2) { 
    const formatter = new Intl.NumberFormat('en-US', {
        minimumFractionDigits: noDecimal,
        maximumFractionDigits: 2
    }); 

    let formattedNumber = formatter.format(number); 
    formattedNumber     = formattedNumber.replace(/,/g, '^').replaceAll(/\./g, ',').replace(/(\d+)(,)(\d+)$/, '$1.$3').replaceAll("^",",");
    
    return formattedNumber;
}

function error419(res) {
    if (res.status === 419) {
        createAlert(textReload419,"error");

        setTimeout(() => {
            window.location.reload(true); 
        }, 2000); 

        return Promise.reject('Session expired (419 error).');  

    } else if(res.status === 401) {
        createAlert(textReload419,"error");

        setTimeout(() => {
            window.location.reload(true); 
        }, 2000); 
    } else if (!res.ok) {
        return Promise.reject(`Error: ${res.status} ${res.statusText}`); 
    }

    return res.json().catch(() => { 
        return Promise.reject('Invalid JSON response.');
    });
}

function checkedInputs(){ 
    return document.querySelectorAll("[name='status']:checked").length != 0;
}

function closeModal(id){$(id).classList.add("hidden");}
function openModal(id){$(id).classList.remove("hidden");}

function getNotifications() {
    fetch(baseURL + "/notifications/list")
        .then(response => error419(response))
        .then(json => {
            if (json.items.length > 0) {

                $("#notificationsContent").innerHTML = json.items.map(notification =>
                    `<div class="flex ${!notification.read_at ? "bg-gray-400 dark:bg-gray-500 bg-opacity-25" : ""}">
                        <a href="${baseURL}/notifications/markAsRead/${notification.id}" class="flex-1 block p-2">
                            <div class="flex justify-between border-b">
                                ${notification.data.title}
                            </div>
                            <small class="flex justify-between">
                                ${notification.data.message}
                            </small>
                            <small class="block text-right">${reformatDate(notification.created_at, "d M y h:i")}</small>
                        </a>
                        <button class="mr-1 mt-1 button_error h-4 w-4 rounded flex items-center justify-center" onclick="deleteNotification('${notification.id}')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M18 6l-12 12"/>
                                <path d="M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>`
                ).join("<hr>");

                if (json.unread != 0) {
                    $("#notificationCount").classList.remove("hidden");
                    $("#notificationCount span").innerHTML = json.unread;
                }
            } else {
                $("#notificationsContent").innerHTML = `<div class="py-4 px-4">${withoutNotificationsText}</div>`;
                $("#notificationCount").classList.add("hidden");
                $("#notificationCount span").innerHTML = 0;
                lastNotification = null;
            }

            if(!isFirstTime){
                processNewNotifications(json.items, json.unread);
            }else{
                isFirstTime = false;
                
                if (json.items.length > 0) {
                    lastNotification = json.items[0]; 
                }
            }
            
        })
        .catch(error => console.error(error));
}

function processNewNotifications(newNotifications, unreadCount) { 
    if (newNotifications.length > 0) {
        if(lastNotification != null){ 
            const isFound =  newNotifications.filter(notification => notification.id == lastNotification.id);
            
            if(!isFound.length && lastNotification.id){ 
                lastNotification = newNotifications[0]; 
                return;
            }
        }

        if(newNotifications.length > 1){
            for (const notification of newNotifications) {
                if (lastNotification?.id && notification.id === lastNotification.id) {
                    break;
                }
                showNotification({
                    title: notification.data.title,
                    message: notification.data.message,
                    link: `${baseURL}/notifications/markAsRead/${notification.id}`,
                    type: notification.data.type,
                    duration: 10000
                });
            }
        }else{
            if(lastNotification == null){
                showNotification({
                    title: newNotifications[0].data.title,
                    message: newNotifications[0].data.message,
                    link: `${baseURL}/notifications/markAsRead/${newNotifications[0].id}`,
                    type: newNotifications[0].data.type,
                    duration: 10000
                });
            }
        }
        
        lastNotification = newNotifications[0]; 
    }
 
    if (unreadCount > 0) {
        $("#notificationCount").classList.remove("hidden");
        $("#notificationCount span").innerHTML = unreadCount;
    } else {
        $("#notificationCount").classList.add("hidden");
        $("#notificationCount span").innerHTML = 0;
    }
}

function deleteNotification(id){
    fetch(baseURL+"/notifications/delete/"+id)
    .then(response => error419(response))
    .then(json => {
        getNotifications();
    })
    .catch(error => console.error(error));
}

function showNotification({ title, message, link = '#', type = "info", duration = 3000, persistent = false }) {
    const container = document.getElementById("notifications-container");

    const colors = {
        success: "bg-green-500 border-t-4 border-green-700",
        error: "bg-red-500 border-t-4 border-red-700",
        warning: "bg-yellow-500 border-t-4 border-yellow-700",
        info: "bg-blue-500 border-t-4 border-blue-700"
    };

    const notification = document.createElement("div");
    notification.className = `flex p-2 rounded-lg shadow-lg text-white ${colors[type]} transition-opacity duration-300 opacity-0 relative`;
    notification.href = link;

    notification.innerHTML = `
        <a href="${link}" class="flex items-center flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="mr-2">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M14.235 19c.865 0 1.322 1.024 .745 1.668a3.992 3.992 0 0 1 -2.98 1.332a3.992 3.992 0 0 1 -2.98 -1.332c-.552 -.616 -.158 -1.579 .634 -1.661l.11 -.006h4.471z"/>
                <path d="M12 2c1.358 0 2.506 .903 2.875 2.141l.046 .171l.008 .043a8.013 8.013 0 0 1 4.024 6.069l.028 .287l.019 .289v2.931l.021 .136a3 3 0 0 0 1.143 1.847l.167 .117l.162 .099c.86 .487 .56 1.766 -.377 1.864l-.116 .006h-16c-1.028 0 -1.387 -1.364 -.493 -1.87a3 3 0 0 0 1.472 -2.063l.021 -.143l.001 -2.97a8 8 0 0 1 3.821 -6.454l.248 -.146l.01 -.043a3.003 3.003 0 0 1 2.562 -2.29l.182 -.017l.176 -.004z"/>
            </svg>
            <div>
                <div  class="flex"> 
                    ${title}
                </div>
                <hr>
                <small class="mr-2">${message}</small>
            </div>
        </a>
        <button class=" mr-1 mt-1 button_error h-4 w-4 rounded flex items-center justify-center close-btn"><svg  xmlns="http://www.w3.org/2000/svg"  width="12"  height="12"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg></button>
    `;

    container.appendChild(notification);

    setTimeout(() => {
        notification.classList.remove("opacity-0");
    }, 10);

    notification.querySelector(".close-btn").addEventListener("click", () => {
        notification.classList.add("opacity-0");
        setTimeout(() => notification.remove(), 300);
    });

    if (!persistent) {
        setTimeout(() => {
            notification.classList.add("opacity-0");
            setTimeout(() => notification.remove(), 300);
        }, duration);
    }
}

HTMLSelectElement.prototype.trigger = function(eventName) {
    this.dispatchEvent(new Event(eventName));
};
HTMLInputElement.prototype.trigger = function(eventName) {
    this.dispatchEvent(new Event(eventName));
};
HTMLTextAreaElement.prototype.trigger = function(eventName) {
    this.dispatchEvent(new Event(eventName));
};