<?php

class OrdenesController extends Zend_Controller_Action
{

    public function indexAction(){


    }

    public function nuevaOrdenAction()
    {    

    }

    public function atencionOrdenAction()
    {    


    }

    public function seguimientoOrdenAction()
    {      
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables/js/jquery.dataTables.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-plugins/dataTables.bootstrap.min.js');
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-responsive/dataTables.responsive.js'); 
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/ordenes/seguimiento-ordenes.js');

    }

    public function monitoreoOrdenAction()
    {    
        $this->_helper->layout->setLayout('layout_monitoreo');  
    }

}

