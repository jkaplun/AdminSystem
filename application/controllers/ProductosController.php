<?php

class ProductosController extends Zend_Controller_Action
{

    private $agencia_producto;
    public function init()
    {
    	$this->view->activemenu=4;
        $this->agencia_producto = new Application_Model_DbTable_AgenciaProducto();
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables/js/jquery.dataTables.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-plugins/dataTables.bootstrap.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-responsive/dataTables.responsive.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/productos/index.js');

        $producto = new Application_Model_DbTable_Producto();
        $params=$this->_request->getParams();
        $this->view->form = new Application_Form_Productos_Productos();
        $registros = $producto->obtenerProductos();
        $this->view->registros = $registros;

    }

    
    public function productosdisponiblesadquiridosporidagenciaAction()
    {
    	$producto = new Application_Model_DbTable_Producto();
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    	$params=$this->_request->getParams();
    	$productos = $producto->obtenerProductosDisponiblesAdquiridosPorIdAgencia($params['id_agencia']);
    	
    	
    	
    	foreach ( $productos as &$producto ){
    		if( $producto['tiene_licencia'] == 'N' ){
    			$producto['numero_licencias_table']='N/A';
    		 } else {
    		 	$producto['numero_licencias_table']='<b>'.$producto['numero_licencias'].'</b>';
    		 }
    		
    		
    		if( $producto['estatus'] == 'S' ){
    			$producto['estatus_table']='<i class="fa fa-check check-green" aria-hidden="true"></i>';
    		} else {
    			$producto['estatus_table']='<i class="fa fa-times x-red" aria-hidden="true"></i>';
    		}
    	}
    	
    	//echo "<pre>".print_r($productos,true)."</pre>";die;
    	 
    	$this->_helper->json($productos);
    }
    
	public function agregarAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams();
        $data = array(
                       	'id_agencia' => $params['id_agencia'],
                       	'id_producto' => $params['id_producto'],
                       	'numero_licencias' => $params['numero_licencias'],
                       	'estatus' => $params['estatus_producto']
                      );

        $agencia_producto = new Application_Model_DbTable_AgenciaProducto();
        $nuevoAgenciaProducto = $this->agencia_producto->insert($data);
        $data['estado']='ok';
        $this->_helper->json($data); 
        $this->_redirect('agencias/');       
    }
    
    public function actualizarAction()
    {
    	$this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams();
        
        $dataResponse = array(
                       	'id_agencia' => $params['id_agencia'],
                       	'id_producto' => $params['id_producto_formProducto'],
                       	'numero_licencias' => $params['numero_licencias'],
                        'estatus' => $params['estatus_producto']
                      );
        
        $data = array(
        		'numero_licencias' => $params['numero_licencias'],
        		'estatus' => $params['estatus_producto']
        );
        
        $agencia_producto = new Application_Model_DbTable_AgenciaProducto();

        $where = "id_agencia = '{$params['id_agencia']}' and id_producto = '{$params['id_producto_formProducto']}'";

        $agencia_producto->update($data, $where);
       	
        $data['descripcion']='El producto ha sido actualizado exitosamente';
        
        if( $dataResponse['estatus'] == 'S' ){
        	$dataResponse['estatus_table']='<i class="fa fa-check check-green" aria-hidden="true"></i>';
        } else {
        	$dataResponse['estatus_table']='<i class="fa fa-times x-red" aria-hidden="true"></i>';
        }
        
        $dataResponse['estado']='ok';
        $this->_helper->json($dataResponse);

    }

    public function consultarproductosAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams(); 
    	$producto = new Application_Model_DbTable_Producto();
        $productos = $producto->obtenerProductos();

        $this->_helper->json($productos);

    }

    public function consultarAction(){
    
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    	$params=$this->_request->getParams();
    	$datosAgencia = $this->agencia->find($params['id_agencia'])->toArray();
    	 
    	$this->_helper->json($datosAgencia[0]);
    
    }

    public function consultarproductosdisponiblesporagenciaAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams(); 
    	$producto = new Application_Model_DbTable_Producto();
        $productos = $producto->obtenerProductosRegistradosPorAgencia($params['id_agencia']);
        
        $this->_helper->json($productos);

    }
    

    public function consultaSelectProductoAction(){
    
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    	$params=$this->_request->getParams();
    	$producto = new Application_Model_DbTable_Producto();
    	$productos = $producto->obtenerProductosFaltantesPorAgencia($params['id_agencia']);
    
    	$this->_helper->json($productos);
    
    }
    
}

