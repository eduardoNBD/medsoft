function initMultiSelect(selectElement,options = {}) {
  const { 
    inputClass = "",
    optionsContinerClass = "",
    labelInputClass = "peer-focus:font-medium absolute text-sm text-[#526270] dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-[#4D4E8D] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6",
    errorLabelInputClass = "text_error pl-2 italic",
    placeholder = "",
    labelText = "",
    noResults  = "",
    placeholderSearch = "",
  } = options;

  const id = selectElement.id;
  selectElement.style.display = 'none'; 

  // Crear el contenedor principal
  const container = document.createElement('div');
  container.classList.add('multiselect-container');

  // Crear el campo de búsqueda
  const inputShow = document.createElement('input');
  
  inputShow.type = 'text';
  inputShow.placeholder = placeholder;
  inputShow.classList = `search-input ${inputClass}`;
  inputShow.readOnly = "readOnly";
  container.appendChild(inputShow);

  const labelInput = document.createElement('label');
  const errorLabelInput = document.createElement('small');

  labelInput.textContent = labelText;

  labelInput.classList = labelInputClass;

  errorLabelInput.classList = errorLabelInputClass; 
  errorLabelInput.id = `${id}_message`;

  container.appendChild(labelInput);
  container.appendChild(errorLabelInput);
 
  const optionsContainer = document.createElement('div');
  optionsContainer.classList= `options ${optionsContinerClass}`;
  container.appendChild(optionsContainer);

  const searchInput = document.createElement('input');
  searchInput.placeholder = placeholderSearch;
  optionsContainer.appendChild(searchInput);
  
  searchInput.classList = "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full px-2 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500";
  
  Array.from(selectElement.options).filter(option => option.value != "").forEach(option => { 
    const label = document.createElement('label');
    const checkbox = document.createElement('input');
    label.classList = "p-2";
    checkbox.type = 'checkbox';
    checkbox.value = option.value;
  
    checkbox.checked = option.selected; 
    // Sincronizar el valor seleccionado con el <select> original
    checkbox.addEventListener('change', () => {
      option.selected = checkbox.checked; 
      updateContent(selectElement,inputShow);
    });

    label.appendChild(checkbox);
    label.appendChild(document.createTextNode(option.textContent));
    optionsContainer.appendChild(label); 
  });

  const label = document.createElement('label');
  label.innerHTML = noResults;
  label.id = "noResults";
  label.style.display = "none";

  optionsContainer.appendChild(label); 
  // Insertar el contenedor del multiselect después del <select> original
  selectElement.parentNode.insertBefore(container, selectElement.nextSibling);

  // Mostrar y ocultar el menú desplegable
  inputShow.addEventListener('focus', () => {
    optionsContainer.style.display = 'block';
  });

  document.addEventListener('click', (event) => {
    if (!container.contains(event.target)) {
      optionsContainer.style.display = 'none';
    }
  });
  // Filtrar opciones según la búsqueda
  searchInput.addEventListener('input', () => {
    const filter = searchInput.value.toLowerCase();
      Array.from(optionsContainer.children).forEach(label => {
        if(!label.type){
          const text = label.textContent.toLowerCase();
          label.style.display = text.includes(filter) ? 'block' : 'none';
        }
      }); 

      if(Array.from(optionsContainer.children).filter(label => label.textContent.toLowerCase().includes(filter)).length == 0){
        container.querySelector("#noResults").style.display = "block";
      }else{
        container.querySelector("#noResults").style.display = "none";
      }
  });

  updateContent(selectElement,inputShow);
}

function updateContent(selectElement,content){
  const selected = [];

  Array.from(selectElement.options).filter(option => option.value != "").forEach(option => { 
    if(option.selected){
      selected.push(option.textContent); 
    }
  });

  content.value = selected.join(", ");
}
  
HTMLSelectElement.prototype.initMultiSelect = function(options) {
  initMultiSelect(this,options); 
};

HTMLSelectElement.prototype.getSelectedValues = function() {
  return Array.from(this.options)
    .filter(option => option.selected)
    .map(option => option.value);
};
  