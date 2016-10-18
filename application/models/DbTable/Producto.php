<?php

class Application_Model_DbTable_Producto extends Zend_Db_Table_Abstract
{

	protected $_name = 'producto';

		public function obtenerProductos(){
	
		// $cond ="vigente_prod='S'";
	
		$select = $this->_db->select()->
		from ( $this->_name,'*')
		// ->where($cond)
		->order('id_producto')
		->order('vigente_prod');
	
		return $this->getAdapter ()->fetchAll ( $select );
	}

	public function obtenerProductoPorId ($id_producto)
	{
		$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where('id_producto="'.$id_producto.'"');

		//echo $select;die;
		return $this->getAdapter ()->fetchRow( $select );
	}
}

