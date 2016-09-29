<?php

class Application_Model_DbTable_UsuarioAgencia extends Zend_Db_Table_Abstract
{

	protected $_name = 'usuario_agencia';

	public function obtenerUsuariosDeAgenciaPorIdAgencia ($id_agencia)
	{
		$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where('id_agencia='.$id_agencia.' and activo="S"')
			->order('nombre');

		return $this->getAdapter ()->fetchAll( $select );
	}

	public function obtenerUsuarioDeAgenciaPorId ($id)
	{
		$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where('id_usuario_agencia="'.$id.'"');

		//echo $select;die;
		return $this->getAdapter ()->fetchRow( $select );
	}
  
  	public function obtenerUsuariosAgenciaPorClave ($clave)
  	{
	    $select = $this->_db->select()->
    	  from ( $this->_name, '*' )
      	->where('clave="'.$clave.'"');

    	return $this->getAdapter ()->fetchAll ( $select );
  	}
  
  	public function obtenerUsuarioAgenciaPorId ($id)
  	{
    	$select = $this->_db->select()->
      	from ( $this->_name, '*' )
      	->where('id_usuario_agencia="'.$id.'"');

	      //echo $select;die;
    	return $this->getAdapter ()->fetchRow( $select );
  }

}

