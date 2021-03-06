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
		->from(array('view_agencia' => 'view_agencia'),
				array('*'));
		
		if ( isset($values['id_agencia']) && $values['id_agencia'] != '') {
			$select->where("view_agencia.id_agencia=?",$values['id_agencia']);
		}
		
		if ( isset($values['prov_timbrado']) && $values['prov_timbrado'] != '') {
			$select->where("view_agencia.prov_timbrado=?",$values['prov_timbrado']);
		}
		
		if ( isset($values['clave_ciudad']) && $values['clave_ciudad'] != '') {
			$select->where("view_agencia.clave_ciudad=?",$values['clave_ciudad']);
		}
		
		if ( isset($values['id_usuario_soporte_titular']) && $values['id_usuario_soporte_titular'] != '') {
			$select->where("view_agencia.id_usuario_soporte_titular=?",$values['id_usuario_soporte_titular']);
		}
		
		if ( isset($values['productos']) && $values['productos'] != '') {
			$select->join("agencia_producto", 'agencia_producto.id_agencia=view_agencia.id_agencia',array());
			$select->join("producto", 'producto.id_producto=agencia_producto.id_producto',array());

 			foreach ( $values['productos'] as $producto ){
 				$select->orWhere("agencia_producto.id_producto=".$producto);
 			}	
		}
		
		
		if ( isset($values['con_sin_poliza']) && $values['con_sin_poliza'] != '') {
			if ($values['con_sin_poliza']==1){
			$cond ="poliza.fecha_ini < CURDATE()
		            AND poliza.fecha_fin > CURDATE()
		            AND poliza.id_poliza_estatus <> 4";
			$select->join("poliza", 'poliza.id_agencia=view_agencia.id_agencia',array());
			$select->where($cond);
			}
			if ($values['con_sin_poliza']==0){
				$cond = "id_agencia not in (SELECT id_agencia FROM view_agencia_polizas_vigentes)";
				$select->where($cond);
			}
		}
		
		$select->group("view_agencia.id_agencia")->order('nombre');
	//	echo $select;die;
		return $this->getAdapter ()->fetchAll( $select );
	}
	
	public function obtenerCiudadesDeAgencias ()
	{
		$select = $this->_db->select()->
		from ( 'view_ciudades_agencias', '*' );
		
		return $this->getAdapter ()->fetchAll( $select );
	}
	
}

