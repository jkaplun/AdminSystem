<?php
// located at application/forms/Usuarios/Usuarios.php
 
class Application_Form_Agencias_Agencias extends Zend_Form
{
    public function init()
    {
    	
    	// id_agencia
    	$id_agencia = new Zend_Form_Element_Hidden('id_agencia');
    	$this->addElement($id_agencia);
    	
        // Clave
        $clave = new Zend_Form_Element_Text('clave');
        $clave->setRequired(true)
        ->addErrorMessage("- Es necesario que introduzca la clave de la agencia.")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Clave de agencia"))
        ->setAttrib("maxlength","15")
        ;
        $this->addElement($clave);
        
        // Nombre
        $nombre = new Zend_Form_Element_Text('nombre');
        $nombre->setRequired(true)
        ->addErrorMessage("- Es necesario que introduzca el nombre.")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Nombre"))
        ->setAttrib("maxlength","255")
        ;
        $this->addElement($nombre);
        
        // Direcci�n
        $direccion = new Zend_Form_Element_Text('direccion');
        $direccion->setRequired(true)
        ->addErrorMessage("- Es necesario que introduzca la dirección.")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder","Dirección")
        ->setAttrib("maxlength","120")
        ;
        $this->addElement($direccion);
        
        // Colonia
        $colonia = new Zend_Form_Element_Text('colonia');
        $colonia->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Colonia"))
        ->setAttrib("maxlength","100")
        ;
        $this->addElement($colonia);
        
        // C.P.
        $cp = new Zend_Form_Element_Text('cp');
        $cp->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder","Código Postal")
        ->setAttrib("maxlength","10")
        ->setAttrib("minlength","10")
        ;
        $this->addElement($cp);
        
        // Clave ciudad
        $clave_ciudad = new Zend_Form_Element_Text('clave_ciudad');
        $clave_ciudad
        ->addErrorMessage("- Es necesario que introduzca la clave de la ciudad")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Clave de Ciudad"))
        ->setAttrib("maxlength","10")
        ;
        $this->addElement($clave_ciudad);
        
        // Tel�fono 1
        $tel1 = new Zend_Form_Element_Text('tel1');
        $tel1->setRequired(true)
        ->addErrorMessage("- Es necesario que introduzca el telefono 1")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder","Teléfono 1")
        ->setAttrib("maxlength","100")
        ->setAttrib("minlength","100")
        ;
        $this->addElement($tel1);
        
        // Tel�fono 2
        $tel2 = new Zend_Form_Element_Text('tel2');
        $tel2->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder","Teléfono 2")
        ->setAttrib("maxlength","100")
        ->setAttrib("minlength","100")
        ;
        $this->addElement($tel2);
        
        // Rfc
        $rfc = new Zend_Form_Element_Text('rfc');
        $rfc->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("R.F.C."))
        ->setAttrib("maxlength","20")
        ->setAttrib("minlength","20")
        ;
        $this->addElement($rfc);
        
        // Email
        $email = new Zend_Form_Element_Text('email');
        $email->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Email"))
        ->setAttrib("maxlength","100")
        ;
        $this->addElement($email);
        
        // Email alternativo
        $email_alt = new Zend_Form_Element_Text('email_alt');
        $email_alt
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Email"))
        ->setAttrib("maxlength","100")
        ;
        $this->addElement($email_alt);
        
