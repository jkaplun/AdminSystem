<?php

class UsuariosAgenciaController extends Zend_Controller_Action
{

    private $usuario_agencia;

    public function init()
    {
        $this->usuario_agencia = new Application_Model_DbTable_UsuarioAgencia();
         
        /* Initialize action controller here */
    }

    public function indexAction()
    {
         
         $usuarioAgencia = new Application_Model_DbTable_UsuarioAgencia();
         $params=$this->_request->getParams();
         //$this->view->form = new Application_Form_UsuariosAgencia_UsuariosAgencia();
         $registros = $usuarioAgencia->obtenerUsuariosDeAgenciaPorIdAgencia($params['id_agencia']);
         $this->view->registros = $registros;

    }

    public function agregarAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams();
        $data = array(
                                'id_agencia' => $params['id_agencia'],
                                'clave' => $params['claveUsuarioAgencia'],
                                //'pwd'=>$params['pwd'],
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
                                //'nuevo' => $params['nuevo'],
                                //'actualizar_pass' => $params['actualizar_pass'],
                                'enviar_reporte_portal_mig' => $params['enviar_reporte_portal_mig'],
                                'bajar_updates' => $params['bajar_updates']
                        );
        
        $form = new Application_Form_UsuariosAgencia_UsuariosAgencia();
        
        $mensajesDeError = $form->getMessages();
        $cantidadDeErrores = count($mensajesDeError);
        if ($cantidadDeErrores == 0)
        {
				//$contraEncrip = sha1($params['pwd']);
                $usuario = $this->usuario_agencia->obtenerUsuariosAgenciaPorClave($params['claveUsuarioAgencia']);
                
                if (!$usuario)
                { // Â¿QuÃ© se verifica aquÃ­?
                    $utiles = new Application_Model_Services_Utiles();
                    $esEmailCorrecto = $utiles->comprobar_email($params['emailUsuarioAgencia']);
                    if($esEmailCorrecto)
                    { // si el emal es correcto:

                    	$dba_pwdEncoded = base64_encode($params['pwd']);
                    	$data['pwd']=$dba_pwdEncoded;
                        // se inserta en la base de datos al nuevo usuario
                        $nuevoUsuarioAgencia = $this->usuario_agencia->insert($data);
                        unset($data['pwd']);
                        $data['estado']='ok';
                        // se responde al cliente
                        $this->_helper->json($data);
                        $this->_redirect('agencias/');
                    }
                    else 
                    { // else cuando el email es incorrecto
  
                       // se inyecta el ID, estado y descripciÃ³n en la respuesta al cliente
                        $data['id_agencia']='0';
                        $data['clave']='';
                        $data['estado']='error';
                        $data['descripcion']='Email en formato incorrecto';
                         // se responde al cliente
                        $this->_helper->json($data);
                        $this->_redirect('agencias/');
                    }
                }
                else 
                { // else cuando ya existe una clave igual (??) 

                       // se inyecta el ID, estado y descripciÃ³n en la respuesta al cliente
                        $data['id_agencia']='0';
                        $data['clave']='';
                        $data['estado']='error';
                        $data['descripcion']='Ya existe una clave igual';
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
    
    public function actualizarAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams();
       	 //echo $params['id_agencia'];
            	
        $data = array(
                                'id_agencia' => $params['id_agencia'],
                                //'clave' => $params['claveUsuarioAgencia'], no se permite modificación
                                //'pwd' => $params['pwd'],
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
       		$usuarioActual = $this->usuario_agencia->obtenerUsuarioDeAgenciaPorId($params['id_agencia'],$params['claveUsuarioAgencia']);
        	
        	$mensajesDeError = $form->getMessages();
        	$cantidadDeErrores = count($mensajesDeError);
        	if ($cantidadDeErrores == 0)
        	{
        		/*$esContrasenaYConfValidos=false;
        		//Revisando si el usuario modificï¿½ la contraseï¿½a
        		if($params['pwd'] != $usuarioActual['pwd'])
        		{//Si el usuario la modificï¿½
        			if($params['pwd'] != $params['pwd_conf'])
        			{// else cuando las contraeÃ±as no coinciden
        				
        				// se inyecta el ID, estado y descripciÃ³n en la respuesta al cliente
        				$data['estado']='error';
        				$data['descripcion']='Passwords diferentes'.$usuarioActual['pwd'];
        				// se responde al cliente
        				$this->_helper->json($data);
        				$this->_redirect('agencias/');
        			}
        			else 
        			{
        				$contraEncrip = sha1($params['pwd']);
        				$data['pwd']=$contraEncrip;
        			}
        		}*/
        		$utiles = new Application_Model_Services_Utiles();
        		$esEmailCorrecto = $utiles->comprobar_email($params['emailUsuarioAgencia']);
        		if ($esEmailCorrecto)
        		{
        			/*if ($usuarioActual['clave'] != $params['claveUsuarioAgencia'])
        			{
	        				// Si se intenta modificar la clave
        					// se inyecta el ID, estado y descripciÃ³n en la respuesta al cliente
        					$data['estado']='error';
        					$data['descripcion']='No se permite modificar la clave';
        					// se responde al cliente
        					$this->_helper->json($data);
        					$this->_redirect('agencias/');
        			}
        			else
        			{ */
        				// 	se actualiza en la base de datos al usuario
                    	$dba_pwdEncoded = base64_encode($params['pwd']);
                    	$data['pwd']=$dba_pwdEncoded;
        				$where = "id_agencia = {$params['id_agencia']} and clave = '{$params['claveUsuarioAgencia']}'";
        				$this->usuario_agencia->update($data, $where);
	        			// 	se inyecta el estado y descripciÃ³n en la respuesta al cliente
        				$data['id_agencia']=$params['id_agencia'];
        				$data['clave']=$params['claveUsuarioAgencia'];
    	    			$data['estado']='ok';
        				$data['descripcion']='El usuario ha sido actualizado exitosamente';
        				// se responde al cliente
        				$this->_helper->json($data);
        				$this->_redirect('agencias/');
        			//}
        		}
        		else
        		{ // else cuando el email es incorrecto
        			// se inyecta el ID, estado y descripciÃ³n en la respuesta al cliente
        			//$data['id_usuario_agencia']='0';
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