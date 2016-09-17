<?php

class ClientesController extends Zend_Controller_Action
{


	private $clientes;
	 
    public function init()
    {
    	//$this->clientes = new Application_Model_DbTable_Clientes();
        /* Initialize action controller here */
    	$this->_helper->layout->setLayout('layout');
    }

    public function indexAction(){

    //	$a = 7;
    //	$b = 1.3;
    	
    //	$this->view->resultado = array( "resultado" => ($a + $b) ,
    //			'nombre' => 'Juan',
    //			'appellido' => 'Garfias',
    //			'clientes' => array( 'MIG' => array('RFC' => 'MIG2345234sad', 'direccion' => 'calle cerrada') ,
    //								 'FORD' => array('RFC'=> 'ABCDESFSA'), 
    //								 'Microsoft' => array('RFC'=> 'POIPOIIOP')
    //			)
    //	);

    //	$this->view->clientes = $this->clientes->getClientes();
    	
    //	$this->view->formulario = new Application_Form_Clientes_AgregarCliente();

    }
    
    public function agregarAction(){
    	$params=$this->_request->getParams();

        $data = array(
            'rfc' => $params['rfc'],
            'nombre' => $params['nombre']
            );
        $this->clientes->insert($data);

    	$this->_redirect('clientes/');
    	
    }
    
    public function eliminarAction(){
        $params=$this->_request->getParams();

        $where = "idclientes = {$params['idclientes']}";

        $this->clientes->delete($where);

        $this->_redirect('clientes/');
        
    }
    
    public function actualizarAction(){
        $params=$this->_request->getParams();

        $data = array(
            'rfc' => $params['rfc'],
            'nombre' => $params['nombre']
            );

        $where = "idclientes = {$params['idclientes']}";

        $this->clientes->update($data, $where);

        $this->_redirect('clientes/');
    }

    public function preEditarAction(){

        $params=$this->_request->getParams();

        $clientes = $this->clientes->find($params['idclientes'])->toArray();

        $this->view->formulario = new Application_Form_Clientes_AgregarCliente();
        $this->view->formulario->setAction('public/clientes/actualizar');

        $this->view->formulario->populate($clientes[0]);


    }


    
    
    
}
