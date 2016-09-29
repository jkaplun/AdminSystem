<?php

class UsuariosAgenciaController extends Zend_Controller_Action
{

    private $usuario_agencia;
    public function init()
    {
        $this->$usuario_agencia = new Application_Model_DbTable_UsuarioAgencia();
         
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/sweetalert.min.js');
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/js/usuarios/index.js');
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables/js/jquery.dataTables.min.js');
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-plugins/dataTables.bootstrap.min.js');
         $this->view->InlineScript()->appendFile($this->view->baseUrl().'/css_complete/datatables-responsive/dataTables.responsive.js');
         
         $usuarioAgencia = new Application_Model_DbTable_UsuarioAgencia();
         $params=$this->_request->getParams();
         $this->view->form = new Application_Form_UsuariosAgencia_UsuariosAgencia();
         $registros = $usuarioAgencia->obtenerUsuariosDeAgenciaPorIdAgencia($params);
         $this->view->registros = $registros;

    }

    public function agregarAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams();
        $data = array(
                                'clave' => $params['clave'],
                                //'pwd' => $contraEncrip, se define más abajo
                                'nombre' => $params['nombre'],
                                'apellido_paterno' => $params['apellido_paterno'],
                                'apellido_materno' => $params['apellido_materno'],
                                'puesto' => $params['puesto'],
                                'email' => $params['email'],
                                'activo' => $params['activo'],
                                'lider_proy' => $params['lider_proy'],
                                'director' => $params['director'],
                                'admin_fe' => $params['admin_fe'],
                                'nuevo_user' => $params['nuevo_user'],
                                'actualizar_pass' => $params['actualizar_pass'],
                                'enviar_reporte_mig' => $params['enviar_reporte_mig'],
                                'bajar_updates' => $params['bajar_updates'],
                                'telefono' => $params['telefono'],
                                'extension' => $params['extension'],
                                'celular' => $params['celular']
                        );
        
        $form = new Application_Form_UsuariosAgencia_UsuariosAgencia();
        
