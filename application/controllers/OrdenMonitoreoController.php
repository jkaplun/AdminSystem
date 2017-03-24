<?php

class OrdenMonitoreoController extends Zend_Controller_Action
{

    public function indexAction(){
        $this->_helper->layout->setLayout('layout_monitoreo');  
    	$params=$this->_request->getParams();
    	
    	$ordenServicioDbTable = new Application_Model_DbTable_OrdenServicio();
		$ordenesBd = $ordenServicioDbTable->obtenerOrdenesMonitoreo();
		$ordenes = array();
		$ordenAMostrar;
		
		foreach ($ordenesBd as $orden){
			$ordenes[$orden['id_usuario']][$orden['id_orden_servicio']] = $orden;
		}
		
		//echo "<pre>".print_r($ordenes,true)."</pre>";die;
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

