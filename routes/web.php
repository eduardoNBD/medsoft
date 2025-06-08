<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    SessionController,
    NoAuthController,
    AuthController,
    DashboardController, 
    UsersController,
    MedicalsController,
    PatientsController,
    AppointmentsController,
    SuppliesController,
    ServicesController,
    EncountersController,
    MedicalUnitsController,
    GoogleCalendarController,
    SettingsController,
    TemplatesController,
    ExpensesController,
    ExpensesRecordsController,
    CertificatesController,
    PublicController,
    ReportController,
    ItemReloadsController,
    CertificateRequestsController,
    NotificationsController
};

Route::get("/login",[ 'as' => 'login', NoAuthController::class,"index"]);   
Route::get("/register",[NoAuthController::class,"register"]);   
Route::get("/forget-password",[NoAuthController::class,"forgetPassword"]);   
Route::get("/reset-password/{token}",[NoAuthController::class,"resetPassword"]);   
Route::post('/login', [ 'as' => 'login', 'uses' => 'NoAuthController@index']);
Route::get("/dashboard",[DashboardController::class,"index"])->middleware(['auth', 'roles:1,2']);
Route::get("/dashboard/report",[DashboardController::class,"report"])->middleware(['auth', 'roles:1']);

//Route Languaje
    Route::get('/lang/{locale}',[SessionController::class,"changeLanguage"]);

//Route Auth
    Route::post('/auth/login', [AuthController::class,"Login"]);
    Route::get('/auth/logout', [AuthController::class,"Logout"]);
    Route::post('/auth/register', [AuthController::class,"Register"]);
    Route::post('/auth/recovery', [AuthController::class,"Recovery"]);
    Route::post('/auth/reset', [AuthController::class,"Reset"]);

//Routes Google Calendar
    Route::get('/google/redirect', [GoogleCalendarController::class, 'redirectToGoogle'])->name('google.redirect');
    Route::get('/google/callback', [GoogleCalendarController::class, 'handleGoogleCallback'])->name('google.callback');
    Route::post('/google/webhook', [GoogleCalendarController::class, 'handleWebhook']); 


/*====================================================USERS===================================================*/

//---------------------------------------------------Views-----------------------------------------------------

    Route::get("/dashboard/profile",[DashboardController::class,"profile"])->middleware(['auth', 'roles:1,2,3']);
    Route::get("/dashboard/users",[DashboardController::class,"users"])->middleware(['auth', 'roles:1']);
    Route::get("/dashboard/users/{page}",[DashboardController::class,"users"])->middleware(['auth', 'roles:1'])->where('page', '[0-9]+');
    Route::get("/dashboard/users/user",[DashboardController::class,"user"])->middleware(['auth', 'roles:1,2']);
    Route::get("/dashboard/users/user/{id}",[DashboardController::class,"user"])->middleware(['auth', 'roles:1,2'])->where('id', '[a-z0-9.\-]+');

//------------------------------------------------Endpoints------------------------------------------------

    Route::post("/users/create",[UsersController::class,"create"])->middleware(['auth', 'roles:1,2']); 
    Route::post("/users/update/{id}",[UsersController::class,"update"])->middleware(['auth', 'roles:1,2'])->where('id', '[a-z0-9.\-]+');
    Route::post("/users/updateProfile",[UsersController::class,"updateProfile"])->middleware(['auth', 'roles:1,2,3']); 
    Route::post("/users/updateProfilePhoto",[UsersController::class,"updateProfilePhoto"])->middleware(['auth', 'roles:1,2']); 
    Route::post("/users/updateProfileDoctor",[UsersController::class,"updateProfileDoctor"])->middleware(['auth', 'roles:1,2']); 
    Route::post("/users/updateProfilePatient",[UsersController::class,"updateProfilePatient"])->middleware(['auth', 'roles:1,3']); 
    Route::get("/users/setNoRemember",[UsersController::class,"setNoRemember"])->middleware(['auth', 'roles:2'])->where('id', '[a-z0-9.\-]+');
    Route::post("/users/updateSchedules",[UsersController::class,"updateSchedules"])->middleware(['auth', 'roles:1,2']); 
    Route::post("/users/updatePassword",[UsersController::class,"updatePassword"])->middleware(['auth', 'roles:1,2,3']);
    Route::post("/users/updatePasswordForUser/{id}",[UsersController::class,"updatePasswordForUser"])->middleware(['auth', 'roles:1'])->where('id', '[a-z0-9.\-]+');
    Route::get("/users/update/credentials",[UsersController::class,"credentials"])->middleware(['auth', 'roles:1,2']);
    Route::get("/users/delete/{id}",[UsersController::class,"delete"])->middleware(['auth', 'roles:1'])->where('id', '[a-z0-9.\-]+');
    Route::get("/users/restore/{id}",[UsersController::class,"restore"])->middleware(['auth', 'roles:1'])->where('id', '[a-z0-9.\-]+');
    Route::get("/users/list",[UsersController::class,"list"])->middleware(['auth', 'roles:1']); 

