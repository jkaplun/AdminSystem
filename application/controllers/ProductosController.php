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

        $users = new Application_Model_DbTable_Producto();
        $params=$this->_request->getParams();
        $this->view->form = new Application_Form_Productos_Productos();
        $registros = $users->obtenerProductos();
        $this->view->registros = $registros;

    }

}

