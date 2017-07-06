<?php
/**
 * 
 * @author Juan Garfias
 * Clase de Orden de Servicio.
 *
 */
class Application_Model_DbTable_OrdenServicio extends Zend_Db_Table_Abstract {

	protected $_name = 'orden_servicio';
	
	public function obtenerOrdenes($valores){
		$select = $this->_db->select()->
		from ( "view_orden_servicio", '*' )
		->where('id_usuario_admin_atiende="'.$_SESSION['Zend_Auth']['USER_VALUES']['id_usuario'].'" and id_orden_servicio_estatus < 6 ')
		->order("id_orden_servicio");

		return $this->getAdapter ()->fetchAll( $select );
	}
	
	public function obtenerTodasLasOrdenes($valores){
		$select = $this->_db->select()
			->from ( "view_orden_servicio", '*' )
			->order("id_orden_servicio desc")->limit(100);
	
        if ($_SESSION['Zend_Auth']['USER_VALUES']['p_admin']=='S') {
        	if (isset($valores['id_usuario_admin_atiende']) && $valores['id_usuario_admin_atiende']!='') {
        		$select->where("id_usuario_admin_atiende=?",$valores['id_usuario_admin_atiende']);
        	}
        } else { 
        	$select->where("id_usuario_admin_atiende=?",$_SESSION['Zend_Auth']['USER_VALUES']['id_usuario']);
        }
		
		if (isset($valores['id_motivo']) && $valores['id_motivo']!='') {
			$select->where("id_motivo=?",$valores['id_motivo']);
		}
		if  (isset($valores['id_orden_servicio_estatus']) && $valores['id_orden_servicio_estatus']!='') {
			$select->where("id_orden_servicio_estatus=?",$valores['id_orden_servicio_estatus']);
		}
		
		if  (isset($valores['id_agencia']) && $valores['id_agencia']!='') {
			$select->where("id_agencia=?",$valores['id_agencia']);
		}
		
		if  (isset($valores['daterange']) && $valores['daterange']!='') {
			$select->where("fecha_alta between '{$valores['fecha_de']} 00:00:00' and '{$valores['fecha_hasta']} 23:59:59'");
		}

		return $this->getAdapter ()->fetchAll( $select );
	}
	
	public function obtenerOrdenesMonitoreo()
	{
		$select = $this->_db->select()->
		from (array('os' => $this->_name),
				array(
					'id_orden_servicio',
					'id_agencia',
					'id_usuario_admin_atiende',
					'id_usuario_agencia_solicito',
					'fecha_alta',
					'id_orden_servicio_estatus',
					'control_cron_estatus as estatus_reloj'
					)
		)
		->joinleft(array('au' => 'agencia_usuario'),
						'os.id_usuario_agencia_solicito = au.id_usuario_agencia',
						array('nombre as nombre_usuario', 'apellidos as apellidos_usuario', 'puesto'))
		->joinRight(array('u_ad' => 'usuario_admin'),
						'os.id_usuario_admin_atiende = u_ad.id_usuario',
						array('id_usuario','nombre as nombre_atiende', 'apellido_paterno'))
		->joinleft(array('a' => 'agencia'),
						'os.id_agencia = a.id_agencia',
						array('nombre as nombre_agencia'))
		->where("id_orden_servicio_estatus<6");
		//->where("u_ad.id_usuario_admin_puesto = 1 and id_orden_servicio_estatus<6");
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
		->joinleft(array('u_a' => 'agencia_usuario'),
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
		->joinleft(array('u_a' => 'agencia_usuario'),
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
		->joinleft(array('u_a' => 'agencia_usuario'),
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
					'control_cron_estatus as estatus_reloj',
					'id_orden_servicio_estatus'
					)
			)
		->joinleft(array('u_a' => 'agencia_usuario'),
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
		//->where('concluido= "N"')
		;
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
	
	public function obtenerMotivos(){
		$select = $this->_db->select()->
		from ('orden_servicio_cat_motivo', '*' )->order('motivo');
		return $this->getAdapter ()->fetchAll( $select );
	}
	
	public function obtenerTipoDeSoporte(){
		$select = $this->_db->select()->
		from ('orden_servicio_cat_tipo_soporte', '*' );
		return $this->getAdapter ()->fetchAll( $select );
	}
	
	public function obtenerOrdenesPorPoliza($id_poliza){
	
		$select = $this->_db->select()->
		from ( "view_orden_servicio", '*' )
		->where('id_poliza='.$id_poliza.' and id_agencia='.$_SESSION['Zend_Auth']['storage']['id_agencia'])
		->order("id_orden_servicio");
	
		return $this->getAdapter ()->fetchAll( $select );
	
	}

	public function obtenerOrdenesEstatus(){
	
		$select = $this->_db->select()->
		from ( "orden_servicio_estatus", '*' )
		->where('activo="S"')
		->order("id_orden_servicio_estatus");
	
		return $this->getAdapter ()->fetchAll( $select );
	
	}
	
	public function obtenerOrdenesPorAgencia($id_agencia, $valores= null){
		
		$select = $this->_db->select()->
		from ( "view_orden_servicio", '*' )
		->where('id_agencia='.$id_agencia)
		->order("id_orden_servicio desc")
		->limit(100);
		

	
		if (isset($valores['id_usuario_admin_atiende']) && $valores['id_usuario_admin_atiende']!='') {
			$select->where("id_usuario_admin_atiende=?",$valores['id_usuario_admin_atiende']);
		}
		if (isset($valores['id_motivo']) && $valores['id_motivo']!='') {
			$select->where("id_motivo=?",$valores['id_motivo']);
		}
		if  (isset($valores['id_orden_servicio_estatus']) && $valores['id_orden_servicio_estatus']!='') {
			$select->where("id_orden_servicio_estatus=?",$valores['id_orden_servicio_estatus']);
		}
		
		if  (isset($valores['daterange']) && $valores['daterange']!='') {
			$select->where("fecha_alta between '{$valores['fecha_de']} 00:00:00' and '{$valores['fecha_hasta']} 23:59:59'");
		}
	
		return $this->getAdapter ()->fetchAll( $select );
	}
}

