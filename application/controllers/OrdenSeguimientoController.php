<?php

class OrdenSeguimientoController extends Zend_Controller_Action
{
	public function init()
	{
		/* Initialize action controller here */
		$this->view->InlineScript()->appendFile( $this->view->baseUrl().'/js/orden-seguimiento/ventas.js' );
		
		$this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables/js/jquery.dataTables.min.js');
		$this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-plugins/dataTables.bootstrap.min.js');
		$this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-responsive/dataTables.responsive.js');
		$this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/sweetalert.min.js');
		
	}
	
    public function indexAction(){
    

        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/flipclock/flipclock.min.js');  
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/flipclock/easytimer.js'); 
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/sweetalert.min.js'); 
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/orden-servicio/seguimiento-ordenes.js');  

        $agencia = new Application_Model_DbTable_Agencia();
        
        $selectAgencias = new Zend_Form_Element_Select('select_agencias');
        $this->view->agencias = $agencia->obtenerTodasLasAgencias();
        
        $listaAgencias = array();
        foreach ( $this->view->agencias as $agencias){
        	$listaAgencias[$agencias['id_agencia']]=$agencias['nombre'];
        }
        
        $zendForm = new Zend_Form();
        
        $selectAgencias
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions($listaAgencias)
        ->setAttrib("class","form-control selectpicker")
        ->setAttrib("data-max-options",10)
        ->setAttrib("data-live-search","true")
        ->setAttrib("title","Ingresa nombre de la agencia...")
        ->setAttrib("autocomplete","off");
        
        $zendForm->addElement($selectAgencias);
        $this->view->selectAgencias=$zendForm;
        
        $orden = new Application_Model_DbTable_OrdenServicio();
        
        $valores = array();
        $resultado = $orden->obtenerOrdenes($valores);
        
        $this->view->countArray= count($resultado);

        // Get a Paginator object using Zend_Paginator's built-in factory.
        $page = $this->_request->getParam('page', 0);
        $paginator = Zend_Paginator::factory($resultado);
        $paginator->setCurrentPageNumber($page)
        ->setItemCountPerPage(10)
        ->setPageRange(10);
        $paginator->setCacheEnabled(true);
        // Assign paginator to view
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination_sm.phtml');
        
        $this->view->paginator=$paginator;
        
        foreach ($this->view->paginator as $key => &$value){

        	$total_diff_cron = 0;
        	
        	if ( $value['control_cron_estatus'] == 1){
	        	$datetime1 = new DateTime($value['control_cron_inicial']);
	        	$zendDate = new Zend_Date();
	        	$datetime2 = new DateTime($zendDate->toString('YYYY-MM-dd HH:mm:ss'));
	        	
	        	$interval = $datetime1->diff($datetime2);
	        	$d = $interval->format('%d');
	        	$h = $interval->format('%h');
	        	$i = $interval->format('%i');
	        	$s = $interval->format('%s');
	        	
	        	$total_diff_cron = $s + ($i * 60) + ($h * 60 * 60) + ( $d * 24 *60 *60);
        	}
        	
        	$duracion_servicio_segundos = ($value['duracion_servicio']*60)+$total_diff_cron;
        	
        	$value['duracion_servicio_segundos'] =  $duracion_servicio_segundos;
        	
        }
        
        
    }
    
    public function playAction()
    {
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    	$params=$this->_request->getParams();
    	
    	$data = array(
    			'control_cron_estatus' => 1
    			);
    	
    	$ordenServicioDbTable = new Application_Model_DbTable_OrdenServicio();
    	$orden = $ordenServicioDbTable->obtenerOrdenPorId($params['id_orden_servicio']);

    	$zendDate = Zend_Date::now()->getTimestamp();
    	$fecha = date('Y-m-d H:i:s', $zendDate);
    	if($orden != null)
    	{
    		if($orden['fecha_inicia_atencion'] == null)
    		{
    			$data['fecha_inicia_atencion'] = $fecha;
    			$data['control_cron_inicial'] = $fecha;
    		}
    		else
    		{
    			$data['control_cron_inicial'] = $fecha;
    		}
    		$where = "id_orden_servicio = {$params['id_orden_servicio']}";
    		// 	se actualiza en la base de datos a la orden de servicio
    		$ordenServicioDbTable->update($data, $where);
            $this->_helper->json("ok");
    	}
    	else 
    	{
    		//else cuando no se encuentra la orden
    		$data['estado']='error';
    		$data['descripcion']='No se encuentra la orden de servicio';
    		// se responde al cliente
    		$this->_helper->json($data);
    	}
    }
    
