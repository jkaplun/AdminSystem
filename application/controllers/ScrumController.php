<?php

/**
 * 
 * @author jgarfias
 *
 */
class ScrumController extends Zend_Controller_Action{

    public function init(){
    
    }

    public function indexAction(){
    	
    	
    	$rh = new Application_Model_DbTable_ScrumRH();
    	$recursosHumanos = new Zend_Form_Element_Select('recursosHumanos');
    	$this->view->rhs = $rh->obtenerRH();
    	//echo "<pre>".print_r($this->view->rhs,true)."</pre>";die;
    	 
    	$lista = array();
    	foreach ( $this->view->rhs as $rh){
    		$lista[$rh['id_scrum_recursos_humanos']]=$rh['nombre_completo'];
    	}
    	 
    	$zendForm = new Zend_Form();
    	 
    	$recursosHumanos
    	->removeDecorator('label')
    	->removeDecorator('HtmlTag')
    	->addMultiOptions($lista)
    	->setAttrib("class","form-control selectpicker")
    	->setAttrib("data-max-options",10)
    	->setAttrib("data-live-search","true")
    	->setAttrib("title","Ingresa el nombre...")
    	->setAttrib("autocomplete","off")
    	->setValue(1);
    	 
    	$zendForm->addElement($recursosHumanos);
    	
    	$this->view->recursosHumanos=$zendForm;
    	 
    }
    
    public function newTicketAction(){
    	
    	$params=$this->_request->getParams();
    	 
    	$formTicket = new Application_Form_Scrum_TicketForm();
    	
    	if( $this->_request->isPost() ){
    	
    		
    		if($formTicket->isValid($params)){
    			$params = $formTicket->getValues();
    			
    			$objDB = new Application_Model_DbTable_ScrumTicket();
    			
    			if($params['fecha_alta']==''){
    				$params['fecha_alta'] = date('Y-m-d'); 
    			}
    			
    			$objDB->insert($params);
    			 
    		}
    		
    		//die('Entra!');
    	
    		$formTicket->populate($params);
    	}
    	
    	
    	
    	$this->view->formTicket = $formTicket;
    	
    }
    
    public function allTicketsAction(){
    	$objDB = new Application_Model_DbTable_ScrumTicket();
    	
    	$this->view->tickets = $objDB->getTickets();
    	
    }
    
}