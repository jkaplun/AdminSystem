<?php
class Application_Model_Services_ServicesPolizas
{
	function esPolizaValida($idProducto, $idAgencia, $fechaInicialNuevaPoliza, $fechaFinalNuevaPoliza)
	{
		$polizaValida = false;
		$polizaDbTable = new Application_Model_DbTable_Poliza();
		$polizas = $polizaDbTable->obtenerPolizasPorIdProductoYIdAgencia($idProducto, $idAgencia);
		$polizasViejasConFechaMayorAPolizaNueva = $polizaDbTable->obtenerPolizasConFechaFinalMayorAInicialNueva($id_agencia, $id_producto, $fechaInicialNuevaPoliza);
		if(count($polizasViejasConFechaMayorAPolizaNueva) == 0)
		{
			$polizaValida = true;
		}
		else
		{
			$fecha_fin = new DateTime($polizas['fecha_fin']);
			unset($polizas[0]);
			$dateTimeInicialNueva = new DateTime($fechaInicialNuevaPoliza);
			$dateTimeFinalNueva = new DateTime($fechaFinalNuevaPoliza);
			$diferenciaPolizaNueva = $dateTimeInicialNueva->diff($dateTimeFinalNueva);
			foreach ($polizas as $poliza)
			{
				$fecha_inicio = new DateTime($polizas['fecha_ini']);
				$diferenciaPolizasViejas = $fecha_fin->diff($fecha_inicio);
				$fecha_fin = new DateTime($polizas['fecha_fin']);
				if($diferenciaPolizasViejas > $diferenciaPolizaNueva &&
					$fechaInicialNuevaPoliza > $fecha_fin && 
					$fechaFinalNuevaPoliza < $fecha_inicio)
				{
					$polizaValida = true;
				}
			}
		}
		
		return $polizaValida;
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
		$poliza = $polizaDbTable->obtenerPolizaPorId($id_poliza);
		if($poliza != null)
		{
			$poliza['horas_consumidas'] += $minutos;
			$diferenciaHoras = $poliza['horas_poliza'] - $minutos;
			if($diferenciaHoras < 0)
			{
				$poliza['tiempo_agotado'] = 'S';
			}
			$polizaDbTable->update($poliza);
		}
	}
	
	
	
	
	
	
	
	
}