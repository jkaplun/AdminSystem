<?php
class Application_Model_Services_ServicesPolizas
{
	function esPolizaValida($idProducto, $idAgencia, $fechaInicialNuevaPoliza, $fechaFinalNuevaPoliza)
	{
		$polizaValida = false;
		$polizaDbTable = new Application_Model_DbTable_Poliza();
		$polizas = $polizaDbTable->obtenerPolizasPorIdProductoYIdAgencia($idProducto, $idAgencia);
		$polizasViejasConFechaMayorAPolizaNueva = $polizaDbTable->obtenerPolizasConFechaFinalMayorAInicialNueva($idAgencia, $idProducto, $fechaInicialNuevaPoliza);
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
		$poliza = $polizaDbTable->obtenerPolizaPorId($idPoliza);
		if($poliza != null)
		{
			$poliza['horas_consumidas'] += $minutos;
			$diferenciaHoras = $poliza['horas_poliza'] - $minutos;
			if($diferenciaHoras < 0)
			{
				$poliza['tiempo_agotado'] = 'S';
			}
    		$where = "id_poliza = ".$idPoliza;
			$polizaDbTable->update($poliza, $where);
		}
	}
	
	
	
	
	
	
	
	
}