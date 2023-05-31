<?php
    class ProcesosEventos extends Controllers{
		public function __construct()
		{
			parent::__construct();
			session_start();
			//session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
			getPermisos(3);
		}

		public function ProcesosEventos()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "ProcesosEventos";
			$data['page_title'] = "PROCESOS / EVENTOS";
			$data['page_name'] = "procesosEventos";
			$data['page_functions_js'] = "functions_procesosEventos.js";
			$this->views->getView($this,"procesosEventos",$data);
		}

        public function setProcesos() {
            if($_POST){	
				$arrResponse = [];		
				if(empty($_POST['txtObjeto']) || empty($_POST['txtnombreCreadorOferta']) || empty($_POST['listActividad']) || empty($_POST['txtDescription']) || empty($_POST['listMoneda']) || empty($_POST['txtPresupuesto']) || empty($_POST['txtFechaInicio']) || empty($_POST['txtHoraInicio']) || empty($_POST['txtFechaCierre']) || empty($_POST['txtHoraCierre']))
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos o vacíos.');
				}else{ 
					$idProceso = intval($_POST['idProceso']); 
					$idPersona = intval($_POST['idPersona']);
					$strObjeto = strClean($_POST['txtObjeto']);
					$strnombreCreadorOferta = strClean($_POST['txtnombreCreadorOferta']);
					$intActividad = intval($_POST['listActividad']);
					$strDescripcion = strClean($_POST['txtDescription']);
					$strMoneda = strClean($_POST['listMoneda']);
					$strPresupuesto = strClean($_POST['txtPresupuesto']);
					$strEstado = strClean($_POST['listStatus']);
                    $strFechaInicio = strClean(formatDate($_POST['txtFechaInicio']));					
                    $strHoraInicio = strClean(formatTime($_POST['txtHoraInicio']));
                    $strFechaCierre = strClean(formatDate($_POST['txtFechaCierre']));
                    $strHoraCierre = strClean(formatTime($_POST['txtHoraCierre']));

					$request_proccess = "";
					if($idProceso == 0)
					{
						$option = 1;
						$strEstado = "Activo";
						if($_SESSION['permisosMod']['w']){
							$request_proccess = $this->model->insertProceso($idPersona,
																		$strObjeto,
                                                                        $strnombreCreadorOferta, 
                                                                        $intActividad, 
                                                                        $strDescripcion, 
                                                                        $strMoneda,
																		$strPresupuesto,
																		$strEstado,
                                                                        $strFechaInicio,
                                                                        $strHoraInicio,
                                                                        $strFechaCierre,
                                                                        $strHoraCierre);
						}
					}else{
						$option = 2;
						
						if($_SESSION['permisosMod']['u']){
							$request_proccess = $this->model->updateProceso($idProceso,
																		$strObjeto,
                                                                        $strnombreCreadorOferta, 
                                                                        $intActividad, 
                                                                        $strDescripcion, 
                                                                        $strMoneda,
																		$strPresupuesto,
																		$strEstado,
                                                                        $strFechaInicio,
                                                                        $strHoraInicio,
                                                                        $strFechaCierre,
                                                                        $strHoraCierre);
						}

					}

					if($request_proccess > 0)
					{
						if($option == 1){
							$arrResponse = array('status' => true, 'msg' => 'Datos creados correctamente');
						}else{
							$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
						}
					}else if($request_proccess == false){						
						$arrResponse = array('status' => false, 'msg' => '¡Atención! el objeto ingresado ya existe, ingrese otro.');		
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
            die();
        }
		
		public function setUpdloadDocuments() {
            if($_POST){	
				$arrResponse = [];		
				if(empty($_POST['txtTitulo']) || empty($_POST['txtDescripcion']))
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos o vacíos.');
				}else{
					$idProceso = intval($_POST['idProcesoUpload']);
					$strTitulo = strClean($_POST['txtTitulo']);
					$strDescripcion = strClean($_POST['txtDescripcion']);
					$request_proccess = "";
					
					if($idProceso != 0)
					{
						if($_SESSION['permisosMod']['w']){
							$request_proccess = $this->model->updateUploadDocuments($idProceso,
																					$strTitulo,
                                                                        			$strDescripcion);
						}
					}
					
					if($request_proccess > 0)
					{					
						$arrResponse = array('status' => true, 'msg' => 'Documentos subidos correctamente.');
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
            die();
        }

		public function setDocument(){
			if($_POST){
				if(empty($_POST['idProceso'])){
					$arrResponse = array('status' => false, 'msg' => 'Error de dato.');
				}else{
					$idProceso = intval($_POST['idProceso']);
					$file = $_FILES['foto'];
					$name = $_POST['name'];
					$extension = pathinfo($name, PATHINFO_EXTENSION);
					$FileNombre = 'pro_'.md5(date('d-m-Y H:i:s')).'.'.$extension;
					$request_image = $this->model->insertdocument($idProceso,$FileNombre);
					if($request_image){
						$uploadImage = uploadDocument($file,$FileNombre);
						$arrResponse = array('status' => true, 'imgname' => $FileNombre, 'msg' => 'Archivo cargado.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error de carga.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getProcesos()
		{
			if($_SESSION['permisosMod']['r']){
				$arrData = $this->model->getProcesos();

				for ($i=0; $i < count($arrData); $i++) {
					$btnAddDocuments = '';
					$btnEdit = '';
					$btnDelete = '';
					
					if($arrData[$i]['estado'] == "Activo")
					{
						$arrData[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
					}else if ($arrData[$i]['estado'] == "Publicado") {
						$arrData[$i]['estado'] = '<span class="badge badge-warning">Publicado</span>';
					}else{
						$arrData[$i]['estado'] = '<span class="badge badge-danger">Evaluacion</span>';
					}

					if($_SESSION['permisosMod']['u']){
						$btnAddDocuments = '<button class="btn btn-secondary btn-sm" onClick="fntAddocumentsProceso('.$arrData[$i]['idProceso'].')" title="Adjuntar Documentos"><i class="fa fa-file"></i></i></button>';
					}
					if($_SESSION['permisosMod']['u']){						
							$btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditProceso(this,'.$arrData[$i]['idProceso'].')" title="Editar Proceso"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){						
						$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelProceso('.$arrData[$i]['idProceso'].')" title="Eliminar Proceso"><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnAddDocuments.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getProceso($idProceso){
			if($_SESSION['permisosMod']['r']){
				$idProceso = intval($idProceso);
				if($idProceso > 0)
				{
					$arrData = $this->model->selectProceso($idProceso);

					if(empty($arrData))
					{
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					}else{
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function getSelectActividad()
		{
			$htmlOptions = "";
			$arrData = $this->model->selectActividad();
			if(count($arrData) > 0 ){
				$htmlOptions .= '<option value="0">Seleccione...</option>';
				for ($i=0; $i < count($arrData); $i++) { 				
					$htmlOptions .= '<option value="'.$arrData[$i]['id'].'">'.$arrData[$i]['nombreSegmento'] .'-'.$arrData[$i]['nombreProducto'].'</option>';
				}
			}
			echo $htmlOptions;
			die();		
		}

		public function delProceso()
		{
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdProceso = intval($_POST['idProceso']);
					$requestDelete = $this->model->deleteProceso($intIdProceso);
					if($requestDelete)
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el cliente.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el cliente.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function delFile(){
			if($_POST){
				if(empty($_POST['idProceso']) || empty($_POST['file'])){
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					//Eliminar de la DB
					$idProceso = intval($_POST['idProceso']);
					$fileNombre  = strClean($_POST['file']);
					$request_document = $this->model->deleteDocument($idProceso,$fileNombre);

					if($request_document){
						deleteFile($fileNombre);
						$arrResponse = array('status' => true, 'msg' => 'Archivo eliminado');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
    }
