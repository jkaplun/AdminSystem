<?php
/**
 * 
 * @author Juan Garfias
 * Clase de Orden de Servicio.
 *
 */
class Application_Model_DbTable_OrdenServicio extends Zend_Db_Table_Abstract
{

	protected $_name = 'orden_servicio';

	
	public function obtenerOrdenes($valores){
		
		$select = $this->_db->select()->
		from ( "view_orden_servicio", '*' );
		
		//echo $select;
		//die;
		return $this->getAdapter ()->fetchAll( $select );
	}
	
	public function obtenerOrdenesMonitoreo()
	{
		$select = $this->_db->select()->
		from ( $this->_name, 'id_orden_servicio, id_agencia, 
				id_usuario_admin_atiende, id_usuario_agencia_solicito, 
				fecha_alta, id_orden_servicio_estatus' );
		return $this->getAdapter ()->fetchAll( $select );
	}
	

}

