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
     
    public function actualizarAction(){
    
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    	$params=$this->_request->getParams();
    
    	$data = array(
    			'id_usuario_admin_atiende' => $params['ejecutivo'],
    			'id_usuario_agencia_solicito' => $params['solicito'],
    			'solucion' => $params['solucion'],
    			//'control_cron_inicial' => se define más adelante,
    			'control_cron_estatus' => $params['control_cron_estatus'],
    			'control_cron_final' => $params['control_cron_final'],
    			'duracion_servicio' => $params['duracion_servicio'],
    			'motivo' => $params['motivo']
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
    			if($params['control_cron_estatus'] == 1 && $orden['control_cron_inicial'] == null)
    			{
    				$data['control_cron_inicial'] = Zend_Date::now();
    			}
    			else if($params['control_cron_estatus'] == 3)
    			{
    				$data['fecha_cierre'] = Zend_Date::now();
    				$diferenciaHoras = $ordenServicioDbTable->obtenerDiferenciaDeHoras
    				($params['id_orden_servicio'], Zend_Date::now(), $params['control_cron_inicial']);
    				$diferenciaMinutos = $diferenciaHoras*60;
    				$data['duracion_servicio'] = $diferenciaMinutos;
					//Restando minutos a la póliza
    				$servicesPolizas = new Application_Model_Services_ServicesPolizas();
    				$servicesPolizas->restarMinutosAPoliza($params['id_poliza'], $diferenciaMinutos);
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

    public function obtener_ordenes_por_ejecutivoAction()
    {
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    	$params=$this->_request->getParams();
    	 
    	$ordenServicioDbTable = new Application_Model_DbTable_OrdenServicio();
    	$ordenes = $ordenServicioDbTable->obtenerOrdenesPorIdEjecutivo($params['ejecutivo']);
    	
    	$this->_helper->json($ordenes);
    }

    public function obtener_ordenes_por_idAction()
    {
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    	$params=$this->_request->getParams();
    	 
    	$ordenServicioDbTable = new Application_Model_DbTable_OrdenServicio();
    	$orden = $ordenServicioDbTable->obtenerOrdenPorId($params['id_orden_servicio']);
    	if($orden != null)
    	{
    		//Si la orden está en play
    		$diferenciaDeMinutos;
    		if($orden['control_cron_estatus'] = 1)
    		{
    			$diferenciaDeHoras = $ordenServicioDbTable->obtenerDiferenciaDeHoras
    			($params['id_orden_servicio'], Zend_Date::now(), $params['control_cron_inicial']);
    			$diferenciaDeMinutos = $diferenciaDeHoras['diferencia']*60;
    		}
    		//Si la orden está en pause
    		else if($orden['control_cron_estatus'] = 2)
    		{
    			$diferenciaDeHoras = $ordenServicioDbTable->obtenerDiferenciaDeHoras
    			($params['id_orden_servicio'], $params['control_cron_final'], $params['control_cron_inicial']);
    			$diferenciaDeMinutos = $diferenciaDeHoras['diferencia']*60;
    		}
    	}
    	$orden['tiempo_cronometro'] = $diferenciaDeMinutos;
    	$this->_helper->json($orden);
    }

}

