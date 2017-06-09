<?php

class Application_Model_DbTable_ProductoTipoPoliza extends Zend_Db_Table_Abstract
{

	protected $_name = 'producto_por_tipo_poliza';

	public function obtenerProductoTiposPoliza($tipo){
	
		$select = $this->_db->select()->
		from ( $this->_name,'*')
		->where("tipo='$tipo'")
		->order('id_producto');
	
		return $this->getAdapter ()->fetchAll ( $select );
	}
}

