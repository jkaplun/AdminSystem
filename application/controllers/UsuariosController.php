<?php

class UsuariosController extends Zend_Controller_Action
{

    private $usuario_admin;
    public function init()
    {
        $this->usuario_admin = new Application_Model_DbTable_UsuarioAdmin();
         
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

    public function agregarAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $params=$this->_request->getParams();
        
        
        $form = new Application_Form_Usuarios_Usuarios();
        
        $mensajesDeError = $form->getMessages();
        $cantidadDeErrores = count($mensajesDeError);
        echo($params['puesto']);
        if ($cantidadDeErrores == 0)
        {
            if ($params['pwd'] == $params['pwd_conf'])
            {
                $usuarios = $this->usuario_admin->obtenerUsuarioPorClave($params['clave']);
                if (count($usuarios) == 0)
                {
                    $utiles = new Application_Model_Services_Utiles();
                    $esEmailCorrecto = $utiles->comprobar_email($params['email']);
                    if($esEmailCorrecto)
                    {
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
                        $idNuevoUsuario = $this->usuario_admin->insert($data);
                        $response = array(
                                'id' => $idNuevoUsuario,
                                'estado' => 'guardado', // error - success
                                'description' => 'El usuario ha sido guardado'
                        );
                        $this->_helper->json($response);
                        $this->_redirect('usuarios/');
                    }
                    else 
                    {
                        $response = array(
                                'id' => '0',
                                'estado' => 'error', // error - success
                                'description' => 'Email en formato incorrecto'
                        );
                        $this->_helper->json($response);
                        $this->_redirect('usuarios/');
                    }
                }
                else 
                {
                    $response = array(
                            'id' => '0',
                            'estado' => 'error', // error - success
                            'description' => 'Ya existe una clave igual',
                    );
                    $this->_helper->json($response);
                    $this->_redirect('usuarios/');
                }
            }
            else 
            {
                $response = array(
                        'id' => '0',
                        'estado' => 'error', // error - success
                        'description' => 'Passwords diferentes'
                );
                $this->_helper->json($response);
                $this->_redirect('usuarios/');
            }
        }
        else 
        {
            $this->_helper->json($mensajesDeError);
            $this->_redirect('usuarios/');
        }
    }
    
    public function actualizarAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
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
    
        $where = "id_usuario = {$params['id_usuario']}";
    
        $this->usuario_admin->update($data, $where);
    
        $this->_redirect('usuarios/');
    }
    
    public function jsonAction(){
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        $users = new Application_Model_DbTable_UsuarioAdmin();
        $registros = $users->getAllUsers(array());
        
        //echo '<pre>'.print_r($registros,true).'</pre>';

    }

}