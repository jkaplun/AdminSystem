<?php

class Application_Model_DbTable_TipoPoliza extends Zend_Db_Table_Abstract
{

	protected $_name = 'tipo_poliza';

	public function obtenerTiposPoliza(){
	
		$select = $this->_db->select()->
		from ( $this->_name,'*')
		->where('activo=1')
		->order('tipo');
	
		return $this->getAdapter ()->fetchAll ( $select );
	}
}

