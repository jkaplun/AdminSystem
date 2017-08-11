<?php

/**
 * 
 * @author jgarfias
 *
 */
class Application_Model_Services_ServicesPolizas
{
	/**
	 * 
	 * @param unknown $idProducto
	 * @param unknown $idAgencia
	 * @param unknown $fechaInicialNuevaPoliza
	 * @param unknown $fechaFinalNuevaPoliza
	 * @param unknown $tipo
	 * @return boolean[]|string[]
	 */
	function esPolizaValida($idProducto, $idAgencia, $fechaInicialNuevaPoliza, $fechaFinalNuevaPoliza, $tipo = null)
	{
		$polizaValida = false;
		$errorDesc='';
		$polizaDbTable = new Application_Model_DbTable_Poliza();
		$polizas = $polizaDbTable->obtenerPolizasPorIdProductoYIdAgencia($idProducto, $idAgencia);
		$polizasViejasConFechaMayorAPolizaNueva = $polizaDbTable->obtenerPolizasConFechaFinalMayorAInicialNueva($idAgencia, $idProducto, $fechaInicialNuevaPoliza);
		
		//echo "<pre>".print_r($polizasViejasConFechaMayorAPolizaNueva,true)."</pre>";die;
		
		if(count($polizasViejasConFechaMayorAPolizaNueva) == 0)
		{
			$polizaValida = true;
		}
		else
		{
			$dateTimeInicialNueva = new DateTime($fechaInicialNuevaPoliza);
			$dateTimeFinalNueva = new DateTime($fechaFinalNuevaPoliza);
			$primerPoliza = $polizas[0];
			$fecha_fin = new DateTime($primerPoliza['fecha_fin']);
			if(count($polizas) == 1)
			{
				if($dateTimeInicialNueva > $fecha_fin)
				{
					$polizaValida = true;
				}
				else
				{
					$polizaValida = false;
				}
			}
			else 
			{
				unset($polizas[0]);
				$diferenciaPolizaNueva = $dateTimeInicialNueva->diff($dateTimeFinalNueva);
				$diferenciaPolizaNuevaFormat = $diferenciaPolizaNueva->format('%R%a');
				$ultimaPoliza = end($polizas);
				$dateTimeInicialUltima = new DateTime($ultimaPoliza['fecha_ini']);
				$dateTimeFinalUltima = new DateTime($ultimaPoliza['fecha_fin']);
				reset($polizas);
				foreach ($polizas as $poliza)
				{
					$fecha_inicio = new DateTime($poliza['fecha_ini']);
					$diferenciaPolizasViejas = $fecha_fin->diff($fecha_inicio);
					$diferenciaPolizasViejasFormat = $diferenciaPolizasViejas->format('%R%a');
					if($diferenciaPolizasViejas > $diferenciaPolizaNuevaFormat &&
							$dateTimeInicialNueva > $fecha_fin &&
							$dateTimeFinalNueva < $fecha_inicio)
					{
						$polizaValida = true;
					}
					$fecha_fin = new DateTime($poliza['fecha_fin']);
					if($polizaValida == false && $poliza['id_poliza'] == $ultimaPoliza['id_poliza']
						&& $fecha_fin < $dateTimeInicialNueva)
					{
						$polizaValida = true;
					}
				}
			}
		}

		if ($tipo == 'G' || $tipo == 'X'){
			$poliza = new Application_Model_DbTable_Poliza();
			
			$values = array('id_agencia' => $idAgencia , 'id_producto' => $idProducto, 'tipo' => $tipo );
			$pruebaPoliza = $poliza->obtienePolizaConGarantiaPorProducto($values);
			
			if ( count( $pruebaPoliza) > 0) {
				$polizaValida = FALSE;
			}
			
			$errorDesc = 'Ya cuenta con una garantía previamente registrada.';
			
		}

		$estatus = array(
			'valida' => $polizaValida,
			'errorDesc' => $errorDesc,
		);
		
		return $estatus;
	}
	