/*====================================================END USERS================================================*/

/*===================================================MEDICALS==================================================*/

//---------------------------------------------------Views-----------------------------------------------------

    Route::get("/dashboard/medicals",[DashboardController::class,"medicals"])->middleware(['auth', 'roles:1']);
    Route::get("/dashboard/medicals/{page}",[DashboardController::class,"medicals"])->middleware(['auth', 'roles:1'])->where('page', '[0-9]+'); 
    Route::get("/dashboard/medicals/medical/{id}",[DashboardController::class,"medical"])->middleware(['auth', 'roles:1'])->where('id', '[a-z0-9.\-]+');

//------------------------------------------------Endpoints-----------------------------------------------------

    Route::get("/medicals/delete/{id}",[MedicalsController::class,"delete"])->middleware(['auth', 'roles:1'])->where('id', '[a-z0-9.\-]+');
    Route::get("/medicals/restore/{id}",[MedicalsController::class,"restore"])->middleware(['auth', 'roles:1'])->where('id', '[a-z0-9.\-]+');
    Route::get("/medicals/list",[MedicalsController::class,"list"]); 
    Route::get("/medicals/getData/{id}",[MedicalsController::class,"getData"])->middleware(['auth', 'roles:1,2'])->where('id', '[a-z0-9.\-]+');

/*===================================================END MEDICALS===============================================*/

/*===================================================PATIENTS===================================================*/

//---------------------------------------------------Views-----------------------------------------------------

    Route::get("/dashboard/patients",[DashboardController::class,"patients"])->middleware(['auth', 'roles:1,2']);
    Route::get("/dashboard/patients/{page}",[DashboardController::class,"patients"])->middleware(['auth', 'roles:1,2'])->where('page', '[0-9]+'); 
    Route::get("/dashboard/patients/patient/{id}",[DashboardController::class,"patient"])->middleware(['auth', 'roles:1,2'])->where('id', '[a-z0-9.\-]+');
    Route::get("/dashboard/patients/record/{id}",[DashboardController::class,"patient_record"])->middleware(['auth', 'roles:1,2'])->where('id', '[a-z0-9.\-]+');
    Route::get("/dashboard/patients/detail/{id}",[DashboardController::class,"patient_detail"])->middleware(['auth', 'roles:1,2'])->where('id', '[a-z0-9.\-]+');

//------------------------------------------------Endpoints-----------------------------------------------------

    Route::post("/patient/update_record/{id}",[PatientsController::class,"update_record"])->middleware(['auth', 'roles:1,2'])->where('id', '[a-z0-9.\-]+');
    Route::get("/patients/delete/{id}",[PatientsController::class,"delete"])->middleware(['auth', 'roles:1,2'])->where('id', '[a-z0-9.\-]+');
    Route::get("/patients/restore/{id}",[PatientsController::class,"restore"])->middleware(['auth', 'roles:1,2'])->where('id', '[a-z0-9.\-]+');
    Route::get("/patients/list",[PatientsController::class,"list"])->middleware(['auth', 'roles:1,2']); 

/*===================================================END PATIENTS===============================================*/

/*====================================================CERTIFICATES==================================================*/

//---------------------------------------------------Views-----------------------------------------------------

    Route::get("/dashboard/certificates",[DashboardController::class,"certificates"])->middleware(['auth', 'roles:1,2']);
    Route::get("/dashboard/certificates/{page}",[DashboardController::class,"certificates"])->middleware(['auth', 'roles:1,2'])->where('page', '[0-9]+');
    Route::get("/dashboard/certificates/certificate",[DashboardController::class,"certificate"])->middleware(['auth', 'roles:1,2']);
    Route::get("/dashboard/certificates/certificate/{id}",[DashboardController::class,"certificate"])->middleware(['auth', 'roles:1,2'])->where('id', '[a-z0-9.\-]+');

