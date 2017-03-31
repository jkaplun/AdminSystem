<?php

class Application_Model_DbTable_Agenda extends Zend_Db_Table_Abstract
{

	protected $_name = 'agenda';

	public function agendaPersonal ($id , $fecha)
	{
		$select = $this->_db->select()->
		from ( 'view_'.$this->_name, '*' )
		->where('id_usuario_admin='.$id.' and fecha="'.$fecha.'"');
		
		//echo $select;die;
		return $this->getAdapter ()->fetchAll( $select );
	}
	
	
	public function agendaGeneral ($fecha)
	{
		$select = $this->_db->select()->
		from ( 'view_'.$this->_name, '*' )
		->where('fecha="'.$fecha.'"');
		
		return $this->getAdapter ()->fetchAll( $select );
	}
	
}

