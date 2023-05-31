<!-- Modal Formulario Nuevo Cliente-->
<div class="modal fade" id="modalFormProcesos" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Crear Proceso / Evento participación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="list-group list-group-horizontal" id="list-tab" role="tablist">
                            <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">Información Básica</a>
                            <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">Cronograma</a>
                        </div>
                    </div>
                    <div class="col-12">
                        <p class="text-primary mt-2">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                                <form id="formProcesos" name="formProcesos" class="form-horizontal">
                                    <input type="hidden" id="idProceso" name="idProceso" value="">
                                    <input type="hidden" id="idPersona" name="idPersona" value="<?= $_SESSION['idUser'] ?>">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="txtObjeto">Objeto <span class="required">*</span></label>
                                            <input type="text" class="form-control valid" id="txtObjeto" name="txtObjeto" placeholder="ejemplo: RFP-000016-22">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="txtObjeto">Nombre creador Oferta <span class="required">*</span></label>
                                            <input type="text" class="form-control valid validText" id="txtnombreCreadorOferta" name="txtnombreCreadorOferta">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="listRolid">Actividad <span class="required">*</span></label>
                                            <select class="form-control" data-live-search="true" id="listActividad" name="listActividad">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="txtDescription">Descripción / Alcance <span class="required">*</span></label>
                                            <textarea class="form-control" id="txtDescription" name="txtDescription" rows="6" placeholder="Descripción detallada"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="listMoneda">Moneda <span class="required">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-bars" aria-hidden="true"></i></span></div>
                                                <select class="form-control" id="listMoneda" name="listMoneda">
                                                    <option value="COP">COP</option>
                                                    <option value="USD">USD</option>
                                                    <option value="EUR">EUR</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="txtPresupuesto">Presupuesto <span class="required">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                                                <input class="form-control valid validNumber" id="txtPresupuesto" name="txtPresupuesto" type="text" placeholder="Monto">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="listStatus">Estado</label>
                                            <select class="form-control" id="listStatus" name="listStatus">
                                                <option value="Activo">Activo</option>
                                                <option value="Publicado">Publicado</option>
                                                <option value="Evaluacion">Evaluación</option>
                                            </select>
                                        </div>
                                    </div>
                            </div>
                            <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="txtFechaInicio">Fecha Inicio <span class="required">*</span></label>
                                        <div class="input-group">
                                            <input class="form-control" id="txtFechaInicio" name="txtFechaInicio" type="date">
                                            <div class="input-group-append"><span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span></div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="txtHoraInicio">Hora Inicio <span class="required">*</span></label>
                                        <div class="input-group">
                                            <input class="form-control" id="txtHoraInicio" name="txtHoraInicio" type="time">
                                            <div class="input-group-append"><span class="input-group-text"><i class="fa fa-clock-o" aria-hidden="true"></i></span></div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="txtFechaCierre">Fecha Cierre <span class="required">*</span></label>
                                        <div class="input-group">
                                            <input class="form-control" id="txtFechaCierre" name="txtFechaCierre" type="date">
                                            <div class="input-group-append"><span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span></div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="txtHoraCierre">Hora Cierre <span class="required">*</span></label>
                                        <div class="input-group">
                                            <input class="form-control" id="txtHoraCierre" name="txtHoraCierre" type="time">
                                            <div class="input-group-append"><span class="input-group-text"><i class="fa fa-clock-o" aria-hidden="true"></i></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tile-footer">
                                <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                                <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Adjuntar Documentos requeridos -->
<div class="modal fade" id="modalUpdateDocumentsEvent" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header header-primary">
                <h5 class="modal-title" id="titleModal">Oferta / Evento participación Cerrada No <span id="objeto"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <p class="text-primary mt-2">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
                        <form id="formUpdloadDocuments" name="formUpdloadDocuments" class="form-horizontal">
                            <input type="hidden" id="idProcesoUpload" name="idProcesoUpload" value="">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="txtTitulo">Título <span class="required">*</span></label>
                                    <input type="text" class="form-control valid" id="txtTitulo" name="txtTitulo">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="txtDescripcion">Descripción<span class="required">*</span></label>
                                    <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="6" placeholder="Descripción detallada"></textarea>
                                </div>
                                <div class="tile-footer">
                                    <div class="form-group col-md-12">
                                        <div id="containerGallery">
                                            <span>Agregar Documentos</span>
                                            <button class="btnAddDocuments btn btn-info btn-sm" type="button">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        <hr>
                                        <div id="containerImages">
                                            <!-- van todo los archivos cargados -->
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="tile-footer">
                                <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                                <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>