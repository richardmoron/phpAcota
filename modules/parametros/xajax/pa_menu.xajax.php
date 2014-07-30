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
        $xajax->registerFunction("path2URL");
        
	$xajax->registerFunction("readOnlyfiles");

	function preload(){
		$objResponse = loadtable(null,0);
//		$objResponse = loadUserLogged($objResponse);
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
			$objResponse->includeCSS("../css\noprint.css","print");
		$objResponse->assign("ibrac","value",$ibrac);
		return $objResponse;
	}
	//-- IBRAC
	function loadfields($key){
		$objResponse = new xajaxResponse();
		$objResponse = clearvalid($objResponse);
		$objpa_menuDAO = new pa_menuDAO();
		$objpa_menuTO = $objpa_menuDAO->selectByIdpa_menu($key);

		$objResponse->assign("txt_menu_id","value",$objpa_menuTO->getMenu_id());
		$objResponse->assign("txt_nombre","value",$objpa_menuTO->getNombre());
		$objResponse->assign("txt_descripcion","innerHTML",$objpa_menuTO->getDescripcion());
		$objResponse->assign("txt_link","value",$objpa_menuTO->getLink());
		$objResponse->assign("txt_menu_padre_id","value",$objpa_menuTO->getMenu_padre_id());
                $objResponse->assign("txt_menu_padre","value",$objpa_menuTO->getMenu_padre());
		$objResponse->assign("txt_area_id","value",$objpa_menuTO->getArea_id());
		$objResponse->assign("txt_es_padre","value",$objpa_menuTO->getEs_padre());
		$objResponse->assign("txt_exclusivo","value",$objpa_menuTO->getExclusivo());
		$objResponse->assign("txt_complemento","value",$objpa_menuTO->getComplemento());
		$objResponse->assign("txt_posicion","value",$objpa_menuTO->getPosicion());
                $objResponse->assign("txt_tab","value",$objpa_menuTO->getTab());
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
		$strhtml .= '<th scope="col">Nombre<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Menú Padre<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Es Padre<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Exclusivo<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Posicion<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th class="table-action">V</th>'."\n";
		$strhtml .= '<th class="table-action">E</th>'."\n";
		$strhtml .= '<th class="table-action">B</th>'."\n";
		$strhtml .= '</tr>'."\n";
		$strhtml .= '</thead>'."\n";
		$strhtml .= '<tfoot>'."\n";
		$strhtml .= '<tr id="table_footer">'."\n";
		$strhtml .= '<th colspan="'.(count(pa_menuTO::$FIELDS)+3).'" id="footer_right">'."\n";
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
				$objpa_menuTO = $iterator->current();
				$strhtml .= '<td>'.$objpa_menuTO->getNombre().'</td>'."\n";
				$strhtml .= '<td>'.$objpa_menuTO->getMenu_padre().'</td>'."\n";
                                if($objpa_menuTO->getEs_padre() == "S")
                                    $strhtml .= '<td>SI</td>'."\n";
                                else 
                                    $strhtml .= '<td>NO</td>'."\n";
                                if($objpa_menuTO->getExclusivo() == "S")
                                    $strhtml .= '<td>SI</td>'."\n";
                                else
                                    $strhtml .= '<td>NO</td>'."\n";
				$strhtml .= '<td>'.$objpa_menuTO->getPosicion().'</td>'."\n";
				//-- IBRAC
				$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="xajax_viewfields('.$objpa_menuTO->getMenu_id().');"><img src="'.MY_URI.'/media/img/actions/view-row.png" alt="ver" title="ver" style="border:0"/></a></td>'."\n";
				if(strlen(strpos($criterio["ibrac"],"A"))>0)
					$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="xajax_loadfields('.$objpa_menuTO->getMenu_id().');"><img src="'.MY_URI.'/media/img/actions/edit-row.png" alt="editar" title="editar" style="border:0"/></a></td>'."\n";
				else
					$strhtml .= '<td>&nbsp;</td>';
				if(strlen(strpos($criterio["ibrac"],"B"))>0)
					$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="if(confirm(\'Esta Seguro?\')){xajax_remove('.$objpa_menuTO->getMenu_id().',xajax.getFormValues(\'formulario\'));}"><img src="'.MY_URI.'/media/img/actions/delete-row.png" alt="eliminar" title="eliminar" style="border:0"/></a></td>'."\n";
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
				$objpa_menuDAO = new pa_menuDAO();
				$objpa_menuTO = new pa_menuTO();
				$objpa_menuTO->setMenu_id($aFormValues['txt_menu_id']);
				$objpa_menuTO->setNombre($aFormValues['txt_nombre']);
				$objpa_menuTO->setDescripcion($aFormValues['txt_descripcion']);
				$objpa_menuTO->setLink($aFormValues['txt_link']);
                                if(strlen(trim($aFormValues['txt_menu_padre_id'])) == 0)
                                    $aFormValues['txt_menu_padre_id'] = "0";
				$objpa_menuTO->setMenu_padre_id($aFormValues['txt_menu_padre_id']);
				$objpa_menuTO->setArea_id("0");//$aFormValues['txt_area_id']);
				$objpa_menuTO->setEs_padre($aFormValues['txt_es_padre']);
				$objpa_menuTO->setExclusivo($aFormValues['txt_exclusivo']);
				$objpa_menuTO->setComplemento($aFormValues['txt_complemento']);
                                if(strlen(trim($aFormValues['txt_posicion'])) == 0)
                                    $aFormValues['txt_posicion'] = "0";
				$objpa_menuTO->setPosicion($aFormValues['txt_posicion']);
                                $objpa_menuTO->setTab($aFormValues['txt_tab']);

				if($aFormValues['txt_menu_id'] == '0' )
					$objpa_menuDAO->insertpa_menu($objpa_menuTO);
				else
					$objpa_menuDAO->updatepa_menu($objpa_menuTO);

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
		$objResponse->assign("txt_menu_id","value","0");
		$objResponse->assign("txt_nombre","value","");
		$objResponse->assign("txt_descripcion","value","");
		$objResponse->assign("txt_link","value","");
		$objResponse->assign("txt_menu_padre_id","value","");
                $objResponse->assign("txt_menu_padre","value","");
		$objResponse->assign("txt_area_id","value","");
		$objResponse->assign("txt_es_padre","value","S");
		$objResponse->assign("txt_exclusivo","value","N");
		$objResponse->assign("txt_complemento","value","");
		$objResponse->assign("txt_posicion","value","");
                $objResponse->assign("txt_tab","value","S");
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
                $objResponse->script("disableField('formulario','txt_link','disabled');");
                $objResponse->script("disableField('formulario','btn_link1','disabled');");

		return $objResponse;
	}

	function remove($key,$aFormValues){
		$objpa_menuDAO = new pa_menuDAO();
		$objpa_menuTO = new pa_menuTO();
		$objpa_menuTO->setMenu_id($key);
		$objpa_menuDAO->deletepa_menu($objpa_menuTO);
		return loadtable($aFormValues,0);
	}

	function valid($aFormValues,$objResponse){
		$valid = true;
		$objResponse = clearvalid($objResponse);
			if(trim($aFormValues['txt_nombre']) == ""){
				$objResponse->assign("valid_nombre","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_descripcion']) == ""){
				$objResponse->assign("valid_descripcion","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
//			if(trim($aFormValues['txt_menu_padre_id']) == ""){
//				$objResponse->assign("valid_menu_padre_id","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
//				$valid = false;
//			}
			if(trim($aFormValues['txt_es_padre']) == ""){
				$objResponse->assign("valid_es_padre","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_exclusivo']) == ""){
				$objResponse->assign("valid_exclusivo","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}

		return $valid;
	}
	function clearvalid($objResponse){
		$objResponse->assign("valid_menu_id","innerHTML", "");
		$objResponse->assign("valid_nombre","innerHTML", "");
		$objResponse->assign("valid_descripcion","innerHTML", "");
		$objResponse->assign("valid_link","innerHTML", "");
		$objResponse->assign("valid_menu_padre_id","innerHTML", "");
		$objResponse->assign("valid_area_id","innerHTML", "");
		$objResponse->assign("valid_es_padre","innerHTML", "");
		$objResponse->assign("valid_exclusivo","innerHTML", "");
		$objResponse->assign("valid_complemento","innerHTML", "");
		$objResponse->assign("valid_posicion","innerHTML", "");
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

		$objResponse->script("readonly('formulario','txt_menu_id',$state)");
		$objResponse->script("readonly('formulario','txt_nombre',$state)");
		$objResponse->script("readonly('formulario','txt_descripcion',$state)");
		$objResponse->script("readonly('formulario','txt_link',$state)");
		$objResponse->script("readonly('formulario','txt_menu_padre_id',$state)");
                $objResponse->script("readonly('formulario','txt_menu_padre',$state)");
		$objResponse->script("readonly('formulario','txt_area_id',$state)");
		$objResponse->script("readonly('formulario','txt_es_padre',$state)");
		$objResponse->script("readonly('formulario','txt_exclusivo',$state)");
		$objResponse->script("readonly('formulario','txt_complemento',$state)");
		$objResponse->script("readonly('formulario','txt_posicion',$state)");
                $objResponse->script("readonly('formulario','txt_tab',$state)");
		if($state == "false"){
			$objResponse = visibilityButton("savebutton", "visible", $objResponse);
                        $objResponse = visibilityButton("editbutton", "hidden", $objResponse);
                        $objResponse->script("disableField('formulario','txt_link','');");
                        $objResponse->script("disableField('formulario','btn_link1','');");
                        $objResponse->script("disableField('formulario','btn_link2','');");
                        $objResponse->script("disableField('formulario','btn_link3','');");
                        $objResponse->script("disableField('formulario','txt_exclusivo','');");
                        $objResponse->script("disableField('formulario','txt_es_padre','');");
                }else{
                    $objResponse->script("disableField('formulario','txt_link','disabled');");
                    $objResponse->script("disableField('formulario','btn_link1','disabled');");
                    $objResponse->script("disableField('formulario','btn_link2','disabled');");
                    $objResponse->script("disableField('formulario','btn_link3','disabled');");
                    $objResponse->script("disableField('formulario','txt_exclusivo','disabled');");
                    $objResponse->script("disableField('formulario','txt_es_padre','disabled');");
                }
		return $objResponse;
	}

	function cancel($aFormValues){
		$objResponse = searchfields($aFormValues,0);
		return $objResponse;
	}

	function searchfields($aFormValues,$page_number){
		$criterio = array();
		$objpa_menuDAO = new pa_menuDAO();
		//-- IBRAC
		if(isset($aFormValues["ibrac"]))
			$criterio["ibrac"] = $aFormValues["ibrac"];
		//-- IBRAC
                if(isset($aFormValues["txts_nombre"]) && strlen(trim($aFormValues["txts_nombre"]))>0)
                    $criterio["nombre"] = $aFormValues["txts_nombre"];
                
                if(isset($aFormValues["txts_es_padre"]) && $aFormValues["txts_es_padre"]!= "0")
                    $criterio["es_padre"] = $aFormValues["txts_es_padre"];
                
                if(isset($aFormValues["txts_es_exclusivo"]) && $aFormValues["txts_es_exclusivo"]!= "0")
                    $criterio["exclusivo"] = $aFormValues["txts_es_exclusivo"];
                
                if(isset($aFormValues["txts_menu_padre_id"]) && strlen(trim($aFormValues["txts_menu_padre_id"]))>0 && strlen(trim($aFormValues["txts_menu_padre"]))>0)
                    $criterio["menu_padre_id"] = $aFormValues["txts_menu_padre_id"];
                
		$arraylist = $objpa_menuDAO->selectByCriteria_pa_menu($criterio,$page_number);
		$table_count = $objpa_menuDAO->selectCountpa_menu($criterio);
		$objResponse = loadtable_default($page_number,$arraylist,$table_count,$criterio);
		return $objResponse;
	}
        
        function path2URL($file,$elem,$http){
            $objResponse = new xajaxResponse();
            $http = false;
            $url = '';
            if($http){
                $url = str_replace('\\', "/",''.MY_URI.str_replace(strtolower(ROOT_FOLDER), '', strtolower($file)));
            }else{
                $url = str_replace('\\', "/",''.str_replace(strtolower(ROOT_FOLDER)."/", '', strtolower($file)));
                //$url = strtolower($file);
            }
            $url = str_replace('\\', "/",''.str_replace(strtolower(ROOT_FOLDER), '', strtolower($file)));
            $objResponse->assign($elem, "value", $url);
            return $objResponse;
        }
	$xajax->processRequest();

?>