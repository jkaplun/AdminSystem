<?php

class Application_Model_DbTable_UsuarioAdmin extends Zend_Db_Table_Abstract
{

	protected $_name = 'usuario_admin';

	public function getUserValues ($values)
	{
	$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where('clave="'.$values['clave'].'" and pwd=sha("'.$values['pwd'].'")');

		return $this->getAdapter ()->fetchRow ( $select );
	}
	
	public function getAllUsers ($values)
	{
		
		$cond = 'clave is not null ';
		
		if( trim(@$values['usuario_admin']) !=''){
			$cond .= ' and clave like "%'.$values['usuario_admin'].'%"';
		}
		
		$select = $this->_db->select()->
		from ( $this->_name, 
				array(
						'id_usuario',
						'clave',
						'nombre',
						'apellido_paterno',
						'apellido_materno',
						'activo',
						'email'))
				->where($cond);;
	
		return $this->getAdapter ()->fetchAll ( $select );
	}
	
	public function obtenerUsuarioPorClave ($clave)
	{
		$select = $this->_db->select()->
			from ( $this->_name, '*' )
			->where('clave="'.$clave['clave']);

		return $this->getAdapter ()->fetchRow ( $select );
	}
}

