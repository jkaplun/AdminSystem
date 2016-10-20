<?php

class Application_Model_DbTable_Producto extends Zend_Db_Table_Abstract
{

	protected $_name = 'producto';
	protected $_relacionAgenciaProducto = 'agencia_producto';

		public function obtenerProductos(){
	
		// $cond ="vigente_prod='S'";
	
		$select = $this->_db->select()->
		from ( $this->_name,'*')
		// ->where($cond)
		->order('id_producto')
		->order('vigente_prod');
	
		return $this->getAdapter ()->fetchAll ( $select );
	}

	public function obtenerProductoPorId ($id_producto)
	{
		$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where('id_producto="'.$id_producto.'"');

		//echo $select;die;
		return $this->getAdapter ()->fetchRow( $select );
	}
	
	public function obtenerProductosDisponiblesAdquiridosPorIdAgencia($id_agencia)
	{
		$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where('id_producto="'.$id_producto.'"');
		
		/*SELECT producto.id_producto, nombre_prod, tiene_licencia, numero_licencias,
		ifnull(id_agencia,0) as id_agencia, agencia_producto.estatus FROM producto
		left JOIN agencia_producto on producto.id_producto = agencia_producto.id_producto
		where vigente_prod = 'S' and (id_agencia = 569 or id_agencia is null) order by id_agencia desc;*/
		
		$select = $this->_db->select()
		->from(array('p' => 'product'),
				array('id_producto', 'nombre_prod', 'tiene_licencia'),
				array('a_p' => 'agencia_producto'),
				array('ifnull(id_agencia,0)', 'numero_licencias'))
				->joinleft(array('a_p' => 'agencia_producto'),
						'p.id_producto = a_p.agencia_producto',
						array())
				->where('p.vigente_prod="S" and 
						(a_p.id_agencia ="'.$id_agencia.'" or a_p.id_agencia is null')
				->order("a_p.id_agencia"); // empty list of columns
	}
}

