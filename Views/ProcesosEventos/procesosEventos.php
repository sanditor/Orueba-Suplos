<?php
headerAdmin($data);
getModal('modalProcesosEventos', $data);
?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="fas fa-user-tag"></i> <?= $data['page_title'] ?>
        <?php if ($_SESSION['permisosMod']['w']) { ?>
          <button class="btn btn-primary" type="button" onclick="openModal();"><i class="fas fa-plus-circle"></i> Crear</button>
        <?php } ?>
      </h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="<?= base_url(); ?>/clientes"><?= $data['page_title'] ?></a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
          <div class="table-responsive">
            <table class="table table-hover table-bordered text-center" id="tableProcesos">
              <thead class="thead-dark">
                <tr>
                  <th>Id Oferta</th>
                  <th>Creador Oferta</th>
                  <th>Objeto</th>
                  <th>Actividad</th>
                  <th>Decripcion</th>
                  <th>Presupuesto</th>
                  <th>Fecha Inicio</th>  
                  <th>Hora Inicio</th>
                  <th>Fecha Cierre</th>
                  <th>Estado</th>                    
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php footerAdmin($data); ?>