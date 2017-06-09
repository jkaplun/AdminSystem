<?php

class Application_Model_DbTable_Producto extends Zend_Db_Table_Abstract
{

	protected $_name = 'producto';
	protected $_relacionAgenciaProducto = 'agencia_producto';

	public function obtenerProductos(){
		$select = $this->_db->select()->
		from ( $this->_name,'*')
		->order('id_producto')
		->order('vigente_prod');
		return $this->getAdapter ()->fetchAll ( $select );
	}
	
	public function obtenerProductosVigentes(){
		$select = $this->_db->select()->
		from ( $this->_name,'*')
		->where("vigente_prod='S'")
		->order('nombre_prod');
		return $this->getAdapter ()->fetchAll ( $select );
	}	

	public function obtenerProductoPorId ($id_producto)
	{
		$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where('id_producto="'.$id_producto.'"');
		return $this->getAdapter ()->fetchRow( $select );
	}
	
	public function obtenerProductosDisponiblesAdquiridosPorIdAgencia($id_agencia)
	{
		
		$select = $this->_db->select()
		->from(array('ap' => 'agencia_producto'),
				'*')
				->join(array('p' => 'producto'),
						'p.id_producto =ap.id_producto')
				->where("p.vigente_prod='S' and ap.id_agencia = $id_agencia "); // empty list of columns
				
		return $this->getAdapter ()->fetchAll( $select );
	}
	
	public function obtenerProductosDisponiblesPorIdAgencia($id_agencia)
	{
		
		$select = $this->_db->select()
		->from(array('p' => 'producto'),
				array('id_producto', 'nombre_prod', 'tiene_licencia'))
				->joinleft(array('a_p' => 'agencia_producto'),
						'p.id_producto = a_p.id_producto',
						array('ifnull(id_agencia,0) as id_agencia', 'ifnull(estatus,"N") as estatus'))
				->where('p.vigente_prod="S" and 
						a_p.id_agencia is null'); // empty list of columns
		echo $select;die;
		return $this->getAdapter ()->fetchAll( $select );
	}
	
	/**
	 * Consulta los productos que aún no tiene la agencia registrados para mostrarse en el SELECT del formulario de nuevo producto.
	 */
	public function obtenerProductosFaltantesPorAgencia($id_agencia){
		$select = $this->_db->select()->
			from ( $this->_name, '*' )
			->where("id_producto not in ( select id_producto from agencia_producto where id_agencia={$id_agencia} ) and vigente_prod='S'");
		return $this->getAdapter()->fetchAll( $select );
	}
	
	/**
	 * Consulta los productos que tiene la agencia registrados para mostrarse en el SELECT del formulario de nueva orden.
	 */
	public function obtenerProductosRegistradosPorAgencia($id_agencia){
		$select = $this->_db->select()->
		from ( $this->_name, '*' )
		->where("id_producto in ( select id_producto from agencia_producto where id_agencia={$id_agencia} and estatus='S' ) and vigente_prod='S'");
		return $this->getAdapter()->fetchAll( $select );
	}
}

