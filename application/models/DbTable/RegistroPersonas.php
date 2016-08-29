<?php

class Application_Model_DbTable_RegistroPersonas extends Zend_Db_Table_Abstract
{

	protected $_name = 'registro_personas';

	public function getSeguimientoRegistros ($values)
	{
		//echo '<pre>'.print_r($values,true).'</pre>';die;
		
		$cond = "id_registro_personas is not null";
		
		if ( trim(@$values['fecharegistro'])!= '' ) {
			$cond.=' and fecha_registro="'. $values['fecharegistro'].'"';
		}
		
		if ( trim(@$values['apellido_paterno'])!= '' ) {
			$cond.=' and apellido_paterno like "%'. $values['apellido_paterno'].'%"';
		}
		
		if ( trim(@$values['apellido_materno'])!= '' ) {
			$cond.=' and apellido_materno like "%'. $values['apellido_materno'].'%"';
		}
		
		if ( trim(@$values['nombre'])!= '' ) {
			$cond.=' and nombre like "%'. $values['nombre'].'%"';
		}
		
		if ( trim(@$values['id_registro_personas'])!= '' ) {
			$cond.=' and id_registro_personas='. $values['id_registro_personas'];
		}
		
		
		
		
		if ( @$values['seguimiento']!= 0 ) {
			$cond.=' and id_seguimiento='. $values['seguimiento'];
		}
		
		if ( @$values['estado']!= 0 ) {
			$cond.=' and clave_entidad='. $values['estado'];
		}
		
		if ( @$values['estado_eu']!= 0 ) {
			$cond.=' and idcatalogo_estados_eua='. $values['estado_eu'];
		}
		
		
		$select = $this->_db->select()->
		from ( 'personas_registradas', array(
				'id_registro_personas',
				'apellido_paterno',
				'apellido_materno',
				'nombre',
				'nombre_entidad',
				'nombre_municipio',
				'estado',
				'id_seguimiento',
				'fecha_registro',
				'seguimiento'
		) )
		->where($cond)
		->order('id_registro_personas desc');
	
		//echo $select;die;
		//$result = $this->getAdapter ()->fetchRow ( $select );
	
		return $this->getAdapter ()->fetchAll ( $select );
	}
	
	
	
	public function getRegistroPersona ($id_registro_personas)
	{
		$cond = "id_registro_personas={$id_registro_personas}";
		$select = $this->_db->select()->
		from ( 'personas_registradas', '*'
		 )
		->where($cond);
	
		//echo $select;die;
		//$result = $this->getAdapter ()->fetchRow ( $select );
	
		return $this->getAdapter ()->fetchRow( $select );
	}
	
	
	
	/**
	 * SELECT 
    COUNT(*) as value, cs.descripcion as label
FROM
    registro_personas rp
        INNER JOIN
    catalogo_seguimiento cs ON rp.id_seguimiento = cs.id_seguimiento
    group by rp.id_seguimiento
    ;
	 */
	public function getChart6 ()
	{
		$select = $this->_db->select()->
		from ( array('rp'=>'registro_personas'), array('value'=>'COUNT(*)', 'label' =>'cs.descripcion')
			 )->join(array('cs'=>'catalogo_seguimiento'), 'rp.id_seguimiento = cs.id_seguimiento')
			 ->group('rp.id_seguimiento');
	
			 //echo $select;die;
			 //$result = $this->getAdapter ()->fetchRow ( $select );
	
			 return $this->getAdapter ()->fetchAll( $select );
	}
	
	/**
	SELECT
	COUNT(*) as value, u.username as label from registro_personas rp left join users u on u.id_user = rp.id_user_registro_inicial
	group by rp.id_user_registro_inicial
	*/
	public function getChart7 ()
	{
		$select = $this->_db->select()->
		from ( array('rp'=>'registro_personas'), array('value'=>'COUNT(*)', 'label' =>'u.username')
				)->join(array('u'=>'users'), 'u.id_user = rp.id_user_registro_inicial')
				->group('rp.id_user_registro_inicial');

		return $this->getAdapter ()->fetchAll( $select );
	}
	
}

