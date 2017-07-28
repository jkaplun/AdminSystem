<?php

class UsuariosAgenciaController extends Zend_Controller_Action
{

    private $usuario_agencia;

    public function init()
    {
        $this->usuario_agencia = new Application_Model_DbTable_AgenciaUsuario();
         
        /* Initialize action controller here */
    }

    public function indexAction()
    {
         
         $usuarioAgencia = new Application_Model_DbTable_AgenciaUsuario();
         $params=$this->_request->getParams();
         //$this->view->form = new Application_Form_UsuariosAgencia_UsuariosAgencia();
         $registros = $usuarioAgencia->obtenerUsuariosDeAgenciaPorIdAgencia($params['id_agencia']);
         $this->view->registros = $registros;

    }
	public function agregarAction() {
		$this->_helper->layout ()->disableLayout ();
		$this->_helper->viewRenderer->setNoRender ();
		$params = $this->_request->getParams ();
		$data = array (
				'id_agencia' => $params ['edita_usr_age_id_agencia'],
				'cve_user' => $params ['cve_user_agencia'],
				'pwd' => $params ['pwd'],
				'nombre' => $params ['nombreUsuarioAgencia'],
				'apellidos' => $params ['apellidos'],
				'puesto' => $params ['puesto'],
				'telefono' => $params ['telefono'],
				'ext' => $params ['ext'],
				'celular' => $params ['celular'],
				'email' => $params ['emailUsuarioAgencia'],
				'activo' => $params ['activo'],
				'lider_proy' => $params ['lider_proy'],
				'director' => $params ['director'],
				'admin_fe' => $params ['admin_fe'],
				'enviar_reporte_portal_mig' => $params ['enviar_reporte_portal_mig'],
				'bajar_updates' => $params ['bajar_updates'] 
		);
		
		$form = new Application_Form_UsuariosAgencia_UsuariosAgencia ();
		
		$utiles = new Application_Model_Services_Utiles ();
		$esEmailCorrecto = $utiles->comprobar_email ( $params ['emailUsuarioAgencia'] );
		if ($esEmailCorrecto) { // si el emal es correcto:
		  
			try {
				$nuevoUsuarioAgencia = $this->usuario_agencia->insert ( $data );
				unset ( $data ['pwd'] );
				$data ['estado'] = 'ok';
				$this->_helper->json ( $data );
			} catch ( Exception $e ){
				unset ( $data ['pwd'] );
				$data ['estado'] = 'error';
				$data['descripcion'] = $e->getMessage();
				$this->_helper->json ( $data );
			}
			
		} else { // else cuando el email es incorrecto
			$data ['estado'] = 'error';
			$data ['descripcion'] = 'Email en formato incorrecto';
			// se responde al cliente
			$this->_helper->json ( $data );
		}
	}
    
    public function actualizarAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams();
       	 //echo $params['id_agencia'];
            	
 
        
        $data = array(
                                //'id_agencia' => $params['id_agencia'],
                                'cve_user' => $params['cve_user_agencia'],
                                'pwd' => $params['pwd'],
                                'nombre' => $params['nombreUsuarioAgencia'],
                                'apellidos' => $params['apellidos'],
                                'puesto' => $params['puesto'],
                                'telefono' => $params['telefono'],
                                'ext' => $params['ext'],
                                'celular' => $params['celular'],
                                'email' => $params['emailUsuarioAgencia'],
                                'activo' => $params['activo'],
                                'lider_proy' => $params['lider_proy'],
                                'director' => $params['director'],
                                'admin_fe' => $params['admin_fe'],
                                'enviar_reporte_portal_mig' => $params['enviar_reporte_portal_mig'],
                                'bajar_updates' => $params['bajar_updates']
                        );
        
        	$form = new Application_Form_UsuariosAgencia_UsuariosAgencia();
       		$usuarioActual = $this->usuario_agencia->obtenerUsuarioDeAgenciaPorId($params['edita_id_user']);
        	
        	$mensajesDeError = $form->getMessages();
        	$cantidadDeErrores = count($mensajesDeError);
        	if ($cantidadDeErrores == 0)
        	{
        		$utiles = new Application_Model_Services_Utiles();
        		
        		if ( trim($params['emailUsuarioAgencia']) == '') {
        			$esEmailCorrecto = true;
        		} else {
        			$esEmailCorrecto = $utiles->comprobar_email($params['emailUsuarioAgencia']);
        		}
        		
        		if ($esEmailCorrecto)
        		{
                    	//$dba_pwdEncoded = base64_encode($params['pwd']);
                    	//$data['pwd']=$dba_pwdEncoded;
        				$where = "id_usuario_agencia = '{$params['edita_id_user']}'";
        				$this->usuario_agencia->update($data, $where);
    	    			$data['estado']='ok';
        				$data['descripcion']='El usuario ha sido actualizado exitosamente';
        				// se responde al cliente
        				$this->_helper->json($data);

        		}
        		else
        		{ // else cuando el email es incorrecto
        			$data['estado']='error';
        			$data['descripcion']='Email en formato incorrecto';
        			// se responde al cliente
        			$this->_helper->json($data);
        			$this->_redirect('agencias/');
        		}
    	}
	    else
    	{ // else cuando existe un error encontrado en el form
       		$this->_helper->json($mensajesDeError);
       		$this->_redirect('agencias/');
    	}
    }
    
    public function jsonAction(){
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        $users = new Application_Model_DbTable_UsuarioAdmin();
        $registros = $users->getAllUsers(array());
        
        //echo '<pre>'.print_r($registros,true).'</pre>';

    }

    public function consultarAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams(); 
        $usuariosAgencia = $this->usuario_agencia->obtenerUsuariosDeAgenciaPorIdAgencia($params['id_agencia']);
       // $datosAgencia = $this->agencia->find($params['id_agencia'])->toArray();
       
        $this->_helper->json($usuariosAgencia);

    }

}