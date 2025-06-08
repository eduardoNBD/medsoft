<h3 class="text-lg font-semibold text_regular m-2">{{__('messages.colors')}}</h3>
<hr class="mb-4">
<form id="colorsForms" class="grid grid-cols-2 px-0 md:px-8">
    <div class="col-span-2">
        <h3 class="text-xl font-semibold text_regular m-2 text-center">{{__('messages.general')}}</h3>
        <hr>
    </div>
    <div class="col-span-2">
        <div class="grid grid-cols-8 mt-4"> 
            <div class="px-2 col-span-2 md:col-span-1 mb-4 text-center flex flex-col items-center"> 
                <label for="bg_login" class="text-xs text_regular">{{__("messages.backgroundLogin")}}</label>
                <input type="color" value="{{$colors ? $colors->bg_login : '#4D4E8D'}}" class="mt-2" id="bg_login" name="bg_login">  
            </div>   
            <div class="px-2 col-span-2 md:col-span-1 mb-4 text-center flex flex-col items-center"> 
                <label for="bg_loader" class="text-xs text_regular">{{__("messages.backgroundLoader")}}</label>
                <input type="color" value="{{$colors ? $colors->bg_loader : '#4D4E8D'}}" class="mt-2" id="bg_loader" name="bg_loader">  
            </div>   
        </div> 
    </div>
    <hr class="col-span-2">
    <div class="col-span-2 md:col-span-1">
        <h3 class="text-xl font-semibold text_regular m-2">{{__('messages.lightMode')}}</h3>
        <div class="grid grid-cols-8">
            <div class="col-span-8 mb-4 mt-8 mx-2">
                <p class="col-span-8 text_regular text-center mb-2 text-lg">{{__("messages.main")}}</p>
                <hr> 
            </div>
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="bg_main_light_mode" class="text-xs text_regular">{{__("messages.backgroundMain")}}</label>
                <input type="color" value="{{$colors ? $colors->bg_main_light_mode : '#ededed'}}" class="mt-2" id="bg_main_light_mode" name="bg_main_light_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="bg_secondary_light_mode" class="text-xs text_regular">{{__("messages.backgroundSecondary")}}</label>
                <input type="color" value="{{$colors ? $colors->bg_secondary_light_mode : '#fafafa'}}" class="mt-2" id="bg_secondary_light_mode" name="bg_secondary_light_mode"> 
            </div>   
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="bg_modal_light_mode" class="text-xs text_regular">{{__("messages.backgroundModal")}}</label>
                <input type="color" value="{{$colors ? $colors->bg_modal_light_mode : '#fafafa'}}" class="mt-2" id="bg_modal_light_mode" name="bg_modal_light_mode">  
            </div> 
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="title_text_light_mode" class="text-xs text_regular">{{__("messages.titles")}}</label>
                <input type="color" value="{{$colors ? $colors->title_text_light_mode : '#101828'}}" class="mt-2" id="title_text_light_mode" name="title_text_light_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="paragraph_text_light_mode" class="text-xs text_regular">{{__("messages.texts")}}</label>
                <input type="color" value="{{$colors ? $colors->paragraph_text_light_mode : '#101828'}}" class="mt-2" id="paragraph_text_light_mode" name="paragraph_text_light_mode">  
            </div>   
            <div class="col-span-8 mb-4 mt-8 mx-2">
                <p class="col-span-8 text_regular text-center mb-2 text-lg">{{__("messages.menu")}}</p>
                <hr> 
            </div>
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="link_text_light_mode" class="text-xs text_regular">{{__("messages.link")}}</label>
                <input type="color" value="{{$colors ? $colors->link_text_light_mode : '#526270'}}" class="mt-2" id="link_text_light_mode" name="link_text_light_mode">  
            </div>   
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="link_text_hover_light_mode" class="text-xs text_regular">{{__("messages.linkHover")}}</label>
                <input type="color" value="{{$colors ? $colors->link_text_hover_light_mode : '#d1d5db'}}" class="mt-2" id="link_text_hover_light_mode" name="link_text_hover_light_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="link_background_hover_light_mode" class="text-xs text_regular">{{__("messages.linkBackgroundHover")}}</label>
                <input type="color" value="{{$colors ? $colors->link_background_hover_light_mode : '#4d4e8d'}}" class="mt-2" id="link_background_hover_light_mode" name="link_background_hover_light_mode"> 
            </div>    
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="link_text_active_light_mode" class="text-xs text_regular">{{__("messages.linkActive")}}</label>
                <input type="color" value="{{$colors ? $colors->link_text_active_light_mode : '#d1d5db'}}" class="mt-2" id="link_text_active_light_mode" name="link_text_active_light_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="link_background_active_light_mode" class="text-xs text_regular">{{__("messages.linkBackgroundActive")}}</label>
                <input type="color" value="{{$colors ? $colors->link_background_active_light_mode : '#4d4e8d'}}" class="mt-2" id="link_background_active_light_mode" name="link_background_active_light_mode">  
            </div> 
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="add_button_light_mode" class="text-xs text_regular">{{__("messages.button")}}</label>
                <input type="color" value="{{$colors ? $colors->add_button_light_mode : '#312c85'}}" class="mt-2" id="add_button_light_mode" name="add_button_light_mode">  
            </div>   
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="add_text_button_light_mode" class="text-xs text_regular">{{__("messages.buttonText")}}</label>
                <input type="color" value="{{$colors ? $colors->add_text_button_light_mode : '#fafafa'}}" class="mt-2" id="add_text_button_light_mode" name="add_text_button_light_mode">  
            </div>   
            <div class="col-span-8 mb-4 mt-8 mx-2">
                <p class="col-span-8 text_regular text-center mb-2 text-lg">{{__("messages.header")}}</p>
                <hr> 
            </div>
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="header_text_light_mode" class="text-xs text_regular">{{__("messages.text")}}</label>
                <input type="color" value="{{$colors ? $colors->header_text_light_mode : '#111827'}}" class="mt-2" id="header_text_light_mode" name="header_text_light_mode">  
            </div> 
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="header_background_light_mode" class="text-xs text_regular">{{__("messages.background")}}</label>
                <input type="color" value="{{$colors ? $colors->header_background_light_mode : '#fafafa'}}" class="mt-2" id="header_background_light_mode" name="header_background_light_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="header_background_hover_light_mode" class="text-xs text_regular">{{__("messages.backgroundHover")}}</label>
                <input type="color" value="{{$colors ? $colors->header_background_hover_light_mode : '#ededed'}}" class="mt-2" id="header_background_hover_light_mode" name="header_background_hover_light_mode"> 
            </div>
            <div class="col-span-8 mb-4 mt-8 mx-2">
                <p class="col-span-8 text_regular text-center mb-2 text-lg">{{__("messages.breadcrumbs")}}</p>
                <hr> 
            </div>
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="breadcrumbs_text_light_mode" class="text-xs text_regular">{{__("messages.breadcrumbs")}}</label>
                <input type="color" value="{{$colors ? $colors->breadcrumbs_text_light_mode : '#526270'}}" class="mt-2" id="breadcrumbs_text_light_mode" name="breadcrumbs_text_light_mode">  
            </div>   
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="breadcrumbs_text_hover_light_mode" class="text-xs text_regular">{{__("messages.breadcrumbsHover")}}</label>
                <input type="color" value="{{$colors ? $colors->breadcrumbs_text_hover_light_mode : '#4d4e8d'}}" class="mt-2" id="breadcrumbs_text_hover_light_mode" name="breadcrumbs_text_hover_light_mode">  
            </div>  
            <div class="col-span-8 mb-4 mt-8 mx-2">
                <p class="col-span-8 text_regular text-center mb-2 text-lg">{{__("messages.text")}}</p>
                <hr> 
            </div>
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="text_primary_light_mode" class="text-xs text_regular">{{__("messages.primary")}}</label>
                <input type="color" value="{{$colors ? $colors->link_background_active_light_mode : '#1e429f'}}" class="mt-2" id="text_primary_light_mode" name="text_primary_light_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="text_secondary_light_mode" class="text-xs text_regular">{{__("messages.secondary")}}</label>
                <input type="color" value="{{$colors ? $colors->text_secondary_light_mode : '#4d4e8d'}}" class="mt-2" id="text_secondary_light_mode" name="text_secondary_light_mode"> 
            </div>   
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="text_error_light_mode" class="text-xs text_regular">{{__("messages.error")}}</label>
                <input type="color" value="{{$colors ? $colors->text_error_light_mode : '#9B1C1C'}}" class="mt-2" id="text_error_light_mode" name="text_error_light_mode"> 
            </div>
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="text_success_light_mode" class="text-xs text_regular">{{__("messages.success")}}</label>
                <input type="color" value="{{$colors ? $colors->text_success_light_mode : '#0E9F6E'}}" class="mt-2" id="text_success_light_mode" name="text_success_light_mode"> 
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="text_regular_light_mode" class="text-xs text_regular">{{__("messages.regular")}}</label>
                <input type="color" value="{{$colors ? $colors->text_regular_light_mode : '#526270'}}" class="mt-2" id="text_regular_light_mode" name="text_regular_light_mode"> 
            </div> 
            <div class="col-span-8 mb-4 mt-8 mx-2">
                <p class="col-span-8 text_regular text-center mb-2 text-lg">{{__("messages.buttons")}}</p>
                <hr> 
            </div>
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="button_primary_light_mode" class="text-xs text_regular">{{__("messages.primary")}}</label>
                <input type="color" value="{{$colors ? $colors->button_primary_light_mode : '#1E429F'}}" class="mt-2" id="button_primary_light_mode" name="button_primary_light_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="button_secondary_light_mode" class="text-xs text_regular">{{__("messages.secondary")}}</label>
                <input type="color" value="{{$colors ? $colors->button_secondary_light_mode : '#4d4e8d'}}" class="mt-2" id="button_secondary_light_mode" name="button_secondary_light_mode"> 
            </div>   
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="button_error_light_mode" class="text-xs text_regular">{{__("messages.error")}}</label>
                <input type="color" value="{{$colors ? $colors->button_error_light_mode : '#9B1C1C'}}" class="mt-2" id="button_error_light_mode" name="button_error_light_mode"> 
            </div>
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="button_success_light_mode" class="text-xs text_regular">{{__("messages.success")}}</label>
                <input type="color" value="{{$colors ? $colors->button_success_light_mode : '#0E9F6E'}}" class="mt-2" id="button_success_light_mode" name="button_success_light_mode"> 
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="button_warning_light_mode" class="text-xs text_regular">{{__("messages.warning")}}</label>
                <input type="color" value="{{$colors ? $colors->button_warning_light_mode : '#FCE96A'}}" class="mt-2" id="button_warning_light_mode" name="button_warning_light_mode"> 
            </div> 
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="button_regular_light_mode" class="text-xs text_regular">{{__("messages.regular")}}</label>
                <input type="color" value="{{$colors ? $colors->button_regular_light_mode : '#526270'}}" class="mt-2" id="button_regular_light_mode" name="button_regular_light_mode"> 
            </div> 
            <div class="col-span-8 mb-4 mt-8 mx-2">
                <p class="col-span-8 text_regular text-center mb-2 text-lg">Tabs</p>
                <hr> 
            </div>
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="tab_background_light_mode" class="text-xs text_regular">{{__("messages.background")}}</label>
                <input type="color" value="{{$colors ? $colors->tab_background_light_mode : '#fafafa'}}" class="mt-2" id="tab_background_light_mode" name="tab_background_light_mode">  
            </div>   
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="tab_text_light_mode" class="text-xs text_regular">{{__("messages.text")}}</label>
                <input type="color" value="{{$colors ? $colors->tab_text_light_mode : '#526270'}}" class="mt-2" id="tab_text_light_mode" name="tab_text_light_mode"> 
            </div>   
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="tab_background_hover_light_mode" class="text-xs text_regular">{{__("messages.backgroundHover")}}</label>
                <input type="color" value="{{$colors ? $colors->tab_background_hover_light_mode : '#4d4e8d'}}" class="mt-2" id="tab_background_hover_light_mode" name="tab_background_hover_light_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="tab_text_hover_light_mode" class="text-xs text_regular">{{__("messages.textHover")}}</label>
                <input type="color" value="{{$colors ? $colors->tab_text_hover_light_mode : '#d1d5db'}}" class="mt-2" id="tab_text_hover_light_mode" name="tab_text_hover_light_mode"> 
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="tab_background_active_light_mode" class="text-xs text_regular">{{__("messages.backgroundActive")}}</label>
                <input type="color" value="{{$colors ? $colors->tab_background_active_light_mode : '#4d4e8d'}}" class="mt-2" id="tab_background_active_light_mode" name="tab_background_active_light_mode"> 
            </div>
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="tab_text_active_light_mode" class="text-xs text_regular">{{__("messages.textActive")}}</label>
                <input type="color" value="{{$colors ? $colors->tab_text_active_light_mode : '#d1d5db'}}" class="mt-2" id="tab_text_active_light_mode" name="tab_text_active_light_mode"> 
            </div>   
            <div class="col-span-8 mb-4 mt-8 mx-2">
                <p class="col-span-8 text_regular text-center mb-2 text-lg">{{__("messages.tables")}}</p>
                <hr> 
            </div>
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="table_background_light_mode" class="text-xs text_regular">{{__("messages.background")}}</label>
                <input type="color" value="{{$colors ? $colors->table_background_light_mode : '#fafafa'}}" class="mt-2" id="table_background_light_mode" name="table_background_light_mode">  
            </div>   
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="table_text_light_mode" class="text-xs text_regular">{{__("messages.text")}}</label>
                <input type="color" value="{{$colors ? $colors->table_text_light_mode : '#526270'}}" class="mt-2" id="table_text_light_mode" name="table_text_light_mode"> 
            </div>   
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="table_header_light_mode" class="text-xs text_regular">{{__("messages.header")}}</label>
                <input type="color" value="{{$colors ? $colors->table_header_light_mode : '#4d4e8d'}}" class="mt-2" id="table_header_light_mode" name="table_header_light_mode"> 
            </div> 
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="text_table_header_light_mode" class="text-xs text_regular">{{__("messages.textHeader")}}</label>
                <input type="color" value="{{$colors ? $colors->text_table_header_light_mode : '#FAFAFA'}}" class="mt-2" id="text_table_header_light_mode" name="text_table_header_light_mode"> 
            </div> 
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="button_table_submenu_light_mode" class="text-xs text_regular">{{__("messages.submenuTable")}}</label>
                <input type="color" value="{{$colors ? $colors->button_table_submenu_light_mode : '#fafafa'}}" class="mt-2" id="button_table_submenu_light_mode" name="button_table_submenu_light_mode"> 
            </div> 
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="submenu_text_light_mode" class="text-xs text_regular">{{__("messages.textSubmenu")}}</label>
                <input type="color" value="{{$colors ? $colors->submenu_text_light_mode : '#444444'}}" class="mt-2" id="submenu_text_light_mode" name="submenu_text_light_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="pagination_background_light_mode" class="text-xs text_regular">{{__("messages.paginationBackground")}}</label>
                <input type="color" value="{{$colors ? $colors->pagination_background_light_mode : '#fafafa'}}" class="mt-2" id="pagination_background_light_mode" name="pagination_background_light_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="pagination_background_hover_light_mode" class="text-xs text_regular">{{__("messages.paginationBackgroundhover")}}</label>
                <input type="color" value="{{$colors ? $colors->pagination_background_hover_light_mode : '#4d4e8d'}}" class="mt-2" id="pagination_background_hover_light_mode" name="pagination_background_hover_light_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="pagination_background_active_light_mode" class="text-xs text_regular">{{__("messages.paginationBackgroundActive")}}</label>
                <input type="color" value="{{$colors ? $colors->pagination_background_active_light_mode : '#4d4e8d'}}" class="mt-2" id="pagination_background_active_light_mode" name="pagination_background_active_light_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="pagination_text_light_mode" class="text-xs text_regular">{{__("messages.paginationText")}}</label>
                <input type="color" value="{{$colors ? $colors->pagination_text_light_mode : '#526270'}}" class="mt-2" id="pagination_text_light_mode" name="pagination_text_light_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="pagination_text_hover_light_mode" class="text-xs text_regular">{{__("messages.paginationTextHover")}}</label>
                <input type="color" value="{{$colors ? $colors->pagination_text_hover_light_mode : '#fafafa'}}" class="mt-2" id="pagination_text_hover_light_mode" name="pagination_text_hover_light_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="pagination_text_active_light_mode" class="text-xs text_regular">{{__("messages.paginationTextActive")}}</label>
                <input type="color" value="{{$colors ? $colors->pagination_text_active_light_mode : '#fafafa'}}" class="mt-2" id="pagination_text_active_light_mode" name="pagination_text_active_light_mode">  
            </div>   
            <div class="col-span-8 mb-4 mt-8 mx-2">
                <p class="col-span-8 text_regular text-center mb-2 text-lg">{{__("messages.inputs")}}</p>
                <hr> 
            </div>
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="input_text_light_mode" class="text-xs text_regular">{{__("messages.text")}}</label>
                <input type="color" value="{{$colors ? $colors->input_text_light_mode : '#526270'}}" class="mt-2" id="input_text_light_mode" name="input_text_light_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="input_label_text_light_mode" class="text-xs text_regular">{{__("messages.label")}}</label>
                <input type="color" value="{{$colors ? $colors->input_label_text_light_mode : '#526270'}}" class="mt-2" id="input_label_text_light_mode" name="input_label_text_light_mode">  
            </div> 
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="input_label_text_focus_light_mode" class="text-xs text_regular">{{__("messages.labelActive")}}</label>
                <input type="color" value="{{$colors ? $colors->input_label_text_focus_light_mode : '#4d4e8d'}}" class="mt-2" id="input_label_text_focus_light_mode" name="input_label_text_focus_light_mode">  
            </div> 
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="input_border_light_mode" class="text-xs text_regular">{{__("messages.borderInput")}}</label>
                <input type="color" value="{{$colors ? $colors->input_border_light_mode : '#d1d5dc'}}" class="mt-2" id="input_border_light_mode" name="input_border_light_mode">  
            </div> 
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="input_border_focus_light_mode" class="text-xs text_regular">{{__("messages.borderInputActive")}}</label>
                <input type="color" value="{{$colors ? $colors->input_border_focus_light_mode : '#4D4E8D'}}" class="mt-2" id="input_border_focus_light_mode" name="input_border_focus_light_mode">  
            </div> 
            <div class="col-span-8 mb-4 mt-8 mx-2">
                <p class="col-span-8 text_regular text-center mb-2 text-lg">{{__("messages.calendar")}}</p>
                <hr> 
            </div>
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="calendar_background_light_mode" class="text-xs text_regular">{{__("messages.background")}}</label>
                <input type="color" value="{{$colors ? $colors->calendar_background_light_mode : '#fafafa'}}" class="mt-2" id="calendar_background_light_mode" name="calendar_background_light_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="calendar_text_light_mode" class="text-xs text_regular">{{__("messages.text")}}</label>
                <input type="color" value="{{$colors ? $colors->calendar_text_light_mode : '#101828'}}" class="mt-2" id="calendar_text_light_mode" name="calendar_text_light_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="calendar_button_light_mode" class="text-xs text_regular">{{__("messages.button")}}</label>
                <input type="color" value="{{$colors ? $colors->calendar_button_light_mode : '#fafafa'}}" class="mt-2" id="calendar_button_light_mode" name="calendar_button_light_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="calendar_button_hover_light_mode" class="text-xs text_regular">{{__("messages.button")}} hover</label>
                <input type="color" value="{{$colors ? $colors->calendar_button_hover_light_mode : '#f0f0f0'}}" class="mt-2" id="calendar_button_hover_light_mode" name="calendar_button_hover_light_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="calendar_year_text_light_mode" class="text-xs text_regular">{{__("messages.year")}}</label>
                <input type="color" value="{{$colors ? $colors->calendar_year_text_light_mode : '#101828'}}" class="mt-2" id="calendar_year_text_light_mode" name="calendar_year_text_light_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="calendar_month_text_light_mode" class="text-xs text_regular">{{__("messages.month")}}</label>
                <input type="color" value="{{$colors ? $colors->calendar_month_text_light_mode : '#101828'}}" class="mt-2" id="calendar_month_text_light_mode" name="calendar_month_text_light_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="calendar_day_text_light_mode" class="text-xs text_regular">{{__("messages.day")}}</label>
                <input type="color" value="{{$colors ? $colors->calendar_day_text_light_mode : '#526270'}}" class="mt-2" id="calendar_day_text_light_mode" name="calendar_day_text_light_mode">  
            </div>  
        </div>
    </div>
    <div class="col-span-2 md:col-span-1">
        <h3 class="text-xl font-semibold text_regular m-2">{{__('messages.darkMode')}}</h3>
        <div class="grid grid-cols-8">
            <div class="col-span-8 mb-4 mt-8 mx-2">
                <p class="col-span-8 text_regular text-center mb-2 text-lg">{{__("messages.main")}}</p>
                <hr> 
            </div>
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="bg_main_dark_mode" class="text-xs text_regular">{{__("messages.backgroundMain")}}</label>
                <input type="color" value="{{$colors ? $colors->bg_main_dark_mode : '#070F26'}}" class="mt-2" id="bg_main_dark_mode" name="bg_main_dark_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="bg_secondary_dark_mode" class="text-xs text_regular">{{__("messages.backgroundSecondary")}}</label>
                <input type="color" value="{{$colors ? $colors->bg_secondary_dark_mode : '#0f172a'}}" class="mt-2" id="bg_secondary_dark_mode" name="bg_secondary_dark_mode"> 
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="bg_modal_dark_mode" class="text-xs text_regular">{{__("messages.backgroundModal")}}</label>
                <input type="color" value="{{$colors ? $colors->bg_modal_dark_mode : '#1e293b'}}" class="mt-2" id="bg_modal_dark_mode" name="bg_modal_dark_mode"> 
            </div>   
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="title_text_dark_mode" class="text-xs text_regular">{{__("messages.titles")}}</label>
                <input type="color" value="{{$colors ? $colors->title_text_dark_mode : '#d1d5dc'}}" class="mt-2" id="title_text_dark_mode" name="title_text_dark_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="paragraph_text_dark_mode" class="text-xs text_regular">{{__("messages.texts")}}</label>
                <input type="color" value="{{$colors ? $colors->paragraph_text_dark_mode : '#d1d5dc'}}" class="mt-2" id="paragraph_text_dark_mode" name="paragraph_text_dark_mode">  
            </div>  
            <div class="col-span-8 mb-4 mt-8 mx-2">
                <p class="col-span-8 text_regular text-center mb-2 text-lg">{{__("messages.menu")}}</p>
                <hr> 
            </div>
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="link_text_dark_mode" class="text-xs text_regular">{{__("messages.link")}}</label>
                <input type="color" value="{{$colors ? $colors->link_text_dark_mode : '#d1d5db'}}" class="mt-2" id="link_text_dark_mode" name="link_text_dark_mode">  
            </div> 
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="link_text_hover_dark_mode" class="text-xs text_regular">{{__("messages.linkHover")}}</label>
                <input type="color" value="{{$colors ? $colors->link_text_hover_dark_mode : '#d1d5db'}}" class="mt-2" id="link_text_hover_dark_mode" name="link_text_hover_dark_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="link_background_hover_dark_mode" class="text-xs text_regular">{{__("messages.linkBackgroundHover")}}</label>
                <input type="color" value="{{$colors ? $colors->link_background_hover_dark_mode : '#4D4E8D'}}" class="mt-2" id="link_background_hover_dark_mode" name="link_background_hover_dark_mode"> 
            </div>    
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="link_text_active_dark_mode" class="text-xs text_regular">{{__("messages.linkActive")}}</label>
                <input type="color" value="{{$colors ? $colors->link_text_active_dark_mode : '#d1d5db'}}" class="mt-2" id="link_text_active_dark_mode" name="link_text_active_dark_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="link_background_active_dark_mode" class="text-xs text_regular">{{__("messages.linkBackgroundActive")}}</label>
                <input type="color" value="{{$colors ? $colors->link_background_active_dark_mode : '#4D4E8D'}}" class="mt-2" id="link_background_active_dark_mode" name="link_background_active_dark_mode">  
            </div> 
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="add_button_dark_mode" class="text-xs text_regular">{{__("messages.button")}}</label>
                <input type="color" value="{{$colors ? $colors->add_button_dark_mode : '#070f26'}}" class="mt-2" id="add_button_dark_mode" name="add_button_dark_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="add_text_button_dark_mode" class="text-xs text_regular">{{__("messages.buttonText")}}</label>
                <input type="color" value="{{$colors ? $colors->add_text_button_dark_mode : '#d1d5db'}}" class="mt-2" id="add_text_button_dark_mode" name="add_text_button_dark_mode">  
            </div>   
            <div class="col-span-8 mb-4 mt-8 mx-2">
                <p class="col-span-8 text_regular text-center mb-2 text-lg">{{__("messages.header")}}</p>
                <hr> 
            </div>
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="header_text_dark_mode" class="text-xs text_regular">{{__("messages.text")}}</label>
                <input type="color" value="{{$colors ? $colors->header_text_dark_mode : '#d1d5db'}}" class="mt-2" id="header_text_dark_mode" name="header_text_dark_mode">  
            </div> 
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="header_background_dark_mode" class="text-xs text_regular">{{__("messages.background")}}</label>
                <input type="color" value="{{$colors ? $colors->header_background_dark_mode : '#0f172a'}}" class="mt-2" id="header_background_dark_mode" name="header_background_dark_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="header_background_hover_dark_mode" class="text-xs text_regular">{{__("messages.backgroundHover")}}</label>
                <input type="color" value="{{$colors ? $colors->header_background_hover_dark_mode : '#070F26'}}" class="mt-2" id="header_background_hover_dark_mode" name="header_background_hover_dark_mode"> 
            </div>
            <div class="col-span-8 mb-4 mt-8 mx-2">
                <p class="col-span-8 text_regular text-center mb-2 text-lg">{{__("messages.breadcrumbs")}}</p>
                <hr> 
            </div>
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="breadcrumbs_text_dark_mode" class="text-xs text_regular">{{__("messages.breadcrumbs")}}</label>
                <input type="color" value="{{$colors ? $colors->breadcrumbs_text_dark_mode : '#d1d5db'}}" class="mt-2" id="breadcrumbs_text_dark_mode" name="breadcrumbs_text_dark_mode">  
            </div>   
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="breadcrumbs_text_hover_dark_mode" class="text-xs text_regular">{{__("messages.breadcrumbsHover")}}</label>
                <input type="color" value="{{$colors ? $colors->breadcrumbs_text_hover_dark_mode : '#4D4E8D'}}" class="mt-2" id="breadcrumbs_text_hover_dark_mode" name="breadcrumbs_text_hover_dark_mode">  
            </div>  
            <div class="col-span-8 mb-4 mt-8 mx-2">
                <p class="col-span-8 text_regular text-center mb-2 text-lg">{{__("messages.text")}}</p>
                <hr> 
            </div>
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="text_primary_dark_mode" class="text-xs text_regular">{{__("messages.primary")}}</label>
                <input type="color" value="{{$colors ? $colors->text_primary_dark_mode : '#1C64F2'}}" class="mt-2" id="text_primary_dark_mode" name="text_primary_dark_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="text_secondary_dark_mode" class="text-xs text_regular">{{__("messages.secondary")}}</label>
                <input type="color" value="{{$colors ? $colors->text_secondary_dark_mode : '#4D4E8D'}}" class="mt-2" id="text_secondary_dark_mode" name="text_secondary_dark_mode"> 
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="text_error_dark_mode" class="text-xs text_regular">{{__("messages.error")}}</label>
                <input type="color" value="{{$colors ? $colors->text_error_dark_mode : '#9B1C1C'}}" class="mt-2" id="text_error_dark_mode" name="text_error_dark_mode"> 
            </div>
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="text_success_dark_mode" class="text-xs text_regular">{{__("messages.success")}}</label>
                <input type="color" value="{{$colors ? $colors->text_success_dark_mode : '#046C4E'}}" class="mt-2" id="text_success_dark_mode" name="text_success_dark_mode"> 
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="text_regular_dark_mode" class="text-xs text_regular">{{__("messages.regular")}}</label>
                <input type="color" value="{{$colors ? $colors->text_regular_dark_mode : '#d1d5db'}}" class="mt-2" id="text_regular_dark_mode" name="text_regular_dark_mode"> 
            </div>  
            <div class="col-span-8 mb-4 mt-8 mx-2">
                <p class="col-span-8 text_regular text-center mb-2 text-lg">{{__("messages.buttons")}}</p>
                <hr> 
            </div>
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="button_primary_dark_mode" class="text-xs text_regular">{{__("messages.primary")}}</label>
                <input type="color" value="{{$colors ? $colors->button_primary_dark_mode : '#1C64F2'}}" class="mt-2" id="button_primary_dark_mode" name="button_primary_dark_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="button_secondary_dark_mode" class="text-xs text_regular">{{__("messages.secondary")}}</label>
                <input type="color" value="{{$colors ? $colors->button_secondary_dark_mode : '#4D4E8D'}}" class="mt-2" id="button_secondary_dark_mode" name="button_secondary_dark_mode"> 
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="button_error_dark_mode" class="text-xs text_regular">{{__("messages.error")}}</label>
                <input type="color" value="{{$colors ? $colors->button_error_dark_mode : '#9B1C1C'}}" class="mt-2" id="button_error_dark_mode" name="button_error_dark_mode"> 
            </div>
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="button_success_dark_mode" class="text-xs text_regular">{{__("messages.success")}}</label>
                <input type="color" value="{{$colors ? $colors->button_success_dark_mode : '#046C4E'}}" class="mt-2" id="button_success_dark_mode" name="button_success_dark_mode"> 
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="button_warning_dark_mode" class="text-xs text_regular">{{__("messages.warning")}}</label>
                <input type="color" value="{{$colors ? $colors->button_warning_dark_mode : '#E3A008'}}" class="mt-2" id="button_warning_dark_mode" name="button_warning_dark_mode"> 
            </div> 
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="button_regular_dark_mode" class="text-xs text_regular">{{__("messages.regular")}}</label>
                <input type="color" value="{{$colors ? $colors->button_regular_dark_mode : '#526270'}}" class="mt-2" id="button_regular_dark_mode" name="button_regular_dark_mode"> 
            </div>  
            <div class="col-span-8 mb-4 mt-8 mx-2">
                <p class="col-span-8 text_regular text-center mb-2 text-lg">Tabs</p>
                <hr> 
            </div>
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="tab_background_dark_mode" class="text-xs text_regular">{{__("messages.background")}}</label>
                <input type="color" value="{{$colors ? $colors->tab_background_dark_mode : '#0f172a'}}" class="mt-2" id="tab_background_dark_mode" name="tab_background_dark_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="tab_text_dark_mode" class="text-xs text_regular">{{__("messages.text")}}</label>
                <input type="color" value="{{$colors ? $colors->tab_text_dark_mode : '#d1d5db'}}" class="mt-2" id="tab_text_dark_mode" name="tab_text_dark_mode"> 
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="tab_background_hover_dark_mode" class="text-xs text_regular">{{__("messages.backgroundHover")}}</label>
                <input type="color" value="{{$colors ? $colors->tab_background_hover_dark_mode : '#4D4E8D'}}" class="mt-2" id="tab_background_hover_dark_mode" name="tab_background_hover_dark_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="tab_text_hover_dark_mode" class="text-xs text_regular">{{__("messages.textHover")}}</label>
                <input type="color" value="{{$colors ? $colors->tab_text_hover_dark_mode : '#d1d5db'}}" class="mt-2" id="tab_text_hover_dark_mode" name="tab_text_hover_dark_mode"> 
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="tab_background_active_dark_mode" class="text-xs text_regular">{{__("messages.backgroundActive")}}</label>
                <input type="color" value="{{$colors ? $colors->tab_background_active_dark_mode : '#4D4E8D'}}" class="mt-2" id="tab_background_active_dark_mode" name="tab_background_active_dark_mode"> 
            </div>
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="tab_text_active_dark_mode" class="text-xs text_regular">{{__("messages.textActive")}}</label>
                <input type="color" value="{{$colors ? $colors->tab_text_active_dark_mode : '#d1d5db'}}" class="mt-2" id="tab_text_active_dark_mode" name="tab_text_active_dark_mode"> 
            </div>  
            <div class="col-span-8 mb-4 mt-8 mx-2">
                <p class="col-span-8 text_regular text-center mb-2 text-lg">{{__("messages.tables")}}</p>
                <hr> 
            </div>
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="table_background_dark_mode" class="text-xs text_regular">{{__("messages.background")}}</label>
                <input type="color" value="{{$colors ? $colors->table_background_dark_mode : '#0f172a'}}" class="mt-2" id="table_background_dark_mode" name="table_background_dark_mode">  
            </div>  
            
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="table_text_dark_mode" class="text-xs text_regular">{{__("messages.text")}}</label>
                <input type="color" value="{{$colors ? $colors->table_text_dark_mode : '#d1d5db'}}" class="mt-2" id="table_text_dark_mode" name="table_text_dark_mode"> 
            </div>   
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="table_header_dark_mode" class="text-xs text_regular">{{__("messages.header")}}</label>
                <input type="color" value="{{$colors ? $colors->table_header_dark_mode : '#4D4E8D'}}" class="mt-2" id="table_header_dark_mode" name="table_header_dark_mode"> 
            </div> 
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="text_table_header_dark_mode" class="text-xs text_regular">{{__("messages.textHeader")}}</label>
                <input type="color" value="{{$colors ? $colors->text_table_header_dark_mode : '#FAFAFA'}}" class="mt-2" id="text_table_header_dark_mode" name="text_table_header_dark_mode"> 
            </div> 
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="button_table_submenu_dark_mode" class="text-xs text_regular">{{__("messages.submenuTable")}}</label>
                <input type="color" value="{{$colors ? $colors->button_table_submenu_dark_mode : '#020618'}}" class="mt-2" id="button_table_submenu_dark_mode" name="button_table_submenu_dark_mode"> 
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="submenu_text_dark_mode" class="text-xs text_regular">{{__("messages.textSubmenu")}}</label>
                <input type="color" value="{{$colors ? $colors->submenu_text_dark_mode : '#fafafa'}}" class="mt-2" id="submenu_text_dark_mode" name="submenu_text_dark_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="pagination_background_dark_mode" class="text-xs text_regular">{{__("messages.paginationBackground")}}</label>
                <input type="color" value="{{$colors ? $colors->pagination_background_dark_mode : '#0f172a'}}" class="mt-2" id="pagination_background_dark_mode" name="pagination_background_dark_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="pagination_background_hover_dark_mode" class="text-xs text_regular">{{__("messages.paginationBackgroundhover")}}</label>
                <input type="color" value="{{$colors ? $colors->pagination_background_hover_dark_mode : '#4D4E8D'}}" class="mt-2" id="pagination_background_hover_dark_mode" name="pagination_background_hover_dark_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="pagination_background_active_dark_mode" class="text-xs text_regular">{{__("messages.paginationBackgroundActive")}}</label>
                <input type="color" value="{{$colors ? $colors->pagination_background_active_dark_mode : '#4D4E8D'}}" class="mt-2" id="pagination_background_active_dark_mode" name="pagination_background_active_dark_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="pagination_text_dark_mode" class="text-xs text_regular">{{__("messages.paginationText")}}</label>
                <input type="color" value="{{$colors ? $colors->pagination_text_dark_mode : '#d1d5db'}}" class="mt-2" id="pagination_text_dark_mode" name="pagination_text_dark_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="pagination_text_hover_dark_mode" class="text-xs text_regular">{{__("messages.paginationTextHover")}}</label>
                <input type="color" value="{{$colors ? $colors->pagination_text_hover_dark_mode : '#fafafa'}}" class="mt-2" id="pagination_text_hover_dark_mode" name="pagination_text_hover_dark_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="pagination_text_active_dark_mode" class="text-xs text_regular">{{__("messages.paginationTextActive")}}</label>
                <input type="color" value="{{$colors ? $colors->pagination_text_active_dark_mode : '#fafafa'}}" class="mt-2" id="pagination_text_active_dark_mode" name="pagination_text_active_dark_mode">  
            </div>  
            <div class="col-span-8 mb-4 mt-8 mx-2">
                <p class="col-span-8 text_regular text-center mb-2 text-lg">{{__("messages.inputs")}}</p>
                <hr> 
            </div>
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="input_text_dark_mode" class="text-xs text_regular">{{__("messages.text")}}</label>
                <input type="color" value="{{$colors ? $colors->input_text_dark_mode : '#d1d5db'}}" class="mt-2" id="input_text_dark_mode" name="input_text_dark_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="input_label_text_dark_mode" class="text-xs text_regular">{{__("messages.label")}}</label>
                <input type="color" value="{{$colors ? $colors->input_label_text_dark_mode : '#d1d5db'}}" class="mt-2" id="input_label_text_dark_mode" name="input_label_text_dark_mode">  
            </div> 
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="input_label_text_focus_dark_mode" class="text-xs text_regular">{{__("messages.labelActive")}}</label>
                <input type="color" value="{{$colors ? $colors->input_label_text_focus_dark_mode : '#4D4E8D'}}" class="mt-2" id="input_label_text_focus_dark_mode" name="input_label_text_focus_dark_mode">  
            </div> 
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="input_border_dark_mode" class="text-xs text_regular">{{__("messages.borderInput")}}</label>
                <input type="color" value="{{$colors ? $colors->input_border_dark_mode : '#d1d5dc'}}" class="mt-2" id="input_border_dark_mode" name="input_border_dark_mode">  
            </div> 
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="input_border_focus_dark_mode" class="text-xs text_regular">{{__("messages.borderInputActive")}}</label>
                <input type="color" value="{{$colors ? $colors->input_border_focus_dark_mode : '#4D4E8D'}}" class="mt-2" id="input_border_focus_dark_mode" name="input_border_focus_dark_mode">  
            </div> 
            <div class="col-span-8 mb-4 mt-8 mx-2">
                <p class="col-span-8 text_regular text-center mb-2 text-lg">{{__("messages.calendar")}}</p>
                <hr> 
            </div>
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="calendar_background_dark_mode" class="text-xs text_regular">{{__("messages.background")}}</label>
                <input type="color" value="{{$colors ? $colors->calendar_background_dark_mode : '#1e293b'}}" class="mt-2" id="calendar_background_dark_mode" name="calendar_background_dark_mode">  
            </div>   
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="calendar_text_dark_mode" class="text-xs text_regular">{{__("messages.text")}}</label>
                <input type="color" value="{{$colors ? $colors->calendar_text_dark_mode : '#fafafa'}}" class="mt-2" id="calendar_text_dark_mode" name="calendar_text_dark_mode">  
            </div> 
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="calendar_button_dark_mode" class="text-xs text_regular">{{__("messages.button")}}</label>
                <input type="color" value="{{$colors ? $colors->calendar_button_dark_mode : '#1e293b'}}" class="mt-2" id="calendar_button_dark_mode" name="calendar_button_dark_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="calendar_button_hover_dark_mode" class="text-xs text_regular">{{__("messages.button")}} hover</label>
                <input type="color" value="{{$colors ? $colors->calendar_button_hover_dark_mode : '#1E203B'}}" class="mt-2" id="calendar_button_hover_dark_mode" name="calendar_button_hover_dark_mode">  
            </div>  
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="calendar_year_text_dark_mode" class="text-xs text_regular">{{__("messages.year")}}</label>
                <input type="color" value="{{$colors ? $colors->calendar_year_text_dark_mode : '#fafafa'}}" class="mt-2" id="calendar_year_text_dark_mode" name="calendar_year_text_dark_mode">  
            </div> 
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="calendar_month_text_dark_mode" class="text-xs text_regular">{{__("messages.month")}}</label>
                <input type="color" value="{{$colors ? $colors->calendar_month_text_dark_mode : '#fafafa'}}" class="mt-2" id="calendar_month_text_dark_mode" name="calendar_month_text_dark_mode">  
            </div> 
            <div class="px-2 col-span-4 md:col-span-2 mb-4 text-center flex flex-col items-center"> 
                <label for="calendar_day_text_dark_mode" class="text-xs text_regular">{{__("messages.day")}}</label>
                <input type="color" value="{{$colors ? $colors->calendar_day_text_dark_mode : '#526270'}}" class="mt-2" id="calendar_day_text_dark_mode" name="calendar_day_text_dark_mode">  
            </div>   
        </div>
    </div>  
    <div class="px-2 col-span-2 text-right mt-8"> 
        <button class="text-white button_success focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-8 py-2">
            {{__("messages.save")}}
        </button>
    </div>   
</form> 