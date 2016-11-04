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
		->where('id_usuario_admin_atiende="'.$_SESSION['Zend_Auth']['USER_VALUES']['id_usuario']
				.'"');
		
		//echo $select;
		//die;
		return $this->getAdapter ()->fetchAll( $select );
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
					'id_orden_servicio_estatus'
					)
		)
		->joinleft(array('u_a' => 'usuario_agencia'),
						'p.id_usuario_agencia_solicito = u_a.id_usuario_agencia',
						array('nombre as nombre_usuario', 'apellidos as apellidos_usuario', 'puesto'))
		->joinleft(array('u_ad' => 'usuario_admin'),
						'p.id_usuario_admin_atiende = u_ad.id_usuario',
						array('nombre as nombre_atiende', 'apellido_paterno'))
		->joinleft(array('a' => 'agencia'),
						'p.id_agencia = a.id_agencia',
						array('nombre as nombre_agencia'))		
		->where("concluido = 'N'");
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
		->where('id_orden="'.$idOrden.'"');
		
		return $this->getAdapter ()->fetchRow( $select );
	}

	public function obtenerDiferenciaDeHoras ($idOrden, $fechaMayor, $fechaMenor)
	{
		$select = $this->_db->select()->
		from ( $this->_name, 
			'extract(hour	from TIMEDIFF("'.$fechaMayor.'", "'.$fechaMenor.'")) as diferencia' )
		->where('id_orden="'.$idOrden.'"');
		
		return $this->getAdapter ()->fetchRow( $select );
	}
	
	
	

}