//------------------------------------------------Endpoints------------------------------------------------

    Route::post("/certificates/create",[CertificatesController::class,"create"])->middleware(['auth', 'roles:1,2']); 
    Route::post("/certificates/update/{id}",[CertificatesController::class,"update"])->middleware(['auth', 'roles:1,2'])->where('id', '[a-z0-9.\-]+');
    Route::post("/certificates/delete/{id}",[CertificatesController::class,"delete"])->middleware(['auth', 'roles:1,2'])->where('id', '[a-z0-9.\-]+');
    Route::get("/certificates/restore/{id}",[CertificatesController::class,"restore"])->middleware(['auth', 'roles:1,2'])->where('id', '[a-z0-9.\-]+');
    Route::get("/certificates/getContent/{id}",[CertificatesController::class,"getContent"])->middleware(['auth'])->where('id', '[a-z0-9.\-]+');
    Route::get("/certificates/list",[CertificatesController::class,"list"])->middleware(['auth', 'roles:1,2']); 

/*====================================================END CERTIFICATES===============================================*/

/*==================================================APPOINTMENTS================================================*/

//---------------------------------------------------Views-----------------------------------------------------

    Route::get("/dashboard/appointments",[DashboardController::class,"appointments"])->middleware(['auth', 'roles:1,2,3']);
    Route::get("/dashboard/appointments/{page}",[DashboardController::class,"appointments"])->middleware(['auth', 'roles:1,2,3'])->where('page', '[0-9]+');
    Route::get("/dashboard/appointments/appointment",[DashboardController::class,"appointment"])->middleware(['auth', 'roles:1,2,3']);
    Route::get("/dashboard/appointments/appointment/{id}",[DashboardController::class,"appointment"])->middleware(['auth', 'roles:1,2,3'])->where('id', '[a-z0-9.\-]+');

//------------------------------------------------Endpoints------------------------------------------------

    Route::post("/appointments/create",[AppointmentsController::class,"create"])->middleware(['auth', 'roles:1,2,3']); 
    Route::post("/appointments/update/{id}",[AppointmentsController::class,"update"])->middleware(['auth', 'roles:1,2'])->where('id', '[a-z0-9.\-]+');
    Route::post("/appointments/delete/{id}",[AppointmentsController::class,"delete"])->middleware(['auth', 'roles:1,2'])->where('id', '[a-z0-9.\-]+'); 
    Route::get("/appointments/confirm/{id}",[AppointmentsController::class,"confirm"])->middleware(['auth', 'roles:1,2'])->where('id', '[a-z0-9.\-]+');
    Route::get("/appointments/generateEncounter/{id}",[AppointmentsController::class,"generateEncounter"])->middleware(['auth', 'roles:1,2'])->where('id', '[a-z0-9.\-]+'); 
    Route::get("/appointments/list",[AppointmentsController::class,"list"])->middleware(['auth', 'roles:1,2,3']); 
    Route::post("/appointments/getAvailableTimes/{doctor_id}",[AppointmentsController::class,"getAvailableTimes"])->where('doctor_id', '[a-z0-9.\-]+'); 

/*==================================================END APPOINTMENTS============================================*/

/*==================================================ENCOUNTERS==================================================*/

//---------------------------------------------------Views-----------------------------------------------------

    Route::get("/dashboard/encounters",[DashboardController::class,"encounters"])->middleware(['auth', 'roles:1,2,3']);
    Route::get("/dashboard/encounters/{page}",[DashboardController::class,"encounters"])->middleware(['auth', 'roles:1,2,3'])->where('page', '[0-9]+');
    Route::get("/dashboard/encounters/encounter",[DashboardController::class,"encounter"])->middleware(['auth', 'roles:1,2,3']);
    Route::get("/dashboard/encounters/encounter/{id}",[DashboardController::class,"encounter"])->middleware(['auth', 'roles:1,2,3'])->where('id', '[a-z0-9.\-]+');
    Route::get("/dashboard/encounters/detail/{id}",[DashboardController::class,"encounter_detail"])->middleware(['auth', 'roles:1,2'])->where('id', '[a-z0-9.\-]+');

