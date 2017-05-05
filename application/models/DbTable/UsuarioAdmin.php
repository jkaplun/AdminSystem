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
    from ( $this->_name, '*')
        ->where($cond);;
  
    return $this->getAdapter ()->fetchAll ( $select );
  }
  
  public function obtenerUsuarioPorClave ($clave)
  {
    $select = $this->_db->select()->
      from ( $this->_name, '*' )
      ->where('clave="'.$clave.'"');

      //echo $select;die;
    return $this->getAdapter ()->fetchRow( $select );
  }
  
  public function obtenerUsuarioPorId ($id)
  {
    $select = $this->_db->select()->
      from ( $this->_name, '*' )
      ->where('id_usuario="'.$id.'"');

      //echo $select;die;
    return $this->getAdapter ()->fetchRow( $select );
  }
  
  public function obtenerUsuariosPorClave ($clave)
  {
    $select = $this->_db->select()->
      from ( $this->_name, '*' )
      ->where('clave="'.$clave.'"');

      //echo $select;die;
    return $this->getAdapter ()->fetchAll ( $select );
  }
  
  public function obtenerUsuarios(){
  	$select = $this->_db->select()->
  	from ( $this->_name,'*')
  	->order('clave');
  
  	return $this->getAdapter ()->fetchAll ( $select );
  }

  public function obtenerTodosEjecutivos ()
  { 
    $cond = 'clave is not null and es_ejecutivo="S"';

    $select = $this->_db->select()->
        from ( $this->_name,'*')
      ->where($cond)
      ->order('nombre');
    return $this->getAdapter ()->fetchAll ( $select );
  }

  public function getUserValuesById ($values)
  {
  	$select = $this->_db->select()->
  	from ( $this->_name, '*' )
  	->where('id_usuario='.$values['id_usuario']);
  
  	return $this->getAdapter ()->fetchRow ( $select );
  }

  public function getSoporteUsers(){
  	$cond = 'activo="S"';
  	$select = $this->_db->select()
  	->from( $this->_name,'*')
  	->where($cond);
  
  	return $this->getAdapter ()->fetchAll ( $select );
  }
}

