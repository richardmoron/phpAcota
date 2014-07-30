<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/xajax/xajax_core/xajax.inc.php");
	include_once (dirname(dirname(__FILE__))."/dao/pa_menu.dao.php");
        include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/session.php");
        
//	session_start();
	$xajax = new xajax();

	$xajax->registerFunction("preload"); //Carga las variables iniciales
	$xajax->registerFunction("loadfields"); //Carga los campos del formulario
	$xajax->registerFunction("loadtable"); //Carga los campos de la tabla
        $xajax->registerFunction("searchfields"); //Busca los datos segun el criterio
        
	function preload(){
            //$objResponse = new xajaxResponse();
            $aFormValues = array();
            if(isset($_GET["es_padre"]) && strlen(trim($_GET["es_padre"])) >0 )
                $aFormValues["es_padre"] = $_GET["es_padre"];
            //--
            $objResponse = searchfields($aFormValues,"0");
            //--
            if(isset($_GET["es_padre"]) && strlen(trim($_GET["es_padre"])) >0 )
                $objResponse->assign("es_padre", "value", $_GET["es_padre"]);
            return $objResponse;
	}

	function loadtable($aFormValues,$page_number){
            return searchfields($aFormValues,$page_number);
	}

	function loadtable_default($arraylist,$criterio,$menu_padre_id,$tab){
		$objResponse = new xajaxResponse();
		$iterator = $arraylist->getIterator();
                $div = "ctn_menus";
                if($menu_padre_id != "0")
                    $div = "div_".$menu_padre_id;

		$strhtml = '<div>'."\n";
                $tab_prox = $tab*2;
		while($iterator->valid()) {
                        $objpa_menuTO = $iterator->current();
                        $strhtml .= '<span style="margin-bottom:20px;"><a href="#" target="_self" style="text-decoration:none;color:#666699;padding-left:'.$tab.'px;" onclick="xajax_searchfields(xajax.getFormValues(\'formulario\'),'.$objpa_menuTO->getMenu_id().','.$tab_prox.');">[<span id="symbol_'.$objpa_menuTO->getMenu_id().'" name="symbol_'.$objpa_menuTO->getMenu_id().'">+</span>]<a/>&nbsp;<a style="text-decoration:none;color:#08298A;" onclick="terminate('.$objpa_menuTO->getMenu_id().',\''.$objpa_menuTO->getNombre().'\')" href="#">'.$objpa_menuTO->getNombre().'</a></span>'."\n";
                        $strhtml .= '<div id="div_'.$objpa_menuTO->getMenu_id().'">';
			$strhtml .= '</div>'."\n";
			$iterator->next();
		}
		$strhtml .= '</div>'."\n";
		$objResponse->assign($div,"innerHTML","$strhtml");
                $objResponse->assign("symbol_".$menu_padre_id,"innerHTML","-");

		return $objResponse;
	}

	
	function searchfields($aFormValues,$menu_padre_id,$tab="10"){
		$page_number = 0;
                $criterio = array();
                $criterio["menu_padre_id"] = $menu_padre_id;

                if(isset($aFormValues["es_padre"]) && strlen(trim($aFormValues["es_padre"]))>0 )
                    $criterio["es_padre"] = $aFormValues["es_padre"];
                
		$pa_menuDAO = new pa_menuDAO();
		$arraylist = $pa_menuDAO->selectByCriteria_pa_menu($criterio,$page_number);
		$table_count = $pa_menuDAO->selectCountpa_menu($criterio);
		$objResponse = loadtable_default($arraylist,$criterio,$menu_padre_id,$tab);
		return $objResponse;
	}

	$xajax->processRequest();
?>