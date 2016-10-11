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

	public function obtenerPolizaPorIdProductoYIdAgencia ($idProducto, $idAgencia)
	{
		$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where('id_producto="'.$idProducto.'" and id_agencia="'.$idAgencia.'" and curdate() < fecha_fin')
		->order('fecha_fin');

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

}

