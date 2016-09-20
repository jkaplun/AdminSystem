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

    public function preEditarAction(){
    
    	$params=$this->_request->getParams();
    
    	$clientes = $this->usuario_admin->find($params['id_usuario'])->toArray();
    
    	$this->view->formulario = new Application_Form_Clientes_AgregarCliente();
    	$this->view->formulario->setAction('public/clientes/actualizar');
    
    	$this->view->formulario->populate($clientes[0]);
    }


}

