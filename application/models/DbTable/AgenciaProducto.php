<?php

class Application_Model_DbTable_AgenciaProducto extends Zend_Db_Table_Abstract
{
	protected $_name = 'agencia_producto';
	
	
	public function filtrarAgenciaProductosFromDBView($values){
		
		$cond = " id_agencia = {$values['id_agencia']}";
		$select = $this->_db->select()
		->from(array('ag' => 'view_agencia_producto'),array('*'))
		->where($cond);
		
		
		return $this->getAdapter ()->fetchAll( $select );
	}
	
}

