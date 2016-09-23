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

	public function obtenerAgenciaPorClave ($clave)
	{
		$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where('clave="'.$clave.'"');

		//echo $select;die;
		return $this->getAdapter ()->fetchRow( $select );
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

