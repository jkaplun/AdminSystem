<?php

class Application_Model_DbTable_Agencia extends Zend_Db_Table_Abstract
{

	protected $_name = 'agencia';

	public function obtenerTodasLasAgencias ($values)
	{
		$cond = 'clave is not null ';

		if( trim(@$values['agencia']) !=''){
			$cond .= ' and clave like "%'.$values['agencia'].'%"';
		}

		$select = $this->_db->select()->
		from ( $this->_name,
				array(
						'id_agencia',
						'clave',
						'nombre_comercial',
						'adeudo',
						'fecha_caducidad',
						'fecha'))
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

