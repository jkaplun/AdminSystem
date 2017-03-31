<?php

class Application_Model_DbTable_FoliosAgencia extends Zend_Db_Table_Abstract
{

	protected $_name = 'folios_agencia';

	public function obtenerFoliosPorId ($id)
	{
		$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->join("folios_agencia_cat_tipo", "folios_agencia_cat_tipo.id_folios_agencia_cat_tipo={$this->_name}.id_folios_agencia_cat_tipo")
		->where('id_agencia="'.$id.'"')
		->order("id_folios_agencia desc");
	
		//echo $select;die;
		return $this->getAdapter ()->fetchAll( $select );
	}
	
	public function obtenerTipoFolios (){
		$select = $this->_db->select()->
		from ( $this->_name.'_cat_tipo', '*' );

		return $this->getAdapter ()->fetchAll( $select );
	}
}

