onload = (event) => { 
    $("#loader").classList.add("hidden");

    if(isLogged){
        setInterval(getNotifications, 5000);
        getNotifications();
    }
};