    public function pauseAction()
    {
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    	$params=$this->_request->getParams();

    	$zendDate = Zend_Date::now()->getTimestamp();
    	$fecha = date('Y-m-d H:i:s', $zendDate);
    	$data = array(
    			'control_cron_estatus' => 2
    			);
    	
    	$ordenServicioDbTable = new Application_Model_DbTable_OrdenServicio();
    	$orden = $ordenServicioDbTable->obtenerOrdenPorId($params['id_orden_servicio']);
    	if($orden != null)
    	{
    		$data['control_cron_final'] = $fecha;
    		$duracionServicio = $orden['duracion_servicio'];
    		$diferenciaFechas = $ordenServicioDbTable->
    							obtenerDiferenciaDeFechas(
    									$fecha, $orden['control_cron_inicial']);
    		$horasConvertidas = $diferenciaFechas['hora']*60;
    		$segundosConvertidos = $diferenciaFechas['segundo']/60;
    		$duracionServicio = $duracionServicio + 
    								$horasConvertidas + 
    								$diferenciaFechas['minuto'] + 
    								$segundosConvertidos;
    		$data['duracion_servicio'] = round($duracionServicio);
    		$where = "id_orden_servicio = {$params['id_orden_servicio']}";
    		// 	se actualiza en la base de datos a la orden de servicio
    		$ordenServicioDbTable->update($data, $where);
            $this->_helper->json("ok");
    	}
    	else 
    	{
    		//else cuando no se encuentra la orden
    		$data['estado']='error';
    		$data['descripcion']='No se encuentra la orden de servicio';
    		// se responde al cliente
    		$this->_helper->json($data);
    	}
    }
     
    public function actualizarAction(){
    
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    	$params=$this->_request->getParams();
    	//echo "<pre>".print_r($params,true)."</pre>";die;
    	 
    	$data = array(
    			'id_producto' => $params['id_producto'],
    			'id_poliza' => $params['id_poliza'],
    			'id_usuario_admin_atiende' => $params['id_usuario_admin_atiende'],
    			'id_motivo' => $params['id_motivo'],
    			'id_usuario_agencia_solicito' => ($params['id_usuario_agencia_solicito']=='')?null:$params['id_usuario_agencia_solicito'],
    			'solicito_otro' => $params['solicito_otro'],
    			'motivo_orden' => $params['motivo_orden'],
    			'solucion_orden' => $params['solucion_orden'],
    			'conformidad' => $params['conformidad']
    	);
    	
    	$form = new Application_Form_Ordenes_NuevaOrden();
    	$zendDate = Zend_Date::now()->getTimestamp();
    	$fecha = date('Y-m-d H:i:s', $zendDate);
    	
    	$mensajesDeError = $form->getMessages();
    	$cantidadDeErrores = count($mensajesDeError);
    	if ($cantidadDeErrores == 0)
    	{
    		$ordenServicioDbTable = new Application_Model_DbTable_OrdenServicio();
    		$orden = $ordenServicioDbTable->obtenerOrdenPorId($params['id_orden_servicio']);
    
    		$duracionServicio = $orden['duracion_servicio'];
    		
    		if($orden['id_orden_servicio_estatus'] < 6 || isset($params["administrador"])){
    			 
    			if($params['accion_orden_servicio'] == 6 ){
    				
    				if ( $orden['control_cron_estatus'] == 1 ) {
	    				$data['fecha_cierre'] = $fecha;
	    				$diferenciaFechas = $ordenServicioDbTable->obtenerDiferenciaDeFechas($fecha, $orden['control_cron_inicial']);
	    				$horasConvertidas = $diferenciaFechas['hora']*60;
	    				$segundosConvertidos = $diferenciaFechas['segundo']/60;
	    				$duracionServicio = $duracionServicio + 
	    									$horasConvertidas + 
	    									$diferenciaFechas['minuto'] + 
	    									$segundosConvertidos;
	    									
	    				$data['duracion_servicio'] = round($duracionServicio);
	    				$data['control_cron_inicial'] = null;
	    				$data['control_cron_final'] = null;
	    				$data['control_cron_estatus'] = 3;
    				}			

					
					//Restando minutos a la póliza
    				$servicesPolizas = new Application_Model_Services_ServicesPolizas();
    				$servicesPolizas->restarMinutosAPoliza($params['id_poliza'], $duracionServicio);
    				$data['id_orden_servicio_estatus']=6;
    				
    			}
    			
    			$where = "id_orden_servicio = {$params['id_orden_servicio']}";

    			// 	se actualiza en la base de datos a la póliza
    			$ordenServicioDbTable->update($data, $where);
    			 
    			$data['cambio_ejecutivo']='N';
    			if ($params['id_usuario_admin_atiende'] != $_SESSION['Zend_Auth']['USER_VALUES']['id_usuario']){
    				$data['cambio_ejecutivo']='S';
    			}
    			
    			//$email = new Application_Model_Services_Emails();
    			//$email->cerrarOrdenServicio($orden);
 
    			$data['estado']='ok';
    			$data['descripcion']='La orden ha sido concluida exitosamente';
    			$data['administrador'] = 0;
    			if( isset($params["administrador"])){
    				$data['administrador'] = $params["administrador"];
    			}
    			// se responde al cliente
    			$this->_helper->json($data);
    			$this->_redirect('orden-servicio/atencion-orden');
    		}
    		else
    		{
				//else cuando se edita una orden concluida
    			$data['estado']='error';
        	 	$data['descripcion']='La orden ya fue concluida';
        	 	// se responde al cliente
        	 	$this->_helper->json($data);
    			
    		}
    	}
    	else
    	{ // else cuando existe un error encontrado en el form
    		$this->_helper->json($mensajesDeError);
    		$this->_redirect('orden-servicio/nueva-orden/');
    	}
    }