//------------------------------------------------Endpoints------------------------------------------------

    Route::post("/encounters/create",[EncountersController::class,"create"])->middleware(['auth', 'roles:1,2']);  
    Route::post("/encounters/update/{id}",[EncountersController::class,"update"])->middleware(['auth', 'roles:1,2'])->where('id', '[a-z0-9.\-]+');
    Route::post("/encounters/updateDetail/{id}",[EncountersController::class,"updateDetail"])->middleware(['auth', 'roles:1,2'])->where('id', '[a-z0-9.\-]+');
    Route::post("/encounters/pay/{id}",[EncountersController::class,"pay"])->middleware(['auth', 'roles:1,2'])->where('id', '[a-z0-9.\-]+');
    Route::post("/encounters/deleteFile/{id}", [EncountersController::class, 'deleteFile'])->middleware(['auth', 'roles:1,2'])->where('id', '[a-z0-9.\-]+');
    Route::post("/encounters/delete/{id}",[EncountersController::class,"delete"])->middleware(['auth', 'roles:1,2'])->where('id', '[a-z0-9.\-]+'); 
    Route::get("/encounters/confirm/{id}",[EncountersController::class,"confirm"])->middleware(['auth', 'roles:1,2'])->where('id', '[a-z0-9.\-]+');
    Route::get("/encounters/list",[EncountersController::class,"list"])->middleware(['auth', 'roles:1,2,3']); 
    Route::get("/encounters/fileList/{id}",[EncountersController::class,"fileList"])->middleware(['auth', 'roles:1,2'])->where('id', '[a-z0-9.\-]+');
    Route::get("/encounters/diagnosisList/{id}",[EncountersController::class,"diagnosisList"])->middleware(['auth', 'roles:1,2'])->where('id', '[a-z0-9.\-]+');
    Route::get("/encounters/items/{id}",[EncountersController::class,"items"])->middleware(['auth', 'roles:1,2'])->where('id', '[a-z0-9.\-]+');
 
/*==================================================END ENCOUNTERS==============================================*/

/*====================================================SUPPLIES==================================================*/

//---------------------------------------------------Views-----------------------------------------------------

    Route::get("/dashboard/supplies",[DashboardController::class,"supplies"])->middleware(['auth', 'roles:1,2']);
    Route::get("/dashboard/supplies/{page}",[DashboardController::class,"supplies"])->middleware(['auth', 'roles:1,2'])->where('page', '[0-9]+');
    Route::get("/dashboard/supplies/supply",[DashboardController::class,"supply"])->middleware(['auth', 'roles:1,2']);
    Route::get("/dashboard/supplies/supply/{id}",[DashboardController::class,"supply"])->middleware(['auth', 'roles:1,2'])->where('id', '[a-z0-9.\-]+');
    Route::get("/dashboard/supplies/detail/{id}/{page}",[DashboardController::class,"supply_detail"])->middleware(['auth', 'roles:1'])->where(['id' => '[a-z0-9.\-]+','page' => '[0-9]+']);

//------------------------------------------------Endpoints------------------------------------------------

    Route::post("/supplies/create",[SuppliesController::class,"create"])->middleware(['auth', 'roles:1']); 
    Route::post("/supplies/update/{id}",[SuppliesController::class,"update"])->middleware(['auth', 'roles:1'])->where('id', '[a-z0-9.\-]+');
    Route::get("/supplies/delete/{id}",[SuppliesController::class,"delete"])->middleware(['auth', 'roles:1'])->where('id', '[a-z0-9.\-]+');
    Route::get("/supplies/restore/{id}",[SuppliesController::class,"restore"])->middleware(['auth', 'roles:1'])->where('id', '[a-z0-9.\-]+');
    Route::get("/supplies/list",[SuppliesController::class,"list"])->middleware(['auth', 'roles:1,2']); 

/*====================================================END SUPPLIES===============================================*/

/*================================================SUPPLIES RELOADS================================================*/

//---------------------------------------------------Views-----------------------------------------------------

     

//------------------------------------------------Endpoints------------------------------------------------

    Route::post("/items_reloads/create",[ItemReloadsController::class,"create"])->middleware(['auth', 'roles:1']); 
    Route::post("/items_reloads/update/",[ItemReloadsController::class,"update"])->middleware(['auth', 'roles:1']);
    Route::get("/items_reloads/delete/{id}",[ItemReloadsController::class,"delete"])->middleware(['auth', 'roles:1'])->where('id', '[a-z0-9.\-]+');
    Route::get("/items_reloads/restore/{id}",[ItemReloadsController::class,"restore"])->middleware(['auth', 'roles:1'])->where('id', '[a-z0-9.\-]+');
    Route::get("/items_reloads/list/{item_id}",[ItemReloadsController::class,"list"])->middleware(['auth', 'roles:1,2'])->where('item_id', '[a-z0-9.\-]+');

