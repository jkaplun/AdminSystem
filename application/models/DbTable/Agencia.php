<?php

class Application_Model_DbTable_Agencia extends Zend_Db_Table_Abstract
{

	protected $_name = 'agencia';

	public function obtenerTodasLasAgencias ($values = null)
	{
		
		$cond = 'clave is not null ';

		if( $values != null){
			$cond .= ' and clave like "%'.$values['agencia'].'%"';
		}

		$select = $this->_db->select()->
				from ( $this->_name,'*')
			->where($cond);;

		return $this->getAdapter ()->fetchAll ( $select );
	}

	public function obtenerAgenciasPorNombre ($nombre)
	{
		$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where('nombre="'.$nombre.'"');

		//echo $select;die;
		return $this->getAdapter ()->fetchAll( $select );
	}

	public function obtenerAgenciaPorId ($id)
	{
		$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where('id_agencia="'.$id.'"');

		//echo $select;die;
		return $this->getAdapter ()->fetchRow( $select );
	}

}