   public function obtenerordenesporejecutivoAction()
    {
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    	$params=$this->_request->getParams();

    	$zendDate = Zend_Date::now()->getTimestamp();
    	$fecha = date('Y-m-d H:i:s', $zendDate);
    	$ordenServicioDbTable = new Application_Model_DbTable_OrdenServicio();
    	$ordenes = $ordenServicioDbTable->obtenerOrdenesPorIdEjecutivo($_SESSION['Zend_Auth']['USER_VALUES']['id_usuario']);
    	$ordenesActualizadas = array();
    	foreach ($ordenes as $orden)
    	{
    		//Si la orden está en play
    		$diferenciaDeMinutos;
    		if($orden['control_cron_estatus'] = 1)
    		{
    			$duracionServicio = $orden['duracion_servicio'];
    			$diferenciaFechas = $ordenServicioDbTable->
    			obtenerDiferenciaDeFechas(
    					$fecha, $orden['control_cron_inicial']);
    			var_dump($diferenciaFechas);
    			$horasConvertidos = $diferenciaFechas['hora']*60;
    			$duracionServicio = $duracionServicio + $horasConvertidos + $diferenciaFechas['minuto'];
    			$orden['duracion_servicio'] = $duracionServicio;
    			array_push($ordenesActualizadas, $orden);
    		}
    		//Si la orden está en pause se envía el tiempo acumulado en duracion_servicio
    	}
    	$this->_helper->json($ordenesActualizadas);
    }

    public function consultaPorAgenciaAction(){
    	
    	$this->_helper->layout->setLayout('layout_login_sin_menus');
    	$this->view->params=$this->_request->getParams();
    	
    	if (isset($this->view->params['exportar'])) {
    		$this->_helper->layout()->disableLayout();
    	}
    	
    	$ordenServicioDbTable = new Application_Model_DbTable_OrdenServicio();
    	$orden = new Application_Model_DbTable_OrdenServicio();
    	$this->view->formFiltroSeguimientoOrdenAdmin = new Application_Form_Ordenes_FiltroSeguimientoOrdenAdmin();
    	$params=$this->_request->getParams();

    	$this->view->formFiltroSeguimientoOrdenAdmin->populate($params);
    	
    	$this->view->ordServ = $ordenServicioDbTable->obtenerOrdenesPorAgencia($this->view->params['id_agencia'], $params);
    	
    	$this->view->totalOrdServ = count($this->view->ordServ);
    	
    	$agencia = new Application_Model_DbTable_Agencia();
    	$this->view->datosAgencia = $agencia->find( $this->view->params['id_agencia'] )->toArray()[0];
    	
    }
    