/*================================================END SUPPLIES RELOADS==============================================*/

/*====================================================SERVICES===================================================*/

//---------------------------------------------------Views-----------------------------------------------------

    Route::get("/dashboard/services",[DashboardController::class,"services"])->middleware(['auth', 'roles:1,2']);
    Route::get("/dashboard/services/{page}",[DashboardController::class,"services"])->middleware(['auth', 'roles:1,2'])->where('page', '[0-9]+');
    Route::get("/dashboard/services/service",[DashboardController::class,"service"])->middleware(['auth', 'roles:1,2']);
    Route::get("/dashboard/services/service/{id}",[DashboardController::class,"service"])->middleware(['auth', 'roles:1,2'])->where('id', '[a-z0-9.\-]+');

//------------------------------------------------Endpoints------------------------------------------------

    Route::post("/services/create",[ServicesController::class,"create"])->middleware(['auth', 'roles:1']); 
    Route::post("/services/update/{id}",[ServicesController::class,"update"])->middleware(['auth', 'roles:1'])->where('id', '[a-z0-9.\-]+');
    Route::get("/services/delete/{id}",[ServicesController::class,"delete"])->middleware(['auth', 'roles:1'])->where('id', '[a-z0-9.\-]+');
    Route::get("/services/restore/{id}",[ServicesController::class,"restore"])->middleware(['auth', 'roles:1'])->where('id', '[a-z0-9.\-]+');
    Route::get("/services/list",[ServicesController::class,"list"])->middleware(['auth', 'roles:1,2']); 

/*====================================================END SERVICES================================================*/

/*====================================================EXPENSES==================================================*/

//---------------------------------------------------Views-----------------------------------------------------

    Route::get("/dashboard/expenses",[DashboardController::class,"expenses"])->middleware(['auth', 'roles:1']);
    Route::get("/dashboard/expenses/{page}",[DashboardController::class,"expenses"])->middleware(['auth', 'roles:1'])->where('page', '[0-9]+');
    Route::get("/dashboard/expenses/expense",[DashboardController::class,"expense"])->middleware(['auth', 'roles:1']);
    Route::get("/dashboard/expenses/expense/{id}",[DashboardController::class,"expense"])->middleware(['auth', 'roles:1'])->where('id', '[a-z0-9.\-]+');

//------------------------------------------------Endpoints------------------------------------------------

    Route::post("/expenses/create",[ExpensesController::class,"create"])->middleware(['auth', 'roles:1']); 
    Route::post("/expenses/update/{id}",[ExpensesController::class,"update"])->middleware(['auth', 'roles:1'])->where('id', '[a-z0-9.\-]+');
    Route::get("/expenses/delete/{id}",[ExpensesController::class,"delete"])->middleware(['auth', 'roles:1'])->where('id', '[a-z0-9.\-]+');
    Route::get("/expenses/restore/{id}",[ExpensesController::class,"restore"])->middleware(['auth', 'roles:1'])->where('id', '[a-z0-9.\-]+');
    Route::get("/expenses/list",[ExpensesController::class,"list"])->middleware(['auth', 'roles:1']); 

/*====================================================END EXPENSES===============================================*/

/*====================================================EXPENSES==================================================*/

//---------------------------------------------------Views-----------------------------------------------------

    Route::get("/dashboard/expenses_records",[DashboardController::class,"expenses_records"])->middleware(['auth', 'roles:1']);
    Route::get("/dashboard/expenses_records/{page}",[DashboardController::class,"expenses_records"])->middleware(['auth', 'roles:1'])->where('page', '[0-9]+');
    Route::get("/dashboard/expenses_records/expenses_record",[DashboardController::class,"expenses_record"])->middleware(['auth', 'roles:1']);
    Route::get("/dashboard/expenses_records/expenses_record/{id}",[DashboardController::class,"expenses_record"])->middleware(['auth', 'roles:1'])->where('id', '[a-z0-9.\-]+');

