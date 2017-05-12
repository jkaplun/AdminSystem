<?php

class ordenCreacionController extends Zend_Controller_Action
{

    public function indexAction(){
        
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/sweetalert.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables/js/jquery.dataTables.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-plugins/dataTables.bootstrap.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-responsive/dataTables.responsive.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/orden-servicio/nueva-orden.js');
        
        
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
        
        $tipoSoporte = new Zend_Form_Element_Select('tipo_soporte');

        $tipoSoporteArreglo = array(
        		'1' => 'Curso',
        		'2' => 'Demostración',
        		'3' => 'Desarrollo',
        		'4' => 'Implementación',
        		'5' => 'Páginas Web',
        		'6' => 'Reportarse',
        		'7' => 'Reportarse Urgente',
        		'8' => 'Revisión MIG',
        		'9' => 'Soporte en Sitio',
        		'10' => 'Soporte Interno',
        		'10' => 'Soporte Remoto',
        		'10' => 'Soporte Telefónico',
        		'10' => 'Ventas',
        );
        $tipoSoporte
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions($tipoSoporteArreglo)
        ->setAttrib("class","form-control tipo-soporte-select")
        ->setAttrib("data-max-options",10)
        ->setAttrib("data-live-search","true")
        ->setAttrib("title","Ingresa el tipo de soporte")
        ->setAttrib("autocomplete","off");
         
        $zendForm->addElement($tipoSoporte);
 		$this->view->selectAgencias=$zendForm;
        $this->view->formUsuarioAgencia = new Application_Form_UsuariosAgencia_UsuariosAgencia();
        
		$this->view->formNuevaOrden = new Application_Form_Ordenes_NuevaOrden();
        
        
    }

    public function agregarAction()
    {
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    	$params=$this->_request->getParams();
    	
    	$data = array(
    			'id_agencia' => $params['id_agencia'],
    			'id_usuario_admin_alta' => $_SESSION['Zend_Auth']['USER_VALUES']['id_usuario'],
    			'id_usuario_admin_atiende' => $params['id_usuario_admin_atiende'],
    			'id_producto' => $params['id_producto'],
    			'id_poliza' => $params['id_poliza'],
    			'id_orden_servicio_estatus' => $params['id_orden_servicio_estatus'],
    			'id_usuario_agencia_solicito' => $params['id_usuario_agencia_solicito'],
    			'solicito_otro' => $params['solicito_otro'],
    			'comentarios_recepcion' => $params['comentarios_recepcion'],
    			'id_motivo' => $params['id_motivo'],
    			'id_tipo_soporte' => $params['id_tipo_soporte'],
    			'fecha_soporte_sitio' => $params['fecha_soporte_sitio']." ".$params['hora_soporte_sitio'],
    	);
    	
    	if ($params['id_usuario_agencia_solicito']=="otro") {
    		unset($data['id_usuario_agencia_solicito']);
    	}
    	
    	
    	$form = new Application_Form_Ordenes_NuevaOrden();
    	
    	$mensajesDeError = $form->getMessages();
    	$cantidadDeErrores = count($mensajesDeError);
        $ordenServicioDbTable = new Application_Model_DbTable_OrdenServicio();
    	if ($cantidadDeErrores == 0){
        	$polizaDbTable = new Application_Model_DbTable_Poliza();
        	$polizaVigente = $polizaDbTable->obtenerPolizaVigentePorId($params['id_poliza']);
        	
        	if($polizaVigente != null){
    			
    			//Obteniendo el id del producto
    			$data['id_producto'] = $polizaVigente['id_producto'];
    			//Se crea la orden de servicio
    			
    			if ($params['id_tipo_soporte']==2 && $params['id_motivo']==21) {
    				$data['id_orden_servicio_estatus'] = 6;
    				$data['motivo_orden'] = $params['motivo_orden'];
    				$data['solucion_orden'] = $params['solucion_orden'];
    				$data['conformidad'] = $params['conformidad'];
    				$idNuevaOrden = $ordenServicioDbTable->insert($data);
    				$data['duracion_servicio'] = $params['duracion_servicio'];
    				$data['control_cron_inicial'] = null;
    				$data['control_cron_final'] = null;
    				$data['control_cron_estatus'] = 3;
    				//Restando minutos a la póliza
    				$servicesPolizas = new Application_Model_Services_ServicesPolizas();
    				$servicesPolizas->restarMinutosAPoliza($params['id_poliza'], $data['duracion_servicio']);
    			} else {
    				$idNuevaOrden = $ordenServicioDbTable->insert($data);
    			}
    			
    			$email = new Application_Model_Services_Emails();
    			$email->agregarOrdenServicio($data);
    			
	    		// se inyecta el ID, estado y descripción en la respuesta al cliente
    			
    			$data['id_orden_servicio']=$idNuevaOrden;
    			$data['estado']='ok';
    			$data['descripcion']='La orden ha sido creada exitosamente';
    			$this->_helper->json($data);
    			
        	} else {
				//else cuando no hay pólizas vigentes
    			$data['estado']='error';
        	 	$data['descripcion']='Elija una póliza vigente';
        	 	// se responde al cliente
        	 	$this->_helper->json($data);
        	}
    	} else { 
    		// else cuando existe un error encontrado en el form
    		$this->_helper->json($mensajesDeError);
    		$this->_redirect('orden-servicio/nueva-orden');
    	}
    }
    
    

}


