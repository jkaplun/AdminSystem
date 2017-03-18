<?php

class Application_Model_DbTable_Poliza extends Zend_Db_Table_Abstract
{

	protected $_name = 'poliza';

	public function obtenerTodasLasPolizasActivas ($values = null)
	{
		
		$cond = 'clave is not null ';

		if( $values != null){
			$cond .= ' and clave like "%'.$values['poliza'].'%" and id_poliza_estatus = 1';
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
		->where('id_producto="'.$idProducto.'" and id_agencia="'.$idAgencia.'" and id_poliza_estatus=1 ')
		->order('fecha_ini');

		//echo $select;die;
		return $this->getAdapter ()->fetchAll( $select );
	}

	public function obtenerPolizasPorIdAgencia ($idAgencia)
	{
		$select = $this->_db->select()->
		from ( array( 'p' => $this->_name), '*' )
		->join( array( 'tp'=> 'tipo_poliza') , 'p.tipo=tp.tipo' )
		->where(' p.id_agencia="'.$idAgencia.'" and current_timestamp between fecha_ini and fecha_fin');

		//echo $select;die;
		return $this->getAdapter ()->fetchAll( $select );
	}
	
	public function obtenerTodasLasPolizasPorIdAgencia ($idAgencia)
	{
		$select = $this->_db->select()->
		from ( array( 'p' => $this->_name), '*' )
		->join( array( 'tp'=> 'tipo_poliza') , 'p.tipo=tp.tipo' )
		->where(' p.id_agencia='.$idAgencia);
	
		//echo $select;die;
		return $this->getAdapter ()->fetchAll( $select );
	}

	public function obtenerPolizasVigentesPorIdAgencia ($idAgencia)
	{
		
		$select = $this->_db->select()->
		from ( $this->_name, array("*",
					"(if ( now() between fecha_ini and fecha_fin_servicio,'si','no')) as vigente",
				 	"((SELECT descripcion FROM tipo_poliza tp WHERE tp.tipo = poliza.tipo)) as tipo_desc" ) )
		->where(' id_agencia="'.$idAgencia.'" and fecha_fin_servicio > now() and id_poliza_estatus = 1')
		->order('fecha_ini');
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
				and fecha_fin>'.$fecha_inicialNueva.' and id_poliza_estatus=1');
		
		return $this->getAdapter ()->fetchAll( $select );
	}
	
	public function obtenerPolizaVigenteProductoAgencia($id_agencia, $id_producto)
	{
		$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where(' id_agencia="'.$id_agencia.'" and id_producto="'.$id_producto.'"
				and now() between fecha_ini and fecha_fin and tiempo_agotado = "N"
				and id_poliza_estatus = 1 and horas_poliza > 0');
		
		return $this->getAdapter ()->fetchRow( $select );
	}
	
	public function obtenerPolizaPorId($id_poliza)
	{
		$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where(' id_poliza="'.$id_poliza.'"');
		
		return $this->getAdapter ()->fetchRow( $select );
	}
	
	public function obtenerPolizaVigentePorId($id_poliza)
	{
		$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where(' id_poliza="'.$id_poliza.'"  and now() between fecha_ini and fecha_fin_servicio 
				 and id_poliza_estatus = 1')
		->order('fecha_ini');
		
		return $this->getAdapter ()->fetchRow( $select );
	}

	
	public function obtienePolizaConGarantiaPorProducto($values){
		$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where("id_agencia={$values['id_agencia']}
					AND id_producto = {$values['id_producto']}
        			AND (tipo = '{$values['tipo']}') AND id_poliza_estatus<>4");
		return $this->getAdapter ()->fetchAll( $select );
	}
	
}

