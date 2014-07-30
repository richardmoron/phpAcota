<?php 
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/xajax/xajax_core/xajax.inc.php");
	include_once (dirname(dirname(__FILE__))."/dao/oc_solicitud_detalle.dao.php");
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
		$objoc_solicitud_detalleDAO = new oc_solicitud_detalleDAO();
		$objoc_solicitud_detalleTO = $objoc_solicitud_detalleDAO->selectByIdoc_solicitud_detalle($key);

		$objResponse->assign("txt_oc_solicitud_detalle_id","value",$objoc_solicitud_detalleTO->getOc_solicitud_detalle_id());
		$objResponse->assign("txt_cod_empresa","value",$objoc_solicitud_detalleTO->getCod_empresa());
		$objResponse->assign("txt_anio","value",$objoc_solicitud_detalleTO->getAnio());
		$objResponse->assign("txt_no_solicitud","value",$objoc_solicitud_detalleTO->getNo_solicitud());
		$objResponse->assign("txt_no_linea","value",$objoc_solicitud_detalleTO->getNo_linea());
		$objResponse->assign("txt_tipo_solicitud","value",$objoc_solicitud_detalleTO->getTipo_solicitud());
		$objResponse->assign("txt_cod_tipo","value",$objoc_solicitud_detalleTO->getCod_tipo());
		$objResponse->assign("txt_cod_grupo","value",$objoc_solicitud_detalleTO->getCod_grupo());
		$objResponse->assign("txt_cod_subgrupo","value",$objoc_solicitud_detalleTO->getCod_subgrupo());
		$objResponse->assign("txt_codigo_referencia","value",$objoc_solicitud_detalleTO->getCodigo_referencia());
		$objResponse->assign("txt_nombre_referencia","value",$objoc_solicitud_detalleTO->getNombre_referencia());
		$objResponse->assign("txt_unidad_medida","value",$objoc_solicitud_detalleTO->getUnidad_medida());
		$objResponse->assign("txt_cantidad","value",$objoc_solicitud_detalleTO->getCantidad());
		$objResponse->assign("txt_cantidad_aprobada","value",$objoc_solicitud_detalleTO->getCantidad_aprobada());
		$objResponse->assign("txt_cantidad_pendiente","value",$objoc_solicitud_detalleTO->getCantidad_pendiente());
		$objResponse->assign("txt_observaciones","value",$objoc_solicitud_detalleTO->getObservaciones());
		$objResponse->assign("txt_no_docto_referencia","value",$objoc_solicitud_detalleTO->getNo_docto_referencia());
		$objResponse->assign("txt_adicionado_por","value",$objoc_solicitud_detalleTO->getAdicionado_por());
		$objResponse->assign("txt_fec_adicion","value",$objoc_solicitud_detalleTO->getFec_adicion());
		$objResponse->assign("txt_modificado_por","value",$objoc_solicitud_detalleTO->getModificado_por());
		$objResponse->assign("txt_fec_modificacion","value",$objoc_solicitud_detalleTO->getFec_modificacion());
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
		$strhtml .= '<th scope="col">Oc_solicitud_detalle_id</th>'."\n";
		$strhtml .= '<th scope="col">Cod_empresa</th>'."\n";
		$strhtml .= '<th scope="col">Anio</th>'."\n";
		$strhtml .= '<th scope="col">No_solicitud</th>'."\n";
		$strhtml .= '<th scope="col">No_linea</th>'."\n";
		$strhtml .= '<th scope="col">Tipo_solicitud</th>'."\n";
		$strhtml .= '<th scope="col">Cod_tipo</th>'."\n";
		$strhtml .= '<th scope="col">Cod_grupo</th>'."\n";
		$strhtml .= '<th scope="col">Cod_subgrupo</th>'."\n";
		$strhtml .= '<th scope="col">Codigo_referencia</th>'."\n";
		$strhtml .= '<th scope="col">Nombre_referencia</th>'."\n";
		$strhtml .= '<th scope="col">Unidad_medida</th>'."\n";
		$strhtml .= '<th scope="col">Cantidad</th>'."\n";
		$strhtml .= '<th scope="col">Cantidad_aprobada</th>'."\n";
		$strhtml .= '<th scope="col">Cantidad_pendiente</th>'."\n";
		$strhtml .= '<th scope="col">Observaciones</th>'."\n";
		$strhtml .= '<th scope="col">No_docto_referencia</th>'."\n";
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
		$strhtml .= '<th colspan="'.(count(oc_solicitud_detalleTO::$FIELDS)+3).'" id="footer_right">'."\n";
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
				$objoc_solicitud_detalleTO = $iterator->current();
				$strhtml .= '<td>'.$objoc_solicitud_detalleTO->getOc_solicitud_detalle_id().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitud_detalleTO->getCod_empresa().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitud_detalleTO->getAnio().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitud_detalleTO->getNo_solicitud().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitud_detalleTO->getNo_linea().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitud_detalleTO->getTipo_solicitud().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitud_detalleTO->getCod_tipo().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitud_detalleTO->getCod_grupo().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitud_detalleTO->getCod_subgrupo().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitud_detalleTO->getCodigo_referencia().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitud_detalleTO->getNombre_referencia().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitud_detalleTO->getUnidad_medida().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitud_detalleTO->getCantidad().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitud_detalleTO->getCantidad_aprobada().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitud_detalleTO->getCantidad_pendiente().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitud_detalleTO->getObservaciones().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitud_detalleTO->getNo_docto_referencia().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitud_detalleTO->getAdicionado_por().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitud_detalleTO->getFec_adicion().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitud_detalleTO->getModificado_por().'</td>'."\n";
				$strhtml .= '<td>'.$objoc_solicitud_detalleTO->getFec_modificacion().'</td>'."\n";
				//-- IBRAC
				$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="xajax_viewfields('.$objoc_solicitud_detalleTO->getOc_solicitud_detalle_id().');"><img src="'.MY_URI.'/media/img/actions/view-row.png" alt="ver" title="ver" style="border:0"/></a></td>'."\n";
				if(strlen(strpos($criterio["ibrac"],"A"))>0)
					$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="xajax_loadfields('.$objoc_solicitud_detalleTO->getOc_solicitud_detalle_id().');"><img src="'.MY_URI.'/media/img/actions/edit-row.png" alt="editar" title="editar" style="border:0"/></a></td>'."\n";
				else
					$strhtml .= '<td>&nbsp;</td>';
				if(strlen(strpos($criterio["ibrac"],"B"))>0)
					$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="if(confirm(\'Esta Seguro?\')){xajax_remove('.$objoc_solicitud_detalleTO->getOc_solicitud_detalle_id().',xajax.getFormValues(\'formulario\'));}"><img src="'.MY_URI.'/media/img/actions/delete-row.png" alt="eliminar" title="eliminar" style="border:0"/></a></td>'."\n";
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
				$objoc_solicitud_detalleDAO = new oc_solicitud_detalleDAO();
				$objoc_solicitud_detalleTO = new oc_solicitud_detalleTO();
				$objoc_solicitud_detalleTO->setOc_solicitud_detalle_id($aFormValues['txt_oc_solicitud_detalle_id']);
				$objoc_solicitud_detalleTO->setCod_empresa($aFormValues['txt_cod_empresa']);
				$objoc_solicitud_detalleTO->setAnio($aFormValues['txt_anio']);
				$objoc_solicitud_detalleTO->setNo_solicitud($aFormValues['txt_no_solicitud']);
				$objoc_solicitud_detalleTO->setNo_linea($aFormValues['txt_no_linea']);
				$objoc_solicitud_detalleTO->setTipo_solicitud($aFormValues['txt_tipo_solicitud']);
				$objoc_solicitud_detalleTO->setCod_tipo($aFormValues['txt_cod_tipo']);
				$objoc_solicitud_detalleTO->setCod_grupo($aFormValues['txt_cod_grupo']);
				$objoc_solicitud_detalleTO->setCod_subgrupo($aFormValues['txt_cod_subgrupo']);
				$objoc_solicitud_detalleTO->setCodigo_referencia($aFormValues['txt_codigo_referencia']);
				$objoc_solicitud_detalleTO->setNombre_referencia($aFormValues['txt_nombre_referencia']);
				$objoc_solicitud_detalleTO->setUnidad_medida($aFormValues['txt_unidad_medida']);
				$objoc_solicitud_detalleTO->setCantidad($aFormValues['txt_cantidad']);
				$objoc_solicitud_detalleTO->setCantidad_aprobada($aFormValues['txt_cantidad_aprobada']);
				$objoc_solicitud_detalleTO->setCantidad_pendiente($aFormValues['txt_cantidad_pendiente']);
				$objoc_solicitud_detalleTO->setObservaciones($aFormValues['txt_observaciones']);
				$objoc_solicitud_detalleTO->setNo_docto_referencia($aFormValues['txt_no_docto_referencia']);
				$objoc_solicitud_detalleTO->setAdicionado_por($aFormValues['txt_adicionado_por']);
				$objoc_solicitud_detalleTO->setFec_adicion($aFormValues['txt_fec_adicion']);
				$objoc_solicitud_detalleTO->setModificado_por($aFormValues['txt_modificado_por']);
				$objoc_solicitud_detalleTO->setFec_modificacion($aFormValues['txt_fec_modificacion']);

				if($aFormValues['txt_oc_solicitud_detalle_id'] == '0' )
					$objoc_solicitud_detalleDAO->insertoc_solicitud_detalle($objoc_solicitud_detalleTO);
				else
					$objoc_solicitud_detalleDAO->updateoc_solicitud_detalle($objoc_solicitud_detalleTO);

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
		$objResponse->assign("txt_oc_solicitud_detalle_id","value","0");
		$objResponse->assign("txt_cod_empresa","value","");
		$objResponse->assign("txt_anio","value","");
		$objResponse->assign("txt_no_solicitud","value","");
		$objResponse->assign("txt_no_linea","value","");
		$objResponse->assign("txt_tipo_solicitud","value","");
		$objResponse->assign("txt_cod_tipo","value","");
		$objResponse->assign("txt_cod_grupo","value","");
		$objResponse->assign("txt_cod_subgrupo","value","");
		$objResponse->assign("txt_codigo_referencia","value","");
		$objResponse->assign("txt_nombre_referencia","value","");
		$objResponse->assign("txt_unidad_medida","value","");
		$objResponse->assign("txt_cantidad","value","");
		$objResponse->assign("txt_cantidad_aprobada","value","");
		$objResponse->assign("txt_cantidad_pendiente","value","");
		$objResponse->assign("txt_observaciones","value","");
		$objResponse->assign("txt_no_docto_referencia","value","");
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
		$objoc_solicitud_detalleDAO = new oc_solicitud_detalleDAO();
		$objoc_solicitud_detalleTO = new oc_solicitud_detalleTO();
		$objoc_solicitud_detalleTO->setOc_solicitud_detalle_id($key);
		$objoc_solicitud_detalleDAO->deleteoc_solicitud_detalle($objoc_solicitud_detalleTO);
		return loadtable($aFormValues,0);
	}

	function valid($aFormValues,$objResponse){
		$valid = true;
		$objResponse = clearvalid($objResponse);
			if(trim($aFormValues['txt_oc_solicitud_detalle_id']) == ""){
				$objResponse->assign("valid_oc_solicitud_detalle_id","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
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
			if(trim($aFormValues['txt_no_linea']) == ""){
				$objResponse->assign("valid_no_linea","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_tipo_solicitud']) == ""){
				$objResponse->assign("valid_tipo_solicitud","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_cod_tipo']) == ""){
				$objResponse->assign("valid_cod_tipo","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_cod_grupo']) == ""){
				$objResponse->assign("valid_cod_grupo","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_cod_subgrupo']) == ""){
				$objResponse->assign("valid_cod_subgrupo","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_codigo_referencia']) == ""){
				$objResponse->assign("valid_codigo_referencia","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_nombre_referencia']) == ""){
				$objResponse->assign("valid_nombre_referencia","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_unidad_medida']) == ""){
				$objResponse->assign("valid_unidad_medida","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_cantidad']) == ""){
				$objResponse->assign("valid_cantidad","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_cantidad_aprobada']) == ""){
				$objResponse->assign("valid_cantidad_aprobada","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_cantidad_pendiente']) == ""){
				$objResponse->assign("valid_cantidad_pendiente","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_observaciones']) == ""){
				$objResponse->assign("valid_observaciones","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_no_docto_referencia']) == ""){
				$objResponse->assign("valid_no_docto_referencia","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
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
		$objResponse->assign("valid_oc_solicitud_detalle_id","innerHTML", "");
		$objResponse->assign("valid_cod_empresa","innerHTML", "");
		$objResponse->assign("valid_anio","innerHTML", "");
		$objResponse->assign("valid_no_solicitud","innerHTML", "");
		$objResponse->assign("valid_no_linea","innerHTML", "");
		$objResponse->assign("valid_tipo_solicitud","innerHTML", "");
		$objResponse->assign("valid_cod_tipo","innerHTML", "");
		$objResponse->assign("valid_cod_grupo","innerHTML", "");
		$objResponse->assign("valid_cod_subgrupo","innerHTML", "");
		$objResponse->assign("valid_codigo_referencia","innerHTML", "");
		$objResponse->assign("valid_nombre_referencia","innerHTML", "");
		$objResponse->assign("valid_unidad_medida","innerHTML", "");
		$objResponse->assign("valid_cantidad","innerHTML", "");
		$objResponse->assign("valid_cantidad_aprobada","innerHTML", "");
		$objResponse->assign("valid_cantidad_pendiente","innerHTML", "");
		$objResponse->assign("valid_observaciones","innerHTML", "");
		$objResponse->assign("valid_no_docto_referencia","innerHTML", "");
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

		$objResponse->script("readonly('formulario','txt_oc_solicitud_detalle_id',$state)");
		$objResponse->script("readonly('formulario','txt_cod_empresa',$state)");
		$objResponse->script("readonly('formulario','txt_anio',$state)");
		$objResponse->script("readonly('formulario','txt_no_solicitud',$state)");
		$objResponse->script("readonly('formulario','txt_no_linea',$state)");
		$objResponse->script("readonly('formulario','txt_tipo_solicitud',$state)");
		$objResponse->script("readonly('formulario','txt_cod_tipo',$state)");
		$objResponse->script("readonly('formulario','txt_cod_grupo',$state)");
		$objResponse->script("readonly('formulario','txt_cod_subgrupo',$state)");
		$objResponse->script("readonly('formulario','txt_codigo_referencia',$state)");
		$objResponse->script("readonly('formulario','txt_nombre_referencia',$state)");
		$objResponse->script("readonly('formulario','txt_unidad_medida',$state)");
		$objResponse->script("readonly('formulario','txt_cantidad',$state)");
		$objResponse->script("readonly('formulario','txt_cantidad_aprobada',$state)");
		$objResponse->script("readonly('formulario','txt_cantidad_pendiente',$state)");
		$objResponse->script("readonly('formulario','txt_observaciones',$state)");
		$objResponse->script("readonly('formulario','txt_no_docto_referencia',$state)");
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
		$objoc_solicitud_detalleDAO = new oc_solicitud_detalleDAO();
		//-- IBRAC
		if(isset($aFormValues["ibrac"]))
			$criterio["ibrac"] = $aFormValues["ibrac"];
		//-- IBRAC
		$arraylist = $objoc_solicitud_detalleDAO->selectByCriteria_oc_solicitud_detalle($criterio,$page_number);
		$table_count = $objoc_solicitud_detalleDAO->selectCountoc_solicitud_detalle($criterio);
		$objResponse = loadtable_default($page_number,$arraylist,$table_count,$criterio);
		return $objResponse;
	}

	$xajax->processRequest();

?>