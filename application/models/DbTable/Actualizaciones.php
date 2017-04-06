<?php
/**
 * 
 * @author jgarfias
 *
 */
class Application_Model_DbTable_Actualizaciones extends Zend_Db_Table_Abstract{

	protected $_name = 'actualizaciones';

	
	public function actualizacionesPendientes (){
		$select = $this->_db->select()->
		from ( 'view_'.$this->_name, '*' )
		->where('fecha_cierre is null');
		
		//echo $select;die;
		return $this->getAdapter ()->fetchAll( $select );
	}
	
	
	public function actualizacionesTodas ($params){
		$select = $this->_db->select()
		->from ( 'view_'.$this->_name, '*' )
		->order('id_update desc')
		->limit(100);
		
		
		
		return $this->getAdapter ()->fetchAll( $select );
	}
}

