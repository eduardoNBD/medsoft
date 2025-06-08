const switchTheme = $("#theme-toggle");
const mainNavbar = $("#main-navbar");
const openMenu   = $("#btnOpen");
const closeMenu   = $("#btnClose"); 
let timeout;
let lastTap = 0;
let menuItem = null;

const getInitialTheme = () => {
    if (typeof window !== "undefined" && window.localStorage) {
        const storedPrefs = window.localStorage.getItem("theme");
        if (typeof storedPrefs === "string") {
            return storedPrefs;
        }

        const userMedia = window.matchMedia("(prefers-color-scheme: dark)");
        if (userMedia.matches) {
            return "dark";
        }
    }

    return "light";  
};

const setTheme = (theme) => {
    if (theme === "dark") {
        document.documentElement.classList.add("dark");
        if (switchTheme) switchTheme.checked = false;
    } else {
        document.documentElement.classList.remove("dark");
        if (switchTheme) switchTheme.checked = true;
    }
    window.localStorage.setItem("theme", theme);
};

const toggleTheme = (event)  => {  
    const target = event.target;
    const newTheme = target.checked ? 'light' : 'dark';
    setTheme(newTheme);
}; 

function openNavbar(){
    if(mainNavbar.classList.contains("w-[48px]")){
        mainNavbar.classList.add("w-[240px]","shadow-lg");
        mainNavbar.classList.remove("w-[48px]");
        openMenu.classList.add("hidden");
        closeMenu.classList.remove("hidden");
    }else{
        mainNavbar.classList.add("w-[48px]");
        mainNavbar.classList.remove("w-[240px]","shadow-lg");
        openMenu.classList.remove("hidden");
        closeMenu.classList.add("hidden");
    }
}

function goToURL(url,event){
    if(event){
        event.preventDefault();
    }
    
    location.href = url;
}

function toggleMenuMovil(event){ 
    event.preventDefault();
    location.href = event.currentTarget.href;
}

function doubleTap(event) {
    var currentTime = new Date().getTime();
    var tapLength = currentTime - lastTap;

    clearTimeout(timeout);
    if (tapLength < 500 && tapLength > 0) {
        event.preventDefault();
        goToURL(event.currentTarget.href)
    } else { 
        timeout = setTimeout(function() { 
            clearTimeout(timeout);
        }, 500);
    }
    lastTap = currentTime;
};

setTheme(getInitialTheme());

onload = (event) => { 
    $("#loader").classList.add("hidden");

    if (switchTheme) {
        switchTheme.addEventListener("change", toggleTheme);
    }

    setInterval(getNotifications, 5000);
    getNotifications();
};

onresize = (event) => {
    if(event.currentTarget.innerWidth >= 959 && mainNavbar.classList.contains("w-[240px]")){
        mainNavbar.classList.remove("shadow-lg");  
    }
    else if(mainNavbar.classList.contains("w-[240px]")){
        mainNavbar.classList.add("shadow-lg"); 
    }
};