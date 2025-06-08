function autocomplete(inp, arr, msgNotFound, callback, searchFields = ["name"]) {
    var currentFocus;

    inp.addEventListener("input", (e) => {
        if (inp.dataset.object) {
            if (JSON.parse(inp.dataset.object).name.trim() != inp.value.trim()) {
                inp.dataset.object = "";
            }
        }
        var a, b, i, indexed = 0, exist = false, val = e.target.value;

        closeAllLists();

        if (!val) {
            inp.dispatchEvent(new Event("click"));
            return false;
        }

        currentFocus = -1;

        a = document.createElement("DIV");
        a.setAttribute("id", e.target.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");

        e.target.parentNode.appendChild(a);

        for (i = 0; i < arr.length; i++) {
            let match = searchFields.some(field => {
                return arr[i][field]?.substr(0, val.length).toUpperCase() == val.toUpperCase();
            });

            if (match) {
                if (!exist) {
                    exist = true;
                }

                b = document.createElement("DIV"); 
                b.innerHTML += arr[i].name;
                b.innerHTML += "<input type='hidden' value='" + arr[i].name + "' data-object='" + JSON.stringify(arr[i]) + "'>";
                b.addEventListener("click", (e) => {
                    inp.value = event.currentTarget.getElementsByTagName("input")[0].value;
                    inp.dataset.object = event.currentTarget.getElementsByTagName("input")[0].dataset.object;

                    if (callback) callback(inp);
                    closeAllLists();
                });
                a.appendChild(b);

                if (indexed == 4) {
                    break;
                }

                indexed++;
            }
        }

        if (!exist) {
            b = document.createElement("DIV");
            b.innerHTML = msgNotFound;
            a.appendChild(b);
        }
    });

    inp.addEventListener("click", (e) => {
        e.stopPropagation();
        var a, b, i, exist = false, val = e.target.value;

        closeAllLists();

        a = document.createElement("DIV");
        a.setAttribute("id", e.target.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");

        e.target.parentNode.appendChild(a);

        for (i = 0; i < arr.length; i++) {
            if (i == 5) {
                break;
            }

            let match = searchFields.some(field => {
                return arr[i][field]?.substr(0, val.length).toUpperCase() == val.toUpperCase();
            });

            if (!val || match) {
                if (!exist) {
                    exist = true;
                }

                b = document.createElement("DIV");
                b.innerHTML += arr[i].name;
                b.innerHTML += `<input type='hidden' value='${arr[i].name}' data-object='${JSON.stringify(arr[i])}'>`;

                b.addEventListener("click", (e) => {
                    inp.value = event.currentTarget.getElementsByTagName("input")[0].value;
                    inp.dataset.object = event.currentTarget.getElementsByTagName("input")[0].dataset.object;

                    if (callback) callback(inp);
                    closeAllLists();
                });
                a.appendChild(b);
            }
        }
    });

    inp.addEventListener("focusout", (event) => {
        event.target.value = event.target.dataset.object ? event.target.value : "";
    });

    inp.addEventListener("keydown", function(e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
            currentFocus++;
            addActive(x);
        } else if (e.keyCode == 38) {
            currentFocus--;
            addActive(x);
        } else if (e.keyCode == 13) {
            e.preventDefault();
            if (currentFocus > -1) {
                if (x) x[currentFocus].click();
            }
        }
    });

    function addActive(x) {
        if (!x) return false;

        removeActive(x);

        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (x.length - 1);

        x[currentFocus].classList.add("autocomplete-active");
    }

    function removeActive(x) {
        for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
        }
    }

    function closeAllLists(element) {
        var x = document.getElementsByClassName("autocomplete-items");

        for (var i = 0; i < x.length; i++) {
            if (element != x[i] && element != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }

    document.addEventListener("click", function(e) {
        closeAllLists(e.target);
    });
}