    public function consultarDatosAgenciaAction(){

    	$poliza = new Application_Model_DbTable_Poliza();
    	$usuario_agencia = new Application_Model_DbTable_AgenciaUsuario();
    	
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    	$params=$this->_request->getParams();
    	$datosAgencia = array();
    	
    	$polizasAgencia = $poliza->obtenerPolizasVigentesPorIdAgencia($params['id_agencia']);
    	
    	foreach ($polizasAgencia as &$polizas){
    		$fecha = new Zend_Date($polizas['fecha_ini']);
    		$fechaString = $fecha->toString('d MMMM yyyy');
    		$polizas['fecha_ini'] = $fechaString;
    		
    		$fecha = new Zend_Date($polizas['fecha_fin']);
    		$fechaString = $fecha->toString('d MMMM yyyy');
    		$polizas['fecha_fin'] = $fechaString;
    		
    		$fecha = new Zend_Date($polizas['fecha_fin_servicio']);
    		$fechaString = $fecha->toString('d MMMM yyyy');
    		$polizas['fecha_fin_servicio'] = $fechaString;
    	}
    	//echo "<pre>".print_r($polizasAgencia,true)."</pre>";die;
    	
    	$datosAgencia[0]['polizas'] = $polizasAgencia;
    	
    	$datosAgencia[0]['usuariosAgencia'] = $usuario_agencia->obtenerUsuariosDeAgenciaPorIdAgencia($params['id_agencia']);
    	
    	$this->_helper->json($datosAgencia[0]);
    }
    
    public function miHistoricoAction(){
    	$this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables/js/jquery.dataTables.min.js');
    	$this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-plugins/dataTables.bootstrap.min.js');
    	$this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-responsive/dataTables.responsive.js');
    	$this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/flipclock/flipclock.min.js');
    	$this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/flipclock/easytimer.js');
    	$this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/sweetalert.min.js');
    	$this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/orden-servicio/seguimiento-ordenes.js');
    	
    	$orden = new Application_Model_DbTable_OrdenServicio();
    	$this->view->formFiltroSeguimientoOrdenAdmin = new Application_Form_Ordenes_FiltroSeguimientoOrdenAdmin();
    	$params=$this->_request->getParams();
    	
    	$this->view->formFiltroSeguimientoOrdenAdmin->populate($params);
    	$resultado = $orden->obtenerTodasLasOrdenes($params, true);
    	
    	$this->view->countArray= count($resultado);
    	
    	// Get a Paginator object using Zend_Paginator's built-in factory.
    	$page = $this->_request->getParam('page', 0);
    	$paginator = Zend_Paginator::factory($resultado);
    	$paginator->setCurrentPageNumber($page)
    	->setItemCountPerPage(10)
    	->setPageRange(10);
    	$paginator->setCacheEnabled(true);
    	// Assign paginator to view
    	Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination_sm.phtml');
    	
    	$this->view->paginator=$paginator;
    	
    	foreach ($this->view->paginator as $key => &$value){
    		$total_diff_cron = 0;
    		if ( $value['control_cron_estatus'] == 1){
    			$datetime1 = new DateTime($value['control_cron_inicial']);
    			$zendDate = new Zend_Date();
    			$datetime2 = new DateTime($zendDate->toString('YYYY-MM-dd HH:mm:ss'));
    			$interval = $datetime1->diff($datetime2);
    			$d = $interval->format('%d');
    			$h = $interval->format('%h');
    			$i = $interval->format('%i');
    			$s = $interval->format('%s');
    			$total_diff_cron = $s + ($i * 60) + ($h * 60 * 60) + ( $d * 24 *60 *60);
    		}
    		$duracion_servicio_segundos = ($value['duracion_servicio']*60)+$total_diff_cron;
    		$value['duracion_servicio_segundos'] =  $duracion_servicio_segundos;
    	}
    	$this->view->formSeguimientoOrden = new Application_Form_Ordenes_SeguimientoOrden();
    	
    }
 
