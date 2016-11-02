<?php

class OrdenMonitoreoController extends Zend_Controller_Action
{

    public function indexAction(){
        $this->_helper->layout->setLayout('layout_monitoreo');  
    	
        // $this->_helper->layout()->disableLayout();
    	// $this->_helper->viewRenderer->setNoRender();
    	$params=$this->_request->getParams();
    	
    	$ordenServicioDbTable = new Application_Model_DbTable_OrdenServicio();
		$ordenesBd = $ordenServicioDbTable->obtenerOrdenesMonitoreo();
		$ordenes = array();
		foreach ($ordenesBd as $orden)
		{

			$ordenes[$orden['id_usuario_admin_atiende']][$orden['id_orden_servicio']] = $orden;
		}
        // echo'<pre>';
        // print_r($ordenes);
        // echo'</pre>';
        // die;
        $this->view->ordenes = $ordenes;
    }
}

