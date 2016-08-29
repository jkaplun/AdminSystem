<?php

class ChartController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$this->view->activemenu=3;
    }

    public function indexAction()
    {
        // action body
    	$params=$this->_request->getParams();
    	//echo '<pre>'.print_r($params,true).'</pre>';die;
    	@$this->view->chart=$params['chart'];
    }

    public function ajaxAction(){
    	$params=$this->_request->getParams();
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    	if ($params['accion_ajax']=='grafica6'){
    		$registroPersonas = new Application_Model_DbTable_RegistroPersonas();
    		$values = $registroPersonas->getChart6();
    		echo json_encode($values);
    	}
    	
    	if ($params['accion_ajax']=='grafica7'){
    		$registroPersonas = new Application_Model_DbTable_RegistroPersonas();
    		$values = $registroPersonas->getChart7();
    		echo json_encode($values);
    	}
    }

}

