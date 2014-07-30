<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/xajax/xajax_core/xajax.inc.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/parsedate.php");
	include_once (dirname(dirname(dirname(__FILE__)))."/parametros/dao/pa_usuarios.dao.php");
        include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/session.php");
	//-- IBRAC
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/permisos.php");
	//-- IBRAC
//	session_start();
	$xajax = new xajax();

	$xajax->registerFunction("preload"); //Carga las variables iniciales
	$xajax->registerFunction("loadfields"); //Carga los campos del formulario
	$xajax->registerFunction("viewfields"); //Muestra los campos del formulario
	$xajax->registerFunction("loadtable"); //Carga los campos de la tabla
	$xajax->registerFunction("save"); //Guarda los campos del formulario
	$xajax->registerFunction("add"); //Limpia los campos del formulario
	$xajax->registerFunction("remove"); //Elimina los campos del formulario (Registro)
	$xajax->registerFunction("valid"); //Valida los campos del formulario
	$xajax->registerFunction("searchfields"); //Busca los datos segun el criterio
	$xajax->registerFunction("cancel"); //cancela la edicion de los campos

	$xajax->registerFunction("readOnlyfiles");

	function preload(){
                $objResponse = new xajaxResponse();
                //-- VERIFICAR SESSION
                if(!isset($_SESSION[SESSION_USER])){
                    $objResponse = new xajaxResponse();
                    return $objResponse->redirect(MY_URL);
                }
                //--
		$objResponse = showPanel("fields", $objResponse);
//		$objResponse = loadUserLogged($objResponse);
		//-- IBRAC
//		$objResponse = loadPrivileges($objResponse);
		//-- IBRAC
                $objResponse = loadfields($objResponse);
		return $objResponse;
	}
	function loadUserLogged($objResponse){
		$pa_usuariosDAO = new pa_usuariosDAO();
		$pa_usuariosTO = $pa_usuariosDAO->selectByNamepa_usuarios($_SESSION[SESSION_USER]);
		$objResponse->assign("header_user_data","innerHTML",$pa_usuariosTO->getNombres()." ".$pa_usuariosTO->getApellidos());
		$objResponse->assign("header_date_data","innerHTML",date(APP_DATETIME_FORMAT));
		$objResponse->assign("header_title","innerHTML",COMPANY_NAME);
		return $objResponse;
	}
	//-- IBRAC
	function loadPrivileges($objResponse,$ibrac = null){
		if($ibrac == null)
			$ibrac = permisos::getIBRAC(__FILE__);
		//--Nuevo
		if(strlen(strpos($ibrac,"I"))==0)
                    $objResponse = visibilityButton("addbutton", "hidden", $objResponse);
                else
                    $objResponse = visibilityButton("addbutton", "visible", $objResponse);
		//--Buscar
		if(strlen(strpos($ibrac,"C"))==0)
                    $objResponse = visibilityButton("searchbutton", "hidden", $objResponse);
                else
                    $objResponse = visibilityButton("searchbutton", "visible", $objResponse);
                //--Editar
		if(strlen(strpos($ibrac,"A"))==0)
			$objResponse = visibilityButton("editbutton", "hidden", $objResponse);
                else
                        $objResponse = visibilityButton("editbutton", "visible", $objResponse);
		//--REPORTE
		if(strlen(strpos($ibrac,"R"))==0)
			$objResponse->includeCSS(MY_URI."/media/css\noprint.css","print");
		$objResponse->assign("ibrac","value",$ibrac);
		return $objResponse;
	}
	//-- IBRAC
	function loadfields($objResponse){
		$objResponse->assign("txt_DB_DSN","value",DB_DSN);
                $objResponse->assign("txt_DB_SERVER_USERNAME","value",DB_SERVER_USERNAME);
                $objResponse->assign("txt_DB_SERVER_PASSWORD","value",DB_SERVER_PASSWORD);
                $objResponse->assign("txt_DB_DATABASE","value",DB_DATABASE);
                $objResponse->assign("txt_DB_PORT","value",DB_PORT);
                $objResponse->assign("txt_SQL_LOG_PATH","value",SQL_LOG_PATH);
                $objResponse->assign("txt_TABLE_ROW_VIEW","value",TABLE_ROW_VIEW);
                $objResponse->assign("txt_TABLE_ROW_VIEW_LOGS","value",TABLE_ROW_VIEW_LOGS);
                $objResponse->assign("txt_ODBC_DEFAULTLRL","value",ODBC_DEFAULTLRL);
                $objResponse->assign("txt_ODBC_MAXLRL","value",ODBC_MAXLRL);
                $objResponse->assign("txt_DB_DATETIME_FORMAT","value",DB_DATETIME_FORMAT);
                $objResponse->assign("txt_LOG_DATETIME_FORMAT","value",LOG_DATETIME_FORMAT);
                $objResponse->assign("txt_APP_DATETIME_FORMAT","value",APP_DATETIME_FORMAT);
                $objResponse->assign("txt_ROOT_FOLDER","value",ROOT_FOLDER);
                $objResponse->assign("txt_MY_URI","value",MY_URI);
                $objResponse->assign("txt_MY_URL","value",MY_URL);
                $objResponse->assign("txt_HOME","value",HOME);
                $objResponse->assign("txt_UPGRADE_VERSION","value",UPGRADE_VERSION);
                $objResponse->assign("txt_SESSION_USER","value",SESSION_USER);
                $objResponse->assign("txt_SESSION_ID","value",SESSION_ID);
                $objResponse->assign("txt_MAX_SEARCH_RESULT_ROW","value",MAX_SEARCH_RESULT_ROW);
                
                $objResponse->assign("txt_COMPANY_NAME","value",COMPANY_NAME);
                $objResponse->assign("txt_REQUERIDO","value",REQUERIDO);
                $objResponse->assign("txt_MESSAGES_FILE","value",MESSAGES_FILE);
                $objResponse->assign("txt_DB_LOGS","value",DB_LOGS);
                $objResponse->assign("txt_MY_SUBURL","value",MY_SUBURL);
                $objResponse->assign("txt_REGISTER_FILE_LOGS","value",REGISTER_FILE_LOGS);
                $objResponse->assign("txt_REGISTER_DB_LOGS","value",REGISTER_DB_LOGS);
		return $objResponse;
	}

	
	function save($aFormValues){
		$objResponse = new xajaxResponse();
		$config = file_get_contents((dirname(dirname(dirname(dirname(__FILE__))))."//conf//configure.php"));
                
                $config = str_replace(DB_DSN, $aFormValues["txt_DB_DSN"], $config);
                $config = str_replace(DB_SERVER_USERNAME, $aFormValues["txt_DB_SERVER_USERNAME"], $config);
                $config = str_replace(DB_SERVER_PASSWORD, $aFormValues["txt_DB_SERVER_PASSWORD"], $config);
                $config = str_replace(DB_DATABASE, $aFormValues["txt_DB_DATABASE"], $config);
                $config = str_replace(DB_PORT, $aFormValues["txt_DB_PORT"], $config);
                $config = str_replace(SQL_LOG_PATH, $aFormValues["txt_SQL_LOG_PATH"], $config);
                $config = str_replace(TABLE_ROW_VIEW, $aFormValues["txt_TABLE_ROW_VIEW"], $config);
                $config = str_replace(TABLE_ROW_VIEW_LOGS, $aFormValues["txt_TABLE_ROW_VIEW_LOGS"], $config);
                $config = str_replace(ODBC_DEFAULTLRL, $aFormValues["txt_ODBC_DEFAULTLRL"], $config);
                $config = str_replace(ODBC_MAXLRL, $aFormValues["txt_ODBC_MAXLRL"], $config);
                $config = str_replace(DB_DATETIME_FORMAT, $aFormValues["txt_DB_DATETIME_FORMAT"], $config);
                $config = str_replace(LOG_DATETIME_FORMAT, $aFormValues["txt_LOG_DATETIME_FORMAT"], $config);
                $config = str_replace(APP_DATETIME_FORMAT, $aFormValues["txt_APP_DATETIME_FORMAT"], $config);
                $config = str_replace(ROOT_FOLDER, $aFormValues["txt_ROOT_FOLDER"], $config);
                $config = str_replace(MY_URI, $aFormValues["txt_MY_URI"], $config);
                $config = str_replace(MY_URL, $aFormValues["txt_MY_URL"], $config);
                $config = str_replace(HOME, $aFormValues["txt_HOME"], $config);
                $config = str_replace(UPGRADE_VERSION, $aFormValues["txt_UPGRADE_VERSION"], $config);
                $config = str_replace(SESSION_USER, $aFormValues["txt_SESSION_USER"], $config);
                $config = str_replace(SESSION_ID, $aFormValues["txt_SESSION_ID"], $config);
                $config = str_replace(MAX_SEARCH_RESULT_ROW, $aFormValues["txt_MAX_SEARCH_RESULT_ROW"], $config);
                $config = str_replace(COMPANY_NAME, $aFormValues["txt_COMPANY_NAME"], $config);
                $config = str_replace(REQUERIDO, $aFormValues["txt_REQUERIDO"], $config);
                $config = str_replace(MESSAGES_FILE, $aFormValues["txt_MESSAGES_FILE"], $config);
                $config = str_replace(DB_LOGS, $aFormValues["txt_DB_LOGS"], $config);
                $config = str_replace(MY_SUBURL, $aFormValues["txt_MY_SUBURL"], $config);
                $config = str_replace(REGISTER_FILE_LOGS, $aFormValues["txt_REGISTER_FILE_LOGS"], $config);
                $config = str_replace(REGISTER_DB_LOGS, $aFormValues["txt_REGISTER_DB_LOGS"], $config);

                file_put_contents((dirname(dirname(dirname(dirname(__FILE__))))."//conf//configure.php"), $config);
                
                //$objResponse = loadfields($objResponse);
                $objResponse->script("document.location.reload(true);");
		return $objResponse;
	}
	

	function showPanel($name,$objResponse){
		$objResponse->assign($name,"style.visibility","visible");
		$objResponse->assign($name,"style.height","auto");
		return $objResponse;
	}

	function hidePanel($name,$objResponse){
		$objResponse->assign($name,"style.visibility","hidden");
		$objResponse->assign($name,"style.height","0px");
		return $objResponse;
	}

	function visibilityButton($name,$visibility,$objResponse){
		$objResponse->assign($name,"style.visibility",$visibility);
		if($visibility == "hidden")
			$objResponse->assign($name,"style.width","0px");
		else
			$objResponse->assign($name,"style.width","100px");
		return $objResponse;
	}

	
	$xajax->processRequest();

?>