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
    					"hora_inicial" => $params['fecha'].' '.$params['hora_inicial'].':00',
    					"hora_final" => $params['fecha'].' '.$params['hora_final'].':00',
    					"contacto" => $params['contacto'],
    					"motivo" => $params['motivo']
    				);
    			try {
    				$agendaDB->insert($data);
    			} catch (Exception $e) {
    				echo $e;die;
    			
    			}
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
			if ( $date->toString("e") == 6 ) {
				$date->addDay(2);
			}
			
			$a = new Application_Model_DbTable_Agenda();
			$agendaArray[$date->toString("Y-MM-dd")] = $a->agendaPersonal($_SESSION['Zend_Auth']['USER_VALUES']['id_usuario'] , $date->toString("Y-MM-dd"));
			
			if ( $date->toString("e") != 6 ) {
				$date->addDay(1);
			}
			$i++;
		}while ($i<7);

		$this->view->agendaArray = $agendaArray;
		
		
	}
	
	public function generalAction(){
		$date = Zend_Date::now();
		
		$agendaArray = array();
		
		$i=0;
		do {
			
			if ( $date->toString("e") == 6 ) {
				$date->addDay(2);
			}
			
			$a = new Application_Model_DbTable_Agenda();
			$agendaArray[$date->toString("Y-MM-dd")] = $a->agendaGeneral($date->toString("Y-MM-dd"));

			if ( $date->toString("e") != 6 ) {
				$date->addDay(1);
			}
			
			$i++;
			
		}while ($i<7);
		
	//	echo "<pre>".print_r($agendaArray,true)."</pre>";
		
		$usuarios = array();
		$agendaTabla = array();
		
		foreach ( $agendaArray  as $key => $value ) {
			$agendaTabla[$key] = array();
			foreach ( $value as $key2 => $value2 ){
				$agendaTabla[$key][$value2['id_usuario_admin']][] = $value2;
				$usuarios[$value2['id_usuario_admin']] = $value2['nombre'].' ' . $value2['apellido_paterno'];
			}
		}
		
	//	echo "<pre>".print_r($agendaTabla,true)."</pre>";die;
		
		$this->view->usuarios= $usuarios;
		$this->view->agendaTabla= $agendaTabla;
		$this->view->agendaArray = $agendaArray;
		
	}
}
