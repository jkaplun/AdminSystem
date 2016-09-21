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

    	 $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/usuarios/index.js');
    	 $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables/js/jquery.dataTables.min.js');
    	 $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-plugins/dataTables.bootstrap.min.js');
    	 $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-responsive/dataTables.responsive.js');
    	 
    	 $users = new Application_Model_DbTable_UsuarioAdmin();
    	 $params=$this->_request->getParams();
    	 $this->view->form = new Application_Form_Usuarios_Usuarios();
    	 
    	 
    	 
    	 if( $this->_request->isPost() ){
    	 	echo '<pre>'.print_r($params,true).'</pre>';die;    		
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
	     				'nombre' => trim($params['edita_nombre']),
                        'apellido_paterno' => trim($params['edita_apellido_paterno']),
                        'apellido_materno' => trim($params['edita_apellido_materno']),
	     				'activo' => $params['edita_activo'],
                        'puesto' => $params['edita_puesto'],
                        'email' => $params['edita_email']
	     		);
    	 		echo '<pre>'.print_r($data,true).'</pre>';die;
    	 		$users->insert($data);
    	 	}
    		
    	 }
    	
    	 $registros = $users->getAllUsers($params);
    	 
    	 $this->view->registros = $registros;

    }


}

