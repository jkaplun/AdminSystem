<?php

class Application_Model_DbTable_Poliza extends Zend_Db_Table_Abstract
{

	protected $_name = 'poliza';

	public function obtenerTodasLasPolizasActivas ($values = null)
	{
		
		$cond = 'clave is not null ';

		if( $values != null){
			$cond .= ' and clave like "%'.$values['poliza'].'%" and estatus = "S"';
		}

		$select = $this->_db->select()->
				from ( $this->_name,'*')
			->where($cond)
			->order('fecha_ini');

		return $this->getAdapter ()->fetchAll ( $select );
	}

	public function obtenerPolizasPorClave ($clave)
	{
		$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where('clave="'.$clave.'"')
			->order('clave');

		//echo $select;die;
		return $this->getAdapter ()->fetchAll( $select );
	}

	public function obtenerPolizasPorIdProductoYIdAgencia ($idProducto, $idAgencia)
	{
		$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where('id_producto="'.$idProducto.'" and id_agencia="'.$idAgencia.'"')
		->order('fecha_ini');

		//echo $select;die;
		return $this->getAdapter ()->fetchAll( $select );
	}

	public function obtenerPolizaPorIdAgencia ($idAgencia)
	{
		$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where(' id_agencia="'.$idAgencia.'"');

		//echo $select;die;
		return $this->getAdapter ()->fetchAll( $select );
	}
	
	public function obtenerPolizasPorFechasYIdAgencia($id_agencia, $id_producto, $fecha_inicial, $fecha_final)
	{
		$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where(' id_agencia="'.$id_agencia.'" and id_producto="'.$id_producto.'"
				and fecha_fin='.$fecha_final.' and fecha_ini='.$fecha_inicial);
		
		return $this->getAdapter ()->fetchAll( $select );
	}
	
	public function obtenerPolizasPorFechasYIdAgenciaParaRango($id_agencia, $id_producto, $fecha_final, $fecha_inicial)
	{
		$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where(' id_agencia="'.$id_agencia.'" and id_producto="'.$id_producto.'"
				and fecha_fin < \''.$fecha_final.'\'and fecha_ini < \''.$fecha_inicial.'\'');
		
		return $this->getAdapter ()->fetchAll( $select );
	}
	
	public function obtenerPolizasConFechaFinalMayorAInicialNueva($id_agencia, $id_producto, $fecha_inicialNueva)
	{
		$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where(' id_agencia="'.$id_agencia.'" and id_producto="'.$id_producto.'"
				and fecha_fin>'.$fecha_inicialNueva);
		
		return $this->getAdapter ()->fetchAll( $select );
	}
	
	public function obtenerPolizaVigenteProductoAgencia($id_agencia, $id_producto)
	{
		$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where(' id_agencia="'.$id_agencia.'" and id_producto="'.$id_producto.'"
				and now() between fecha_ini and fecha_fin and tiempo_agotado = "N"
				and estatus = "S" and horas_poliza > 0');
		
		return $this->getAdapter ()->fetchRow( $select );
	}
	
	public function obtenerPolizaPorId($id_poliza)
	{
		$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where(' id_poliza="'.$id_poliza.'"');
		
		return $this->getAdapter ()->fetchRow( $select );
	}

}

