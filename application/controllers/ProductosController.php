<?php

class ProductosController extends Zend_Controller_Action
{

    public function init()
    {
    	$this->view->activemenu=4;
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
    
    public function productosDisponiblesAdquiridosPorIdAgenciaAction()
    {
    	$producto = new Application_Model_DbTable_Producto();
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    	$params=$this->_request->getParams();
    	$productos = $producto->obtenerProductosDisponiblesAdquiridosPorIdAgencia($params['id_agencia']);
    	
    	$this->_helper->json($productos);
    }
    
	public function agregarProductoAAgenciaAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams();
        $data = array(
                       	'id_agencia' => $params['id_agencia'],
                       	'id_producto' => $params['id_producto'],
                       	'numero_licencias' => $params['numero_licencias'],
                       	'estatus' => 'S'
                      );

        $agencia_producto = new Application_Model_DbTable_AgenciaProducto();
        $nuevoAgenciaProducto = $this->$agencia_producto->insert($data);
        $data['estado']='ok';
        $this->_helper->json($data); 
        $this->_redirect('agencias/');       
    }
    
    public function actualizarRelacionAgenciaProductoAction()
    {
    	$this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams();
        $data = array(
                       	'id_agencia' => $params['id_agencia'],
                       	'id_producto' => $params['id_producto'],
                       	'numero_licencias' => $params['numero_licencias']
                      );

        $agencia_producto = new Application_Model_DbTable_AgenciaProducto();

        $where = "id_agencia = '{$params['id_agencia']}' and id_producto = '{$params['id_producto']}'";
        if($params['estatus'] == 'N')
        {
        	$agencia_producto->delete($where);
        	$data['descripcion']='El producto ha sido eliminado exitosamente';
        }
        else 
        {
        	$agencia_producto->update($data, $where);
        	$data['descripcion']='El producto ha sido actualizado exitosamente';
        }
        $data['id_agencia']=$params['id_agencia'];
        $data['id_producto']=$params['id_producto'];
        $data['estado']='ok';
        $this->_helper->json($data);
        $this->_redirect('agencias/');
    }

    public function consultarProductosAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams(); 
    	$producto = new Application_Model_DbTable_Producto();
        $productos = $producto->obtenerProductos();
       
        $this->_helper->json($productos);

    }
    

}

