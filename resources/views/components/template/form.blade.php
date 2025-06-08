<form action="#" method="POST" id="form"  class="grid grid-cols-1 md:grid-cols-6 gap-y-4 gap-x-0 md:gap-4 mx-4">  
    <section class="bg-white dark:bg-slate-900 px-7 pt-5 pb-5 w-full rounded-lg col-span-6 md:col-span-2 relative h-fit">
        <div class="px-2">
            <div class="relative z-0 mb-2 group">
                <input type="text" autocomplete="off" name="name" id="name" value="" class="block py-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer" placeholder="" />
                <label for="name" class="peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("messages.name")}}</label>
                <small id="name_message" class="text_error pl-2 italic"></small>
            </div>
        </div>
        <div class="px-2 col-span-2 md:col-span-1">
            <div class="relative z-0 group mb-2">
                <select name="module" id="module" class="bg-white dark:bg-slate-900 block p-2 w-full text-sm input_text bg-transparent border-0 border-b-2 input_border appearance-none focus:outline-none focus:ring-0 peer">
                    <option value=""></option>
                    <option value="patients">{{__("routes.patients")}}</option>
                    <option value="medicals">{{__("routes.medicals")}}</option>
                    <option value="appointments">{{__("routes.appointments")}}</option>
                    <option value="encounters">{{__("routes.encounters")}}</option>
                    <option value="supplies">{{__("routes.supplies")}}</option>
                    <option value="services">{{__("routes.services")}}</option>
                </select> 
                <label for="module" class="z-10 peer-focus:font-medium absolute text-sm input_label_text duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">{{__("routes.module")}}</label>
                <small id="module_message" class="text_error pl-2 italic"></small>
            </div>
        </div>
    </section>
    <section class="bg-white dark:bg-slate-900 px-7 pt-5 pb-5 w-full rounded-lg col-span-6 md:col-span-4 relative h-fit">
        <div id="editorContent">
            <div>
                <label for="headerEditor">Header</label>
                <div id="headerEditor" class="editor-container"></div>
                <textarea name="header" id="header" style="display: none;"></textarea>
              </div>
            <div>
                <label for="contentEditor">Content</label>
                <div id="contentEditor" class="editor-container"></div>
                <textarea name="body" id="body" style="display: none;"></textarea>
            </div> 
            <div>
                <label for="footerEditor">Footer</label>
                <div id="footerEditor" class="editor-container"></div>
                <textarea name="footer" id="footer" style="display: none;"></textarea>
            </div>
        </div>
    </section> 
</form>