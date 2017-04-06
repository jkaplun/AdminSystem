<?php

class ActualizacionesController extends Zend_Controller_Action
{

    public function init(){
    	
    }

    public function indexAction(){
    	
    	$params=$this->_request->getParams();
    	
    	$form = new Application_Form_Actualizaciones_Actualizacion();
    	
    	$form->removeElement("titulo_update");
    	$form->removeElement("version_update");
    	$form->removeElement("http_update");
    	$form->removeElement("path_update");
    	$form->removeElement("archivo_update");
    	$form->removeElement("Cerrar");
    	
    	if( $this->_request->isPost() ){
    		
    		if ($form->isValid($params)) {
    			$a = new Application_Model_DbTable_Actualizaciones();
    			
    			$data = array(
    					'id_producto' => $params['id_producto'],
    					'id_agencia' => $params['id_agencia'],
    					'descripcion' => $params['descripcion'],
    					"id_usuario_solicita" => $_SESSION['Zend_Auth']['USER_VALUES']['id_usuario'],
    					'fecha_solicitud' => date("Y-m-d H:i:s")
    			);
    			
    			$a->insert($data);
    			
    			$this->redirect('actualizaciones/success');
    			
    		} else {
    			$form->populate($params);
    		}
    		
    	}
    	
    	$this->view->formActualizacion = $form;
    	
    }
    
    public function registrarAction(){
    	
    	$params=$this->_request->getParams();

    	$form = new Application_Form_Actualizaciones_Actualizacion();
    	$form->removeElement("Guardar");
    	
    	
    	if( $this->_request->isPost() ){
    		
    		if ($form->isValid($params)) {
    			$a = new Application_Model_DbTable_Actualizaciones();
    			
    			$data = array(
    					'id_producto' => $params['id_producto'],
    					'id_agencia' => $params['id_agencia'],
    					"id_usuario_solicita" => $_SESSION['Zend_Auth']['USER_VALUES']['id_usuario'],
    					'fecha_solicitud' => date("Y-m-d H:i:s"),
    					'titulo_update' => $params['titulo_update'],
    					'version_update' => $params['version_update'],
    					'http_update' => $params['http_update'],
    					'path_update' => $params['path_update'],
    					'archivo_update' => $params['archivo_update'],
    					'descripcion' => $params['descripcion'],
    					'id_usuario_cierra' => $params['id_usuario_cierra'],
    					'fecha_cierre' => date("Y-m-d H:i:s"),
    					"id_usuario_cierra" => $_SESSION['Zend_Auth']['USER_VALUES']['id_usuario'],
    			);
    			
    			$a->insert($data);
    			
    			$this->redirect('actualizaciones/success');
    			
    		} else {
    			$form->populate($params);
    		}
    		
    		
    	}
    	
    	$this->view->formActualizacion = $form;
    	$this->view->formActualizacion = $form;

    }
    
    public function seguimientoAction(){
    	$a = new Application_Model_DbTable_Actualizaciones();
    	
    	$where = 'fecha_cierre is null';
    	$this->view->actualizacionesPendientes = $a->actualizacionesPendientes();
    	
    }
    
    public function editarAction(){
    	
    	$params=$this->_request->getParams();
    	
    	$form = new Application_Form_Actualizaciones_Actualizacion();
    	$a = new Application_Model_DbTable_Actualizaciones();
    	
    	$form->removeElement("Guardar");
    	
    	$actualizacion = $a->find($params['id_update'])->toArray()[0];
    	
    	$form->populate($actualizacion);
    	
    	if( $this->_request->isPost() ){
    		
    		if ($form->isValid($params)) {
    			
    			$data = array(
    					'id_producto' => $params['id_producto'],
    					'id_agencia' => $params['id_agencia'],
    					"id_usuario_solicita" => $_SESSION['Zend_Auth']['USER_VALUES']['id_usuario'],
    					'fecha_solicitud' => date("Y-m-d H:i:s"),
    					'titulo_update' => $params['titulo_update'],
    					'version_update' => $params['version_update'],
    					'http_update' => $params['http_update'],
    					'path_update' => $params['path_update'],
    					'archivo_update' => $params['archivo_update'],
    					'descripcion' => $params['descripcion'],
    					'id_usuario_cierra' => $params['id_usuario_cierra'],
    					'fecha_cierre' => date("Y-m-d H:i:s"),
    					"id_usuario_cierra" => $_SESSION['Zend_Auth']['USER_VALUES']['id_usuario'],
    			);
    			
    			$where = 'id_update='.$params['id_update'];
    					
    			$a->update($data,$where);
    			
    			$this->redirect('actualizaciones/success');
    			
    		} else {
    			$form->populate($params);
    		}
    		
    		
    	}
    	
    	$this->view->formActualizacion = $form;
    }
    
    public function historicoAction(){
    	$params=$this->_request->getParams();
    	
    	$a = new Application_Model_DbTable_Actualizaciones();
    	
    	$where = 'fecha_cierre is null';
    	$this->view->actualizacionesPendientes = $a->actualizacionesTodas($params);
    	//echo "<pre>".print_r($this->view->actualizacionesPendientes,true)."</pre>";die;
    	
    	
    	
    	
    	
    	
    }
    
    public function successAction(){
    	
    }
}