<?php

class Application_Model_DbTable_ScrumTicket extends Zend_Db_Table_Abstract
{

	protected $_name = 'scrum_tickets';

	public function getTickets()
	{
		$select = $this->_db->select()
		->from(array('st' => $this->_name),
				array('*'))
		->join(array('srh' => 'scrum_recursos_humanos'), 'srh.id_scrum_recursos_humanos = st.id_rh_asignado','clave')
		->join(array('set' => 'scrum_estatus_ticket'), 'set.id_scrum_estatus_ticket = st.id_estatus_ticket','descripcion');
		return $this->getAdapter ()->fetchAll( $select );
	}
	
	
	
	
}

