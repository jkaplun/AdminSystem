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
				$dateFinalPoliza = new DateTime($poliza['fecha_fin']);
				if($dateInicialNuevaPoliza > $dateFinalPoliza)
				{
					$esPolizaValida = true;
				}
				else
				{
					$dateInicialPolizaActual = new DateTime($poliza['fecha_ini']);
					$indicePolizaAnterior = (key($polizasVigentes))-2;
					$polizaAnterior = $polizasVigentes[$indicePolizaAnterior];
					$dateFinalPolizaAnterior = new DateTime($polizaAnterior['fecha_fin']);
					$difFechasDePolizasAnteriores = $dateFinalPolizaAnterior ->diff($dateInicialPolizaActual, false);
					$difFechasDePolizaNueva = $dateInicialNuevaPoliza -> diff($dateFinalNuevaPoliza, false);
					if((array)$difFechasDePolizasAnteriores >= (array)$difFechasDePolizaNueva)
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