        $mensajesDeError = $form->getMessages();
        $cantidadDeErrores = count($mensajesDeError);
        if ($cantidadDeErrores == 0)
        {
            if ($params['pwd'] == $params['pwd_conf'])
            { // ¿Qué se verifica aquí?
				$contraEncrip = sha1($params['pwd']);
                $usuario = $this->usuario_agencia->obtenerUsuariosAgenciaPorClave($params['clave']);
                $data['pwd']=$contraEncrip;
                if (!$usuario)
                { // ¿Qué se verifica aquí?
                    $utiles = new Application_Model_Services_Utiles();
                    $esEmailCorrecto = $utiles->comprobar_email($params['email']);
                    if($esEmailCorrecto)
                    { // si el emal es correcto:
                        unset($data['pwd']);
                        // se inserta en la base de datos al nuevo usuario
                        $idNuevoUsuario = $this->usuario_agencia->insert($data);
                        // se inyecta el ID, estado y descripción en la respuesta al cliente
                        $data['id_usuario_agencia']=$idNuevoUsuario;
                        $data['estado']='ok';
                        //$data['descripcion']='El usuario ha sido guardado exitosamente';
                        // se responde al cliente
                        $this->_helper->json($data);
                        $this->_redirect('agencias/');
                    }
                    else 
                    { // else cuando el email es incorrecto
  
                       // se inyecta el ID, estado y descripción en la respuesta al cliente
                        $data['id_usuario_agencia']='0';
                        $data['estado']='error';
                        $data['descripcion']='Email en formato incorrecto';
                         // se responde al cliente
                        $this->_helper->json($data);
                        $this->_redirect('agencias/');
                    }
                }
                else 
                { // else cuando ya existe una clave igual (??) 

                       // se inyecta el ID, estado y descripción en la respuesta al cliente
                        $data['id_usuario_agencia']='0';
                        $data['estado']='error';
                        $data['descripcion']='Ya existe una clave igual';
                        // se responde al cliente
                        $this->_helper->json($data);
                        $this->_redirect('agencias/');
                }
            }
            else 
            { // else cuando las contraeñas no coinciden

                     // se inyecta el ID, estado y descripción en la respuesta al cliente
                        $data['id_usuario_agencia']='0';
                        $data['estado']='error';
                        $data['descripcion']='Passwords diferentes';
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
       	 //echo $params['id_usuario_agencia'];
    
        	
        $data = array(
                        'clave' => $params['clave'],
                        //'pwd' => $contraEncrip, se define más abajo
                        'nombre' => $params['nombre'],
                        'apellido_paterno' => $params['apellido_paterno'],
                        'apellido_materno' => $params['apellido_materno'],
                        'puesto' => $params['puesto'],
                        'email' => $params['email'],
                        'activo' => $params['activo'],
                        'lider_proy' => $params['lider_proy'],
                        'director' => $params['director'],
                        'admin_fe' => $params['admin_fe'],
                        'nuevo_user' => $params['nuevo_user'],
                        'actualizar_pass' => $params['actualizar_pass'],
                        'enviar_reporte_mig' => $params['enviar_reporte_mig'],
                        'bajar_updates' => $params['bajar_updates'],
                        'telefono' => $params['telefono'],
                        'extension' => $params['extension'],
                        'celular' => $params['celular']
                       );
        
        	$form = new Application_Form_UsuariosAgencia_UsuariosAgencia();
       		$usuarioActual = $this->usuario_agencia->obtenerUsuarioAgenciaPorId($params['id_usuario_agencia']);
        	
        	$mensajesDeError = $form->getMessages();
        	$cantidadDeErrores = count($mensajesDeError);
        	if ($cantidadDeErrores == 0)
        	{
        		if ($params['pwd'] == $params['pwd_conf'])
        		{ // ¿Qué se verifica aquí?
        			$contraEncrip = sha1($params['pwd']);
        			$data['pwd']=$contraEncrip;
        			$utiles = new Application_Model_Services_Utiles();
        			$esEmailCorrecto = $utiles->comprobar_email($params['email']);
        			if ($esEmailCorrecto)
        			{
        				if ($usuarioActual['clave'] != $params['clave'])
        				{
        					$usuario = $this->usuario_agencia->obtenerUsuarioPorClave($params['clave']);
        					if (!$usuario)
        					{ // Si se intenta modificaar la clave

        						// se inyecta el ID, estado y descripción en la respuesta al cliente
        						//$data['id_usuario_agencia']=$params['id_usuario_agencia'];
        						$data['estado']='error';
        						$data['descripcion']='No se permite modificar la clave';
        						// se responde al cliente
        						$this->_helper->json($data);
        						$this->_redirect('agencias/');
        						
        					}
        					else
        					{ // si la clave no se modifica
        						$where = "id_usuario_agencia = {$params['id_usuario_agencia']}";
        						// 	se actualiza en la base de datos al usuario
        						$this->usuario_agencia->update($data, $where);
        						// se inyecta el estado y descripción en la respuesta al cliente
        						$data['estado']='ok';
        						//$data['descripcion']='El usuario ha sido actualizado exitosamente';
        						// se responde al cliente
        						$this->_helper->json($data);
        						$this->_redirect('agencias/');
        					}
        			}
        			else
        			{ 
        				// 	se actualiza en la base de datos al usuario
        				$where = "id_usuario_agencia = {$params['id_usuario_agencia_agencia']}";
        				$this->usuario_agencia->update($data, $where);
        				// se inyecta el estado y descripción en la respuesta al cliente
        				$data['estado']='ok';
        				$data['descripcion']='El usuario ha sido actualizado exitosamente';
        				// se responde al cliente
        				$this->_helper->json($data);
        				$this->_redirect('agencias/');
        			}
        		}
        		else
        		{ // else cuando el email es incorrecto
        			// se inyecta el ID, estado y descripción en la respuesta al cliente
        			//$data['id_usuario_agencia']='0';
        			$data['estado']='error';
        			$data['descripcion']='Email en formato incorrecto';
        			// se responde al cliente
        			$this->_helper->json($data);
        			$this->_redirect('agencias/');
        		}
        	}
        	else
        	{ // else cuando las contraeñas no coinciden
        			// se inyecta el ID, estado y descripción en la respuesta al cliente
        			//$data['id_usuario_agencia']='0';
        			$data['estado']='error';
        			$data['descripcion']='Passwords diferentes';
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

}