    public function actualizarDuracionAction(){
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    	$params=$this->_request->getParams();
    	
    	if ( !is_numeric( $params['duracion_servicio'] ) ) {
    		$this->_helper->json(array('estado'=>'error','descripcion' => 'Formato incorrecto de minutos.' ));
    		die();
    	}
    	
    	$data = array(
    		'solucion_orden' => $params['solucion_orden'],
    		'motivo_orden' => $params['motivo_orden'],
    		'conformidad' => $params['conformidad'],
    		'duracion_servicio' => $params['duracion_servicio']
    	);
    	
    	$id_orden_servicio = $params['id_orden_servicio'];
    	
    	$orden = new Application_Model_DbTable_OrdenServicio();
    	$poliza = new Application_Model_DbTable_Poliza();
    	
    	$where = "id_orden_servicio=$id_orden_servicio";
    	
    	$ordenRow = $orden->fetchRow($where)->toArray();
    	$polizaRow = $poliza->fetchRow('id_poliza='.$ordenRow['id_poliza'])->toArray();

    	$dataPoliza = array(
    			'horas_consumidas' => ($polizaRow['horas_consumidas'] - ($ordenRow['duracion_servicio']/60))
    	);
    	
    	$poliza->update($dataPoliza, 'id_poliza='.$polizaRow['id_poliza']);
    	
    	$polizaRow = $poliza->fetchRow('id_poliza='.$ordenRow['id_poliza'])->toArray();
    	
    	$dataPoliza = array(
    			'horas_consumidas' => ($polizaRow['horas_consumidas'] + ($params['duracion_servicio']/60))
    	);
    	
    	$poliza->update($dataPoliza, 'id_poliza='.$polizaRow['id_poliza']);
    	
    	
    	$status = $orden->update($data, $where);
    	
    	$this->_helper->json(array('estado'=>'ok'));
    	
    }
    
    public function ventasAction(){
    	
    	
    	$params=$this->_request->getParams();
    	$ordenVentas = new Application_Model_DbTable_OrdenVentas();
		
    	if(!isset ($params['id_usuario_admin_atiende']) ) {
    		$params['id_usuario_admin_atiende'] = $_SESSION['Zend_Auth']['USER_VALUES']['id_usuario'];
    	}
    	
    	
    	//echo "<pre>".print_r($params,true)."</pre>";die;
    	
    	$llamadas = $ordenVentas->obtenerLlamadasVentas($params);
    	
    	
    	$this->view->countArray= count($llamadas);
    	
    	// Get a Paginator object using Zend_Paginator's built-in factory.
    	$page = $this->_request->getParam('page', 0);
    	$paginator = Zend_Paginator::factory($llamadas);
    	$paginator->setCurrentPageNumber($page)
    	->setItemCountPerPage(10)
    	->setPageRange(10);
    	$paginator->setCacheEnabled(true);
    	// Assign paginator to view
    	Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination_sm.phtml');
    	
    	$this->view->paginator=$paginator;
    	
    	$this->view->formFiltro = new Application_Form_Ordenes_FiltroSeguimientoVentas();
    	$this->view->formFiltro->populate($params);
    	
    	
    	
//    	echo "<pre>".print_r($llamadas,true)."</pre>";die;
    	
    }
    
    
    public function editaLlamadaAction(){
    	
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    	$params=$this->_request->getParams();
    	$ordenVentas = new Application_Model_DbTable_OrdenVentas();
    	
    	$zendDate = Zend_Date::now()->getTimestamp();
    	$fecha = date('Y-m-d H:i:s', $zendDate);
    	
    	$data = array(
    		'motivo' => $params['motivo'],	
    		'solucion' => $params['solucion'],
    		'id_orden_ventas_estatus' => 2,
    		'fecha_cierre' => $fecha
    	);
    	
    	$where = "id_orden_ventas={$params['id_orden_ventas']}";
    	$params['status-db'] = $ordenVentas->update($data, $where);
    	
    	$this->_helper->json($params);
	}
	
	public function borrarLlamadaAction(){
		
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
		$params=$this->_request->getParams();
		$ordenVentas = new Application_Model_DbTable_OrdenVentas();
				
		$where = "id_orden_ventas={$params['id_orden_ventas']}";
		$params['status-db'] = $ordenVentas->delete($where);
		
		$this->_helper->json($params);
		
		
		
	}
	
	public function consultarOrdenesPorPolizaAction(){
		$params=$this->_request->getParams();
		
		$os = new Application_Model_DbTable_OrdenServicio();
		
		$this->view->llamadas = $os->obtenerServiciosPorPoliza($params['id_poliza']);		
	}
	
}