//------------------------------------------------Endpoints------------------------------------------------

    Route::post("/expenses_records/create",[ExpensesRecordsController::class,"create"])->middleware(['auth', 'roles:1']); 
    Route::post("/expenses_records/update/{id}",[ExpensesRecordsController::class,"update"])->middleware(['auth', 'roles:1'])->where('id', '[a-z0-9.\-]+');
    Route::get("/expenses_records/delete/{id}",[ExpensesRecordsController::class,"delete"])->middleware(['auth', 'roles:1'])->where('id', '[a-z0-9.\-]+');
    Route::get("/expenses_records/restore/{id}",[ExpensesRecordsController::class,"restore"])->middleware(['auth', 'roles:1'])->where('id', '[a-z0-9.\-]+');
    Route::get("/expenses_records/list",[ExpensesRecordsController::class,"list"])->middleware(['auth', 'roles:1']); 

/*====================================================END EXPENSES===============================================*/

/*==================================================MEDICAL UNITS=================================================*/

//---------------------------------------------------Views-----------------------------------------------------

    Route::get("/dashboard/medical_units",[DashboardController::class,"medical_units"])->middleware(['auth', 'roles:1']);
    Route::get("/dashboard/medical_units/{page}",[DashboardController::class,"medical_units"])->middleware(['auth', 'roles:1'])->where('page', '[0-9]+');
    Route::get("/dashboard/medical_units/medical_unit",[DashboardController::class,"medical_unit"])->middleware(['auth', 'roles:1']);
    Route::get("/dashboard/medical_units/medical_unit/{id}",[DashboardController::class,"medical_unit"])->middleware(['auth', 'roles:1'])->where('id', '[a-z0-9.\-]+');

//------------------------------------------------Endpoints------------------------------------------------

    Route::post("/medical_units/create",[MedicalUnitsController::class,"create"])->middleware(['auth', 'roles:1']); 
    Route::post("/medical_units/update/{id}",[MedicalUnitsController::class,"update"])->middleware(['auth', 'roles:1'])->where('id', '[a-z0-9.\-]+');
    Route::get("/medical_units/delete/{id}",[MedicalUnitsController::class,"delete"])->middleware(['auth', 'roles:1'])->where('id', '[a-z0-9.\-]+');
    Route::get("/medical_units/restore/{id}",[MedicalUnitsController::class,"restore"])->middleware(['auth', 'roles:1'])->where('id', '[a-z0-9.\-]+');
    Route::get("/medical_units/list",[MedicalUnitsController::class,"list"])->middleware(['auth', 'roles:1']); 

/*==============================================END MEDICAL UNITS=============================================*/

/*==================================================TEMPLATES=================================================*/

//---------------------------------------------------Views-----------------------------------------------------

    Route::get("/dashboard/templates",[DashboardController::class,"templates"])->middleware(['auth', 'roles:1']);
    Route::get("/dashboard/templates/{page}",[DashboardController::class,"templates"])->middleware(['auth', 'roles:1'])->where('page', '[0-9]+');
    Route::get("/dashboard/templates/template",[DashboardController::class,"template"])->middleware(['auth', 'roles:1']);
    Route::get("/dashboard/templates/template/{id}",[DashboardController::class,"template"])->middleware(['auth', 'roles:1'])->where('id', '[a-z0-9.\-]+');

//------------------------------------------------Endpoints------------------------------------------------

    Route::post("/templates/create",[TemplatesController::class,"create"])->middleware(['auth', 'roles:1']); 
    Route::post("/templates/update/{id}",[TemplatesController::class,"update"])->middleware(['auth', 'roles:1'])->where('id', '[a-z0-9.\-]+');
    Route::get("/templates/delete/{id}",[TemplatesController::class,"delete"])->middleware(['auth', 'roles:1'])->where('id', '[a-z0-9.\-]+');
    Route::get("/templates/restore/{id}",[TemplatesController::class,"restore"])->middleware(['auth', 'roles:1'])->where('id', '[a-z0-9.\-]+');
    Route::get("/templates/list",[TemplatesController::class,"list"])->middleware(['auth', 'roles:1']); 

/*==============================================END TEMPLATES=============================================*/

/*==================================================TEMPLATES=================================================*/

