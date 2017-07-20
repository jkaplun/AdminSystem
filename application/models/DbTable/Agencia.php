<?php

class Application_Model_DbTable_Agencia extends Zend_Db_Table_Abstract
{

	protected $_name = 'agencia';

	public function obtenerTodasLasAgencias ($values = null)
	{
		
		$cond = 'clave is not null ';

		if( $values != null){
			$cond .= ' and clave like "%'.$values['agencia'].'%"';
		}

		$select = $this->_db->select()->
				from ( $this->_name,'*')
			->where($cond)
			->order('nombre');

		return $this->getAdapter ()->fetchAll ( $select );
	}

	public function obtenerAgenciasPorNombre ($nombre)
	{
		$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where('nombre="'.$nombre.'"')
			->order('nombre');

		//echo $select;die;
		return $this->getAdapter ()->fetchAll( $select );
	}

	public function obtenerAgenciaPorId ($id)
	{
		$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where('id_agencia="'.$id.'"');

		//echo $select;die;
		return $this->getAdapter ()->fetchRow( $select );
	}
	
	public function obtenerAgenciaPorAvanzado($where)
	{
		$select = $this->_db->select()
		->from(array('ag' => 'agencia'),
				array('*'))
				->joinleft(array('u_ag' => 'agencia_usuario'),
						'ag.id_usuario_soporte_titular = u_ag.id_usuario_agencia',
						array('nombre as contacto'))
				->joinleft(array('u_ad' => 'usuario_admin'),
							'ag.id_usuario_soporte_titular = u_ad.id_usuario',
							array('nombre as ejecutivo'))
				->joinleft(array('ag_p' => 'agencia_producto'),
							'ag.id_agencia = ag_p.id_agencia',
							array('id_producto as producto'))
				->where($where);
	
		//echo $select;die;
		return $this->getAdapter ()->fetchAll( $select );
	}

	public function obtenerAgenciaPorProducto($id)
	{
		$select = $this->_db->select()
		->from(array('ag' => 'agencia'),
				array('*'))
				->joinleft(array('ap' => 'agencia_producto'),
						'ag.id_agencia = ap.id_agencia',
						array('numero_licencias'))
				->where('ap.estatus="s" and ap.id_producto="'.$id.'"');
		//echo $select;die;
		return $this->getAdapter ()->fetchAll( $select );
	}

	public function obtenerAgenciaPorPoliza($id)
	{
		$select = $this->_db->select()
		->from(array('ag' => 'agencia'),
				array('*'))
				->joinleft(array('p' => 'poliza'),
						'ag.id_agencia = p.id_agencia',
						array('horas_poliza','horas_consumidas'))
				->where('p.id_poliza_estatus="1" and p.tipo="'.$id.'"');
		//echo $select;die;
		return $this->getAdapter ()->fetchAll( $select );
	}

	public function filtrarAgencias($values)
	{
		$select = $this->_db->select()
		->from(array('ag' => 'agencia'),
				array('*'));
		
		if ( isset($values['id_agencia']) && $values['id_agencia'] != '') {
			$select->where("ag.id_agencia=?",$values['id_agencia']);
		}
		
		if ( isset($values['id_usuario_soporte_titular']) && $values['id_usuario_soporte_titular'] != '') {
			$select->where("ag.id_usuario_soporte_titular=?",$values['id_usuario_soporte_titular']);
		}

		return $this->getAdapter ()->fetchAll( $select );
	}
	
	public function filtrarAgenciasFromDBView($values)
	{
		$select = $this->_db->select()
		->from(array('ag' => 'view_agencia'),
				array('*'));
		
		if ( isset($values['id_agencia']) && $values['id_agencia'] != '') {
			$select->where("ag.id_agencia=?",$values['id_agencia']);
		}
		
		if ( isset($values['id_usuario_soporte_titular']) && $values['id_usuario_soporte_titular'] != '') {
			$select->where("ag.id_usuario_soporte_titular=?",$values['id_usuario_soporte_titular']);
		}
		
		return $this->getAdapter ()->fetchAll( $select );
	}
	

}