        // HTTP
        $http = new Zend_Form_Element_Text('http');
        $http->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("HTTP"))
        ->setAttrib("maxlength","100")
        ;
        $this->addElement($http);
              
        // CFDI
        $cfdi = new Zend_Form_Element_Select('cfdi');
        $cfdi
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off");
        $this->addElement($cfdi);
        
        $fa = new Application_Model_DbTable_FoliosAgencia();
        $result_fa = $fa->obtenerTipoFolios();

        $options = array();
        
        foreach ( $result_fa as $value ){
        	$options[$value['id_folios_agencia_cat_tipo']] = $value['descripcion'];
        }
        
        // Tipo de folios
        $element = new Zend_Form_Element_Select('id_folios_agencia_cat_tipo');
        $element
	        ->setLabel("Tipo de Folios")
	        ->removeDecorator('HtmlTag')
	        ->addMultiOptions($options)
	        ->setAttrib("class","form-control input-sm")
	        ->setAttrib("autocomplete","off");
        $this->addElement($element);
        
        
        // DBA pwd
        $dba_pwd = new Zend_Form_Element_Text('dba_pwd');
        $dba_pwd->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("DBA Password"))
        ->setAttrib("maxlength","15")
        ;
        $this->addElement($dba_pwd);
        
        // Layout login
        $layout_login = new Zend_Form_Element_Text('layout_login');
        $layout_login->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Layout Login"))
        ->setAttrib("maxlength","15")
        ;
        $this->addElement($layout_login);
        
        // Layout password
        $layout_pwd = new Zend_Form_Element_Text('layout_pwd');
        $layout_pwd->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Layout Password"))
        ->setAttrib("maxlength","15")
        ;
        $this->addElement($layout_pwd);
        
        // Fecha
        $fecha = new Zend_Form_Element_Text('fecha');
        $fecha->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->removeDecorator('Errors')
        ->setAttrib("autocomplete","off")
        ->setAttrib("class","form-control input-sm datepicker")
        ->setAttrib("placeholder",utf8_encode("yyyy-mm-dd"))
        ->setAttrib("maxlength","10");
        $this->addElement($fecha);
        
        // Observaciones
        $observaciones = new Zend_Form_Element_Textarea('observaciones');
        $observaciones->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Observaciones"))
        ;
        $this->addElement($observaciones);
        
        // Sucursales
        $sucursales = new Zend_Form_Element_Text('sucursales');
        $sucursales->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Sucursales"))
        ->setAttrib("maxlength","11")
        ;
        $this->addElement($sucursales);
        
        // Update login
        $update_login = new Zend_Form_Element_Text('update_login');
        $update_login->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Update Login"))
        ->setAttrib("maxlength","50")
        ;
        $this->addElement($update_login);
        
        // Update password
        $update_pwd = new Zend_Form_Element_Text('update_pwd');
        $update_pwd->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Update Password"))
        ->setAttrib("maxlength","50")
        ;
        $this->addElement($update_pwd);

        
        // Update password
        $update_pwd_bd = new Zend_Form_Element_Text('update_pwd_bd');
        $update_pwd_bd ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Update Password BD"))
        ->setAttrib("maxlength","50")
        ;
        $this->addElement($update_pwd_bd);


        
        // Activa nuevos sp
        $activa_nuevos_sp = new Zend_Form_Element_Select('activa_nuevos_sp');
        $activa_nuevos_sp
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ;
        $this->addElement($activa_nuevos_sp);
        
        // ADDENDA
        $addenda = new Zend_Form_Element_Select('addenda');
        $addenda
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ;
        $this->addElement($addenda);
        
        // FTP login
        $ftp_add_login = new Zend_Form_Element_Text('ftp_add_login');
        $ftp_add_login->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("FTP Login"))
        ->setAttrib("maxlength","50")
        ;
        $this->addElement($ftp_add_login);
        
        // FTP password
        $ftp_add_pwd = new Zend_Form_Element_Text('ftp_add_pwd');
        $ftp_add_pwd->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("FTP Password"))
        ->setAttrib("maxlength","50")
        ;
        $this->addElement($update_pwd);
        
        // ip_portal_fe
        $ip_portal_fe = new Zend_Form_Element_Text('ip_portal_fe');
        $ip_portal_fe->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("IP Portal FE"))
        ->setAttrib("maxlength","255")
        ;
        $this->addElement($ip_portal_fe);
        
        // prov_timbrado
        $prov_timbrado = new Zend_Form_Element_Select('prov_timbrado');
        $prov_timbrado
        ->setLabel("Proveedor de Timbrado")
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'X'=>'EDX',
                'E'=>'Edicom',
        		'I'=>'Factura Inteligente',
        		'N'=>'No tiene',
        		''=>'Otro'
        ))
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ;
        $this->addElement($prov_timbrado);
        
        // facturacion_boleto
        $facturacion_boleto = new Zend_Form_Element_Text('facturacion_boleto');
        $facturacion_boleto->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder","Facturación boleto")
        ->setAttrib("maxlength","11")
        ;
        $this->addElement($facturacion_boleto);
        
        // nombre_comercial
        $nombre_comercial = new Zend_Form_Element_Text('nombre_comercial');
        $nombre_comercial->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Nombre Comercial"))
        ->setAttrib("maxlength","255")
        ;
        $this->addElement($nombre_comercial); 
        
        // markup
        $markup = new Zend_Form_Element_Select('markup');
        $markup
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ;
        $this->addElement($markup); 
        
        // agencias_consolidadas
        $agencias_consolidadas = new Zend_Form_Element_Select('agencias_consolidadas');
        $agencias_consolidadas
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ;
        $this->addElement($agencias_consolidadas);  

        // Submit
        $submit = new Zend_Form_Element_Submit('submit');
        $submit ->setLabel("Iniciar")
        ->setAttrib("class","btn btn-lg btn-success btn-block")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->removeDecorator('Errors')
        ;
        $id_agencia = new Zend_Form_Element_Hidden('id_agencia');
        
        // Observaciones
        $observaciones_agencia = new Zend_Form_Element_TextArea('observaciones_agencia');
        $observaciones_agencia
        ->setLabel("Observaciones del Cliente:")
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder","Observaciones de la Agencia")
        ->setAttrib("maxlength","50000")
        ->setAttrib("rows","10");
        $this->addElement($observaciones_agencia);
        
        
        // Observaciones
        $element = new Zend_Form_Element_TextArea('observaciones_internas');
        $element
        ->setLabel("Observaciones Internas (Para Uso del Area de Soporte):")
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder","Observaciones de la Agencia")
        ->setAttrib("maxlength","50000")
        ->setAttrib("rows","10");
        $this->addElement($element);
        
        

        
        $usuarioAdmin = new Application_Model_DbTable_UsuarioAdmin();
        $usuarios = $usuarioAdmin->obtenerUsuariosConfigAgencia();
        
        $arregloUsuariosSelect = array(''=> 'Sin Asignar');
        foreach ($usuarios as $key => $value){
        	$arregloUsuariosSelect[$value['id_usuario']] = $value['clave'] . ' - '.$value['nombre'] . ' '.$value['apellido_paterno'] . ' '.$value['apellido_materno'];
        }
        
        // Ejecutivo Titular
        $id_usuario_soporte_titular = new Zend_Form_Element_Select('id_usuario_soporte_titular');
        $id_usuario_soporte_titular
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions($arregloUsuariosSelect)
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ;
        $this->addElement($id_usuario_soporte_titular);
        
        // Ejecutivo Auxiliar
        $id_usuario_soporte_auxiliar = new Zend_Form_Element_Select('id_usuario_soporte_auxiliar');
        $id_usuario_soporte_auxiliar
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions($arregloUsuariosSelect)
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ;
        $this->addElement($id_usuario_soporte_auxiliar);
        
        // iata1
        $iatas1 = new Zend_Form_Element_Text('iatas1');
        $iatas1->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("IATA 1"))
        ->setAttrib("maxlength","255")
        ;
        $this->addElement($iatas1);


        // iata1
        $iatas2 = new Zend_Form_Element_Text('iatas2');
        $iatas2->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("IATA 2"))
        ->setAttrib("maxlength","255")
        ;
        $this->addElement($iatas2);


        // iata1
        $iatas3 = new Zend_Form_Element_Text('iatas3');
        $iatas3->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("IATA 3"))
        ->setAttrib("maxlength","255")
        ;
        $this->addElement($iatas3);


        // iata4
        $iatas4 = new Zend_Form_Element_Text('iatas4');
        $iatas4->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("IATA 4"))
        ->setAttrib("maxlength","255")
        ;
        $this->addElement($iatas4);


        // iata5
        $iatas5 = new Zend_Form_Element_Text('iatas5');
        $iatas5->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("IATA 5"))
        ->setAttrib("maxlength","255");
        $this->addElement($iatas5);
        
        // nombre_bd
        $element = new Zend_Form_Element_Text('nombre_bd');
        $element
      	->setLabel("Nombre de la BD")
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Nombre de la Base de Datos"))
        ->setAttrib("maxlength","45");
        $this->addElement($element);
        
        // host
        $element = new Zend_Form_Element_Text('host');
        $element
        ->setLabel("Host")
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("http://example.com"))
        ->setAttrib("maxlength","1000");
        $this->addElement($element);
        
        // puerto
        $element = new Zend_Form_Element_Text('puerto');
        $element
        ->setLabel("Puerto:")
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("5432"))
        ->setAttrib("maxlength","10");
        $this->addElement($element);
        
        // observaciones_conexion
        $element = new Zend_Form_Element_Textarea('observaciones_conexion');
        $element
        ->setLabel("Observaciones:")
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder","Observaciones")
        ->setAttrib("maxlength","1000")
        ->setAttrib("rows","4");
        $this->addElement($element);
        
        // data_source_name
        $element = new Zend_Form_Element_Text('data_source_name');
        $element
        ->setLabel("Data Source Name:")
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control input-sm")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder","Data Source Name")
        ->setAttrib("maxlength","1000");
        $this->addElement($element);
        
        
        
        $producto = new Application_Model_DbTable_Producto();
        $resultados = $producto->obtenerProductos();
        $lista = array();
        foreach ( $resultados as $resultado){
        	$lista[$resultado['id_producto']]=$resultado['nombre_prod'];
        }
        
        // Producto
        $producto = new Zend_Form_Element_Select('id_producto_d_c');
        $producto->setAttribs ( array (
        	'autocomplete'=>'off'))
        	->addMultiOptions($lista)
        	->setAttrib("class","form-control")
        	->setLabel("Producto:")
        //	->setValue('producto1')
        	->removeDecorator('HtmlTag');
        
        $this->addElement($producto);
        
        }
}