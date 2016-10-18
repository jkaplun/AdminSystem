<?php
class Application_Model_Services_ServicesPolizas
{
	function esPolizaValida($idProducto, $idAgencia, $fechaInicialNuevaPoliza, $fechaFinalNuevaPoliza)
	{
		$poliza = new Application_Model_DbTable_Poliza();
		$polizasVigentes = $poliza->obtenerPolizaPorIdProductoYIdAgencia($idProducto, $idAgencia);
		$dateInicialNuevaPoliza = new DateTime($fechaInicialNuevaPoliza);
		$dateFinalNuevaPoliza = new DateTime($fechaFinalNuevaPoliza);
		$esPolizaValida = false;
		//var_dump(count($polizasVigentes));
		if(count($polizasVigentes) > 0)
		{
			foreach ($polizasVigentes as $poliza)
			{
				$dateFinalPolizaActual = new DateTime($poliza['fecha_fin']);
				if($dateInicialNuevaPoliza > $dateFinalPolizaActual)
				{
					$esPolizaValida = true;
				}
				else
				{
					$dateInicialPolizaActual = new DateTime($poliza['fecha_ini']);
					$difFechasDePolizasAnteriores = 0;
					if(key($polizasVigentes) == 0)
					{
						$indicePolizaAnterior = 1;
						$difFechasDePolizasAnteriores = 0;
					}
					else 
					{
						$indicePolizaAnterior = (key($polizasVigentes))-1;
						$polizaAnterior = $polizasVigentes[$indicePolizaAnterior];
						$dateFinalPolizaAnterior = new DateTime($polizaAnterior['fecha_fin']);
						$difFechasDePolizasAnteriores = $dateFinalPolizaAnterior ->diff($dateInicialPolizaActual, false);
						
					}
					$difFechasDePolizaNueva = $dateInicialNuevaPoliza -> diff($dateFinalNuevaPoliza, false);
					if((array)$difFechasDePolizasAnteriores >= (array)$difFechasDePolizaNueva 
							&& $dateInicialNuevaPoliza != $dateInicialPolizaActual
							&& $dateFinalNuevaPoliza != $dateFinalPolizaActual)
					{
						return true;
					}
					else
					{
						return false;
					}
				}
			}
		}
		else
		{
			$esPolizaValida = true;
		}
		return $esPolizaValida;
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
	
	
	
	
	
	
	
	
}