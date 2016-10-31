<?php

class OrdenServicioController extends Zend_Controller_Action
{

    public function indexAction(){


    }

    public function nuevaOrdenAction()
    {    
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

