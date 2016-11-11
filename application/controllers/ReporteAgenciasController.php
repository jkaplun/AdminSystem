<?php

class ReporteAgenciasController extends Zend_Controller_Action
{
            
    public function init()
    {
        $this->orden = new Application_Model_DbTable_Agencia();
    }

    public function reporteAgenciasPolizasAction()
    {
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/sweetalert.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables/js/jquery.dataTables.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-plugins/dataTables.bootstrap.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-responsive/dataTables.responsive.js');    
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/reportes/agencias/reportes-agencias.js');

        $tipoPoliza = new Application_Model_DbTable_TipoPoliza();
        $selectAgencias = new Zend_Form_Element_Select('select_agencias');
        $resultados = $tipoPoliza->obtenerTiposPoliza();
        $lista = array();
        foreach ( $resultados as $resultado){
            $lista[$resultado['tipo']]=$resultado['descripcion'];
        }
         
        $zendForm = new Zend_Form();
         
        $selectAgencias
            ->removeDecorator('label')
            ->removeDecorator('HtmlTag')
            ->addMultiOptions($lista)
            ->setAttrib("class","form-control selectpicker")
            ->setAttrib("data-max-options",10)
            ->setAttrib("data-live-search","true")
            ->setAttrib("title","Ingresa nombre del tipo de Póliza...")
            ->setAttrib("autocomplete","off");
         
        $zendForm->addElement($selectAgencias);
        $this->view->selectAgencias=$zendForm;
    }

    public function reporteAgenciasProductosAction()
    {
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/sweetalert.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables/js/jquery.dataTables.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-plugins/dataTables.bootstrap.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-responsive/dataTables.responsive.js');    
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/reportes/agencias/reportes-agencias.js');

        $usuariosAdmin = new Application_Model_DbTable_Producto(); 
        $selectAgencias = new Zend_Form_Element_Select('select_agencias');
        $this->view->productos = $usuariosAdmin->obtenerProductos();

        $listaEjecutivos = array();
         foreach ( $this->view->productos as $productos){
            $listaEjecutivos[$productos['id_producto']]=$productos['nombre_prod'];
        }
         
        $zendForm = new Zend_Form();
         
        $selectAgencias
            ->removeDecorator('label')
            ->removeDecorator('HtmlTag')
            ->addMultiOptions($listaEjecutivos)
            ->setAttrib("class","form-control selectpicker")
            ->setAttrib("data-max-options",10)
            ->setAttrib("data-live-search","true")
            ->setAttrib("title","Ingresa nombre del producto...")
            ->setAttrib("autocomplete","off");
         
        $zendForm->addElement($selectAgencias);
        $this->view->selectAgencias=$zendForm;
    }

    public function consultarReporteAgenciaProductosAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams(); 
        $serviciosAgencia = $this->orden->obtenerAgenciaPorProducto($params['id_producto']);
        $this->_helper->json($serviciosAgencia);

    }

    public function consultarReporteAgenciaPolizasAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams(); 
        $serviciosAgencia = $this->orden->obtenerAgenciaPorPoliza($params['id_poliza']);
        $this->_helper->json($serviciosAgencia);

    }

}

