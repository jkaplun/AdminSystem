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
		
		$cond = 'username is not null ';
		
		if( trim(@$values['usuario']) !=''){
			$cond .= ' and username like "%'.$values['usuario'].'%"';
		}
		
		$select = $this->_db->select()->
		from ( $this->_name, 
				array(
						'id_user',
						'username',
						'realname',
						'activo',
						'id_rol'))
				->where($cond);;
	
		//echo $select;die;
		//$result = $this->getAdapter ()->fetchRow ( $select );
	
		return $this->getAdapter ()->fetchAll ( $select );
	}
}

