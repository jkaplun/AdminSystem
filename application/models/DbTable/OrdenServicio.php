<?php
/**
 * 
 * @author Juan Garfias
 * Clase de Orden de Servicio.
 *
 */
class Application_Model_DbTable_OrdenServicio extends Zend_Db_Table_Abstract
{

	protected $_name = 'orden_servicio';

	
	public function obtenerOrdenes($valores){
		
		$select = $this->_db->select()->
		from ( "view_orden_servicio", '*' )
		->where('id_usuario_admin_atiende="'.$_SESSION['Zend_Auth']['USER_VALUES']['id_usuario'].'"');
		return $this->getAdapter ()->fetchAll( $select );
		
		/*echo $select;
		die;*/
	}
	
	public function obtenerOrdenesMonitoreo()
	{
		$select = $this->_db->select()->
		from (array('p' => $this->_name),
				array(
					'id_orden_servicio',
					'id_agencia',
					'id_usuario_admin_atiende',
					'id_usuario_agencia_solicito',
					'fecha_alta',
					'id_orden_servicio_estatus',
					'concluido',
					'control_cron_estatus as estatus_reloj'
					)
		)
		->joinleft(array('u_a' => 'usuario_agencia'),
						'p.id_usuario_agencia_solicito = u_a.id_usuario_agencia',
						array('nombre as nombre_usuario', 'apellidos as apellidos_usuario', 'puesto'))
		->joinRight(array('u_ad' => 'usuario_admin'),
						'p.id_usuario_admin_atiende = u_ad.id_usuario',
						array('id_usuario','nombre as nombre_atiende', 'apellido_paterno'))
		->joinleft(array('a' => 'agencia'),
						'p.id_agencia = a.id_agencia',
						array('nombre as nombre_agencia'))
		->where("u_ad.es_ejecutivo = 'S'");
		//->where("(concluido = 'N' or concluido is null) and u_ad.ejecutivo = 'S'");
		return $this->getAdapter ()->fetchAll( $select );
	}

	public function obtenerOrdenesPorIdEjecutivo ($idEjecutivo)
	{
		$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where('id_usuario_admin_atiende="'.$idEjecutivo.'" and concluido= "N"');
	
		//echo $select;die;
		return $this->getAdapter ()->fetchAll( $select );
	}

	public function obtenerOrdenPorId ($idOrden)
	{
		$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where('id_orden_servicio="'.$idOrden.'"');
		
		return $this->getAdapter ()->fetchRow( $select );
	}

	public function obtenerServiciosFinalizadosPorIdAgencia ($idAgencia)
	{
		$select = $this->_db->select()->
		from ( array('p' => $this->_name),
				array(
					'id_orden_servicio',
					'id_agencia',
					'id_usuario_admin_atiende',
					'id_usuario_agencia_solicito',
					'fecha_alta',
					'duracion_servicio',
					'fecha_cierre',
					'concluido',
					'conformidad'
					)
			)
		->joinleft(array('u_a' => 'usuario_agencia'),
						'p.id_usuario_agencia_solicito = u_a.id_usuario_agencia',
						array('nombre as nombre_usuario', 'apellidos as apellidos_usuario'))
		->joinleft(array('u_ad' => 'usuario_admin'),
						'p.id_usuario_admin_atiende = u_ad.id_usuario',
						array('nombre as nombre_atiende', 'apellido_paterno'))		
		->joinleft(array('po' => 'producto'),
						'p.id_producto = po.id_producto',
						array('nombre_prod as producto'))							
		->where('p.id_agencia="'.$idAgencia.'" and p.concluido= "S"');
		return $this->getAdapter ()->fetchAll( $select );
	}

