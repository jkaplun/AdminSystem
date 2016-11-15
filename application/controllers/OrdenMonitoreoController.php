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
		$ordenAMostrar;
		foreach ($ordenesBd as $orden)
		{
			if($orden['concluido'] == 'S')
				$ordenAMostrar = $this->reiniciaOrden($orden);
			else
				$ordenAMostrar = $orden;
			$ordenes[$ordenAMostrar['id_usuario']][$ordenAMostrar['id_orden_servicio']] = $ordenAMostrar;
		}
        /*echo'<pre>';
        print_r($ordenes);
        die;*/
        /*echo'</pre>';
        die;*/
        $this->view->ordenes = $ordenes;
    }
    
    private function reiniciaOrden($orden)
    {
    	$orden['id_orden_servicio']=null;
    	$orden['id_agencia']=null;
    	$orden['id_usuario_admin_atiende']=null;
    	$orden['id_usuario_agencia_solicito']=null;
    	$orden['fecha_alta']=null;
    	$orden['id_orden_servicio_estatus']=null;
    	$orden['nombre_usuario']=null;
    	$orden['apellidos_usuario']=null;
    	$orden['puesto']=null;
    	$orden['nombre_agencia']=null;
    	$orden['concluido']=null;
    	
    	return $orden;
    }
}

