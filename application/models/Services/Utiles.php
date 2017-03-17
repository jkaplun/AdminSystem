<?php
class Application_Model_Services_Utiles
{
	

	
	function comprobar_email($email)
	{
		$mail_correcto = false;
		//compruebo unas cosas primeras
		if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
			if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
				//miro si tiene caracter .
				if (substr_count($email,".")>= 1){
					//obtengo la terminacion del dominio
					$term_dom = substr(strrchr ($email, '.'),1);
					//compruebo que la terminaci�n del dominio sea correcta
					if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
						//compruebo que lo de antes del dominio sea correcto
						$antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
						$caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
						if ($caracter_ult != "@" && $caracter_ult != "."){
							$mail_correcto = true;
						}
					}
				}
			}
		}
		if ($mail_correcto)
			return true;
			else
				return false;
	}
	
	function validarRFC($rfc)
	{
		$regex = '/^(([a-z]{4})|([a-z]{3}))([0-9]{2})(1[0-2]|0[1-9])([0-3][0-9])([a-z0-9]{3})$/';
		$esRfcValido = preg_match($regex, $rfc);
		if($esRfcValido == 1)
		{
			return true;
		}
		return false;
	}
	
	function validarEmail($email)
	{
		$regex = '/^(([a-z]+)@{3})$/';
		$esRfcValido = preg_match($regex, $email);
		if($esRfcValido == 1)
		{
			return true;
		}
		return false;
	}
	
	
	
	public function consultarejecutivosporidService($params){
	
		$usuario_admin = new Application_Model_DbTable_UsuarioAdmin();
			
		
		$ejecutivoPrincipal = $usuario_admin->find($params['id_usuario_soporte_titular'])->toArray();
		$ejecutivoAuxiliar = $usuario_admin->find($params['id_usuario_soporte_auxiliar'])->toArray();
		
		$user = $usuario_admin->getSoporteUsers();
		
		$result = array_merge($ejecutivoPrincipal, $ejecutivoAuxiliar);
		
		//$result = array_merge($result, $user);
		
		$resultProcessed = array();
		
		foreach ( $user as $key => $value ){
			$resultProcessed[$value['id_usuario']] = $value;
		}
		
		return $resultProcessed;
	}	
	
	
	
}