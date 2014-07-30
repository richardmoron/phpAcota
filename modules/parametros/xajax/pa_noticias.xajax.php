<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/xajax/xajax_core/xajax.inc.php");
	include_once (dirname(dirname(__FILE__))."/dao/pa_noticias.dao.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/parsedate.php");
	include_once (dirname(dirname(dirname(__FILE__)))."/parametros/dao/pa_usuarios.dao.php");
  include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/comboboxes.php");
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
		//--VERIFICAR SESSION
		if(!isset($_SESSION[SESSION_USER])){
			$objResponse = new xajaxResponse();
			return $objResponse->redirect(MY_URL);
		}
		$objResponse = loadtable(null,0);
//		$objResponse = loadUserLogged($objResponse);
		//-- IBRAC
		$objResponse = loadPrivileges($objResponse);
		//-- IBRAC
    $objResponse->assign("ctns_cbx_area","innerHTML",  loadCbx_Area("", true));
		return $objResponse;
	}
	function loadUserLogged($objResponse){
		$pa_usuariosDAO = new pa_usuariosDAO();
		$pa_usuariosTO = $pa_usuariosDAO->selectByNamepa_usuarios($_SESSION[SESSION_USER]);
		$objResponse->assign("header_user_data","innerHTML",$pa_usuariosTO->getNombres()." ".$pa_usuariosTO->getApellidos());
		$objResponse->assign("header_date_data","innerHTML",date(APP_DATETIME_FORMAT));
		$objResponse->assign("header_title","innerHTML",COMPANY_NAME);
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
	function loadfields($key){
		$objResponse = new xajaxResponse();
		$objResponse = clearvalid($objResponse);
		$objpa_noticiasDAO = new pa_noticiasDAO();
		$objpa_noticiasTO = $objpa_noticiasDAO->selectByIdpa_noticias($key);
                $objResponse->assign("ctn_cbx_area","innerHTML",  loadCbx_Area("_new", true));
                $objResponse->assign("ctn_cbx_tipo","innerHTML", loadCbx_Parametros("_new", false,"NOTICIAS"));
                
		$objResponse->assign("txt_noticia_id","value",$objpa_noticiasTO->getNoticia_id());
		$objResponse->assign("txt_titulo","value",$objpa_noticiasTO->getTitulo());
		$objResponse->assign("txt_descripcion","innerHTML",$objpa_noticiasTO->getDescripcion());
		$objResponse->assign("txt_fecha_registro","value",parsedate::changeDateFormat($objpa_noticiasTO->getFecha_registro(), DB_DATETIME_FORMAT, "d/m/Y H:i:s" ));
		$objResponse->assign("txt_fecha_desde","value",parsedate::changeDateFormat($objpa_noticiasTO->getFecha_desde(), DB_DATETIME_FORMAT, "d/m/Y" ));
		$objResponse->assign("txt_fecha_hasta","value",parsedate::changeDateFormat($objpa_noticiasTO->getFecha_hasta(), DB_DATETIME_FORMAT, "d/m/Y" ));
		$objResponse->assign("txt_registrado_por","value",$objpa_noticiasTO->getRegistrado_porstr());
		$objResponse->assign("cbx_parametro_new","value",$objpa_noticiasTO->getTipo_id());
		$objResponse->assign("cbx_area_new","value",$objpa_noticiasTO->getArea_id());
		$objResponse->assign("datatable","style.visibility","hidden");
		$objResponse->assign("fields","style.visibility","visible");
                $objResponse->script("setDataContent('".$objpa_noticiasTO->getDescripcion()."');");
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
		$strhtml .= '<th scope="col">Titulo<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Fecha Desde<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Fecha Hasta<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Tipo<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Area<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th class="table-action">V</th>'."\n";
		$strhtml .= '<th class="table-action">E</th>'."\n";
		$strhtml .= '<th class="table-action">B</th>'."\n";
		$strhtml .= '</tr>'."\n";
		$strhtml .= '</thead>'."\n";
		$strhtml .= '<tfoot>'."\n";
		$strhtml .= '<tr id="table_footer">'."\n";
		$strhtml .= '<th colspan="'.(count(pa_noticiasTO::$FIELDS)+3).'" id="footer_right">'."\n";
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
				$objpa_noticiasTO = $iterator->current();
				$strhtml .= '<td>'.$objpa_noticiasTO->getTitulo().'</td>'."\n";
				$strhtml .= '<td>'.parsedate::changeDateFormat($objpa_noticiasTO->getFecha_desde(), DB_DATETIME_FORMAT, "d/m/Y" ).'</td>'."\n";
				$strhtml .= '<td>'.parsedate::changeDateFormat($objpa_noticiasTO->getFecha_hasta(), DB_DATETIME_FORMAT, "d/m/Y" ).'</td>'."\n";
				$strhtml .= '<td>'.$objpa_noticiasTO->getTipo().'</td>'."\n";
				$strhtml .= '<td>'.$objpa_noticiasTO->getArea().'</td>'."\n";
				//-- IBRAC
				$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="xajax_viewfields('.$objpa_noticiasTO->getNoticia_id().');"><img src="'.MY_URI.'/media/img/actions/view-row.png" alt="ver" title="ver" style="border:0"/></a></td>'."\n";
				if(strlen(strpos($criterio["ibrac"],"A"))>0)
					$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="xajax_loadfields('.$objpa_noticiasTO->getNoticia_id().');"><img src="'.MY_URI.'/media/img/actions/edit-row.png" alt="editar" title="editar" style="border:0"/></a></td>'."\n";
				else
					$strhtml .= '<td>&nbsp;</td>';
				if(strlen(strpos($criterio["ibrac"],"B"))>0)
					$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="if(confirm(\'Esta Seguro?\')){xajax_remove('.$objpa_noticiasTO->getNoticia_id().',xajax.getFormValues(\'formulario\'));}"><img src="'.MY_URI.'/media/img/actions/delete-row.png" alt="eliminar" title="eliminar" style="border:0"/></a></td>'."\n";
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
				$objpa_noticiasDAO = new pa_noticiasDAO();
				$objpa_noticiasTO = new pa_noticiasTO();
				$objpa_noticiasTO->setNoticia_id($aFormValues['txt_noticia_id']);
				$objpa_noticiasTO->setTitulo($aFormValues['txt_titulo']);
				$objpa_noticiasTO->setDescripcion($aFormValues['txt_descripcion']);
				$objpa_noticiasTO->setFecha_registro(parsedate::changeDateFormat($aFormValues['txt_fecha_registro'], "d/m/Y H:i:s", DB_DATETIME_FORMAT ));
				$objpa_noticiasTO->setFecha_desde(parsedate::changeDateFormat($aFormValues['txt_fecha_desde']." 01:01:01", "d/m/Y H:i:s", DB_DATETIME_FORMAT ));
				$objpa_noticiasTO->setFecha_hasta(parsedate::changeDateFormat($aFormValues['txt_fecha_hasta']." 01:01:01", "d/m/Y H:i:s", DB_DATETIME_FORMAT ));
				$objpa_noticiasTO->setRegistrado_por($aFormValues['txt_usuario_id']);
				$objpa_noticiasTO->setTipo_id($aFormValues['cbx_parametro_new']);
				$objpa_noticiasTO->setArea_id($aFormValues['cbx_area_new']);

				if($aFormValues['txt_noticia_id'] == '0' )
					$objpa_noticiasDAO->insertpa_noticias($objpa_noticiasTO);
				else
					$objpa_noticiasDAO->updatepa_noticias($objpa_noticiasTO);

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
		$objResponse->assign("txt_noticia_id","value","0");
		$objResponse->assign("txt_titulo","value","");
		$objResponse->assign("txt_descripcion","value","");
		$objResponse->assign("txt_fecha_registro","value",date("d/m/Y H:i:s"));
		$objResponse->assign("txt_fecha_desde","value","");
		$objResponse->assign("txt_fecha_hasta","value","");
		$objResponse->assign("txt_registrado_por","value",  strtoupper($_SESSION[SESSION_USER]));
		$objResponse->assign("txt_tipo_id","value","");
		$objResponse->assign("txt_area_id","value","");
                $objResponse->assign("ctn_cbx_area","innerHTML",  loadCbx_Area("_new", true));
                $objResponse->assign("ctn_cbx_tipo","innerHTML", loadCbx_Parametros("_new", false,"NOTICIAS"));
		$objResponse->assign("fields_title_panel","innerHTML","Registrar Datos");
		$objResponse = hidePanel("datatable_box", $objResponse);
		$objResponse = hidePanel("searchfields", $objResponse);
		$objResponse = showPanel("fields", $objResponse);
                $objResponse->script("setDataContent('');");
                
		$objResponse = visibilityButton("savebutton", "visible", $objResponse);
		$objResponse = visibilityButton("cancelbutton", "visible", $objResponse);
		$objResponse = visibilityButton("addbutton", "visible", $objResponse);
		$objResponse = visibilityButton("searchbutton", "hidden", $objResponse);
		$objResponse = visibilityButton("editbutton", "hidden", $objResponse);

		$objResponse = readOnlyfiles("false",$objResponse);

		return $objResponse;
	}

	function remove($key,$aFormValues){
		$objpa_noticiasDAO = new pa_noticiasDAO();
		$objpa_noticiasTO = new pa_noticiasTO();
		$objpa_noticiasTO->setNoticia_id($key);
		$objpa_noticiasDAO->deletepa_noticias($objpa_noticiasTO);
		return loadtable($aFormValues,0);
	}

	function valid($aFormValues,$objResponse){
		$valid = true;
		$objResponse = clearvalid($objResponse);
			if(trim($aFormValues['txt_noticia_id']) == ""){
				$objResponse->assign("valid_noticia_id","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_titulo']) == ""){
				$objResponse->assign("valid_titulo","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_descripcion']) == ""){
				$objResponse->assign("valid_descripcion","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_fecha_registro']) == ""){
				$objResponse->assign("valid_fecha_registro","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
//				$valid = false;
			}
			if(trim($aFormValues['txt_fecha_desde']) == ""){
				$objResponse->assign("valid_fecha_desde","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_fecha_hasta']) == ""){
				$objResponse->assign("valid_fecha_hasta","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_registrado_por']) == ""){
				$objResponse->assign("valid_registrado_por","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(isset($aFormValues['cbx_parametro_new'])==false || trim($aFormValues['cbx_parametro_new']) == ""){
				$objResponse->assign("valid_tipo_id","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(isset($aFormValues['cbx_area_new'])==false || trim($aFormValues['cbx_area_new']) == ""){
				$objResponse->assign("valid_area_id","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
		return $valid;
	}
	function clearvalid($objResponse){
		$objResponse->assign("valid_noticia_id","innerHTML", "");
		$objResponse->assign("valid_titulo","innerHTML", "");
		$objResponse->assign("valid_descripcion","innerHTML", "");
		$objResponse->assign("valid_fecha_registro","innerHTML", "");
		$objResponse->assign("valid_fecha_desde","innerHTML", "");
		$objResponse->assign("valid_fecha_hasta","innerHTML", "");
		$objResponse->assign("valid_registrado_por","innerHTML", "");
		$objResponse->assign("valid_tipo_id","innerHTML", "");
		$objResponse->assign("valid_area_id","innerHTML", "");
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

		$objResponse->script("readonly('formulario','txt_noticia_id',$state)");
		$objResponse->script("readonly('formulario','txt_titulo',$state)");
		$objResponse->script("readonly('formulario','txt_descripcion',$state)");
		$objResponse->script("readonly('formulario','txt_fecha_registro',true)");
		$objResponse->script("readonly('formulario','txt_fecha_desde',$state)");
		$objResponse->script("readonly('formulario','txt_fecha_hasta',$state)");
		$objResponse->script("readonly('formulario','txt_registrado_por',true)");
		$objResponse->script("readonly('formulario','txt_tipo_id',$state)");
		$objResponse->script("readonly('formulario','txt_area_id',$state)");
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
		$objpa_noticiasDAO = new pa_noticiasDAO();
		//-- IBRAC
		if(isset($aFormValues["ibrac"]))
			$criterio["ibrac"] = $aFormValues["ibrac"];
		//-- IBRAC
                $criterio["ibrac"] = $aFormValues["ibrac"];
                $criterio["titulo"] = $aFormValues["txts_nombre"];
                $criterio["area_id"] = $aFormValues["cbx_area"];
		$arraylist = $objpa_noticiasDAO->selectByCriteria_pa_noticias($criterio,$page_number);
		$table_count = $objpa_noticiasDAO->selectCountpa_noticias($criterio);
		$objResponse = loadtable_default($page_number,$arraylist,$table_count,$criterio);
		return $objResponse;
	}

	$xajax->processRequest();

?>