<?php

class ProcesosEventosModel extends Mysql
{
	private $intIdProceso;
	private $intIdPersona;
	private $strObjeto;
	private $strnombreCreadorOferta;
	private $intActividad;
	private $strTitulo;
	private $strDescripcion;
	private $strMoneda;
	private $strPresupuesto;
	private $strEstado;
	private $strFechaInicio;
	private $strHoraInicio;
	private $strFechaCierre;
	private $strHoraCierre;
	private $strDocumento;

	public function __construct()
	{
		parent::__construct();
	}

	public function insertProceso(int $idPersona, string $objeto, string $nombreCreadorOferta, int $actividad, string $descripcion, string $moneda, string $presupuesto, string $estado, string $fechaInicio, string $horaInicio,  string $fechaCierre, string $horaCierre)
	{
		$this->intIdPersona = $idPersona;
		$this->strObjeto = $objeto;
		$this->strnombreCreadorOferta = $nombreCreadorOferta;
		$this->intActividad = $actividad;
		$this->strDescripcion = $descripcion;
		$this->strMoneda = $moneda;
		$this->strPresupuesto = $presupuesto;
		$this->strFechaInicio = $fechaInicio;
		$this->strHoraInicio = $horaInicio;
		$this->strFechaCierre = $fechaCierre;
		$this->strHoraCierre = $horaCierre;
		$this->strEstado = $estado;
		$return = 0;

		$sql = "SELECT * FROM procesos WHERE 
					refProceso = '{$this->strObjeto}'";
		$request = $this->select_all($sql);

		if (empty($request)) {
			$query_insert  = "INSERT INTO procesos(idPersona,refProceso,nombreCreadorOferta,idActividad,descripcion,moneda,presupuesto,fechaInicio,horaInicio,fechaCierre,horaCierre,estado) 
								  VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
			$arrData = array(
				$this->intIdPersona,
				$this->strObjeto,
				$this->strnombreCreadorOferta,
				$this->intActividad,
				$this->strDescripcion,
				$this->strMoneda,
				$this->strPresupuesto,
				$this->strFechaInicio,
				$this->strHoraInicio,
				$this->strFechaCierre,
				$this->strHoraCierre,
				$this->strEstado
			);
			$request_insert = $this->insert($query_insert, $arrData);
			$return = $request_insert;
		} else {
			$return = false;
		}
		return $return;
	}

	public function insertdocument(int $idProceso, string $documento)
	{
		$this->intIdProceso = $idProceso;
		$this->strDocumento = $documento;
		$query_insert  = "INSERT INTO documentos(idProceso,documento) VALUES(?,?)";
		$arrData = array(
			$this->intIdProceso,
			$this->strDocumento
		);
		$request_insert = $this->insert($query_insert, $arrData);
		return $request_insert;
	}

	public function getProcesos()
	{
		$idUsuario = $_SESSION['idUser'];
		if ($idUsuario == '1') {
			$sql = "SELECT p.id AS idProceso, p.idPersona, p.refProceso, p.nombreCreadorOferta, p.descripcion, p.presupuesto, CONCAT(p.moneda,' ',p.presupuesto) AS presupuesto, p.fechaInicio, p.horaInicio, p.fechaCierre, p.horaCierre, p.estado, CONCAT(ae.nombreSegmento,'-',ae.nombreProducto) AS actividadEconomica, ae.nombreFamilia, ae.nombreClase
						FROM procesos AS p
						INNER JOIN actividadeconomica AS ae ON p.idActividad = ae.id
						WHERE p.estado != 'Inactivo';";
		} else {
			$sql = "SELECT p.id AS idProceso, p.idPersona, p.refProceso, p.nombreCreadorOferta, p.descripcion, p.presupuesto, CONCAT(p.moneda,' ',p.presupuesto) AS presupuesto, p.fechaInicio, p.horaInicio, p.fechaCierre, p.horaCierre, p.estado, CONCAT(ae.nombreSegmento,'-',ae.nombreProducto) AS actividadEconomica, ae.nombreFamilia, ae.nombreClase
						FROM procesos AS p
						INNER JOIN actividadeconomica AS ae ON p.idActividad = ae.id
						WHERE p.estado != 'Inactivo' AND p.idpersona = {$idUsuario};";
		}
		$request = $this->select_all($sql);
		return $request;
	}

