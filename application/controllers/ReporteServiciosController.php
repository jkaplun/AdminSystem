<?php

class ReporteServiciosController extends Zend_Controller_Action
{
            
    public function init()
    {
        $this->orden = new Application_Model_DbTable_OrdenServicio();
    }


    public function reporteServiciosClientesAction()
    {
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/sweetalert.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables/js/jquery.dataTables.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-plugins/dataTables.bootstrap.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-responsive/dataTables.responsive.js');    
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/reportes/servicios/reportes-servicios.js');

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

    public function reporteServiciosEjecutivosAction()
    {
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/sweetalert.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables/js/jquery.dataTables.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-plugins/dataTables.bootstrap.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-responsive/dataTables.responsive.js');    
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/reportes/servicios/reportes-servicios.js');

        $usuariosAdmin = new Application_Model_DbTable_UsuarioAdmin(); 
        $selectAgencias = new Zend_Form_Element_Select('select_agencias');
        $this->view->ejectutivos = $usuariosAdmin->obtenerTodosEjecutivos();

        $listaEjecutivos = array();
         foreach ( $this->view->ejectutivos as $ejectutivos){
            $listaEjecutivos[$ejectutivos['id_usuario']]=$ejectutivos['nombre'].' '.$ejectutivos['apellido_paterno'];
        }
         
        $zendForm = new Zend_Form();
         
        $selectAgencias
            ->removeDecorator('label')
            ->removeDecorator('HtmlTag')
            ->addMultiOptions($listaEjecutivos)
            ->setAttrib("class","form-control selectpicker")
            ->setAttrib("data-max-options",10)
            ->setAttrib("data-live-search","true")
            ->setAttrib("title","Ingresa nombre del ejectutivo...")
            ->setAttrib("autocomplete","off");
         
        $zendForm->addElement($selectAgencias);
        $this->view->selectAgencias=$zendForm;
    }

    public function reporteServiciosHistoricoAction()
    {
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/sweetalert.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables/js/jquery.dataTables.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-plugins/dataTables.bootstrap.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-responsive/dataTables.responsive.js');    
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/reportes/servicios/reportes-servicios.js');
    
        $params=$this->_request->getParams();
        $registros = $this->orden->obtenerServiciosFinalizadosHistorico();
        $this->view->registros = $registros;
    }

    public function consultarReporteServiciosAgenciaAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams(); 
        $serviciosAgencia = $this->orden->obtenerServiciosFinalizadosPorIdAgencia($params['id_agencia']);
        $this->_helper->json($serviciosAgencia);

    }

    public function consultarReporteServiciosEjecutivoAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams(); 
        $serviciosAgencia = $this->orden->obtenerServiciosFinalizadosPorIdEjecutivo($params['id_ejecutivo']);
        $this->_helper->json($serviciosAgencia);

    }

}

