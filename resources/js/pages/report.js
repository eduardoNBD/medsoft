const report_form = $("#report_form");

report_form.addEventListener("submit", (e) => {
    e.preventDefault(); 

    const data = new FormData(event.target);  

    if($("#start").value){
        const start  = $("#start").value.split("/");

        data.set("start",`${start[2]}-${start['1']}-${start['0']}`);
    }
    
    if($("#end").value){
        const end  = $("#end").value.split("/");

        data.set("end",`${end[2]}-${end['1']}-${end['0']}`);
    }
    fetch(url,{
        method: "post", 
        body: data,
        headers: { 
            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }, 
    })
    .then(response => response.json())
    .then(json  => {  
        if(json.status){    
            $("#exportExcellButton").classList.remove("hidden");
            let rows = '';  
            let services = Object.entries(json.servicesType).map(([key, service]) => {
                return {
                    name: service.name,
                    total: service.total,
                    qty: service.qty
                };
            });
            let payments = json.allPayments;
            let totalRows = services.length >= Object.keys(payments).length ? services.length : Object.keys(payments).length;
            let setTotals = false;

            for (let index = 0; index < totalRows; index++) { 
                const service = services[index];
                const payment = payments[(index+1)]; 
                rows+= `<tr>
                            <td class="px-6"></td>
                            ${service ?
                                `<td class="px-4 py-2 bg-gray-100 text-gray-500 text-center">${service.name}</td>
                                <td class="px-4 py-2 bg-gray-100 text-gray-500 text-center">${service.qty}</td>
                                <td class="px-4 py-2 bg-gray-100 text-gray-500 text-center">$ ${customNumberFormat(service.total)}</td>` : ''
                            }
                            ${!service && setTotals ?
                                `<td class="px-6"></td>
                                <td class="px-6"></td> 
                                <td class="px-6"></td> ` : ''
                            }
                            ${!service && !setTotals ?
                                `<td class="px-4 py-2 bg-slate-100"></td>
                                <td class="px-4 py-2 bg-slate-100 text_error text-center font-bold">Saldo Total de caja</td>
                                <td class="px-4 py-2 bg-slate-100 text-gray-500 text-center font-bold"> 
                                    $ ${customNumberFormat(Object.values(json.servicesType).reduce((accumulator, currentValue) => {
                                        return accumulator + currentValue.total;
                                    }, 0))}
                                </td> ` : ''
                            }
                            <td class="px-6"></td> 
                            ${payment ?
                                `<td class="px-4 py-2 bg-gray-100 text-gray-500 text-center font-bold">${payment.name}</td>
                                <td class="px-4 py-2 bg-gray-100 text-gray-500 text-center font-bold">$ ${customNumberFormat(payment.total)}</td>` :
                                '<td class="px-6"></td><td class="px-6"></td>'
                            }
                            <td class="px-6"></td>
                        </tr>`;

                        if(!service){
                            setTotals = true;
                        }
            }
            
            if(services.length >= Object.keys(payments).length){
                rows += `
                        <tr>
                            <td class="px-6"></td>
                            <td class="px-4 py-2 bg-slate-100"></td>
                            <td class="px-4 py-2 bg-slate-100 text_error text-center font-bold">Saldo Total de caja</td>
                            <td class="px-4 py-2 bg-slate-100 text-gray-500 text-center font-bold"> 
                                $ ${customNumberFormat(Object.values(json.servicesType).reduce((accumulator, currentValue) => {
                                    return accumulator + currentValue.total;
                                }, 0))}
                            </td>
                            <td class="px-6"></td>
                            <td class="px-4 py-2 text-center font-bold"></td>
                            <td class="px-4 py-2 text-center font-bold"></td>
                            <td class="px-6"></td>
                        </tr>`;
            } 

            $("#reportContent").innerHTML = `
                <table class="w-full mb-10">
                    <tbody>
                        <tr>
                            <td colspan="8" class="p-4 bg-red-500 text-white">Control de caja</td>
                        </tr>
                        <tr>
                            <td colspan="8" class="p-4"></td>
                        </tr>
                        <tr>
                            <td class="px-6"></td>
                            <td class="px-4 py-2 bg-red-100 text_error text-center font-bold">Tipo de servicio</td>
                            <td class="px-4 py-2 bg-red-100 text_error text-center font-bold">Cantidad</td>
                            <td class="px-4 py-2 bg-red-100 text_error text-center font-bold">Totales</td>
                            <td class="px-6"></td>
                            <td class="px-4 py-2 bg-red-100 text_error text-center font-bold">Tipo de caja</td>
                            <td class="px-4 py-2 bg-red-100 text_error text-center font-bold">Saldo</td>
                            <td class="px-6"></td>
                        </tr>
                        ${rows} 
                        <tr>
                            <td colspan="8" class="p-4"></td>
                        </tr>
                        <tr> 
                            <td class="px-4 py-2 bg-red-100 text_error text-center font-bold">Fecha</td>
                            <td class="px-4 py-2 bg-red-100 text_error text-center font-bold">Codigo</td>
                            <td class="px-4 py-2 bg-red-100 text_error text-center font-bold">Categoria</td>
                            <td class="px-4 py-2 bg-red-100 text_error text-center font-bold">Nombre comercial</td> 
                            <td class="px-4 py-2 bg-red-100 text_error text-center font-bold">Tipo de caja</td> 
                            <td class="px-4 py-2 bg-red-100 text_error text-center font-bold">Entradas</td>
                            <td class="px-4 py-2 bg-red-100 text_error text-center font-bold">Salidas</td>
                            <td class="px-6"></td>
                        </tr>
                        ${Object.entries(json.itemsPerDay).map(([key, item]) =>  
                            Object.entries(item).map(([key2, item2]) => 
                                Object.entries(item2).map(([key3, item3]) => 
                                    Object.entries(item3).map(([key4, item3]) =>{ return `<tr> 
                                        <td class="px-4 py-2 text-gray-500 text-center font-bold">${reformatDate(key)}</td>
                                        <td class="px-4 py-2 text-gray-500 text-center font-bold">${item3.barcode}</td>
                                        <td class="px-4 py-2 text-gray-500 text-center font-bold">${item3.cat}</td>
                                        <td class="px-4 py-2 text-gray-500 text-center font-bold">${item3.name}</td> 
                                        <td class="px-4 py-2 text-gray-500 text-center font-bold">${key2}</td> 
                                        <td class="px-4 py-2 text-gray-500 text-center font-bold">$ ${customNumberFormat((key4*item3.qty))}</td>
                                        <td class="px-4 py-2 text-gray-500 text-center font-bold"></td>
                                        <td class="px-6"></td>
                                    </tr>`}).join("")
                                ).join("")
                            ).join("")
                        ).join("")} 
                        ${Object.entries(json.expensesPerDay).map(([key, item]) =>  
                            Object.entries(item).map(([key2, item2]) => 
                                Object.entries(item2).map(([key3, item3]) => 
                                    Object.entries(item3).map(([key4, item3]) =>{ return `<tr> 
                                        <td class="px-4 py-2 text-gray-500 text-center font-bold">${reformatDate(key)}</td>
                                        <td class="px-4 py-2 text-gray-500 text-center font-bold">${item3.barcode}</td>
                                        <td class="px-4 py-2 text-gray-500 text-center font-bold">${item3.cat}</td>
                                        <td class="px-4 py-2 text-gray-500 text-center font-bold">${item3.name}</td> 
                                        <td class="px-4 py-2 text-gray-500 text-center font-bold">${key2}</td> 
                                        <td class="px-4 py-2 text-gray-500 text-center font-bold"></td>
                                        <td class="px-4 py-2 text-gray-500 text-center font-bold">$ ${customNumberFormat((key4*item3.qty))}</td>
                                        <td class="px-6"></td>
                                    </tr>`}).join("")
                                ).join("")
                            ).join("")
                        ).join("")} 
                        <tr>
                            <td colspan="4"></td>  
                            <td class="px-4 py-2 text-gray-500 text-center font-bold">Totales</td>  
                            <td class="px-4 py-2 text-gray-500 text-center font-bold border-t-2">${customNumberFormat(json.totalIncome)}</td>  
                            <td class="px-4 py-2 text-gray-500 text-center font-bold border-t-2">${customNumberFormat(json.totalExpenses)}</td>  
                        </tr> 
                        <tr>
                            <td colspan="5"></td>   
                            <td class="px-4 py-2 text-gray-500 text-center font-bold border-2">Balance</td>  
                            <td class="px-4 py-2 text-gray-500 text-center font-bold border-2">${customNumberFormat((json.totalIncome-json.totalExpenses))}</td>  
                        </tr>  
                    </tbody> 
                </table>
                <hr>
            `;
        }else{
            Object.keys(json.message).forEach(key => { 
                report_form.querySelector(`#${key}_message`).innerHTML = json.message[key];
                report_form.querySelector(`#${key}`)?.classList.add("border-red-500");
                report_form.querySelector(`#${key}+label`)?.classList.add("text_error");
            });

            $("#exportExcell").classList.add("hidden");
        }
    })
});

function exportExcell(){
    const anchor = document.createElement("a");
    let start = "";
    let end = "";

    if($("#start").value){
        const startArr  = $("#start").value.split("/");

        start = `${startArr[2]}-${startArr['1']}-${startArr['0']}`;
    }
    
    if($("#end").value){
        const endArr  = $("#end").value.split("/");

        end = `${endArr[2]}-${endArr['1']}-${endArr['0']}`;
    }
    
    anchor.href = `${baseURL}/report/generateReport/?start=${start}&end=${end}&medical_unit=${$("#medical_unit").value}`;
    anchor.target = "_blank";
    anchor.click();
}