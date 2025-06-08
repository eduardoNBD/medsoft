window.addEventListener("load", () => {
    getPaginationFiles(currentPageFiles);
    getPaginationTreatmentEncounters(currentPageTreatmentsEncounters);
    getPaginationDiagnosisEncounters(currentPageDiagnosisEncounters);
    getPaginationNotesEncounters(currentPageNotesEncounters);
    getPaginationSupplies(currentPageSuppliesEncounters);
    getPaginationServices(currentPageServicesEncounters);
});

function showTab(item,button){ 
    $("#tabList button").forEach(element => {
        element.classList = 'h-full inline-flex items-center px-4 py-3 rounded-t-lg w-full tab_text tab_background';
    });

    $(".tab-item").forEach(element => {
        element.classList.add("hidden");
    });

    $(item).classList.remove("hidden");
    button.classList = 'h-full inline-flex items-center px-4 py-3 rounded-t-lg  w-full tab_text_active tab_background_active';
} 