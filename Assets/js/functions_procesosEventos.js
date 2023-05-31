var tableProcesos;
var rowTable = "";
var divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function () {

    tableProcesos = $('#tableProcesos').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " " + base_url + "/ProcesosEventos/getProcesos",
            "dataSrc": ""
        },
        "columns": [
            { "data": "idProceso" },
            { "data": "nombreCreadorOferta" },
            { "data": "refProceso" },
            { "data": "actividadEconomica" },
            { "data": "descripcion" },
            { "data": "presupuesto" },
            { "data": "fechaInicio" },
            { "data": "horaInicio" },
            { "data": "fechaCierre" },
            { "data": "estado" },
            { "data": "options" }
        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr": "Copiar",
                "className": "btn btn-secondary"
            }, {
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr": "Esportar a Excel",
                "className": "btn btn-success"
            }, {
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr": "Esportar a PDF",
                "className": "btn btn-danger"
            }, {
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr": "Esportar a CSV",
                "className": "btn btn-info"
            }
        ],
        "resonsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 5,
        "order": [[0, "desc"]]
    });

    //Nuevo Proceso
    if (document.querySelector("#formProcesos")) {
        let formProcesos = document.querySelector("#formProcesos");
        formProcesos.onsubmit = function (e) {
            e.preventDefault();
            let strNombreCreadorOferta = document.querySelector('#txtnombreCreadorOferta').value;
            let strObjeto = document.querySelector('#txtObjeto').value;
            let listActividad = document.querySelector('#listActividad').value;
            let strDescription = document.querySelector('#txtDescription').value;
            let listMoneda = document.querySelector('#listMoneda').value;
            let strPresupuesto = document.querySelector('#txtPresupuesto').value;
            let strEstado = document.querySelector('#listStatus').value;
            let strFechaInicio = document.querySelector('#txtFechaInicio').value;
            let strHoraInicio = document.querySelector('#txtHoraInicio').value;
            let strFechaCierre = document.querySelector('#txtFechaCierre').value;
            let strHoraCierre = document.querySelector('#txtHoraCierre').value;


            if (strObjeto == '' || strNombreCreadorOferta == '' || listActividad == '' || strDescription == '' || listMoneda == '' || strPresupuesto == '' || strFechaInicio == '' || strHoraInicio == '' || strFechaCierre == '' || strHoraCierre == '') {
                swal("Atención", "Todos los campos son obligatorios.", "error");
                return false;
            }

            let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) {
                if (elementsValid[i].classList.contains('is-invalid')) {
                    swal("Atención", "Por favor verifique los campos en rojo.", "error");
                    return false;
                }
            }
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/ProcesosEventos/setProcesos';
            let formData = new FormData(formProcesos);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                       
                    if (objData.status) {
                        if (rowTable == "") {
                            tableProcesos.api().ajax.reload();
                        } else {
                            htmlStatus = (strEstado == "Activo" ?
                                '<span class="badge badge-success">Activo</span>' :
                                (strEstado == "Publicado" ?
                                    '<span class="badge badge-warning">Prublicado</span>' :
                                    (strEstado == "Evaluacion" ?
                                        '<span class="badge badge-danger">Evaluación</span>' :
                                        '<span class="badge badge-danger">Inactivo</span>')));
                            rowTable.cells[1].textContent = strNombreCreadorOferta;
                            rowTable.cells[2].textContent = strObjeto;
                            rowTable.cells[3].textContent = listActividad;
                            rowTable.cells[4].textContent = strDescription;
                            rowTable.cells[5].textContent = strPresupuesto;
                            rowTable.cells[6].textContent = strFechaInicio;
                            rowTable.cells[7].textContent = strHoraInicio;
                            rowTable.cells[8].textContent = strFechaCierre;
                            rowTable.cells[9].innerHTML = htmlStatus;
                            rowTable = "";
                        }
                        $('#modalFormProcesos').modal("hide");
                        formProcesos.reset();
                        swal("Procesos", objData.msg, "success");
                    } else {
                        swal("Error", objData.msg, "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }

    //Subida documentos al Proceso
    if (document.querySelector("#formUpdloadDocuments")) {
        let formUpdloadDocuments = document.querySelector("#formUpdloadDocuments");
        formUpdloadDocuments.onsubmit = function (e) {
            e.preventDefault();
            let strTitulo = document.querySelector('#txtTitulo').value;
            let strDescripcion = document.querySelector('#txtDescripcion').value;

            if (strTitulo == '' || strDescripcion == '') {
                swal("Atención", "Todos los campos son obligatorios.", "error");
                return false;
            }

            let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) {
                if (elementsValid[i].classList.contains('is-invalid')) {
                    swal("Atención", "Por favor verifique los campos en rojo.", "error");
                    return false;
                }
            }
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/ProcesosEventos/setUpdloadDocuments';
            let formData = new FormData(formUpdloadDocuments);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {                    
                    
                    let objData = JSON.parse(request.responseText);                  

                    if (objData.status) {
                        $('#modalUpdateDocumentsEvent').modal("hide");
                        formUpdloadDocuments.reset();
                        swal("Procesos", objData.msg, "success");
                    } else {
                        swal("Error", objData.msg, "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }

    if (document.querySelector(".btnAddDocuments")) {
        let btnAddDocuments = document.querySelector(".btnAddDocuments");
        btnAddDocuments.onclick = function (e) {
            let key = Date.now();
            let newElement = document.createElement("div");
            newElement.id = "div" + key;
            newElement.innerHTML = `
            <div class="prevImage"></div>
            <input type="file" name="foto" id="img${key}" class="inputUploadfile">
            <label for="img${key}" class="btnUploadfile"><i class="fas fa-upload "></i></label>
            <button class="btnDeleteImage notblock" type="button" onclick="fntDelItem('#div${key}')"><i class="fas fa-trash-alt"></i></button>`;
            document.querySelector("#containerImages").appendChild(newElement);
            document.querySelector("#div" + key + " .btnUploadfile").click();
            fntInputFile();
        }
    }
    fntInputFile();

}, false);

window.addEventListener('load', function () {
    fntActividadEconomica();
}, false);

function fntActividadEconomica() {
    if (document.querySelector('#listActividad')) {
        let ajaxUrl = base_url + '/ProcesosEventos/getSelectActividad';
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET", ajaxUrl, true);
        request.send();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                document.querySelector('#listActividad').innerHTML = request.responseText;
                $('#listActividad').selectpicker('render');
                /* $('#listActividad').selectpicker({
                    liveSearch: true
                }); */
            }
        }
    }
}

function fntAddocumentsProceso(idProceso) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/ProcesosEventos/getProceso/' + idProceso;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);

            if (objData.status) {
                if (document.querySelector("#containerImages")) {
                    let itemsRemove = document.querySelector("#containerImages");
                    // Remover todos los nodos hijos del div
                    while (itemsRemove.firstChild) {
                        itemsRemove.removeChild(itemsRemove.firstChild);
                    }
                }
                document.querySelector("#txtTitulo").value = "";
                document.querySelector("#txtDescripcion").value = "";
                document.querySelector("#idProcesoUpload").value = objData.data.idProceso;
                document.querySelector("#objeto").innerHTML = objData.data.objeto;
                $('#modalUpdateDocumentsEvent').modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    }
}

function fntInputFile() {
    let inputUploadfile = document.querySelectorAll(".inputUploadfile");
    inputUploadfile.forEach(function (inputUploadfile) {
        inputUploadfile.addEventListener('change', function () {
            let idProceso = document.querySelector("#idProcesoUpload").value;
            let parentId = this.parentNode.getAttribute("id");
            let idFile = this.getAttribute("id");
            let uploadFoto = document.querySelector("#" + idFile).value;
            let fileimg = document.querySelector("#" + idFile).files;
            let prevImg = document.querySelector("#" + parentId + " .prevImage");
            let nav = window.URL || window.webkitURL;
            if (uploadFoto != '') {
                let type = fileimg[0].type;
                let name = fileimg[0].name;
                if (type != 'application/pdf' && type != 'application/msword') {
                    prevImg.innerHTML = "Archivos pdf o word solamente";
                    uploadFoto.value = "";
                    return false;
                } else {
                    let objeto_url = nav.createObjectURL(this.files[0]);
                    prevImg.innerHTML = `<img class="loading" src="${base_url}/Assets/images/loading.svg" >`;

                    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    let ajaxUrl = base_url + '/ProcesosEventos/setDocument';
                    let formData = new FormData();
                    formData.append('idProceso', idProceso);
                    formData.append("foto", this.files[0]);
                    formData.append("name", name);
                    request.open("POST", ajaxUrl, true);
                    request.send(formData);
                    request.onreadystatechange = function () {
                        if (request.readyState != 4) return;
                        if (request.status == 200) {
                            let objData = JSON.parse(request.responseText);
                            if (objData.status) {
                                prevImg.innerHTML = `<img src="${base_url}/Assets/images/uploadFiles.jpg">`;
                                document.querySelector("#" + parentId + " .btnDeleteImage").setAttribute("imgname", objData.imgname);
                                document.querySelector("#" + parentId + " .btnUploadfile").classList.add("notblock");
                                document.querySelector("#" + parentId + " .btnDeleteImage").classList.remove("notblock");
                            } else {
                                swal("Error", objData.msg, "error");
                            }
                        }
                    }

                }
            }

        });
    });
}

function fntDelItem(element) {
    let nameDocument = document.querySelector(element + ' .btnDeleteImage').getAttribute("imgname");
    let idProceso = document.querySelector("#idProcesoUpload").value;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/ProcesosEventos/delFile';

    let formData = new FormData();
    formData.append('idProceso', idProceso);
    formData.append("file", nameDocument);
    request.open("POST", ajaxUrl, true);
    request.send(formData);
    request.onreadystatechange = function () {
        if (request.readyState != 4) return;
        if (request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                let itemRemove = document.querySelector(element);
                itemRemove.parentNode.removeChild(itemRemove);
            } else {
                swal("", objData.msg, "error");
            }
        }
    }
}

function fntEditProceso(element, idProceso) {
    rowTable = element.parentNode.parentNode.parentNode//devuelve todo la fila del registro de la tabla;
    document.querySelector('#titleModal').innerHTML = "Actualizar Proceso / Evento";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/ProcesosEventos/getProceso/' + idProceso;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {

        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            
            if (objData.status) {
                document.querySelector("#idProceso").value = objData.data.idProceso;
                document.querySelector("#txtObjeto").value = objData.data.objeto;
                document.querySelector("#txtnombreCreadorOferta").value = objData.data.nombreCreadorOferta;
                document.querySelector("#listActividad").value = objData.data.idActividad;
                document.querySelector("#txtDescription").value = objData.data.descripcion;
                document.querySelector("#listMoneda").value = objData.data.moneda;
                document.querySelector("#txtPresupuesto").value = objData.data.presupuesto;
                document.querySelector("#txtFechaInicio").value = objData.data.fechaInicio;
                document.querySelector("#txtHoraInicio").value = objData.data.horaInicio;
                document.querySelector("#txtFechaCierre").value = objData.data.fechaCierre;
                document.querySelector("#txtHoraCierre").value = objData.data.horaCierre;

                if (objData.data.estado == "Activo") {
                    document.querySelector("#listStatus").value = 'Activo';
                }else if (objData.data.estado == "Activo") {
                    document.querySelector("#Prublicado").value = 'Prublicado';
                }else {
                   document.querySelector("#listStatus").value = 'Evaluacion';
                }
                $('#listStatus, #listActividad').selectpicker('render');
            }
        }

        $('#modalFormProcesos').modal('show');
    }
}

function fntDelProceso(idProceso) {

    swal({
        title: "Eliminar Proceso",
        text: "¿Realmente quiere eliminar el Proceso / Evento?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function (isConfirm) {

        if (isConfirm) {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/ProcesosEventos/delProceso';
            let strData = "idProceso=" + idProceso;
            request.open("POST", ajaxUrl, true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        swal("Eliminar!", objData.msg, "success");
                        tableProcesos.api().ajax.reload();
                    } else {
                        swal("Atención!", objData.msg, "error");
                    }
                }
            }
        }

    });

}

function openModal() {
    // Resetear valores de los select con selectpicker
    let selectElement = $('#listActividad');
    selectElement.val('0');
    selectElement.selectpicker('refresh');
    rowTable = "";
    document.querySelector('#idProcesoUpload').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Crear Proceso / Evento participación";
    document.querySelector("#formProcesos").reset();
    document.querySelector("#containerGallery").classList.add("notblock");
    document.querySelector("#containerGallery").classList.add("notblock");
    $('#modalFormProcesos').modal('show');
}