	function obtenerV1DeClavePoliza($idProducto, $id_agencia)
	{
		//Obteniendo nombre del producto
		$productoDbTable = new Application_Model_DbTable_Producto();
		$producto = $productoDbTable->obtenerProductoPorId($idProducto);
		$nombreProducto = substr($producto['clave'], 0, 3);
		
		//Obteniendo rfc de la agencia
		$agenciaDbTable = new Application_Model_DbTable_Agencia();
		$agencia = $agenciaDbTable->obtenerAgenciaPorId($id_agencia);
		$rfcAgencia = substr($agencia['rfc'], 0, 4);
		
		//Creando la primera versión de la clave que se compone de las tres primeras letras del producto,
		//las cuatro primeras letras del rfc de la agencia
		$v1ClavePoliza = $nombreProducto.$rfcAgencia;
		return $v1ClavePoliza;
	}
	
	function restarMinutosAPoliza($idPoliza, $minutos)
	{
		$polizaDbTable = new Application_Model_DbTable_Poliza();
		$poliza = $polizaDbTable->obtenerPolizaPorId($idPoliza);
		if($poliza != null)
		{
			$minutosConvertidos = $minutos/60;
			$poliza['horas_consumidas'] += $minutosConvertidos;
			$diferenciaHoras = $poliza['horas_poliza'] - $minutosConvertidos;
			if($diferenciaHoras < 0)
			{
				$poliza['tiempo_agotado'] = 'S';
			}
    		$where = "id_poliza = ".$idPoliza;
			$polizaDbTable->update($poliza, $where);
		}
	}
	
	public function actualizaProductosPorPoliza($params){
		
		$date = new Zend_Date();

	//	$fecha_ini = new Zend_Date($params['fecha_ini'],Zend_Date::ISO_8601);
	//	$fecha_fin = new Zend_Date($params['fecha_fin'],Zend_Date::ISO_8601);
		
/*		echo $date.'<hr>';
		echo $fecha_ini.'<hr>';
		echo $fecha_fin.'<hr>';
		
		echo $fecha_ini->compare($date).'<hr>';
		echo $fecha_fin->compare($date).'<hr>';
	*/	
	//	if ( !($fecha_ini->compare($date) == -1 && $fecha_fin->compare($date)==1) ) {
		
			$modelProductoTipoPoliza = new Application_Model_DbTable_ProductoTipoPoliza();
			
			$productos = $modelProductoTipoPoliza->obtenerProductoTiposPoliza($params['tipo']);
			
			$modelAgenciaProducto = new Application_Model_DbTable_AgenciaProducto();

			$productoTipoPoliza = new Application_Model_DbTable_ProductoTipoPoliza();
			$productosTipo = $productoTipoPoliza->obtenerProductos();
			
			foreach ( $productosTipo as $idProducto ) {
				$dataProductos = array('estatus'=>'N');
				$where = 'id_agencia='.$params['id_agencia']. ' and id_producto='.$idProducto['id_producto'];
				$modelAgenciaProducto->update($dataProductos, $where);
			}
			
			foreach ($productos as $value){
				$dataProductos = array();
				$exist=0;
				$where = "id_agencia={$params['id_agencia']} and id_producto={$value['id_producto']}";
				$agenciaProducto = $modelAgenciaProducto->fetchAll($where)->toArray();
				//echo "<pre>".print_r($agenciaProducto,true)."</pre>";die;
				 
				if (count($agenciaProducto)==0) {
					$dataProductos = array(
							'id_agencia' => $params['id_agencia'],
							'id_producto' => $value['id_producto'],
							'numero_licencias' => 0,
							'estatus' => 'S',
					);
					$modelAgenciaProducto->insert($dataProductos);
				} else {
					$dataProductos = array(
							'estatus' => 'S',
					);
					$where = "id_agencia={$params['id_agencia']} and id_producto={$value['id_producto']}";
					$modelAgenciaProducto->update($dataProductos, $where);
				}
			}
		//}
	}
	
}