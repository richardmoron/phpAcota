<?php 
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/xajax/xajax_core/xajax.inc.php");
	include_once (dirname(dirname(__FILE__))."/dao/oc_solicitud.dao.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/parsedate.php");
	include_once (dirname(dirname(dirname(__FILE__)))."/sistema/dao/usuario.dao.php");
	//-- IBRAC
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/permisos.php");
	//-- IBRAC
	session_start();
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
		$objResponse = loadtable(null,0);
		//$objResponse = loadUserLogged($objResponse);
		//-- IBRAC
		$objResponse = loadPrivileges($objResponse);
		//-- IBRAC
		return $objResponse;
	}
	function loadUserLogged($objResponse){
		$objusuarioDAO = new usuarioDAO();
		$usuarioTO = $objusuarioDAO->selectByIdusuarioId($_SESSION[SESSION_USER]);
		$objResponse->assign("header_user_data","innerHTML",$usuarioTO->getNombres()." ".$usuarioTO->getApellidos());
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
			$objResponse->assign("addbutton","style.visibility","hidden");
		//--Buscar
		if(strlen(strpos($ibrac,"C"))==0)
			$objResponse->assign("searchbutton","style.visibility","hidden");
		//--REPORTE
		if(strlen(strpos($ibrac,"R"))==0)
			$objResponse->includeCSS("../css/noprint.css","print");
		$objResponse->assign("ibrac","value",$ibrac);
		return $objResponse;
	}
	//-- IBRAC
	function loadfields($key){
		$objResponse = new xajaxResponse();
		$objResponse = clearvalid($objResponse);
		$objoc_solicitudDAO = new oc_solicitudDAO();
		$objoc_solicitudTO = $objoc_solicitudDAO->selectByIdoc_solicitud($key);

		$objResponse->assign("txt_oc_solicitud_id","value",$objoc_solicitudTO->getOc_solicitud_id());
		$objResponse->assign("txt_cod_empresa","value",$objoc_solicitudTO->getCod_empresa());
		$objResponse->assign("txt_anio","value",$objoc_solicitudTO->getAnio());
		$objResponse->assign("txt_no_solicitud","value",$objoc_solicitudTO->getNo_solicitud());
		$objResponse->assign("txt_fecha","value",$objoc_solicitudTO->getFecha());
		$objResponse->assign("txt_referencia","value",$objoc_solicitudTO->getReferencia());
		$objResponse->assign("txt_observaciones","value",$objoc_solicitudTO->getObservaciones());
		$objResponse->assign("txt_num_mes","value",$objoc_solicitudTO->getNum_mes());
		$objResponse->assign("txt_cod_persona","value",$objoc_solicitudTO->getCod_persona());
		$objResponse->assign("txt_nombre_persona","value",$objoc_solicitudTO->getNombre_persona());
		$objResponse->assign("txt_cod_proyecto","value",$objoc_solicitudTO->getCod_proyecto());
		$objResponse->assign("txt_cod_agencia","value",$objoc_solicitudTO->getCod_agencia());
		$objResponse->assign("txt_cod_seccion","value",$objoc_solicitudTO->getCod_seccion());
		$objResponse->assign("txt_centro_costo","value",$objoc_solicitudTO->getCentro_costo());
		$objResponse->assign("txt_ind_estado","value",$objoc_solicitudTO->getInd_estado());
		$objResponse->assign("txt_prioridad","value",$objoc_solicitudTO->getPrioridad());
		$objResponse->assign("txt_adicionado_por","value",$objoc_solicitudTO->getAdicionado_por());
		$objResponse->assign("txt_fec_adicion","value",$objoc_solicitudTO->getFec_adicion());
		$objResponse->assign("txt_modificado_por","value",$objoc_solicitudTO->getModificado_por());
		$objResponse->assign("txt_fec_modificacion","value",$objoc_solicitudTO->getFec_modificacion());
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
		$objResponse = loadPrivileges($objResponse);
		//-- IBRAC

		$objResponse = readOnlyfiles("false",$objResponse);

		return $objResponse;
	}

	function viewfields($key){
		$objResponse = loadfields($key);
		$objResponse->assign("fields_title_panel","innerHTML","Ver Datos");
		$objResponse->assign("savebutton","style.visibility","hidden");
		$objResponse = readOnlyfiles("true",$objResponse);
		$objResponse = visibilityButton("editbutton", "visible", $objResponse);
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
		$strhtml = '<table class="datatable">'."\n";
		$strhtml .= '<thead>'."\n";
		$strhtml .= '<tr>'."\n";
		$strhtml .= '<th scope="col">Oc_solicitud_id</th>'."\n";
		$strhtml .= '<th scope="col">Cod_empresa</th>'."\n";
		$strhtml .= '<th scope="col">Anio</th>'."\n";
		$strhtml .= '<th scope="col">No_solicitud</th>'."\n";
		$strhtml .= '<th scope="col">Fecha</th>'."\n";
		$strhtml .= '<th scope="col">Referencia</th>'."\n";
		$strhtml .= '<th scope="col">Observaciones</th>'."\n";
		$strhtml .= '<th scope="col">Num_mes</th>'."\n";
		$strhtml .= '<th scope="col">Cod_persona</th>'."\n";
		$strhtml .= '<th scope="col">Nombre_persona</th>'."\n";
		$strhtml .= '<th scope="col">Cod_proyecto</th>'."\n";
		$strhtml .= '<th scope="col">Cod_agencia</th>'."\n";
		$strhtml .= '<th scope="col">Cod_seccion</th>'."\n";
		$strhtml .= '<th scope="col">Centro_costo</th>'."\n";
		$strhtml .= '<th scope="col">Ind_estado</th>'."\n";
		$strhtml .= '<th scope="col">Prioridad</th>'."\n";
		$strhtml .= '<th scope="col">Adicionado_por</th>'."\n";
		$strhtml .= '<th scope="col">Fec_adicion</th>'."\n";
		$strhtml .= '<th scope="col">Modificado_por</th>'."\n";
		$strhtml .= '<th scope="col">Fec_modificacion</th>'."\n";
		$strhtml .= '<th class="table-action">V</th>'."\n";
		$strhtml .= '<th class="table-action">E</th>'."\n";
		$strhtml .= '<th class="table-action">B</th>'."\n";
		$strhtml .= '</tr>'."\n";
		$strhtml .= '</thead>'."\n";
		$strhtml .= '<tfoot>'."\n";
		$strhtml .= '<tr id="table_footer">'."\n";
		$strhtml .= '<th colspan="'.(count(oc_solicitudTO::$FIELDS)+3).'" id="footer_right">'."\n";
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
				$objoc_solicitudTO = $iterator->current();
				$strhtml .= '<td>'.$objoc_solicitudTO->getOc_solicitud_id().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitudTO->getCod_empresa().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitudTO->getAnio().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitudTO->getNo_solicitud().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitudTO->getFecha().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitudTO->getReferencia().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitudTO->getObservaciones().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitudTO->getNum_mes().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitudTO->getCod_persona().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitudTO->getNombre_persona().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitudTO->getCod_proyecto().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitudTO->getCod_agencia().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitudTO->getCod_seccion().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitudTO->getCentro_costo().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitudTO->getInd_estado().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitudTO->getPrioridad().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitudTO->getAdicionado_por().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitudTO->getFec_adicion().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitudTO->getModificado_por().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitudTO->getFec_modificacion().'</td>'."\n";
				//-- IBRAC
				$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="xajax_viewfields('.$objoc_solicitudTO->getOc_solicitud_id().');"><img src="'.MY_URI.'/media/img/actions/view-row.png" alt="ver" title="ver" style="border:0"/></a></td>'."\n";
				if(strlen(strpos($criterio["ibrac"],"A"))>0)
					$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="xajax_loadfields('.$objoc_solicitudTO->getOc_solicitud_id().');"><img src="'.MY_URI.'/media/img/actions/edit-row.png" alt="editar" title="editar" style="border:0"/></a></td>'."\n";
				else
					$strhtml .= '<td>&nbsp;</td>';
				if(strlen(strpos($criterio["ibrac"],"B"))>0)
					$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="if(confirm(\'Esta Seguro?\')){xajax_remove('.$objoc_solicitudTO->getOc_solicitud_id().',xajax.getFormValues(\'formulario\'));}"><img src="'.MY_URI.'/media/img/actions/delete-row.png" alt="eliminar" title="eliminar" style="border:0"/></a></td>'."\n";
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
		return $objResponse;
	}

	function save($aFormValues){
		$objResponse = new xajaxResponse();
		$valid = valid($aFormValues,$objResponse);
		try{
			if($valid){
				$objoc_solicitudDAO = new oc_solicitudDAO();
				$objoc_solicitudTO = new oc_solicitudTO();
				$objoc_solicitudTO->setOc_solicitud_id($aFormValues['txt_oc_solicitud_id']);
				$objoc_solicitudTO->setCod_empresa($aFormValues['txt_cod_empresa']);
				$objoc_solicitudTO->setAnio($aFormValues['txt_anio']);
				$objoc_solicitudTO->setNo_solicitud($aFormValues['txt_no_solicitud']);
				$objoc_solicitudTO->setFecha($aFormValues['txt_fecha']);
				$objoc_solicitudTO->setReferencia($aFormValues['txt_referencia']);
				$objoc_solicitudTO->setObservaciones($aFormValues['txt_observaciones']);
				$objoc_solicitudTO->setNum_mes($aFormValues['txt_num_mes']);
				$objoc_solicitudTO->setCod_persona($aFormValues['txt_cod_persona']);
				$objoc_solicitudTO->setNombre_persona($aFormValues['txt_nombre_persona']);
				$objoc_solicitudTO->setCod_proyecto($aFormValues['txt_cod_proyecto']);
				$objoc_solicitudTO->setCod_agencia($aFormValues['txt_cod_agencia']);
				$objoc_solicitudTO->setCod_seccion($aFormValues['txt_cod_seccion']);
				$objoc_solicitudTO->setCentro_costo($aFormValues['txt_centro_costo']);
				$objoc_solicitudTO->setInd_estado($aFormValues['txt_ind_estado']);
				$objoc_solicitudTO->setPrioridad($aFormValues['txt_prioridad']);
				$objoc_solicitudTO->setAdicionado_por($aFormValues['txt_adicionado_por']);
				$objoc_solicitudTO->setFec_adicion($aFormValues['txt_fec_adicion']);
				$objoc_solicitudTO->setModificado_por($aFormValues['txt_modificado_por']);
				$objoc_solicitudTO->setFec_modificacion($aFormValues['txt_fec_modificacion']);

				if($aFormValues['txt_oc_solicitud_id'] == '0' )
					$objoc_solicitudDAO->insertoc_solicitud($objoc_solicitudTO);
				else
					$objoc_solicitudDAO->updateoc_solicitud($objoc_solicitudTO);

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
		$objResponse->assign("txt_oc_solicitud_id","value","0");
		$objResponse->assign("txt_cod_empresa","value","");
		$objResponse->assign("txt_anio","value","");
		$objResponse->assign("txt_no_solicitud","value","");
		$objResponse->assign("txt_fecha","value","");
		$objResponse->assign("txt_referencia","value","");
		$objResponse->assign("txt_observaciones","value","");
		$objResponse->assign("txt_num_mes","value","");
		$objResponse->assign("txt_cod_persona","value","");
		$objResponse->assign("txt_nombre_persona","value","");
		$objResponse->assign("txt_cod_proyecto","value","");
		$objResponse->assign("txt_cod_agencia","value","");
		$objResponse->assign("txt_cod_seccion","value","");
		$objResponse->assign("txt_centro_costo","value","");
		$objResponse->assign("txt_ind_estado","value","");
		$objResponse->assign("txt_prioridad","value","");
		$objResponse->assign("txt_adicionado_por","value","");
		$objResponse->assign("txt_fec_adicion","value","");
		$objResponse->assign("txt_modificado_por","value","");
		$objResponse->assign("txt_fec_modificacion","value","");
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
		$objoc_solicitudDAO = new oc_solicitudDAO();
		$objoc_solicitudTO = new oc_solicitudTO();
		$objoc_solicitudTO->setOc_solicitud_id($key);
		$objoc_solicitudDAO->deleteoc_solicitud($objoc_solicitudTO);
		return loadtable($aFormValues,0);
	}

	function valid($aFormValues,$objResponse){
		$valid = true;
		$objResponse = clearvalid($objResponse);
			if(trim($aFormValues['txt_oc_solicitud_id']) == ""){
				$objResponse->assign("valid_oc_solicitud_id","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_cod_empresa']) == ""){
				$objResponse->assign("valid_cod_empresa","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_anio']) == ""){
				$objResponse->assign("valid_anio","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_no_solicitud']) == ""){
				$objResponse->assign("valid_no_solicitud","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_fecha']) == ""){
				$objResponse->assign("valid_fecha","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_referencia']) == ""){
				$objResponse->assign("valid_referencia","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_observaciones']) == ""){
				$objResponse->assign("valid_observaciones","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_num_mes']) == ""){
				$objResponse->assign("valid_num_mes","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_cod_persona']) == ""){
				$objResponse->assign("valid_cod_persona","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_nombre_persona']) == ""){
				$objResponse->assign("valid_nombre_persona","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_cod_proyecto']) == ""){
				$objResponse->assign("valid_cod_proyecto","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_cod_agencia']) == ""){
				$objResponse->assign("valid_cod_agencia","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_cod_seccion']) == ""){
				$objResponse->assign("valid_cod_seccion","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_centro_costo']) == ""){
				$objResponse->assign("valid_centro_costo","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_ind_estado']) == ""){
				$objResponse->assign("valid_ind_estado","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_prioridad']) == ""){
				$objResponse->assign("valid_prioridad","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_adicionado_por']) == ""){
				$objResponse->assign("valid_adicionado_por","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_fec_adicion']) == ""){
				$objResponse->assign("valid_fec_adicion","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_modificado_por']) == ""){
				$objResponse->assign("valid_modificado_por","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_fec_modificacion']) == ""){
				$objResponse->assign("valid_fec_modificacion","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
		return $valid;
	}
	function clearvalid($objResponse){
		$objResponse->assign("valid_oc_solicitud_id","innerHTML", "");
		$objResponse->assign("valid_cod_empresa","innerHTML", "");
		$objResponse->assign("valid_anio","innerHTML", "");
		$objResponse->assign("valid_no_solicitud","innerHTML", "");
		$objResponse->assign("valid_fecha","innerHTML", "");
		$objResponse->assign("valid_referencia","innerHTML", "");
		$objResponse->assign("valid_observaciones","innerHTML", "");
		$objResponse->assign("valid_num_mes","innerHTML", "");
		$objResponse->assign("valid_cod_persona","innerHTML", "");
		$objResponse->assign("valid_nombre_persona","innerHTML", "");
		$objResponse->assign("valid_cod_proyecto","innerHTML", "");
		$objResponse->assign("valid_cod_agencia","innerHTML", "");
		$objResponse->assign("valid_cod_seccion","innerHTML", "");
		$objResponse->assign("valid_centro_costo","innerHTML", "");
		$objResponse->assign("valid_ind_estado","innerHTML", "");
		$objResponse->assign("valid_prioridad","innerHTML", "");
		$objResponse->assign("valid_adicionado_por","innerHTML", "");
		$objResponse->assign("valid_fec_adicion","innerHTML", "");
		$objResponse->assign("valid_modificado_por","innerHTML", "");
		$objResponse->assign("valid_fec_modificacion","innerHTML", "");
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

		$objResponse->script("readonly('formulario','txt_oc_solicitud_id',$state)");
		$objResponse->script("readonly('formulario','txt_cod_empresa',$state)");
		$objResponse->script("readonly('formulario','txt_anio',$state)");
		$objResponse->script("readonly('formulario','txt_no_solicitud',$state)");
		$objResponse->script("readonly('formulario','txt_fecha',$state)");
		$objResponse->script("readonly('formulario','txt_referencia',$state)");
		$objResponse->script("readonly('formulario','txt_observaciones',$state)");
		$objResponse->script("readonly('formulario','txt_num_mes',$state)");
		$objResponse->script("readonly('formulario','txt_cod_persona',$state)");
		$objResponse->script("readonly('formulario','txt_nombre_persona',$state)");
		$objResponse->script("readonly('formulario','txt_cod_proyecto',$state)");
		$objResponse->script("readonly('formulario','txt_cod_agencia',$state)");
		$objResponse->script("readonly('formulario','txt_cod_seccion',$state)");
		$objResponse->script("readonly('formulario','txt_centro_costo',$state)");
		$objResponse->script("readonly('formulario','txt_ind_estado',$state)");
		$objResponse->script("readonly('formulario','txt_prioridad',$state)");
		$objResponse->script("readonly('formulario','txt_adicionado_por',$state)");
		$objResponse->script("readonly('formulario','txt_fec_adicion',$state)");
		$objResponse->script("readonly('formulario','txt_modificado_por',$state)");
		$objResponse->script("readonly('formulario','txt_fec_modificacion',$state)");
		if($state == "false")
			$objResponse = visibilityButton("savebutton", "visible", $objResponse);
		return $objResponse;
	}

	function cancel($aFormValues){
		$objResponse = searchfields($aFormValues,0);
		return $objResponse;
	}

	function searchfields($aFormValues,$page_number){
		$criterio = array();
		$objoc_solicitudDAO = new oc_solicitudDAO();
		//-- IBRAC
		if(isset($aFormValues["ibrac"]))
			$criterio["ibrac"] = $aFormValues["ibrac"];
		//-- IBRAC
		$arraylist = $objoc_solicitudDAO->selectByCriteria_oc_solicitud($criterio,$page_number);
		$table_count = $objoc_solicitudDAO->selectCountoc_solicitud($criterio);
		$objResponse = loadtable_default($page_number,$arraylist,$table_count,$criterio);
		return $objResponse;
	}

	$xajax->processRequest();

?>