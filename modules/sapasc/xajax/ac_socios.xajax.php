<?php error_reporting(E_ALL);
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
        include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/session.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/xajax/xajax_core/xajax.inc.php");
	include_once (dirname(dirname(__FILE__))."/dao/ac_socios.dao.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/parsedate.php");
        include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/comboboxes_ac.php");
        include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/comboboxes.php");
	include_once (dirname(dirname(dirname(__FILE__)))."/parametros/dao/pa_usuarios.dao.php");
	//-- IBRAC
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/permisos.php");
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
        $xajax->registerFunction("exrpotexcel");//Exporta a excel la tabla
	$xajax->registerFunction("readOnlyfiles");

	function preload(){
		$objResponse = loadtable(null,0);
//		$objResponse = loadUserLogged($objResponse);
//		$objResponse->assign("ctn_cbx_grupo","innerHTML", loadCbx_GruposSocios("_new", false));
                $objResponse->assign("ctns_cbx_comunidad","innerHTML", loadCbx_Parametros("", true,"AC_COMUNIDAD"));
                $objResponse->assign("ctns_cbx_grupo","innerHTML", loadCbx_GruposSocios("", true));
		//-- IBRAC
		$objResponse = loadPrivileges($objResponse);
		//-- IBRAC
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
			$objResponse->includeCSS("../css/noprint.css","print");
		$objResponse->assign("ibrac","value",$ibrac);
		return $objResponse;
	}
	//-- IBRAC
	function loadfields($key){
		$objResponse = new xajaxResponse();
                $objResponse = verifySession($objResponse);
		$objResponse = clearvalid($objResponse);
		$objac_sociosDAO = new ac_sociosDAO();
    		$objac_sociosTO = $objac_sociosDAO->selectByIdac_socios($key);
                $objResponse->assign("ctn_cbx_grupo","innerHTML", loadCbx_GruposSocios("_new", false));
                $objResponse->assign("ctn_cbx_comunidad","innerHTML", loadCbx_Parametros("_new", false,"AC_COMUNIDAD"));
                
		$objResponse->assign("txt_socio_id","value",$objac_sociosTO->getSocio_id());
		$objResponse->assign("cbx_grupos_socios_new","value",$objac_sociosTO->getGrupo_id());
		$objResponse->assign("txt_nro_medidor","value",$objac_sociosTO->getNro_medidor());
		$objResponse->assign("txt_marca_medidor","value",$objac_sociosTO->getMarca_medidor());
		$objResponse->assign("txt_nombres","value",$objac_sociosTO->getNombres());
		$objResponse->assign("txt_apellidos","value",$objac_sociosTO->getApellidos());
		$objResponse->assign("txt_ci","value",$objac_sociosTO->getCi());
		$objResponse->assign("txt_ci_expedido_en","value",$objac_sociosTO->getCi_expedido_en());
		$objResponse->assign("txt_direccion","value",$objac_sociosTO->getDireccion());
		$objResponse->assign("cbx_parametro_new","value",$objac_sociosTO->getComunidad_id());
		$objResponse->assign("txt_zona","value",$objac_sociosTO->getZona());
		$objResponse->assign("txt_registrado_por","value",$objac_sociosTO->getRegistrado_por());
		$objResponse->assign("txt_fecha_registro","value",  parsedate::changeDateFormat($objac_sociosTO->getFecha_registro(),DB_DATETIME_FORMAT, APP_DATETIME_FORMAT ));
		$objResponse->assign("datatable","style.visibility","hidden");
		$objResponse->assign("fields","style.visibility","visible");

		$objResponse = hidePanel("datatable_box", $objResponse);
		$objResponse = hidePanel("searchfields", $objResponse);
		$objResponse = showPanel("fields", $objResponse);

		$objResponse = visibilityButton("savebutton", "visible", $objResponse);
		$objResponse = visibilityButton("cancelbutton", "visible", $objResponse);
		$objResponse = visibilityButton("addbutton", "visible", $objResponse);
		$objResponse = visibilityButton("editbutton", "hidden", $objResponse);
		$objResponse = visibilityButton("searchbutton", "hidden", $objResponse);

		$objResponse->assign("fields_title_panel","innerHTML","Editar Datos");
		//-- IBRAC
		$objResponse = loadPrivileges($objResponse,null,"EDIT");
		//-- IBRAC

		$objResponse = readOnlyfiles("false",$objResponse);

		return $objResponse;
	}

	function viewfields($key){
		$objResponse = loadfields($key);
		$objResponse->assign("fields_title_panel","innerHTML","Ver Datos");
		$objResponse->assign("savebutton","style.visibility","hidden");
		$objResponse = readOnlyfiles("true",$objResponse);
		//-- IBRAC
		$objResponse = loadPrivileges($objResponse,null,"VIEW");
		//-- IBRAC

		$objResponse = visibilityButton("savebutton", "hidden", $objResponse);
		return $objResponse;
	}

	function loadtable($aFormValues,$page_number){
		return searchfields($aFormValues,$page_number);
	}

	function loadtable_default($page_number,$arraylist,$table_count,$criterio){
		$objResponse = new xajaxResponse();
                $objResponse = verifySession($objResponse);
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
		$strhtml .= '<th scope="col">Grupo<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Nro Medidor<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Nombres<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Apellidos<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Ci<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Comunidad<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th class="table-action">V</th>'."\n";
		$strhtml .= '<th class="table-action">E</th>'."\n";
		$strhtml .= '<th class="table-action">B</th>'."\n";
		$strhtml .= '</tr>'."\n";
		$strhtml .= '</thead>'."\n";
		$strhtml .= '<tfoot>'."\n";
		$strhtml .= '<tr id="table_footer">'."\n";
		$strhtml .= '<th colspan="'.(count(ac_sociosTO::$FIELDS)+3).'" id="footer_right">'."\n";
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
				$objac_sociosTO = $iterator->current();
				$strhtml .= '<td>'.$objac_sociosTO->getGrupo().'</td>'."\n";
				$strhtml .= '<td>'.$objac_sociosTO->getNro_medidor().'</td>'."\n";
				$strhtml .= '<td>'.$objac_sociosTO->getNombres().'</td>'."\n";
				$strhtml .= '<td>'.$objac_sociosTO->getApellidos().'</td>'."\n";
				$strhtml .= '<td>'.$objac_sociosTO->getCi()." ".$objac_sociosTO->getCi_expedido_en().'</td>'."\n";
				$strhtml .= '<td>'.$objac_sociosTO->getComunidad().'</td>'."\n";
				//-- IBRAC
				$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="xajax_viewfields('.$objac_sociosTO->getSocio_id().');"><img src="'.MY_URI.'/media/img/actions/view-row.png" alt="ver" title="ver" style="border:0"/></a></td>'."\n";
				if(strlen(strpos($criterio["ibrac"],"A"))>0)
					$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="xajax_loadfields('.$objac_sociosTO->getSocio_id().');"><img src="'.MY_URI.'/media/img/actions/edit-row.png" alt="editar" title="editar" style="border:0"/></a></td>'."\n";
				else
					$strhtml .= '<td>&nbsp;</td>';
				if(strlen(strpos($criterio["ibrac"],"B"))>0)
					$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="if(confirm(\'Esta Seguro?\')){xajax_remove('.$objac_sociosTO->getSocio_id().',xajax.getFormValues(\'formulario\'));}"><img src="'.MY_URI.'/media/img/actions/delete-row.png" alt="eliminar" title="eliminar" style="border:0"/></a></td>'."\n";
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
		$objResponse = showPanel("datatable_box", $objResponse);
		$objResponse = showPanel("searchfields", $objResponse);
		$objResponse = hidePanel("fields", $objResponse);

		$objResponse = visibilityButton("savebutton","hidden",$objResponse);
		$objResponse = visibilityButton("cancelbutton","hidden",$objResponse);
		$objResponse = visibilityButton("addbutton","visible",$objResponse);
		$objResponse = visibilityButton("searchbutton","visible",$objResponse);
		$objResponse = visibilityButton("editbutton","hidden",$objResponse);
		//-- IBRAC
		$objResponse = loadPrivileges($objResponse,$criterio["ibrac"]);
		//-- IBRAC
		$objResponse->script('$(document).ready(function(){ $("#myTable").tablesorter(); } );');
		return $objResponse;
	}

	function save($aFormValues){
		$objResponse = new xajaxResponse();
                $objResponse = verifySession($objResponse);
		$valid = valid($aFormValues,$objResponse);
		try{
			if($valid){
				$objac_sociosDAO = new ac_sociosDAO();
				$objac_sociosTO = new ac_sociosTO();
				$objac_sociosTO->setSocio_id($aFormValues['txt_socio_id']);
				$objac_sociosTO->setGrupo_id($aFormValues['cbx_grupos_socios_new']);
				$objac_sociosTO->setNro_medidor($aFormValues['txt_nro_medidor']);
				$objac_sociosTO->setMarca_medidor($aFormValues['txt_marca_medidor']);
				$objac_sociosTO->setNombres($aFormValues['txt_nombres']);
				$objac_sociosTO->setApellidos($aFormValues['txt_apellidos']);
				$objac_sociosTO->setCi($aFormValues['txt_ci']);
				$objac_sociosTO->setCi_expedido_en($aFormValues['txt_ci_expedido_en']);
				$objac_sociosTO->setDireccion($aFormValues['txt_direccion']);
				$objac_sociosTO->setComunidad_id($aFormValues['cbx_parametro_new']);
				$objac_sociosTO->setZona($aFormValues['txt_zona']);
				$objac_sociosTO->setRegistrado_por($_SESSION[SESSION_USER]);
				$objac_sociosTO->setFecha_registro(date(DB_DATETIME_FORMAT));

				if($aFormValues['txt_socio_id'] == '0' )
					$objac_sociosDAO->insertac_socios($objac_sociosTO);
				else
					$objac_sociosDAO->updateac_socios($objac_sociosTO);

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
		$objResponse->assign("txt_socio_id","value","0");
		$objResponse->assign("txt_grupo_id","value","");
		$objResponse->assign("txt_nro_medidor","value","");
		$objResponse->assign("txt_marca_medidor","value","");
		$objResponse->assign("txt_nombres","value","");
		$objResponse->assign("txt_apellidos","value","");
		$objResponse->assign("txt_ci","value","");
		$objResponse->assign("txt_ci_expedido_en","value","");
		$objResponse->assign("txt_direccion","value","");
		$objResponse->assign("txt_comunidad_id","value","");
		$objResponse->assign("txt_zona","value","");
		$objResponse->assign("txt_registrado_por","value",$_SESSION[SESSION_USER]);
		$objResponse->assign("txt_fecha_registro","value",  date(APP_DATETIME_FORMAT));
		$objResponse->assign("fields_title_panel","innerHTML","Registrar Datos");
                $objResponse->assign("ctn_cbx_grupo","innerHTML", loadCbx_GruposSocios("_new", false));
                $objResponse->assign("ctn_cbx_comunidad","innerHTML", loadCbx_Parametros("_new", false,"AC_COMUNIDAD"));
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
		$objac_sociosDAO = new ac_sociosDAO();
		$objac_sociosTO = new ac_sociosTO();
		$objac_sociosTO->setSocio_id($key);
		$objac_sociosDAO->deleteac_socios($objac_sociosTO);
		return loadtable($aFormValues,0);
	}

	function valid($aFormValues,$objResponse){
		$valid = true;
		$objResponse = clearvalid($objResponse);
			if(trim($aFormValues['txt_socio_id']) == ""){
				$objResponse->assign("valid_socio_id","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['cbx_grupos_socios_new']) == ""){
				$objResponse->assign("valid_grupo_id","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_nro_medidor']) == ""){
				$objResponse->assign("valid_nro_medidor","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_marca_medidor']) == ""){
				$objResponse->assign("valid_marca_medidor","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_nombres']) == ""){
				$objResponse->assign("valid_nombres","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_apellidos']) == ""){
				$objResponse->assign("valid_apellidos","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_ci']) == ""){
				$objResponse->assign("valid_ci","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_ci_expedido_en']) == ""){
				$objResponse->assign("valid_ci_expedido_en","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_direccion']) == ""){
				$objResponse->assign("valid_direccion","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['cbx_parametro_new']) == ""){
				$objResponse->assign("valid_comunidad_id","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_zona']) == ""){
				$objResponse->assign("valid_zona","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_registrado_por']) == ""){
				$objResponse->assign("valid_registrado_por","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_fecha_registro']) == ""){
				$objResponse->assign("valid_fecha_registro","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
		return $valid;
	}
	function clearvalid($objResponse){
		$objResponse->assign("valid_socio_id","innerHTML", "");
		$objResponse->assign("valid_grupo_id","innerHTML", "");
		$objResponse->assign("valid_nro_medidor","innerHTML", "");
		$objResponse->assign("valid_marca_medidor","innerHTML", "");
		$objResponse->assign("valid_nombres","innerHTML", "");
		$objResponse->assign("valid_apellidos","innerHTML", "");
		$objResponse->assign("valid_ci","innerHTML", "");
		$objResponse->assign("valid_ci_expedido_en","innerHTML", "");
		$objResponse->assign("valid_direccion","innerHTML", "");
		$objResponse->assign("valid_comunidad_id","innerHTML", "");
		$objResponse->assign("valid_zona","innerHTML", "");
		$objResponse->assign("valid_registrado_por","innerHTML", "");
		$objResponse->assign("valid_fecha_registro","innerHTML", "");
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

	function readOnlyfiles($state, $objResponse = null, $title = null){
		if($objResponse==null)
			$objResponse = new xajaxResponse();
		if($title!=null)
			$objResponse->assign("fields_title_panel","innerHTML",$title);

		$objResponse->script("readonly('formulario','txt_socio_id',$state)");
		$objResponse->script("readonly('formulario','txt_grupo_id',$state)");
		$objResponse->script("readonly('formulario','txt_nro_medidor',$state)");
		$objResponse->script("readonly('formulario','txt_marca_medidor',$state)");
		$objResponse->script("readonly('formulario','txt_nombres',$state)");
		$objResponse->script("readonly('formulario','txt_apellidos',$state)");
		$objResponse->script("readonly('formulario','txt_ci',$state)");
		$objResponse->script("readonly('formulario','txt_ci_expedido_en',$state)");
		$objResponse->script("readonly('formulario','txt_direccion',$state)");
		$objResponse->script("readonly('formulario','txt_comunidad_id',$state)");
		$objResponse->script("readonly('formulario','txt_zona',$state)");
		if($state == "false"){
			$objResponse = visibilityButton("savebutton", "visible", $objResponse);
			$objResponse = visibilityButton("editbutton", "hidden", $objResponse);
		}else{
		}
		return $objResponse;
	}

	function cancel($aFormValues){
		$objResponse = searchfields($aFormValues,0);
		return $objResponse;
	}
        
        function exrpotexcel($aFormValues){
            
        }
        
	function searchfields($aFormValues,$page_number){
		$criterio = array();
		$objac_sociosDAO = new ac_sociosDAO();
		//-- IBRAC
		if(isset($aFormValues["ibrac"]))
			$criterio["ibrac"] = $aFormValues["ibrac"];
		//-- IBRAC
                if(isset($aFormValues["txts_nombres"]) && strlen(trim($aFormValues["txts_nombres"]))>0)
			$criterio["nombres"] = $aFormValues["txts_nombres"];
                
                if(isset($aFormValues["txts_apellidos"]) && strlen(trim($aFormValues["txts_apellidos"]))>0)
			$criterio["apellidos"] = $aFormValues["txts_apellidos"];
                
                if(isset($aFormValues["txts_ci"]) && strlen(trim($aFormValues["txts_ci"]))>0)
			$criterio["ci"] = $aFormValues["txts_ci"];
                
                if(isset($aFormValues["txts_nro_medidor"]) && strlen(trim($aFormValues["txts_nro_medidor"]))>0)
			$criterio["nro_medidor"] = $aFormValues["txts_nro_medidor"];
                
                if(isset($aFormValues["cbx_parametro"]) && strlen(trim($aFormValues["cbx_parametro"]))>0)
			$criterio["comunidad_id"] = $aFormValues["cbx_parametro"];
                
                if(isset($aFormValues["cbx_grupos_socios"]) && strlen(trim($aFormValues["cbx_grupos_socios"]))>0)
			$criterio["grupo_id"] = $aFormValues["cbx_grupos_socios"];
                
		$arraylist = $objac_sociosDAO->selectByCriteria_ac_socios($criterio,$page_number);
		$table_count = $objac_sociosDAO->selectCountac_socios($criterio);
		$objResponse = loadtable_default($page_number,$arraylist,$table_count,$criterio);
		return $objResponse;
	}

	$xajax->processRequest();

?>