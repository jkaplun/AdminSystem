<?php
// located at application/forms/Usuarios/Usuarios.php
 
class Application_Form_Agencias_Agencias extends Zend_Form
{
    public function init()
    {
        // Clave
        $clave = new Zend_Form_Element_Text('clave');
        $clave->setRequired(true)
        ->addErrorMessage("- Es necesario que introduzca la clave de la agencia.")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Clave de agencia"))
        ->setAttrib("maxlength","15")
        ;
        $this->setMethod('post')->addElement($clave);
        
        // Nombre
        $nombre = new Zend_Form_Element_Text('nombre');
        $nombre->setRequired(true)
        ->addErrorMessage("- Es necesario que introduzca el nombre.")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Nombre"))
        ->setAttrib("maxlength","225")
        ;
        $this->setMethod('post')->addElement($nombre);
        
        // Direcci�n
        $direccion = new Zend_Form_Element_Text('direccion');
        $direccion->setRequired(true)
        ->addErrorMessage("- Es necesario que introduzca la direcci�n.")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Direcci�n"))
        ->setAttrib("maxlength","120")
        ;
        $this->setMethod('post')->addElement($direccion);
        
        // Colonia
        $colonia = new Zend_Form_Element_Text('colonia');
        $colonia->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Colonia"))
        ->setAttrib("maxlength","100")
        ;
        $this->setMethod('post')->addElement($colonia);
        
        // C.P.
        $cp = new Zend_Form_Element_Text('cp');
        $cp->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("C�digo postal"))
        ->setAttrib("maxlength","20")
        ;
        $this->setMethod('post')->addElement($cp);
        
        // Clave ciudad
        $clave_ciudad = new Zend_Form_Element_Text('clave_ciudad');
        $clave_ciudad->setRequired(true)
        ->addErrorMessage("- Es necesario que introduzca la clave de la ciudad")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Clave de ciudad"))
        ->setAttrib("maxlength","10")
        ;
        $this->setMethod('post')->addElement($clave_ciudad);
        
        // Tel�fono 1
        $tel1 = new Zend_Form_Element_Text('tel1');
        $tel1->setRequired(true)
        ->addErrorMessage("- Es necesario que introduzca el tel�fono 1")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Tel�fono 1"))
        ->setAttrib("maxlength","20")
        ;
        $this->setMethod('post')->addElement($tel1);
        
        // Tel�fono 2
        $tel2 = new Zend_Form_Element_Text('tel2');
        $tel2->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Tel�fono 2"))
        ->setAttrib("maxlength","20")
        ;
        $this->setMethod('post')->addElement($tel2);
        
