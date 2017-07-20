<?php
/**
 * 
 * @author Juan Garfias
 * Clase de Orden de Ventas.
 *
 */
class Application_Model_DbTable_OrdenVentas extends Zend_Db_Table_Abstract {

	protected $_name = 'orden_ventas';
	
	public function obtenerLlamadasVentas($valores){
		
		//echo "<pre>".print_r($valores,true)."</pre>";die;
		
		$select = $this->_db->select()->
		from ( "view_llamada_ventas", '*' )
		//->where('id_usuario_admin_atiende="'.$_SESSION['Zend_Auth']['USER_VALUES']['id_usuario'].'"')
		->order(array("id_orden_ventas desc"))->limit(100);
		
		if (isset($valores['id_usuario_admin_atiende']) && $valores['id_usuario_admin_atiende']!='') {
			$select->where("id_usuario_admin_atiende=?",$valores['id_usuario_admin_atiende']);
		}
		
// 		if ($valores['id_orden_ventas_estatus']==0) {
// 			unset($valores['id_orden_ventas_estatus']);
// 		}
		
		if  (isset($valores['id_orden_ventas_estatus']) && $valores['id_orden_ventas_estatus']!='' && $valores['id_orden_ventas_estatus']!=0) {
			$select->where("id_orden_ventas_estatus=?",$valores['id_orden_ventas_estatus']);
		}
		
		if  (isset($valores['id_agencia']) && $valores['id_agencia']!='') {
			
			if ( $valores['id_agencia'] == '--prospect--') {
				$select->where("id_agencia is null");
			} else {
				$select->where("id_agencia=?",$valores['id_agencia']);
			}
		}
		

		
		
		if  (isset($valores['daterange']) && $valores['daterange']!='') {
			$select->where("fecha_llamada between '{$valores['fecha_de']} 00:00:00' and '{$valores['fecha_hasta']} 23:59:59'");
		}
		
		
		
		return $this->getAdapter ()->fetchAll( $select );
	}
}

