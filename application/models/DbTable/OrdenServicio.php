<?php

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
	

}

