<?php

class Application_Model_DbTable_CatalogoEstadosUSA extends Zend_Db_Table_Abstract
{

	protected $_name = 'catalogo_estados_eua';

	public function getEstadosUSA ()
	{
	$select = $this->_db->select()->
		from ( $this->_name, array('idcatalogo_estados_eua','estado') )
		->group('idcatalogo_estados_eua');
		
		//echo $select;die;
		//$result = $this->getAdapter ()->fetchRow ( $select );

		return $this->getAdapter ()->fetchAll ( $select );
	}

}

