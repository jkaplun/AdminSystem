<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	protected function _initDoctype(){
	
		$this->bootstrap('view');
		$view = $this->getResource('view');
		$view->doctype('HTML5');
		 
		$this->view->setEncoding ( "UTF-8" );
		$this->view->headMeta ()->appendHttpEquiv ( 'Content-Type', 'text/html; charset=UTF-8' );
	
	}
	
	protected function _initView()
	{
		// Initialize view
		$view = new Zend_View();
		$view->doctype('XHTML1_STRICT');
		$view->headTitle('MIG');
	
		// Add it to the ViewRenderer
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
				'ViewRenderer'
				);
		$viewRenderer->setView($view);
	
		// Return it, so that it can be stored by the bootstrap
		return $view;
	}
	
	protected function _initAutoload() {
		$moduleLoader = new Zend_Application_Module_Autoloader (
				array ('namespace' => '',
						'basePath' => APPLICATION_PATH
				)
				);
	
		$this->bootstrap('FrontController');
		$front =  $this->getResource('FrontController');
		$front->registerPlugin(new Plugin_Acl() );
	
		return $moduleLoader;
	}
	
	protected function _initMyDb() {
		$this->bootstrap('db');
		$resource = $this->getPluginResource('db');
		$db = $resource->getDbAdapter();
		$db->query('SET CHARACTER SET \'UTF8\'');
	}
	
	/**
	 * Initializing session
	 */
	protected function _initSession() {
		
		// server should keep session data for AT LEAST 10 hour
		ini_set('session.gc_maxlifetime', 36000);
		
		// each client should remember their session id for EXACTLY 10 hour
		session_set_cookie_params(36000);
		
		Zend_Session::start();
		
		Zend_Registry::set('Zend_Locale', 'es');
		
// 		// Instance namespace Zend_Auth
// 		$authNamespace = new Zend_Session_Namespace('Zend_Auth');
	
// 		// Timeout is 30 minutes (1800 seconds)
// 		$authNamespace->timeout = time() + 1800000;
		
// 		// clear the identity of a user who has not accessed a controller for
// 		// longer than a timeout period.
// 		if(isset($authNamespace->timeout) && time() > $authNamespace->timeout){
// 			$storage = new Zend_Auth_Storage_Session();
// 			$storage->clear();
// 			$this->bootstrap('view');
// 			$this->view = $this->getResource('view');
// 			$this->view->errorMessageTimeout = "<strong>" . $this->view->translate('Alert') .":</strong>" . $this->view->translate('Su Sesi&oacute;n ha caducado por inactividad en el sistema');
	
// 		}
		if(isset($_SESSION['Zend_Auth']['USER_VALUES'])){

			$userDetails= new Application_Model_DbTable_UsuarioAdmin();
			$_SESSION['Zend_Auth']['USER_VALUES'] = $userDetails->getUserValuesById(
				array(
						'id_usuario'=>$_SESSION['Zend_Auth']['USER_VALUES']['id_usuario'])
				);
				
		}
	}
	

}

