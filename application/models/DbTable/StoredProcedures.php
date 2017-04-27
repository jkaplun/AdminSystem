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
			
			$sql = "call sp_datos_compilacion_icaav('{$compilationName['client_user']}','{$compilationName['client_pasw']}')";
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

