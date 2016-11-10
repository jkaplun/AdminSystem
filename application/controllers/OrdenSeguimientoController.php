<?php

class OrdenSeguimientoController extends Zend_Controller_Action
{

    public function indexAction(){
    
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables/js/jquery.dataTables.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-plugins/dataTables.bootstrap.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-responsive/dataTables.responsive.js'); 
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/orden-servicio/seguimiento-ordenes.js');  

        $orden = new Application_Model_DbTable_OrdenServicio();
        
        $valores = array();
        $resultado = $orden->obtenerOrdenes($valores);
        
        
        //echo '<pre>'.print_r($resultado,true).'</pre>';die;
        
        /*echo('<pre>');
        var_dump($_SESSION);
        echo('</pre>');*/
        
        
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
    	if($orden != null)
    	{
    		if($orden['fecha_inicia_atencion'] == null)
    		{
    			$data['fecha_inicia_atencion'] = Zend_Date::now();
    			$data['control_cron_inicial'] = Zend_Date::now();
    		}
    		else
    		{
    			$data['control_cron_inicial'] = Zend_Date::now();
    		}
    		$where = "id_orden_servicio = {$params['id_orden_servicio']}";
    		// 	se actualiza en la base de datos a la orden de servicio
    		$ordenServicioDbTable->update($data, $where);
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
    	
    	$data = array(
    			'control_cron_estatus' => 2
    			);
    	
    	$ordenServicioDbTable = new Application_Model_DbTable_OrdenServicio();
    	$orden = $ordenServicioDbTable->obtenerOrdenPorId($params['id_orden_servicio']);
    	if($orden != null)
    	{
    		$data['control_cron_final'] = Zend_Date::now();
    		$duracionServicio = $orden['duracion_servicio'];
    		$diferenciaFechas = $ordenServicioDbTable->
    							obtenerDiferenciaDeFechas(
    									$data['control_cron_final'], $data['control_cron_inicial']);
    		$minutosConvertidos = $diferenciaFechas['hora']*60;
    		$duracionServicio = $duracionServicio + $minutosConvertidos + $diferenciaFechas['minuto'];
    		$data['duracion_servicio'] = $duracionServicio;
    		$where = "id_orden_servicio = {$params['id_orden_servicio']}";
    		// 	se actualiza en la base de datos a la orden de servicio
    		$ordenServicioDbTable->update($data, $where);
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
    
    	$data = array(
    			'id_usuario_admin_atiende' => $params['ejecutivo'],
    			'id_usuario_agencia_solicito' => $params['solicito'],
    			'solucion' => $params['solucion'],
    			'concluido' => $params['concluido '],
    			'motivo' => $params['motivo']
    			//'control_cron_estatus' => se define más adelante,
    			//'fecha_cierre' => se define más adelante,
    			//'control_cron_inicial' => se define más adelante,
    			//'control_cron_final' => $params['control_cron_final'],
    			//'duracion_servicio' => se define más adelante,
    	);
    
    	$form = new Application_Form_Ordenes_NuevaOrden();
    	 
    	$mensajesDeError = $form->getMessages();
    	$cantidadDeErrores = count($mensajesDeError);
    	if ($cantidadDeErrores == 0)
    	{
    		$ordenServicioDbTable = new Application_Model_DbTable_OrdenServicio();
    		$orden = $ordenServicioDbTable->obtenerOrdenPorId($params['id_orden_servicio']);
    		if($orden['concluido'] != "S")
    		{
    			if($params['concluido'] == "N")
    			{
    				if($params['control_cron_estatus'] == 1)
    				{
    					if($orden['control_cron_inicial'] == null)
    					{
    						$data['fecha_inicia_atencion'] = Zend_Date::now();
    						$data['control_cron_inicial'] = Zend_Date::now();
    					}
    					else
    					{
    						$data['control_cron_inicial'] = Zend_Date::now();
    					}
    					$data['control_cron_estatus'] = 2;
    				}
    				else if($params['control_cron_estatus'] == 2)
    				{
    					$duracionServicio = $orden['duracion_servicio'];
    					$diferenciaFechas = $ordenServicioDbTable->
    					obtenerDiferenciaDeFechas(
    							Zend_Date::now(), $data['control_cron_inicial']);
    					$minutosConvertidos = $diferenciaFechas['hora']*60;
    					$duracionServicio = $duracionServicio + $minutosConvertidos + $diferenciaFechas['minuto'];
    					$data['duracion_servicio'] = $duracionServicio;
    					$data['control_cron_final'] = Zend_Date::now();
    				}
    			}
    			else 
    			{
    				$data['fecha_cierre'] = Zend_Date::now();
    				$diferenciaFechas = $ordenServicioDbTable->
    					obtenerDiferenciaDeFechas(
    							Zend_Date::now(), $data['control_cron_inicial']);
    					$minutosConvertidos = $diferenciaFechas['hora']*60;
    				$duracionServicio = $duracionServicio + $minutosConvertidos + $diferenciaFechas['minuto'];
    				$data['duracion_servicio'] = $duracionServicio;
    				$data['control_cron_final'] = Zend_Date::now();
    				$data['control_cron_estatus'] = 3;
					//Restando minutos a la póliza
    				$servicesPolizas = new Application_Model_Services_ServicesPolizas();
    				$servicesPolizas->restarMinutosAPoliza($params['id_poliza'], $duracionServicio);
    				
    			}
    			$where = "id_orden_servicio = {$params['id_orden_servicio']}";
    			// 	se actualiza en la base de datos a la p�liza
    			$ordenServicioDbTable->update($data, $where);
    			$data['estado']='ok';
    			$data['descripcion']='La orden ha sido actualizada exitosamente';
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
    	 
    	$ordenServicioDbTable = new Application_Model_DbTable_OrdenServicio();
    	$ordenes = $ordenServicioDbTable->obtenerOrdenesPorIdEjecutivo($_SESSION['Zend_Auth']['USER_VALUES']['id_usuario']);
    	foreach ($ordenes as $orden)
    	{
    		//Si la orden está en play
    		$diferenciaDeMinutos;
    		if($orden['control_cron_estatus'] = 1)
    		{
    			$duracionServicio = $orden['duracion_servicio'];
    			$diferenciaFechas = $ordenServicioDbTable->
    			obtenerDiferenciaDeFechas(
    					Zend_Date::now(), $data['control_cron_inicial']);
    			$horasConvertidos = $diferenciaFechas['hora']*60;
    			$duracionServicio = $duracionServicio + $horasConvertidos + $diferenciaFechas['minuto'];
    			$orden['duracion_servicio'] = $duracionServicio;
    		}
    		//Si la orden está en pause se envía el tiempo acumulado en duracion_servicio
    	}
    	$this->_helper->json($orden);
    }

}

