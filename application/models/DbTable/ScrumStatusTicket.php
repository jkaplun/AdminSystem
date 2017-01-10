<?php

class Application_Model_DbTable_ScrumStatusTicket extends Zend_Db_Table_Abstract
{

	protected $_name = 'scrum_estatus_ticket';

	public function obtenerStatus()
	{
		$select = $this->_db->select()
		->from(array('set' => $this->_name),
			array('*'))
			->where('set.activo=1')->order('id_scrum_estatus_ticket');
		return $this->getAdapter ()->fetchAll( $select );
	}



}

