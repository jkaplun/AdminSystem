<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract
{

	protected $_name = 'users';

	public function getUserValues ($values)
	{
	$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where('username="'.$values['usuario'].'" and password=sha("'.$values['password'].'")');
		
		//echo $select;die;
		//$result = $this->getAdapter ()->fetchRow ( $select );

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