        // Rfc
        $rfc = new Zend_Form_Element_Text('rfc');
        $rfc->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("R.F.C."))
        ->setAttrib("maxlength","20")
        ;
        $this->setMethod('post')->addElement($rfc);
        
        // Email
        $email = new Zend_Form_Element_Text('email');
        $email->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Email"))
        ->setAttrib("maxlength","100")
        ;
        $this->setMethod('post')->addElement($email);
        
        // HTTP
        $http = new Zend_Form_Element_Text('http');
        $http->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("HTTP"))
        ->setAttrib("maxlength","100")
        ;
        $this->setMethod('post')->addElement($http);
        
        // Licencia ICAAVWIN
        $lic_icaavwin = new Zend_Form_Element_Text('lic_icaavwin');
        $lic_icaavwin->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("ICAAVWIN"))
        ->setAttrib("maxlength","11")
        ;
        $this->setMethod('post')->addElement($lic_icaavwin);
        
        // Licencia IRISWIN
        $lic_iriswin = new Zend_Form_Element_Text('lic_iriswin');
        $lic_iriswin->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("IRISWIN"))
        ->setAttrib("maxlength","11")
        ;
        $this->setMethod('post')->addElement($lic_iriswin);
        
        // Licencia GVC
        $lic_gvc = new Zend_Form_Element_Text('lic_gvc');
        $lic_gvc->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("GVC"))
        ->setAttrib("maxlength","11")
        ;
        $this->setMethod('post')->addElement($lic_gvc);
        
        // Licencia Centauro
        $lic_centauro = new Zend_Form_Element_Text('lic_centauro');
        $lic_centauro->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Centauro"))
        ->setAttrib("maxlength","11")
        ;
        $this->setMethod('post')->addElement($lic_centauro);
        
        // Versi�n ICAAV
        $version_icaav = new Zend_Form_Element_Text('version_icaav');
        $version_icaav->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Versi�n ICAAV"))
        ->setAttrib("maxlength","10")
        ;
        $this->setMethod('post')->addElement($version_icaav);
        
        // Seguridad
        $seguridad = new Zend_Form_Element_Select('seguridad');
        $seguridad->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->setMethod('post')->addElement($seguridad);
        
        // Factura electr�nica
        $factura_electronica = new Zend_Form_Element_Select('factura_electronica');
        $factura_electronica->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->setMethod('post')->addElement($factura_electronica);
        
        // Fe activa
        $fe_activa = new Zend_Form_Element_Select('fe_activa');
        $fe_activa->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->setMethod('post')->addElement($fe_activa);
        
        // CFDI
        $cfdi = new Zend_Form_Element_Select('cfdi');
        $cfdi->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->setMethod('post')->addElement($cfdi);
        
        // FTP login
        $ftp_login = new Zend_Form_Element_Text('ftp_login');
        $ftp_login->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("FTP login"))
        ->setAttrib("maxlength","15")
        ;
        $this->setMethod('post')->addElement($ftp_login);
        
        // FTP pwd
        $ftp_pwd = new Zend_Form_Element_Text('ftp_pwd');
        $ftp_pwd->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("FTP password"))
        ->setAttrib("maxlength","15")
        ;
        $this->setMethod('post')->addElement($ftp_pwd);
        
        // DBA pwd
        $dba_pwd = new Zend_Form_Element_Text('dba_pwd');
        $dba_pwd->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("DBA password"))
        ->setAttrib("maxlength","15")
        ;
        $this->setMethod('post')->addElement($dba_pwd);
        
        // Layout login
        $layout_login = new Zend_Form_Element_Text('layout_login');
        $layout_login->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Layout login"))
        ->setAttrib("maxlength","15")
        ;
        $this->setMethod('post')->addElement($layout_login);
        
        // Layout password
        $layout_pwd = new Zend_Form_Element_Text('layout_pwd');
        $layout_pwd->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Layout password"))
        ->setAttrib("maxlength","15")
        ;
        $this->setMethod('post')->addElement($layout_pwd);
        
        // Tamara
        $tamara = new Zend_Form_Element_Select('tamara');
        $tamara->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->setMethod('post')->addElement($tamara);
        
        // IBANK
        $ibank = new Zend_Form_Element_Select('ibank');
        $ibank->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->setMethod('post')->addElement($ibank);
        
        // AMEX
        $amex = new Zend_Form_Element_Select('amex');
        $amex->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->setMethod('post')->addElement($amex);
        
        // DIOT
        $diot = new Zend_Form_Element_Select('diot');
        $diot->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->setMethod('post')->addElement($diot);
        // cve_usopor_tit
        $cve_usopor_tit = new Zend_Form_Element_Text('cve_usopor_tit');
        $cve_usopor_tit->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Clave soporte titular"))
        ->setAttrib("maxlength","15")
        ;
        $this->setMethod('post')->addElement($cve_usopor_tit);
        
        // cve_usopor_aux
        $cve_usopor_aux = new Zend_Form_Element_Text('cve_usopor_aux');
        $cve_usopor_aux->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Clave soporte auxiliar"))
        ->setAttrib("maxlength","15")
        ;
        $this->setMethod('post')->addElement($cve_usopor_aux);
        
        // id_estatus_icaav
        $id_estatus_icaav = new Zend_Form_Element_Select('id_estatus_icaav');
        $id_estatus_icaav->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->setMethod('post')->addElement($id_estatus_icaav);
        
        // id_estatus_iris
        $id_estatus_iris = new Zend_Form_Element_Select('id_estatus_iris');
        $id_estatus_iris->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->setMethod('post')->addElement($id_estatus_iris);
        
        // Fecha
        $fecha = new Zend_Form_Element_Text('fecha');
        $fecha->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->removeDecorator('Errors')
        ->setAttrib("autocomplete","off")
        ->setAttrib("class","form-control datepicker")
        ->setAttrib("placeholder",utf8_encode("yyyy-mm-dd"))
        ->setAttrib("maxlength","10")
        ;
        $this->setMethod('post')->addElement($fecha);
        
        // Observaciones
        $observaciones = new Zend_Form_Element_Textarea('observaciones');
        $observaciones->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Obervaciones"))
        ;
        $this->setMethod('post')->addElement($observaciones);
        
        // Sucursales
        $sucursales = new Zend_Form_Element_Text('sucursales');
        $sucursales->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Sucursales"))
        ->setAttrib("maxlength","11")
        ;
        $this->setMethod('post')->addElement($sucursales);
        
        // Adeudo
        $adeudo = new Zend_Form_Element_Select('adeudo');
        $adeudo->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->setMethod('post')->addElement($adeudo);
        
        // Boleto e
        $boleto_e = new Zend_Form_Element_Select('boleto_e');
        $boleto_e->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->setMethod('post')->addElement($boleto_e);
        
        // Update login
        $update_login = new Zend_Form_Element_Text('update_login');
        $update_login->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Update login"))
        ->setAttrib("maxlength","50")
        ;
        $this->setMethod('post')->addElement($update_login);
        
        // Update password
        $update_pwd = new Zend_Form_Element_Text('update_pwd');
        $update_pwd->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Update password"))
        ->setAttrib("maxlength","50")
        ;
        $this->setMethod('post')->addElement($update_pwd);
        
        // Activa nuevos sp
        $activa_nuevos_sp = new Zend_Form_Element_Select('activa_nuevos_sp');
        $activa_nuevos_sp->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->setMethod('post')->addElement($activa_nuevos_sp);
        
        // ADDENDA
        $addenda = new Zend_Form_Element_Select('addenda');
        $addenda->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->setMethod('post')->addElement($addenda);
        
        // Fecha de caducidad
        $fecha_caducidad = new Zend_Form_Element_Text('fecha_caducidad');
        $fecha_caducidad->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->removeDecorator('Errors')
        ->setAttrib("autocomplete","off")
        ->setAttrib("class","form-control datepicker")
        ->setAttrib("placeholder",utf8_encode("yyyy-mm-dd"))
        ->setAttrib("maxlength","10")
        ;
        $this->setMethod('post')->addElement($fecha_caducidad);
        
        // ftp_add_login
        $ftp_add_login = new Zend_Form_Element_Text('ftp_add_login');
        $ftp_add_login->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("FTP add login"))
        ->setAttrib("maxlength","255")
        ;
        $this->setMethod('post')->addElement($ftp_add_login);
        
        // ftp_add_pwd
        $ftp_add_pwd = new Zend_Form_Element_Text('ftp_add_pwd');
        $ftp_add_pwd->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("FTP add password"))
        ->setAttrib("maxlength","255")
        ;
        $this->setMethod('post')->addElement($ftp_add_pwd);
        
        // ip_portal_fe
        $ip_portal_fe = new Zend_Form_Element_Text('ip_portal_fe');
        $ip_portal_fe->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("IP portal fe"))
        ->setAttrib("maxlength","255")
        ;
        $this->setMethod('post')->addElement($ip_portal_fe);
        
        // prov_timbrado
        $prov_timbrado = new Zend_Form_Element_Select('prov_timbrado');
        $prov_timbrado->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->setMethod('post')->addElement($prov_timbrado);
        
        // facturacion_boleto
        $facturacion_boleto = new Zend_Form_Element_Text('facturacion_boleto');
        $facturacion_boleto->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Facturaci�n boleto"))
        ->setAttrib("maxlength","11")
        ;
        $this->setMethod('post')->addElement($facturacion_boleto);
        
        // implant_am
        $implant_am = new Zend_Form_Element_Select('implant_am');
        $implant_am->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->setMethod('post')->addElement($implant_am);
        
        // folios_utilizados
        $folios_utilizados = new Zend_Form_Element_Text('folios_utilizados');
        $folios_utilizados->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Folios utilizados"))
        ->setAttrib("maxlength","11")
        ;
        $this->setMethod('post')->addElement($folios_utilizados);
        
        // folios_sync
        $folios_sync = new Zend_Form_Element_Select('folios_sync');
        $folios_sync->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->setMethod('post')->addElement($folios_sync);
        
        // nombre_comercial
        $nombre_comercial = new Zend_Form_Element_Text('nombre_comercial');
        $nombre_comercial->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ->setAttrib("placeholder",utf8_encode("Nombre comercial"))
        ->setAttrib("maxlength","255")
        ;
        $this->setMethod('post')->addElement($nombre_comercial); 
        
        // markup
        $markup = new Zend_Form_Element_Select('markup');
        $markup->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->setMethod('post')->addElement($markup); 
        
        // portal_proveedores
        $portal_proveedores = new Zend_Form_Element_Select('portal_proveedores');
        $portal_proveedores->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->setMethod('post')->addElement($portal_proveedores);  
        
        // agencias_consolidadas
        $agencias_consolidadas = new Zend_Form_Element_Select('agencias_consolidadas');
        $agencias_consolidadas->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->setMethod('post')->addElement($agencias_consolidadas);  
        
        // contabilidad_elect
        $contabilidad_elect = new Zend_Form_Element_Select('contabilidad_elect');
        $contabilidad_elect->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->setMethod('post')->addElement($contabilidad_elect);    
        
        // fecha_actualizacion_folios
        $fecha_actualizacion_folios = new Zend_Form_Element_Text('fecha_actualizacion_folios');
        $fecha_actualizacion_folios->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->removeDecorator('Errors')
        ->setAttrib("autocomplete","off")
        ->setAttrib("class","form-control datepicker")
        ->setAttrib("placeholder",utf8_encode("yyyy-mm-dd"))
        ->setAttrib("maxlength","10")
        ;
        $this->setMethod('post')->addElement($fecha_actualizacion_folios);    
        
        // ine
        $ine = new Zend_Form_Element_Select('ine');
        $ine->setRequired(true)
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->addMultiOptions(array(
                'S'=>'Activo',
                'N'=>'Inactivo'
        ))
        ->setAttrib("class","form-control")
        ->setAttrib("autocomplete","off")
        ;
        $this->setMethod('post')->addElement($ine);       
        
        // Submit
        $submit = new Zend_Form_Element_Submit('submit');
        $submit ->setLabel("Iniciar")
        ->setAttrib("class","btn btn-lg btn-success btn-block")
        ->removeDecorator('label')
        ->removeDecorator('HtmlTag')
        ->removeDecorator('Errors')
        ;
        $id_agencia = new Zend_Form_Element_Hidden('id_agencia');
        
        $this
        ->setMethod('post')
        ->addElements(array(
                $clave, $password, $password_conf, $nombre, $apellido_paterno, 
                $apellido_materno, $puesto, $email, $admin, 
                $supervisor, $folios, $compila, $activo, $id_usuario, $submit
                ));
        }
}