	public function obtenerServiciosFinalizadosPorIdEjecutivo ($idEjecutivo)
	{
		$select = $this->_db->select()->
		from ( array('p' => $this->_name),
				array(
					'id_orden_servicio',
					'id_agencia',
					'id_usuario_admin_atiende',
					'id_usuario_agencia_solicito',
					'fecha_alta',
					'duracion_servicio',
					'fecha_cierre',
					'concluido',
					'conformidad'
					)
			)
		->joinleft(array('u_a' => 'usuario_agencia'),
						'p.id_usuario_agencia_solicito = u_a.id_usuario_agencia',
						array('nombre as nombre_usuario', 'apellidos as apellidos_usuario'))
		->joinleft(array('u_ad' => 'usuario_admin'),
						'p.id_usuario_admin_atiende = u_ad.id_usuario',
						array('nombre as nombre_atiende', 'apellido_paterno'))		
		->joinleft(array('po' => 'producto'),
						'p.id_producto = po.id_producto',
						array('nombre_prod as producto'))
		->joinleft(array('a' => 'agencia'),
						'p.id_agencia = a.id_agencia',
						array('nombre as nombre_agencia'))														
		->where('id_usuario_admin_atiende="'.$idEjecutivo.'" and concluido= "S"');
		//echo $select;die;
		return $this->getAdapter ()->fetchAll( $select );
	}
	
	public function obtenerServiciosFinalizadosHistorico ()
	{
		$select = $this->_db->select()->
		from ( array('p' => $this->_name),
				array(
					'id_orden_servicio',
					'id_agencia',
					'id_usuario_admin_atiende',
					'id_usuario_agencia_solicito',
					'fecha_alta',
					'duracion_servicio',
					'fecha_cierre',
					'concluido',
					'conformidad'
					)
			)
		->joinleft(array('u_a' => 'usuario_agencia'),
						'p.id_usuario_agencia_solicito = u_a.id_usuario_agencia',
						array('nombre as nombre_usuario', 'apellidos as apellidos_usuario'))
		->joinleft(array('u_ad' => 'usuario_admin'),
						'p.id_usuario_admin_atiende = u_ad.id_usuario',
						array('nombre as nombre_atiende', 'apellido_paterno'))		
		->joinleft(array('po' => 'producto'),
						'p.id_producto = po.id_producto',
						array('nombre_prod as producto'))
		->joinleft(array('a' => 'agencia'),
						'p.id_agencia = a.id_agencia',
						array('nombre as nombre_agencia'))														
		->where('concluido= "S"');
		//echo $select;die;
		return $this->getAdapter ()->fetchAll( $select );
	}	

	public function obtenerServiciosPendientesHistorico ()
	{
		$select = $this->_db->select()->
		from ( array('p' => $this->_name),
				array(
					'id_orden_servicio',
					'id_agencia',
					'id_usuario_admin_atiende',
					'id_usuario_agencia_solicito',
					'fecha_alta',
					'duracion_servicio',
					'fecha_cierre',
					'concluido',
					'motivo',
					'control_cron_estatus as estatus_reloj',
					'id_orden_servicio_estatus'
					)
			)
		->joinleft(array('u_a' => 'usuario_agencia'),
						'p.id_usuario_agencia_solicito = u_a.id_usuario_agencia',
						array('nombre as nombre_usuario', 'apellidos as apellidos_usuario'))
		->joinleft(array('u_ad' => 'usuario_admin'),
						'p.id_usuario_admin_atiende = u_ad.id_usuario',
						array('nombre as nombre_atiende', 'apellido_paterno'))		
		->joinleft(array('po' => 'producto'),
						'p.id_producto = po.id_producto',
						array('nombre_prod as producto'))
		->joinleft(array('a' => 'agencia'),
						'p.id_agencia = a.id_agencia',
						array('nombre as nombre_agencia'))														
		->where('concluido= "N"');
		//echo $select;die;
		return $this->getAdapter ()->fetchAll( $select );
	}	

	/*public function obtenerDiferenciaDeHoras ($idOrden, $fechaMayor, $fechaMenor)
	{
		$select = $this->_db->select()->
		from ( $this->_name, 
			'extract(hour	from TIMEDIFF("'.$fechaMayor.'", "'.$fechaMenor.'")) as diferencia' )
		->where('id_orden="'.$idOrden.'"');
		
		return $this->getAdapter ()->fetchRow( $select );
	}*/

	public function obtenerDiferenciaDeFechas ($fechaMayor, $fechaMenor)
	{
		$select = 'select extract(hour	from TIMEDIFF("'.$fechaMayor.'", "'.$fechaMenor.'")) as hora,
					extract(minute from TIMEDIFF("'.$fechaMayor.'", "'.$fechaMenor.'")) as minuto,
					extract(second from TIMEDIFF("'.$fechaMayor.'", "'.$fechaMenor.'")) as segundo';
		
		return $this->getAdapter ()->fetchRow( $select );
	}
	
	
	

}

