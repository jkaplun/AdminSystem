<?php
/**
 * 
 * @author jgarfias
 *
 */
class Application_Model_DbTable_UsuarioWebService extends Zend_Db_Table_Abstract
{

  protected $_name = 'usuario_web_service';
  
  public function getUser ($values){
  
  	$select = $this->_db->select()->
  	from ( $this->_name, '*' )
  	->where('usuario="'.$values['user'].'" and pwd=sha("'.$values['pwd'].'")');
  	
  	$file = fopen('C:/logs/query_'.uniqid().'.sql', "w");
  	fwrite($file, $select );
  	fclose($file);
  	
  	return $this->getAdapter ()->fetchAll( $select );
  	
  }
  
}

