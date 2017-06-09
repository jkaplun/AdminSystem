<?php

class Application_Model_DbTable_ScrumRH extends Zend_Db_Table_Abstract
{

	protected $_name = 'scrum_recursos_humanos';

	public function obtenerRH()
	{
		$select = $this->_db->select()
		->from(array('srh' => $this->_name),
			array('*'))
			->where('srh.activo=1')->order('nombre_completo');
		return $this->getAdapter ()->fetchAll( $select );
	}



}

