<?php

class OrdenSeguimientoController extends Zend_Controller_Action
{

    public function indexAction(){


    }

    public function monitoreoordenAction()
    {    
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    	$params=$this->_request->getParams();
    	
    	$ordenServicioDbTable = new Application_Model_DbTable_OrdenServicio();
		$ordenesBd = $ordenServicioDbTable->obtenerOrdenesMonitoreo($idProducto, $idAgencia);
		$ordenes = array();
		foreach ($ordenesBd as $orden)
		{
			$ordenes[$orden['id_usuario_admin_atiende']] = $orden;
		}
		$this->_helper->json($ordenes);
        $this->_helper->layout->setLayout('layout_monitoreo');  
    }
}

