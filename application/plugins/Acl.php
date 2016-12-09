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
    	$roleName = '';
    	if(isset( $_SESSION['Zend_Auth'])){
    		$roleName = 'usuario';
    	}
    	$actionName=$request->getActionName();
    	$controllerName=$request->getControllerName();
    	//echo $controllerName;die;
    	/** Creating the ACL object */
    	$acl = new Zend_Acl();
    	
    	/** Creating Roles */
    	$acl->addRole(new Zend_Acl_Role('usuario'));
    	
    	// 		Resources
    	$acl->add(new Zend_Acl_Resource('admin'));
    	$acl->add(new Zend_Acl_Resource('agencias'));
    	$acl->add(new Zend_Acl_Resource('index'));
    	$acl->add(new Zend_Acl_Resource('orden-admin'));
    	$acl->add(new Zend_Acl_Resource('orden-creacion'));
        $acl->add(new Zend_Acl_Resource('orden-seguimiento-admin'));
        $acl->add(new Zend_Acl_Resource('orden-seguimiento'));
        $acl->add(new Zend_Acl_Resource('polizas'));
        $acl->add(new Zend_Acl_Resource('productos'));
        $acl->add(new Zend_Acl_Resource('reporte-agencias'));
        $acl->add(new Zend_Acl_Resource('reporte-servicios'));
        $acl->add(new Zend_Acl_Resource('usuarios-agencias'));
        $acl->add(new Zend_Acl_Resource('usuarios'));
        
        
    	
        if ( $roleName != '') {
        	
	    	$acl->allow('usuario', array(
				'admin',
				'agencias',
				'index',
				'orden-admin',
				'orden-creacion',
				'orden-seguimiento-admin',
				'orden-seguimiento',
				'polizas',
				'productos',
				'reporte-agencias',
				'reporte-servicios',
				'usuarios-agencias',
				'usuarios'
	    	));
        	
        	 
	    	if ( $_SESSION['Zend_Auth']['USER_VALUES']['p_admin'] == 'S'){
	    		//$acl->allow('usuario', array('usuarios','ordenes','clientes'));
	    		//$acl->deny('usuario', array('clientes'));
	    	}	
	    	
	    	if ( $_SESSION['Zend_Auth']['USER_VALUES']['p_supervisor'] == 'S'){
	    		//$acl->allow('usuario', array('reportes'));
	    	}
	    	
	    	if ( $_SESSION['Zend_Auth']['USER_VALUES']['p_agrega_folios'] == 'S'){
	    		//$acl->allow('usuario', array('folios'));
	    	}
	    	
	    	if ( $_SESSION['Zend_Auth']['USER_VALUES']['p_ejecutivo'] == 'S'){
	    		//$acl->allow('usuario', array('compila'));
	    	}
	    	
	    	if ( $_SESSION['Zend_Auth']['USER_VALUES']['p_edita_poliza'] == 'S'){
	    		//$acl->allow('usuario', array('compila'));
	    	}
	    	
	    	if ( $_SESSION['Zend_Auth']['USER_VALUES']['p_recepcionista'] == 'S'){
	    		//$acl->allow('usuario', array('compila'));
	    	}
        }

        
 		// if the resource exists in the ACL
		if ( $acl->has($controllerName, $actionName)==true ) {
			if($roleName=='') { 
				$r = new Zend_Controller_Action_Helper_Redirector;
				$r->gotoUrl('/auth/login')->redirectAndExit();
			}
			
			$isAllowed = $acl->isAllowed($roleName, $controllerName, $actionName);	 
			
			if(!$isAllowed){							 
				$request->setControllerName("error");
				$request->setActionName("denied");
	 		}
		}  
	 				
	}	
}
