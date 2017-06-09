<?php
/**
 * 
 * @author jgarfias
 *
 */
class OrdenMonitoreoController extends Zend_Controller_Action{ 

    public function indexAction(){
    	$this->_helper->layout->setLayout('layout_monitoreo');  
    	$params=$this->_request->getParams();
    	$ordenServicioDbTable = new Application_Model_DbTable_OrdenServicio();
		$ordenesBd = $ordenServicioDbTable->obtenerOrdenesMonitoreo();
		$ordenes = array();

		foreach ($ordenesBd as $orden){
			$ordenes[$orden['id_usuario']][$orden['id_orden_servicio']] = $orden;
		}
		$ua = new Application_Model_DbTable_UsuarioAdmin();
		$usuariosAdmin = $ua->getSoporteUsers();
		$usuariosAdminNombres = array();
		foreach ( $usuariosAdmin as $value ){
			//$usuariosAdminAux[$value['id_usuario']] = array();
			if (isset($ordenes[$value['id_usuario']])){
				$usuariosAdminAux[$value['id_usuario']] = $ordenes[$value['id_usuario']];
			} else {
				$usuariosAdminAux[$value['id_usuario']] = array();
			}
			$usuariosAdminNombres[$value['id_usuario']] = $value['nombre'].' '.$value['apellido_paterno'].' '.$value['apellido_materno'];
		}
		$this->view->usuariosAdminNombres = $usuariosAdminNombres;
		$this->view->ordenes = $usuariosAdminAux;
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

