<?php
/**
 * 
 * @author jgarfias
 *a
 */
class AgendaController extends Zend_Controller_Action{
    public function init(){
    }

    public function indexAction(){
    	$params=$this->_request->getParams();
    	$agendaForm = new Application_Form_Agenda_Agenda();
    	
    	if ( $this->_request->isPost() ) {
    		$agendaForm->populate($params);
    		
    		if ( $agendaForm->isValid($params) ) {
    			$agendaDB = new Application_Model_DbTable_Agenda();
    			$data = array(
    					"id_usuario_admin" => $_SESSION['Zend_Auth']['USER_VALUES']['id_usuario'],
    					"id_agencia" => $params['id_agencia'],
    					"fecha" => $params['fecha'],
    					"hora_inicial" => $params['hora_inicial'],
    					"hora_final" => $params['hora_final'],
    					"contacto" => $params['contacto'],
    					"motivo" => $params['motivo']
    			);
    			
    			$agendaDB->insert($data);
    			
    			$this->redirect('agenda/confirmacion');
    			
    		} else {
    			$agendaForm->populate($params);
    		}
       	}
    	
    	$this->view->agendaForm = $agendaForm;
    	
	}
	
	public function confirmacionAction(){
		
	}
	
	public function personalAction(){
		
		$date = Zend_Date::now();
		
		$agendaArray = array();
		
		$i=0;
		do {
			$a = new Application_Model_DbTable_Agenda();
			$agendaArray[$date->toString("Y-MM-dd")] = $a->agendaPersonal($_SESSION['Zend_Auth']['USER_VALUES']['id_usuario'] , $date->toString("Y-MM-dd"));
			
			$date->addDay(1);
			$i++;
		}while ($i<7);

		$this->view->agendaArray = $agendaArray;
		
		
	}
	
	public function generalAction(){
		$date = Zend_Date::now();
		
		$agendaArray = array();
		
		$i=0;
		do {
			$a = new Application_Model_DbTable_Agenda();
			$agendaArray[$date->toString("Y-MM-dd")] = $a->agendaGeneral($date->toString("Y-MM-dd"));
			
			$date->addDay(1);
			$i++;
		}while ($i<7);
		
		$this->view->agendaArray = $agendaArray;
		
	}
}