	public function selectActividad()
	{
		$sql = "SELECT id,nombreSegmento,nombreFamilia,nombreClase,nombreProducto 
					FROM actividadeconomica;";
		$request = $this->select_all($sql);
		return $request;
	}

	public function selectProceso(int $idProceso)
	{
		$sql = "SELECT id AS idProceso, refProceso AS objeto, idActividad, descripcion, nombreCreadorOferta, descripcion, moneda, presupuesto, fechaInicio, horaInicio, fechaCierre, horaCierre, estado
					FROM procesos
					WHERE id = {$idProceso} ";
		$request = $this->select($sql);
		return $request;
	}


	public function updateProceso(int $idProceso, string $objeto, string $nombreCreadorOferta, int $actividad, string $descripcion, string $moneda, string $presupuesto, string $estado, string $fechaInicio, string $horaInicio,  string $fechaCierre, string $horaCierre)
	{

		$this->intIdProceso = $idProceso;
		$this->strObjeto = $objeto;
		$this->strnombreCreadorOferta = $nombreCreadorOferta;
		$this->intActividad = $actividad;
		$this->strDescripcion = $descripcion;
		$this->strMoneda = $moneda;
		$this->strPresupuesto = $presupuesto;
		$this->strFechaInicio = $fechaInicio;
		$this->strHoraInicio = $horaInicio;
		$this->strFechaCierre = $fechaCierre;
		$this->strHoraCierre = $horaCierre;
		$this->strEstado = $estado;

		$sql = "SELECT * FROM procesos WHERE (refProceso = '{$this->strObjeto}' AND id != $this->intIdProceso)";
		$request = $this->select_all($sql);

		if (empty($request)) {
			$sql = "UPDATE procesos SET refProceso=?, nombreCreadorOferta=?, idActividad=?, descripcion=?, moneda=?, presupuesto=?, fechaInicio=?, horaInicio=?, fechaCierre=?, horaCierre=?, estado=?
							WHERE id = $this->intIdProceso ";
			$arrData = array(
				$this->strObjeto,
				$this->strnombreCreadorOferta,
				$this->intActividad,
				$this->strDescripcion,
				$this->strMoneda,
				$this->strPresupuesto,
				$this->strFechaInicio,
				$this->strHoraInicio,
				$this->strFechaCierre,
				$this->strHoraCierre,
				$this->strEstado
			);

			$request = $this->update($sql, $arrData);
		} else {
			$request = false;
		}
		return $request;
	}

	public function updateUploadDocuments(int $idProceso, string $titulo, string $descripcion)
	{

		$this->intIdProceso = $idProceso;
		$this->strTitulo = $titulo;
		$this->strDescripcion = $descripcion;
		$sqlUpdate = "UPDATE documentos SET titulo=?, descripcion=?  
					WHERE idProceso = $this->intIdProceso ";
		$arrData = array(
			$this->strTitulo,
			$this->strDescripcion
		);

		$request = $this->update($sqlUpdate, $arrData);
		return $request;
	}

	public function deleteProceso(int $intIdProceso)
	{
		$this->intIdProceso = $intIdProceso;
		$sql = "UPDATE procesos SET estado = ? WHERE id = $this->intIdProceso ";
		$arrData = array('Inactivo');
		$request = $this->update($sql, $arrData);
		return $request;
	}

	public function deleteDocument(int $idProceso, string $documento)
	{
		$this->intIdProceso = $idProceso;
		$this->strDocumento = $documento;
		$query  = "DELETE FROM documentos 
						WHERE idProceso = $this->intIdProceso 
						AND documento = '{$this->strDocumento}'";
		$request_delete = $this->delete($query);
		return $request_delete;
	}
}
