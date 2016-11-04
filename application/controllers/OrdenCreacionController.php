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
        $this->view->selectAgencias=$zendForm;

    }

    public function agregarAction()
    {
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    	$params=$this->_request->getParams();
    	
    	$data = array(
    			'id_agencia' => $params['id_agencia'],
    			'id_usuario_admin_alta' => 1, //$params['id_usuario_admin_alta'],
    			'id_usuario_admin_atiende' => $params['ejecutivo'],
    			'id_producto' => $params['producto'],
    			//'id_poliza' => $params['id_poliza'],
    			'id_orden_servicio_estatus' => 2,
    			'id_usuario_agencia_solicito' => $params['solicito'],
    			//Se crea con el estado 0 que indica que es nueva
    			'control_cron_estatus' => 0,
    			//'fecha_alta' => se asigna en la base de datos 
    			'comentarios_recepcion' => $params['descripcion'],
    			'motivo' => $params['motivo']
    	);
    	
    	$form = new Application_Form_Ordenes_NuevaOrden();
    	
    	$mensajesDeError = $form->getMessages();
    	$cantidadDeErrores = count($mensajesDeError);
    	if ($cantidadDeErrores == 0)
    	{
        	$polizaDbTable = new Application_Model_DbTable_Poliza();
        	$polizaVigente = $polizaDbTable->obtenerPolizaVigenteProductoAgencia($params['id_agencia'], $params['producto']);
        	if($polizaVigente != null)
        	{
    			//Se crea la orden de servicio con una clave sin el id
    			$idNuevaOrden = $this->poliza->insert($data);
	    		// se inyecta el ID, estado y descripción en la respuesta al cliente
    			$data['id_orden_servicio']=$idNuevaOrden;
    			$data['estado']='ok';
    			$data['descripcion']='La orden ha sido creada exitosamente';
    			$this->_helper->json($data);    
        	}
        	else 
        	{
				//else cuando no hay pólizas vigentes
    			$data['estado']='error';
        	 	$data['descripcion']='El cliente no tiene pólizas vigentes';
        	 	// se responde al cliente
        	 	$this->_helper->json($data);
        	}
    	}
    	else
    	{ 
    		// else cuando existe un error encontrado en el form
    		$this->_helper->json($mensajesDeError);
    		$this->_redirect('orden-servicio/nueva-orden');
    	}
    }
    
    

}


