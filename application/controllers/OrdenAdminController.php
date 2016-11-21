<?php

class OrdenAdminController extends Zend_Controller_Action
{

    public function init()
    {
        $this->orden = new Application_Model_DbTable_OrdenServicio();
        $this->view->formOrdenes = new Application_Form_Ordenes_NuevaOrden();
    }

    public function indexAction(){   
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables/js/jquery.dataTables.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-plugins/dataTables.bootstrap.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-responsive/dataTables.responsive.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/flipclock/flipclock.min.js');  
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/flipclock/easytimer.js'); 
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/sweetalert.min.js'); 
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/orden-servicio/seguimiento-ordenes-admin.js'); 


        $params=$this->_request->getParams();
        $registros = $this->orden->obtenerServiciosPendientesHistorico();
        $this->view->registros = $registros;

     }

}

