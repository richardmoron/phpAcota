<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/xajax/xajax_core/xajax.inc.php");
	include_once (dirname(dirname(__FILE__))."/dao/ec_valores_respuesta.dao.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/parsedate.php");
	include_once (dirname(dirname(dirname(__FILE__)))."/parametros/dao/pa_usuarios.dao.php");
	//-- IBRAC
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/permisos.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/session.php");
	//-- IBRAC
	//session_start();
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
		//--VERIFICAR SESSION
		if(!isset($_SESSION[SESSION_USER])){
			$objResponse = new xajaxResponse();
			return $objResponse->redirect(MY_URL);
		}
                $criterio = array();
                if(isset($_GET["pregunta_id"]) && trim($_GET["pregunta_id"]) != "" ){
                    $criterio["txt_pregunta_id"] = $_GET["pregunta_id"];
                }
		$objResponse = loadtable($criterio,0);
		//$objResponse = loadUserLogged($objResponse);
		//-- IBRAC
		$objResponse = loadPrivileges($objResponse);
		//-- IBRAC
                if(isset($_GET["pregunta_id"]) && trim($_GET["pregunta_id"]) != "" ){
                    $objResponse->assign("txt_pregunta_id","value",$_GET["pregunta_id"]);
                }
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
	function loadPrivileges($objResponse,$ibrac = null, $mode = "TABLE"){
		if($ibrac == null)
			$ibrac = permisos::getIBRAC(__FILE__);
		//--Nuevo
		//--REPORTE
		$objResponse->assign("ibrac","value",$ibrac);
		return $objResponse;
	}
	//-- IBRAC

	function loadtable($aFormValues,$page_number){
		return searchfields($aFormValues,$page_number);
	}

	function loadtable_default($page_number,$arraylist,$table_count,$criterio){
		$objResponse = new xajaxResponse();
		if($page_number >= $table_count){
			$page_number = $page_number - 1;
		}
		//-- IBRAC
		if(!isset($criterio["ibrac"]))
			$criterio["ibrac"] = permisos::getIBRAC(__FILE__);
		//-- IBRAC
		$iterator = $arraylist->getIterator();
		$strhtml = '<table class="datatable" id="myTable">'."\n";
		$strhtml .= '<thead>'."\n";
		$strhtml .= '<tr>'."\n";
		$strhtml .= '<th scope="col">Valor<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Etiqueta<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th class="table-action">B</th>'."\n";
		$strhtml .= '</tr>'."\n";
		$strhtml .= '</thead>'."\n";
		$strhtml .= '<tfoot>'."\n";
		$strhtml .= '<tr id="table_footer">'."\n";
		$strhtml .= '<th colspan="'.(count(ec_valores_respuestaTO::$FIELDS)+3).'" id="footer_right">'."\n";
		//-- IBRAC
		if(strlen(strpos($criterio["ibrac"],"C"))>0){
		//-- IBRAC
			for ($i= 0 ; $i <= $table_count-1 ; $i++) {
				if($i != $page_number){
					$strhtml .= '<a href="#" target="_self" onclick="xajax_loadtable(xajax.getFormValues(\'formulario\'),'.($i).')">'.($i+1).'</a>'."\n";
				}else{
					$strhtml .= ($i+1)."\n";
				}
			}
		}
		$strhtml .= '</th>'."\n";
		$strhtml .= '</tr>'."\n";
		$strhtml .= '</tfoot>'."\n";
		$strhtml .= '<tbody>'."\n";
		//-- IBRAC
		if(strlen(strpos($criterio["ibrac"],"C"))>0){
		//-- IBRAC
			while($iterator->valid()) {
				if($iterator->key() % 2 == 0){
					$strhtml .= '<tr class="paintedrow">'."\n";
				}else{
					$strhtml .= '<tr>'."\n";
				}
				$objec_valores_respuestaTO = $iterator->current();
				$strhtml .= '<td>'.$objec_valores_respuestaTO->getValor().'</td>'."\n";
				$strhtml .= '<td>'.$objec_valores_respuestaTO->getEtiqueta().'</td>'."\n";
				//-- IBRAC
				if(strlen(strpos($criterio["ibrac"],"B"))>0)
					$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="if(confirm(\'Esta Seguro?\')){xajax_remove('.$objec_valores_respuestaTO->getValor_respuesta_id().',xajax.getFormValues(\'formulario\'));}"><img src="'.MY_URI.'/media/img/actions/delete-row.png" alt="eliminar" title="eliminar" style="border:0"/></a></td>'."\n";
				else
					$strhtml .= '<td>&nbsp;</td>';
				//-- IBRAC
				$strhtml .= '</tr>'."\n";
				$iterator->next();
			}
		}
		$strhtml .= '</tbody>'."\n";
		$strhtml .= '</table>'."\n";
		$objResponse->assign("datatable_box","innerHTML","$strhtml");
                $objResponse->assign("txt_valor","value","");
		$objResponse->assign("txt_etiqueta","value","");
		//-- IBRAC
		$objResponse = loadPrivileges($objResponse,$criterio["ibrac"]);
		//-- IBRAC
		$objResponse->script('$(document).ready(function(){ $("#myTable").tablesorter(); } );');
		return $objResponse;
	}

	function save($aFormValues){
		$objResponse = new xajaxResponse();
		$valid = valid($aFormValues,$objResponse);
		try{
			if($valid){
				$objec_valores_respuestaDAO = new ec_valores_respuestaDAO();
				$objec_valores_respuestaTO = new ec_valores_respuestaTO();
				$objec_valores_respuestaTO->setValor_respuesta_id($aFormValues['txt_valor_respuesta_id']);
				$objec_valores_respuestaTO->setPregunta_id($aFormValues['txt_pregunta_id']);
				$objec_valores_respuestaTO->setValor($aFormValues['txt_valor']);
				$objec_valores_respuestaTO->setEtiqueta($aFormValues['txt_etiqueta']);

				if($aFormValues['txt_valor_respuesta_id'] == '0' )
					$objec_valores_respuestaDAO->insertec_valores_respuesta($objec_valores_respuestaTO);
				else
					$objec_valores_respuestaDAO->updateec_valores_respuesta($objec_valores_respuestaTO);

				return loadtable($aFormValues,0);
			}
		}catch(Exception $ex){
			$objResponse->script("alert('".$ex->getMessage()."')");
		}
		return $objResponse;
	}

	function add(){
		$objResponse = new xajaxResponse();
		$objResponse = clearvalid($objResponse);
		$objResponse->assign("txt_valor_respuesta_id","value","0");
		$objResponse->assign("txt_pregunta_id","value","");
		$objResponse->assign("txt_valor","value","");
		$objResponse->assign("txt_etiqueta","value","");
		$objResponse->assign("fields_title_panel","innerHTML","Registrar Datos");
		$objResponse = hidePanel("datatable_box", $objResponse);
		$objResponse = hidePanel("searchfields", $objResponse);
		$objResponse = showPanel("fields", $objResponse);

		$objResponse = visibilityButton("savebutton", "visible", $objResponse);
		$objResponse = visibilityButton("cancelbutton", "visible", $objResponse);
		$objResponse = visibilityButton("addbutton", "visible", $objResponse);
		$objResponse = visibilityButton("searchbutton", "hidden", $objResponse);
		$objResponse = visibilityButton("editbutton", "hidden", $objResponse);

		$objResponse = readOnlyfiles("false",$objResponse);

		return $objResponse;
	}

	function remove($key,$aFormValues){
		$objec_valores_respuestaDAO = new ec_valores_respuestaDAO();
		$objec_valores_respuestaTO = new ec_valores_respuestaTO();
		$objec_valores_respuestaTO->setValor_respuesta_id($key);
		$objec_valores_respuestaDAO->deleteec_valores_respuesta($objec_valores_respuestaTO);
		return loadtable($aFormValues,0);
	}

	function valid($aFormValues,$objResponse){
		$valid = true;
		$objResponse = clearvalid($objResponse);
			
			if(trim($aFormValues['txt_pregunta_id']) == ""){
				$objResponse->assign("valid_pregunta_id","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			//if(trim($aFormValues['txt_valor']) == ""){
			//	$objResponse->assign("valid_valor","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
			//	$valid = false;
			//}
			if(trim($aFormValues['txt_etiqueta']) == ""){
				$objResponse->assign("valid_etiqueta","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
//				$valid = false;
			}
		return $valid;
	}
	function clearvalid($objResponse){
		$objResponse->assign("valid_valor_respuesta_id","innerHTML", "");
		$objResponse->assign("valid_pregunta_id","innerHTML", "");
		$objResponse->assign("valid_valor","innerHTML", "");
		$objResponse->assign("valid_etiqueta","innerHTML", "");
		return $objResponse;
	}

	
	function searchfields($aFormValues,$page_number){
		$criterio = array();
		$objec_valores_respuestaDAO = new ec_valores_respuestaDAO();
		//-- IBRAC
		if(isset($aFormValues["ibrac"]))
			$criterio["ibrac"] = $aFormValues["ibrac"];
		//-- IBRAC
                if(isset($aFormValues["txt_pregunta_id"]))
			$criterio["pregunta_id"] = $aFormValues["txt_pregunta_id"];
                
		$arraylist = $objec_valores_respuestaDAO->selectByCriteria_ec_valores_respuesta($criterio,$page_number);
		$table_count = $objec_valores_respuestaDAO->selectCountec_valores_respuesta($criterio);
		$objResponse = loadtable_default($page_number,$arraylist,$table_count,$criterio);
		return $objResponse;
	}

	$xajax->processRequest();

?>