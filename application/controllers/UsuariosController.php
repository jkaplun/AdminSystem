<?php

class UsuariosController extends Zend_Controller_Action
{

    public function init()
    {
    	//$this->view->activemenu=4;
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        //action body
        $mensaje = 'mensaje de prueba';
        $this->view->mensaje=$mensaje;
    }
    
    public function agregarAction(){
    	$params=$this->_request->getParams();

        $data = array(
            'clave' => $params['clave'],
            'pwd' => $params['pwd'],
            'nombre' => $params['nombre'],
            'apellido_paterno' => $params['apellido_paterno'],
            'apellido_materno' => $params['apellido_materno'],
            'puesto' => $params['puesto'],
            'email' => $params['email'],
            'admin' => $params['admin'],
            'supervisor' => $params['supervisor'],
            'folios' => $params['folios'],
            'compila' => $params['compila'],
            'activo' => $params['activo']
            );
        $this->usuario_admin->insert($data);

    	$this->_redirect('usuarios/');
    }
    
    public function actualizarAction(){
        $params=$this->_request->getParams();
    	 $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/admin/index.js');
    	 $users = new Application_Model_DbTable_UsuarioAdmin();
    	 $params=$this->_request->getParams();

    	 if( $this->_request->isPost() ){
    	 	echo '<pre>'.print_r($params,true).'</pre>';die;
    	 	$users = new Application_Model_DbTable_UsuarioAdmin();
    		
    	 	if ( $params['accion'] == 'editar' ){
	     		$data = array(
	     				'nombre' => trim($params['edita_nombre']),
                        'apellido_paterno' => trim($params['edita_apellido_paterno']),
                        'apellido_materno' => trim($params['edita_apellido_materno']),
	     				'activo' => $params['edita_activo'],
                        'puesto' => $params['edita_puesto'],
                        'email' => $params['edita_email']
	     		);
	    		
	     		if ($params['edita_password'] != '' && $params['edita_password']==$params['edita_passwordConfirm']){
	     			$data['password'] = sha1(trim($params['edita_password']));
	     		}
	
	     		$where = "id_usuario = ".$params['edita_id_user'];
	    		
	     		$users->update($data, $where);
    		
    	 	}
    		
    	 	if ( $params['accion'] == 'agregar' ){
    			
    	 		$data = array(
    	 				'clave' => trim($params['clave']),
    	 				'realname' => trim($params['nombre_real']),
    	 				'activo' => 1,
    	 				'id_rol' => $params['rol'],
    	 				'password' => sha1(trim($params['password']))
    	 		);
    	 		echo '<pre>'.print_r($data,true).'</pre>';die;
    	 		$users->insert($data);
    	 	}
    		
    	 }
    	
    	 unset($params['controller']);
    	 unset($params['action']);
    	 unset($params['module']);
    	 $registros = $users->getAllUsers($params);
    	 
    	 $this->view->registros = $registros;
    	 $this->view->countArray= count($registros);
    	
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

