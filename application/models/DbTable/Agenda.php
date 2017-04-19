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
	
	public function agendaDelDiaPorUsuario($id)
	{
		$select = $this->_db->select()->
		from ( 'view_'.$this->_name, '*' )
		->where("(id_usuario_admin={$id}) && date( fecha ) = current_date()");
		
		return $this->getAdapter ()->fetchAll( $select );
	}
	
	
	public function validarFechaDeAlta($id , $fecha, $hora_inicial , $hora_final)
	{
		$select = $this->_db->select()->
		from ( 'view_'.$this->_name, '*' )
		->where("id_usuario_admin=$id and fecha='$fecha' and
		(time(hora_inicial) <= '$hora_inicial' and  time(hora_final) >= '$hora_inicial' or time(hora_inicial) <= '$hora_final' and  time(hora_final) >= '$hora_final')");

		return $this->getAdapter ()->fetchAll( $select );
	}

	
}

