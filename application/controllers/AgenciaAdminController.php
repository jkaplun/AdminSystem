<?php

class AgenciaAdminController extends Zend_Controller_Action
{

    private $agencia;
    public function init(){
    	$this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables/js/jquery.dataTables.min.js');
    	$this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-plugins/dataTables.bootstrap.min.js');
    	$this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-responsive/dataTables.responsive.js');
    	if( !isset( $_SESSION['Zend_Auth'] )){
    		$this->_redirect('/auth-agency/login');
    	}
    	$this->_helper->layout->setLayout('layout_agencia');
    	$agencia = new Application_Model_DbTable_Agencia();
    	$this->view->agencia = $agencia->find($_SESSION['Zend_Auth']['storage']['id_agencia'])->toArray();
    }

    public function indexAction(){
    	
    	$this->view->params = $this->_request->getParams();
    	 
    	$poliza = new Application_Model_DbTable_Poliza();
    	$this->view->polizasAgencia = $poliza->obtenerPolizasVigentesPorIdAgenciaView($_SESSION['Zend_Auth']['storage']['id_agencia']);

    	foreach ($this->view->polizasAgencia as &$value){
    		$fecha = new Zend_Date($value['fecha_ini']);
    		$fechaString = $fecha->toString('d MMMM yyyy');
    		$value['fecha_ini'] = $fechaString;
    		$fecha = new Zend_Date($value['fecha_fin']);
    		$fechaString = $fecha->toString('d MMMM yyyy');
    		$value['fecha_fin'] = $fechaString;
    	}
    	
		$this->view->usuario = $_SESSION['Zend_Auth']['storage'];

		$utiles = new Application_Model_Services_Utiles();
		$ejecutivos = $utiles->consultarejecutivosporidService($this->view->agencia[0]);
		
		$zendForm = new Zend_Form();

		$element = new Zend_Form_Element_Select('id_usuario_admin_atiende');
		$element->setLabel("Ejecutivo")
			->removeDecorator('HtmlTag')
			->addMultiOptions($ejecutivos)
			->setAttrib("class","form-control")
			->setAttrib("autocomplete","off");
		 
		$zendForm->addElement($element);

		
		$producto = new Application_Model_DbTable_Producto();
		$productos = $producto->obtenerProductosRegistradosPorAgencia($_SESSION['Zend_Auth']['storage']['id_agencia']);
		 
		$productoSelect = array();
		foreach ( $productos as $value2){
			$productoSelect[$value2['id_producto']] = $value2['nombre_prod']; 
		}
		
		// producto
		$element = new Zend_Form_Element_Select('id_producto');
		$element->setRequired(true)
			->setLabel("Producto")
			->removeDecorator('HtmlTag')
			->setAttrib("class","form-control")
			->addMultiOptions($productoSelect)
			->setAttrib("autocomplete","off");
		$zendForm->addElement($element);
		
		// descripcion
		$element = new Zend_Form_Element_Textarea('comentarios_recepcion');
		$element
		->setLabel("Descripción del Problema")
		->removeDecorator('HtmlTag')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("rows","5")
		->setAttrib("placeholder",("Descripción"));
		$zendForm->addElement($element);
		
		$element = new Zend_Form_Element_Text('telefono');
		
		$element->setRequired(false)
		->setLabel('Teléfono')
		->removeDecorator('HtmlTag')
		->setAttrib("class","form-control")
		->setAttrib("autocomplete","off")
		->setAttrib("placeholder","Télefono")
		->setAttrib("maxlength","245");
		$zendForm->addElement($element);
		
		$this->view->selectEjecutivo=$zendForm;		
    }
    
    public function consultarOrdenesAction(){
    	$params=$this->_request->getParams();
    	$ordser = new Application_Model_DbTable_OrdenServicio();
    	$this->view->ordenes = $ordser->obtenerOrdenesPorPoliza($params['id_poliza']);
    	
    	foreach ($this->view->ordenes as &$value) {
    		$fecha = new Zend_Date($value['fecha_alta']);
    		$fechaString = $fecha->toString('d MMMM yyyy , H:m:s');
    		$value['fecha_alta'] = $fechaString;
    		$fecha = new Zend_Date($value['fecha_cierre']);
    		$fechaString = $fecha->toString('d MMMM yyyy , H:m:s');
    		$value['fecha_cierre'] = $fechaString;
    	}
    }
    
    public function agregarOrdenAction(){

    	$params=$this->_request->getParams();
//     	echo "<pre>".print_r($_SESSION['storage']['id_usuario_agencia'],true)."</pre>";
//     	echo "<pre>".print_r($params,true)."</pre>";die;
    	
    	$data = array(
    			'id_agencia' => $_SESSION['Zend_Auth']['storage']['id_agencia'],
    			'id_usuario_admin_alta' => 2,
    			'id_usuario_admin_atiende' => $params['id_usuario_admin_atiende'],
    			'id_producto' => $params['id_producto'],
    			'id_poliza' => $params['id_poliza'],
    			'id_orden_servicio_estatus' => 5,
    			'id_usuario_agencia_solicito' => $_SESSION['storage']['id_usuario_agencia'],
    			'comentarios_recepcion' => "Teléfono : ".$params['telefono']." <br> ". $params['comentarios_recepcion'],
    			'id_motivo' => 21,
    			'id_tipo_soporte' => 1
    	);
    	$ordenServicioDbTable = new Application_Model_DbTable_OrdenServicio();
    	
    	$idNuevaOrden = $ordenServicioDbTable->insert($data);
    	 
    	$this->_redirect('/agencia-admin/index/status/1');    	
    }
    
    
    public function historicoActualizacionesAction(){
    	
    	$params=$this->_request->getParams();
    	$params['id_agencia']= $_SESSION['Zend_Auth']['storage']['id_agencia'];
    	
    	$a = new Application_Model_DbTable_Actualizaciones();
    	$this->view->actualizaciones = $a->actualizacionesTodas($params);
    
    	
    }
}
