<?php

class AdminController extends Zend_Controller_Action
{

    public function init()
    {
    	$this->view->activemenu=4;
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    	$this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/admin/index.js');
    	$users = new Application_Model_DbTable_Users();
    	$params=$this->_request->getParams();

    	if( $this->_request->isPost() ){
    		//echo '<pre>'.print_r($params,true).'</pre>';die;
    		$users = new Application_Model_DbTable_Users();
    		
    		if ( $params['accion'] == 'editar' ){
	    		$data = array(
	    				'realname' => trim($params['edita_nombre_real']),
	    				'activo' => $params['edita_activo'],
	    				'id_rol' => $params['edita_rol']
	    		);
	    		
	    		if ($params['edita_password'] != '' && $params['edita_password']==$params['edita_passwordConfirm']){
	    			$data['password'] = sha1(trim($params['edita_password']));
	    		}
	
	    		$where = "id_user = ".$params['edita_id_user'];
	    		
	    		$users->update($data, $where);
    		
    		}
    		
    		if ( $params['accion'] == 'agregar' ){
    			
    			$data = array(
    					'username' => trim($params['username']),
    					'realname' => trim($params['nombre_real']),
    					'activo' => 1,
    					'id_rol' => $params['rol'],
    					'password' => sha1(trim($params['password']))
    			);
    			//echo '<pre>'.print_r($data,true).'</pre>';die;
    			$users->insert($data);
    		}
    		
    	}
    	
    	unset($params['controller']);
    	unset($params['action']);
    	unset($params['module']);
    	$registros = $users->getAllUsers($params);
    	 
    	//$this->view->registros = $registros;
    	$this->view->countArray= count($registros);
    	
    	// Get a Paginator object using Zend_Paginator's built-in factory.
    	$page = $this->_request->getParam('page', 0);
    	//$page = 0;
    	$paginator = Zend_Paginator::factory($registros);
    	$paginator->setCurrentPageNumber($page)
    	->setItemCountPerPage(10)
    	->setPageRange(10);
    	//Zend_Paginator::setCache($cache);
    	$paginator->setCacheEnabled(true);
    	// Assign paginator to view
    	Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination_sm.phtml');
    	$this->view->paginator=$paginator;
    }


}

