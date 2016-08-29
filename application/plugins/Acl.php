<?php

/**
 * Plugin Access control list
 * @author Ing. Juan Garfias
 * @version 1.0
 * Create Diciembre,23th 2015
 *
 */
class Plugin_Acl extends Zend_Controller_Plugin_Abstract {

public function preDispatch(Zend_Controller_Request_Abstract $request)
    {    

    	if (isset ( $_SESSION['Zend_Auth']['USER_VALUES'] )){	
    		$rol = $_SESSION['Zend_Auth']['USER_VALUES']['id_rol'];
    	} else {
    		$rol = '';
    	}
    	
    	$actionName=$request->getActionName();
    	$controllerName=$request->getControllerName();
    	 
    	/** Creating the ACL object */
    	$acl = new Zend_Acl();
    	
    	/** Creating Roles */
    	$acl->addRole(new Zend_Acl_Role('superadmin'))
    		->addRole(new Zend_Acl_Role('gerencial'))
	    	->addRole(new Zend_Acl_Role('operador'));
    	
    	// 		Resources
    	$acl->add(new Zend_Acl_Resource('index'));
    	$acl->add(new Zend_Acl_Resource('admin'));
    	$acl->add(new Zend_Acl_Resource('chart'));
    	
    		switch ($rol){
    			case '1':
    				$roleName = 'superadmin';
    				$acl->allow('superadmin', array('index','admin','chart'));
    				break;
    			case '2':
    				$roleName = 'gerencial';
    				$acl->allow('gerencial', array('index','chart'));
    				break;
    			case '3':
    				$roleName = 'operador';
    				$acl->allow('operador', array('index'));
    				$acl->deny('operador', array('chart'));
    				
    				break;
    			default:
    				$roleName = '';
    				break;
    		}
 		// if the resource exists in the ACL
		if ( $acl->has($controllerName, $actionName)==true ) {
			
			if($roleName=='') {   $r = new Zend_Controller_Action_Helper_Redirector;
    		$r->gotoUrl('/auth/login')->redirectAndExit();}
			
			$isAllowed = $acl->isAllowed($roleName, $controllerName, $actionName);	 
			
			if(!$isAllowed){							 
				$request->setControllerName("error");
				$request->setActionName("denied");
	 		}
		}  
	 				
	}	
}
