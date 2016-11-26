<?php

class Application_Model_DbTable_AgenciaUsuario extends Zend_Db_Table_Abstract
{

	protected $_name = 'agencia_usuario';

	public function obtenerUsuariosDeAgenciaPorIdAgencia ($id_agencia)
	{
		$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where('id_agencia='.$id_agencia.' and activo="S"')
			->order('nombre');

		return $this->getAdapter ()->fetchAll( $select );
	}

	public function obtenerUsuarioDeAgenciaPorId ($id_usuarioAgencia)
	{
		$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where('id_usuario_agencia="'.$id_usuarioAgencia.'"');

		return $this->getAdapter ()->fetchRow( $select );
	}
  
  	public function obtenerUsuariosAgenciaPorEmail($email)
  	{
	    $select = $this->_db->select()->
    	  from ( $this->_name, '*' )
      	->where('email="'.$email.'"');

    	return $this->getAdapter ()->fetchAll ( $select );
  	}

}

