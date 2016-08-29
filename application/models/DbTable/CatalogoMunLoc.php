<?php

class Application_Model_DbTable_CatalogoMunLoc extends Zend_Db_Table_Abstract
{

	protected $_name = 'catalogo_municipios_localidades';

	public function getEntidades ()
	{
	$select = $this->_db->select()->
		from ( $this->_name, array('clave_entidad','nombre_entidad') )
		->group('clave_entidad');
		
		//echo $select;die;
		//$result = $this->getAdapter ()->fetchRow ( $select );

		return $this->getAdapter ()->fetchAll ( $select );
	}
	
	
	public function getMunicipios ($claveEntidad)
	{		
		$cond = "clave_entidad =$claveEntidad and clave_municipio<>0";
		$select = $this->_db->select()->
		from ( $this->_name, array('clave_municipio','nombre_municipio') )
		->where($cond)
		->order('nombre_municipio')
		->group('clave_municipio');
	
		//echo $select;die;
		//$result = $this->getAdapter ()->fetchRow ( $select );
	
		return $this->getAdapter ()->fetchAll ( $select );
	}
	
}

