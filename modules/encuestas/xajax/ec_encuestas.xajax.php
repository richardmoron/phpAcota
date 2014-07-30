<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/xajax/xajax_core/xajax.inc.php");
	include_once (dirname(dirname(__FILE__))."/dao/ec_encuestas.dao.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/parsedate.php");
	include_once (dirname(dirname(dirname(__FILE__)))."/parametros/dao/pa_usuarios.dao.php");
	//-- IBRAC
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/permisos.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/session.php");
        include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/comboboxes.php");
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
		$objResponse = loadtable(null,0);
		//$objResponse = loadUserLogged($objResponse);
		//-- IBRAC
		$objResponse = loadPrivileges($objResponse);
		//-- IBRAC
        $objResponse->assign("ctns_cbx_clientes","innerHTML",  loadCbx_EmpresasEncuestas("", true));
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
			$objResponse->includeCSS("../css\noprint.css","print");
		$objResponse->assign("ibrac","value",$ibrac);
		return $objResponse;
	}
	//-- IBRAC
	function loadfields($key){
		$objResponse = new xajaxResponse();
		$objResponse = clearvalid($objResponse);
		$objec_encuestasDAO = new ec_encuestasDAO();
		$objec_encuestasTO = $objec_encuestasDAO->selectByIdec_encuestas($key);
                $objResponse->assign("ctn_cbx_clientes","innerHTML",  loadCbx_EmpresasEncuestas("_new", false));
                
		$objResponse->assign("txt_encuesta_id","value",$objec_encuestasTO->getEncuesta_id());
		$objResponse->assign("cbx_empresas_new","value",$objec_encuestasTO->getEmpresa_id());
		$objResponse->assign("txt_nombre","value",$objec_encuestasTO->getNombre());
		$objResponse->assign("txt_descripcion","innerHTML",$objec_encuestasTO->getDescripcion());
		$objResponse->assign("txt_fecha_inicio","value",parsedate::changeDateFormat($objec_encuestasTO->getFecha_inicio(),DB_DATETIME_FORMAT, "d/m/Y"));
		$objResponse->assign("txt_fecha_fin","value",parsedate::changeDateFormat($objec_encuestasTO->getFecha_fin(),DB_DATETIME_FORMAT, "d/m/Y"));
		$objResponse->assign("txt_es_anonimo","value",$objec_encuestasTO->getEs_anonimo());
		$objResponse->assign("txt_acuerdo","innerHTML",$objec_encuestasTO->getAcuerdo());
                $objResponse->assign("datatable","style.visibility","hidden");
		$objResponse->assign("fields","style.visibility","visible");
                $objResponse->script("document.getElementById('txt_descripcion').innerHTML = '".$objec_encuestasTO->getDescripcion()."';");
                $objResponse->script("setDataContentIE('txt_descripcion','".$objec_encuestasTO->getDescripcion()."');");
                $objResponse->script("setDataContentIE('txt_acuerdo','".$objec_encuestasTO->getAcuerdo()."');");
//                $objResponse->script("alert(". $objec_encuestasTO->getDescripcion().");");

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
		$strhtml .= '<th scope="col">Empresa<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Nombre<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Fecha Inicio<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Fecha Fin<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Anonimo<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
                $strhtml .= '<th class="table-action">O</th>'."\n";
		$strhtml .= '<th class="table-action">V</th>'."\n";
		$strhtml .= '<th class="table-action">E</th>'."\n";
		$strhtml .= '<th class="table-action">B</th>'."\n";
		$strhtml .= '</tr>'."\n";
		$strhtml .= '</thead>'."\n";
		$strhtml .= '<tfoot>'."\n";
		$strhtml .= '<tr id="table_footer">'."\n";
		$strhtml .= '<th colspan="'.(count(ec_encuestasTO::$FIELDS)+3).'" id="footer_right">'."\n";
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
				$objec_encuestasTO = $iterator->current();
				$strhtml .= '<td>'.$objec_encuestasTO->getEmpresa().'</td>'."\n";
				$strhtml .= '<td>'.$objec_encuestasTO->getNombre().'</td>'."\n";
				$strhtml .= '<td>'.parsedate::changeDateFormat($objec_encuestasTO->getFecha_inicio(),DB_DATETIME_FORMAT, "d/m/Y").'</td>'."\n";
				$strhtml .= '<td>'.parsedate::changeDateFormat($objec_encuestasTO->getFecha_fin(),DB_DATETIME_FORMAT, "d/m/Y").'</td>'."\n";
                                if($objec_encuestasTO->getEs_anonimo() == "S")
                                    $strhtml .= '<td>SI</td>'."\n";
                                else
                                    $strhtml .= '<td>NO</td>'."\n";
				//-- IBRAC
                                $strhtml .= '<td style="width:5px;"><a target="_blank" href="encuesta.php?id='.$objec_encuestasTO->getEncuesta_id().'"><img src="'.MY_URI.'/media/img/actions/globe.png" alt="ver" title="ver" style="border:0"/></a></td>'."\n";
				$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="xajax_viewfields('.$objec_encuestasTO->getEncuesta_id().');"><img src="'.MY_URI.'/media/img/actions/view-row.png" alt="ver" title="ver" style="border:0"/></a></td>'."\n";
				if(strlen(strpos($criterio["ibrac"],"A"))>0)
					$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="xajax_loadfields('.$objec_encuestasTO->getEncuesta_id().');"><img src="'.MY_URI.'/media/img/actions/edit-row.png" alt="editar" title="editar" style="border:0"/></a></td>'."\n";
				else
					$strhtml .= '<td>&nbsp;</td>';
				if(strlen(strpos($criterio["ibrac"],"B"))>0)
					$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="if(confirm(\'Esta Seguro?\')){xajax_remove('.$objec_encuestasTO->getEncuesta_id().',xajax.getFormValues(\'formulario\'));}"><img src="'.MY_URI.'/media/img/actions/delete-row.png" alt="eliminar" title="eliminar" style="border:0"/></a></td>'."\n";
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
		$valid = valid($aFormValues,$objResponse);
		try{
			if($valid){
				$objec_encuestasDAO = new ec_encuestasDAO();
				$objec_encuestasTO = new ec_encuestasTO();
				$objec_encuestasTO->setEncuesta_id($aFormValues['txt_encuesta_id']);
				$objec_encuestasTO->setEmpresa_id($aFormValues['cbx_empresas_new']);
				$objec_encuestasTO->setNombre($aFormValues['txt_nombre']);
				$objec_encuestasTO->setDescripcion($aFormValues['txt_descripcion']);
                                $objec_encuestasTO->setAcuerdo($aFormValues['txt_acuerdo']);
                                
                                if($aFormValues['txt_fecha_inicio'] != "")
                                        $objec_encuestasTO->setFecha_inicio(parsedate::changeDateFormat($aFormValues['txt_fecha_inicio']." 01:01:01", "d/m/Y h:i:s", DB_DATETIME_FORMAT ));
                                if($aFormValues['txt_fecha_fin'] != "")
                                        $objec_encuestasTO->setFecha_fin(parsedate::changeDateFormat($aFormValues['txt_fecha_fin']." 01:01:01", "d/m/Y h:i:s", DB_DATETIME_FORMAT ));
                                
				$objec_encuestasTO->setEs_anonimo($aFormValues['txt_es_anonimo']);

				if($aFormValues['txt_encuesta_id'] == '0' )
					$objec_encuestasDAO->insertec_encuestas($objec_encuestasTO);
				else
					$objec_encuestasDAO->updateec_encuestas($objec_encuestasTO);

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
		$objResponse->assign("txt_encuesta_id","value","0");
		$objResponse->assign("txt_empresa_id","value","");
		$objResponse->assign("txt_nombre","value","");
		$objResponse->assign("txt_descripcion","innerHTML","");
                $objResponse->assign("txt_acuerdo","innerHTML","");
		$objResponse->assign("txt_fecha_inicio","value","");
		$objResponse->assign("txt_fecha_fin","value","");
		$objResponse->assign("txt_es_anonimo","value","");
		$objResponse->assign("fields_title_panel","innerHTML","Registrar Datos");
		$objResponse = hidePanel("datatable_box", $objResponse);
		$objResponse = hidePanel("searchfields", $objResponse);
		$objResponse = showPanel("fields", $objResponse);
                $objResponse->assign("ctn_cbx_clientes","innerHTML",  loadCbx_EmpresasEncuestas("_new", false));
                $objResponse->script("setDataContentIE('txt_descripcion','');");
                $objResponse->script("setDataContentIE('txt_acuerdo','');");
                
		$objResponse = visibilityButton("savebutton", "visible", $objResponse);
		$objResponse = visibilityButton("cancelbutton", "visible", $objResponse);
		$objResponse = visibilityButton("addbutton", "visible", $objResponse);
		$objResponse = visibilityButton("searchbutton", "hidden", $objResponse);
		$objResponse = visibilityButton("editbutton", "hidden", $objResponse);

		$objResponse = readOnlyfiles("false",$objResponse);

		return $objResponse;
	}

	function remove($key,$aFormValues){
		$objec_encuestasDAO = new ec_encuestasDAO();
		$objec_encuestasTO = new ec_encuestasTO();
		$objec_encuestasTO->setEncuesta_id($key);
		$objec_encuestasDAO->deleteec_encuestas($objec_encuestasTO);
		return loadtable($aFormValues,0);
	}

	function valid($aFormValues,$objResponse){
		$valid = true;
		$objResponse = clearvalid($objResponse);
			if(trim($aFormValues['txt_encuesta_id']) == ""){
				$objResponse->assign("valid_encuesta_id","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['cbx_empresas_new']) == ""){
				$objResponse->assign("valid_empresa_id","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_nombre']) == ""){
				$objResponse->assign("valid_nombre","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_descripcion']) == ""){
				$objResponse->assign("valid_descripcion","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_fecha_inicio']) == ""){
				$objResponse->assign("valid_fecha_inicio","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_fecha_fin']) == ""){
				$objResponse->assign("valid_fecha_fin","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_es_anonimo']) == ""){
				$objResponse->assign("valid_es_anonimo","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
		return $valid;
	}
	function clearvalid($objResponse){
		$objResponse->assign("valid_encuesta_id","innerHTML", "");
		$objResponse->assign("valid_empresa_id","innerHTML", "");
		$objResponse->assign("valid_nombre","innerHTML", "");
		$objResponse->assign("valid_descripcion","innerHTML", "");
		$objResponse->assign("valid_fecha_inicio","innerHTML", "");
		$objResponse->assign("valid_fecha_fin","innerHTML", "");
		$objResponse->assign("valid_es_anonimo","innerHTML", "");
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

		$objResponse->script("readonly('formulario','txt_encuesta_id',$state)");
		$objResponse->script("readonly('formulario','txt_empresa_id',$state)");
		$objResponse->script("readonly('formulario','txt_nombre',$state)");
		$objResponse->script("readonly('formulario','txt_descripcion',$state)");
		$objResponse->script("readonly('formulario','txt_fecha_inicio',$state)");
		$objResponse->script("readonly('formulario','txt_fecha_fin',$state)");
		$objResponse->script("readonly('formulario','txt_es_anonimo',$state)");
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

	function searchfields($aFormValues,$page_number){
		$criterio = array();
		$objec_encuestasDAO = new ec_encuestasDAO();
		//-- IBRAC
		if(isset($aFormValues["ibrac"]))
			$criterio["ibrac"] = $aFormValues["ibrac"];
		//-- IBRAC
                
                if(isset($aFormValues["txts_nombre"]) && strlen(trim($aFormValues["txts_nombre"]))>0)
			$criterio["nombre"] = $aFormValues["txts_nombre"];
                
                if(isset($aFormValues["cbx_empresas"]) && strlen(trim($aFormValues["cbx_empresas"]))>0)
			$criterio["empresa_id"] = $aFormValues["cbx_empresas"];
                
		$arraylist = $objec_encuestasDAO->selectByCriteria_ec_encuestas($criterio,$page_number);
		$table_count = $objec_encuestasDAO->selectCountec_encuestas($criterio);
		$objResponse = loadtable_default($page_number,$arraylist,$table_count,$criterio);
		return $objResponse;
	}

	$xajax->processRequest();

?>