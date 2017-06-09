<?php
/**
 * 
 * @author jgarfias
 *
 */
class Application_Model_DbTable_Actualizaciones extends Zend_Db_Table_Abstract{

	protected $_name = 'actualizaciones';

	
	public function actualizacionesPendientes (){
		$select = $this->_db->select()->
		from ( 'view_'.$this->_name, '*' )
		->where('fecha_cierre is null');
		
		//echo $select;die;
		return $this->getAdapter ()->fetchAll( $select );
	}
	
	
	public function actualizacionesTodas ($valores){
		
		//echo "<pre>".print_r($valores,true)."</pre>";die;
		$select = $this->_db->select()
		->from ( 'view_'.$this->_name, '*' )
		->order('id_update desc')
		->limit(100);
		
		if (isset($valores['id_usuario_solicita']) && $valores['id_usuario_solicita']!='') {
			$select->where("id_usuario_solicita=?",$valores['id_usuario_solicita']);
		}
		
		if  (isset($valores['daterange']) && $valores['daterange']!='') {
			$select->where("fecha_solicitud between '{$valores['fecha_de']} 00:00:00' and '{$valores['fecha_hasta']} 23:59:59'");
		}
		
		if (isset($valores['id_agencia']) && $valores['id_agencia']!='') {
			$select->where("id_agencia=?",$valores['id_agencia']);
		}
		
		return $this->getAdapter ()->fetchAll( $select );
	}
}

