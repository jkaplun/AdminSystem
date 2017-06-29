<?php
/**
 * 
 * @author jgarfias
 *
 */
class Application_Model_DbTable_StoredProcedures extends Zend_Db_Table_Abstract{

	protected $_name = 'sp_';

	/**
	 * Get Compilation values for ICAAV
	 * @param
	 * @return 	array	$result
	 * @author Garfias
	 * Created July 16, 2015
	 */
	public function getCompilationValues($compilationName){
		try{
			$clientData = '';
			
			$sql = "CALL sp_datos_compilacion_icaav('{$compilationName['client_user']}','{$compilationName['client_pasw']}')";
			//$stmt = new Zend_Db_Statement_Sqlsrv($this->_db, $sql);
			$stmt = $this->_db->prepare($sql);
			
			$stmt->execute();
			$result = $stmt->fetchAll();

			return  $result;
		} catch(Exception $e){
			return  array('Error'=>$e);
			//return 0;
		}
	}

	/**
	 * Add Used Folios from Icaav
	 * @param
	 * @return 	array	$result
	 * @author Garfias
	 * Created February 4, 2016
	 */
	public function AddUsedFolios($values){
		try{
			$sql = "CALL sp_i_folios_cte('{$values['rfc']}', '{$values['numFolios']}', '{$values['fecha']}','{$values['foliosTimbrados']}', @resultadoOUT)";
			//$stmt = new Zend_Db_Statement_Sqlsrv($this->_db, $sql);
			$stmt = $this->_db->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll();
			return  $result;
		} catch(Exception $e){
			//return  array('Error'=>$e);
			return 0;
		}
	}
	
	/**
	 * Get Available Folios for ICAAV
	 * @param
	 * @return 	array	$result
	 * @author Garfias
	 * Created July 16, 2015
	 */
	public function getAvailableFolios($rfcClient){
		try{
			$clientData = '';
			
			// Execute a SQLSRV statment
			//$sql = '{call select_agencias_portalMIG()}';
			$sql = "CALL select_folios_cte ('".$rfcClient."')";
			//EXEC  @return_value = [dbo].[select_agencias_portalMIG]
			//$stmt = new Zend_Db_Statement_Sqlsrv($this->_db, $sql);
			$stmt = $this->_db->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll();
			
			return  $result;
		} catch(Exception $e){
			echo $e;
		}
	}
	
	
	/**
	 * Verify Folios Per Month from 'Admin'
	 * @param
	 * @return 	array	$result
	 * @author Garfias
	 * Created February 5, 2016
	 */
	public function FoliosPerMonth($values){
		try{
			$sql = "CALL sp_c_verificacion_folios_rango_fecha('{$values['rfc']}','{$values['DateFrom']}','{$values['DateTo']}')";
			//$stmt = new Zend_Db_Statement_Sqlsrv($this->_db, $sql);
			$stmt = $this->_db->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll();
			return  $result;
		} catch(Exception $e){
			//return  array('Error'=>$e);
			return 0;
		}
	}
	
	
	/**
	 * Sync folios used from ICAAV
	 * @param
	 * @return 	array	$result
	 * @author Garfias
	 * Created July 16, 2015
	 */
	public function SyncFoliosFromIcaav($values){
		try{
			$clientData = '';
			
			// Execute a SQLSRV statment
			$sql = "CALL update_folios_utilizados('".$values['rfc']."',".$values['folios_utilizados'].")";

			//$stmt = new Zend_Db_Statement_Sqlsrv($this->_db, $sql);
			$stmt = $this->_db->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll();

			return  $result;
		} catch(Exception $e){
			echo $e;
		}
	}
	
	
	/**
	 * Verify Used Folios from 'Admin'
	 * @param
	 * @return 	array	$result
	 * @author Garfias
	 * Created February 5, 2016
	 */
	public function VerifyFolios($values){
		try{
			$sql = "call sp_c_verifica_folios('{$values['rfc']}')";
			//$stmt = new Zend_Db_Statement_Sqlsrv($this->_db, $sql);
			$stmt = $this->_db->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll();
			return  $result;
		} catch(Exception $e){
			//return  array('Error'=>$e);
			return 0;
		}
	}
}

