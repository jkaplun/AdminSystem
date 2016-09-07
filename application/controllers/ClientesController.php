<?php

class ClientesController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction(){
    	
    	$a = 7;
    	$b = 1.3;
    	
    	$this->view->resultado = array( "resultado" => ($a + $b) ,
    			'nombre' => 'Juan',
    			'appellido' => 'Garfias',
    			'clientes' => array( 'MIG' => array('RFC' => 'MIG2345234sad', 'direccion' => 'calle cerrada') ,
    								 'FORD' => array('RFC'=> 'ABCDESFSA'), 
    								 'Microsoft' => array('RFC'=> 'POIPOIIOP')
    			)
    	);
    	//echo "<pre>".print_r($this->view->resultado,true)."</pre>";
 
    	$clientes = new Application_Model_DbTable_Clientes();
    	
    	$this->view->clientes = $clientes->getClientes();
    	
    	
    	
    	
    	
    	
    	
    	
    	//echo "<pre>".print_r($resultado,true)."</pre>";
    	//die;
    	//die("entra");
    }
}
