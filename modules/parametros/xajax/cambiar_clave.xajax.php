<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/xajax/xajax_core/xajax.inc.php");
	include_once (dirname(dirname(__FILE__))."/dao/pa_usuarios.dao.php");
        include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/session.php");
	//-- IBRAC
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/permisos.php");
	//-- IBRAC
//	session_start();
	$xajax = new xajax();

	$xajax->registerFunction("preload"); //Carga las variables iniciales
	$xajax->registerFunction("save"); //Guarda los campos del formulario


	$xajax->registerFunction("readOnlyfiles");

	function preload(){
                verifySession();
		$objResponse = new xajaxResponse();
		$objResponse = loadUserLogged($objResponse);
		return $objResponse;
	}
        function loadUserLogged($objResponse){
		$pa_usuariosDAO = new pa_usuariosDAO();
		$pa_usuariosTO = $pa_usuariosDAO->selectByNamepa_usuarios($_SESSION[SESSION_USER]);
		$objResponse->assign("txt_usuario_id","value",$pa_usuariosTO->getUsuario_id());
		return $objResponse;
	}
	//-- IBRAC
	function loadPrivileges($objResponse,$ibrac = null, $mode = "TABLE"){
		if($ibrac == null)
			$ibrac = permisos::getIBRAC(__FILE__);
		//--Nuevo
		if(strlen(strpos($ibrac,"I"))==0)
                    $objResponse = visibilityButton("addbutton", "hidden", $objResponse);
                else
                    $objResponse = visibilityButton("addbutton", "visible", $objResponse);
		//--Buscar
		if(strlen(strpos($ibrac,"C"))!=0 && $mode == "TABLE")
                    $objResponse = visibilityButton("searchbutton", "visible", $objResponse);
                else
                    $objResponse = visibilityButton("searchbutton", "hidden", $objResponse);
                //--Editar
		if(strlen(strpos($ibrac,"A"))!=0 && $mode == "VIEW")
			$objResponse = visibilityButton("editbutton", "visible", $objResponse);
                else
                        $objResponse = visibilityButton("editbutton", "hidden", $objResponse);
		//--REPORTE
		if(strlen(strpos($ibrac,"R"))==0)
			$objResponse->includeCSS("../css\noprint.css","print");
		$objResponse->assign("ibrac","value",$ibrac);
		return $objResponse;
	}
	//-- IBRAC
	
	function save($aFormValues){
		$objResponse = new xajaxResponse();
		$valid = valid($aFormValues,$objResponse);
		try{
			if($valid){
				$objpa_usuariosDAO = new pa_usuariosDAO();
				$objpa_usuariosTO = new pa_usuariosTO();
				$objpa_usuariosTO->setUsuario_id($aFormValues['txt_usuario_id']);
                                $objpa_usuariosTO->setUsuario(md5($aFormValues['txt_password_actual'])); // Password actual
				$objpa_usuariosTO->setPassword(md5($aFormValues['txt_password']));

				$rows = $objpa_usuariosDAO->updatepa_usuariosCambio_Clave($objpa_usuariosTO);
				/**Terminar Session*/
                                if($rows > 0)
                                    $objResponse->script("window.top.location.href='".MY_URI."/logout.php'");
                                else
                                    $objResponse->script("alert('Clave actual incorrecta.')");
			}
		}catch(Exception $ex){
			$objResponse->script("alert('".$ex->getMessage()."')");
		}
		return $objResponse;
	}

	function valid($aFormValues,$objResponse){
		$valid = true;
		$objResponse = clearvalid($objResponse);
                        if(trim($aFormValues['txt_password_actual']) == ""){
				$objResponse->assign("valid_password","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_password']) == ""){
				$objResponse->assign("valid_password","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
                        if(trim($aFormValues['txt_password']) != trim($aFormValues['txt_password1'])){
				$objResponse->assign("valid_password","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
                                $objResponse->assign("valid_password1","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" /> Las claves no coinciden');
				$valid = false;
			}
			
		return $valid;
	}
	function clearvalid($objResponse){
		$objResponse->assign("valid_password1","innerHTML", "");
		$objResponse->assign("valid_password","innerHTML", "");
		return $objResponse;
	}

	$xajax->processRequest();

?>