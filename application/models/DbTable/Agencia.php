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
			->where($cond)
			->order('nombre');

		return $this->getAdapter ()->fetchAll ( $select );
	}

	public function obtenerAgenciasPorNombre ($nombre)
	{
		$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where('nombre="'.$nombre.'"')
			->order('nombre');

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
	
	public function obtenerAgenciaPorAvanzado($where)
	{
		$select = $this->_db->select()
		->from(array('ag' => 'agencia'),
				array('*'))
				->joinleft(array('u_ag' => 'usuario_agencia'),
						'ag.id_usuario_soporte_titular = u_ag.id_usuario_agencia',
						array('nombre as contacto'))
				->joinleft(array('u_ad' => 'usuario_admin'),
							'ag.id_usuario_soporte_titular = u_ad.id_usuario',
							array('nombre as ejecutivo'))
				->where($where);
	
		//echo $select;die;
		return $this->getAdapter ()->fetchAll( $select );
	}

}

