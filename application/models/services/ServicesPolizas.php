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
	
	
	
	
	
	
	
	
}