//---------------------------------------------------Views-----------------------------------------------------

    Route::get("/dashboard/requests",[DashboardController::class,"requests"])->middleware(['auth', 'roles:1,2']);
    Route::get("/dashboard/requests/{page}",[DashboardController::class,"requests"])->middleware(['auth', 'roles:1,2'])->where('page', '[0-9]+');
    //Route::get("/dashboard/requests/request",[DashboardController::class,"request"])->middleware(['auth', 'roles:1']);
    //Route::get("/dashboard/requests/request/{id}",[DashboardController::class,"request"])->middleware(['auth', 'roles:1'])->where('id', '[a-z0-9.\-]+');

//------------------------------------------------Endpoints------------------------------------------------

    Route::post("/requests/create",[CertificateRequestsController::class,"create"])->middleware(['auth', 'roles:3']); 
    //Route::post("/requests/update/{id}",[CertificateRequestsController::class,"update"])->middleware(['auth', 'roles:1,2,3'])->where('id', '[a-z0-9.\-]+');
    Route::post("/requests/delete/{id}",[CertificateRequestsController::class,"delete"])->middleware(['auth', 'roles:1,2,3'])->where('id', '[a-z0-9.\-]+');
    //Route::get("/requests/restore/{id}",[CertificateRequestsController::class,"restore"])->middleware(['auth', 'roles:1,2,3'])->where('id', '[a-z0-9.\-]+');
    Route::get("/requests/list",[CertificateRequestsController::class,"list"])->middleware(['auth', 'roles:1,2,3']); 

/*==============================================END TEMPLATES=============================================*/

/*==================================================SETTINGS=================================================*/

//---------------------------------------------------Views-----------------------------------------------------

    Route::get("/dashboard/settings",[DashboardController::class,"settings"])->middleware(['auth', 'roles:1']);

//------------------------------------------------Endpoints------------------------------------------------

    Route::post("/setting/save/prices",[SettingsController::class,"savePrices"])->middleware(['auth', 'roles:1']);  
    Route::post("/setting/save/specialties",[SettingsController::class,"saveSpecialties"])->middleware(['auth', 'roles:1']);  
    Route::post("/setting/save/colors",[SettingsController::class,"saveColors"])->middleware(['auth', 'roles:1']);   
    Route::post("/setting/save/logos",[SettingsController::class,"saveLogos"])->middleware(['auth', 'roles:1']);  

/*==============================================END SETTINGS=================================================*/

/*==================================================REPORT===================================================*/

//---------------------------------------------------Views-----------------------------------------------------

    Route::get("/dashboard/report",[DashboardController::class,"report"])->middleware(['auth', 'roles:1']);

//------------------------------------------------Endpoints------------------------------------------------

    Route::get("/report/generateReport",[ReportController::class,"generateReport"])->middleware(['auth', 'roles:1']); 
    Route::post("/report/previewReport",[ReportController::class,"previewReport"])->middleware(['auth', 'roles:1']); 

/*==============================================END REPORT=================================================*/

/*==================================================PUBLIC=================================================*/

//---------------------------------------------------Views-----------------------------------------------------

    Route::get("/",[PublicController::class,"index"]);
    Route::get("/home",[PublicController::class,"index"]);
    Route::get("/profile",[PublicController::class,"profile"])->middleware(['auth', 'roles:3']); 
    Route::get("/appointment/{id}",[PublicController::class,"appointment"])->where('id', '[a-z0-9.\-]+');
    Route::get("/medicals",[PublicController::class,"medicals"]);  
    Route::get("/medicals/{page}",[PublicController::class,"medicals"])->where('page', '[0-9]+');  

//------------------------------------------------Endpoints------------------------------------------------

/*==============================================END PUBLIC=============================================*/

/*==================================================NOTIFICATIONS==========================================*/

//---------------------------------------------------Views-----------------------------------------------------

//------------------------------------------------Endpoints------------------------------------------------

    Route::get("/notifications/list",[NotificationsController::class,"list"])->middleware(['auth', 'roles:1,2,3']);
    Route::get("/notifications/stream",[NotificationsController::class,"stream"])->middleware(['auth', 'roles:1,2,3']);  
    Route::get("/notifications/markAsRead/{id}",[NotificationsController::class,"markAsRead"])->middleware(['auth', 'roles:1,2,3'])->where('id', '[a-z0-9.\-]+');  
    Route::get("/notifications/delete/{id}",[NotificationsController::class,"delete"])->middleware(['auth', 'roles:1,2,3'])->where('id', '[a-z0-9.\-]+');  

/*==============================================END NOTIFICATIONS=========================================*/


