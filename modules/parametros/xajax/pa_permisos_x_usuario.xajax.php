<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/xajax/xajax_core/xajax.inc.php");
	include_once (dirname(dirname(__FILE__))."/dao/pa_permisos_x_usuario.dao.php");
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
		$objpa_permisos_x_usuarioDAO = new pa_permisos_x_usuarioDAO();
		$objpa_permisos_x_usuarioTO = $objpa_permisos_x_usuarioDAO->selectByIdpa_permisos_x_usuario($key);

		$objResponse->assign("txt_permisos_x_usuario_id","value",$objpa_permisos_x_usuarioTO->getPermisos_x_usuario_id());
		$objResponse->assign("txt_usuario_id","value",$objpa_permisos_x_usuarioTO->getUsuario_id());
                $objResponse->assign("txt_usuario_nombres","value",$objpa_permisos_x_usuarioTO->getUsuario());
		$objResponse->assign("txt_archivo","value",$objpa_permisos_x_usuarioTO->getArchivo());
		$objResponse->assign("txt_insertar","value",$objpa_permisos_x_usuarioTO->getInsertar());
		$objResponse->assign("txt_borrar","value",$objpa_permisos_x_usuarioTO->getBorrar());
		$objResponse->assign("txt_reporte","value",$objpa_permisos_x_usuarioTO->getReporte());
		$objResponse->assign("txt_actualizar","value",$objpa_permisos_x_usuarioTO->getActualizar());
		$objResponse->assign("txt_consultar","value",$objpa_permisos_x_usuarioTO->getConsultar());
		$objResponse->assign("txt_observaciones","value",$objpa_permisos_x_usuarioTO->getObservaciones());
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
		$strhtml .= '<th scope="col">Usuario<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Archivo<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Insertar<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Borrar<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Reporte<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Actualizar<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Consultar<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th class="table-action">V</th>'."\n";
		$strhtml .= '<th class="table-action">E</th>'."\n";
		$strhtml .= '<th class="table-action">B</th>'."\n";
		$strhtml .= '</tr>'."\n";
		$strhtml .= '</thead>'."\n";
		$strhtml .= '<tfoot>'."\n";
		$strhtml .= '<tr id="table_footer">'."\n";
		$strhtml .= '<th colspan="'.(count(pa_permisos_x_usuarioTO::$FIELDS)+3).'" id="footer_right">'."\n";
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
				$objpa_permisos_x_usuarioTO = $iterator->current();
				$strhtml .= '<td>'.$objpa_permisos_x_usuarioTO->getUsuario().'</td>'."\n";
				$strhtml .= '<td>'.$objpa_permisos_x_usuarioTO->getArchivo().'</td>'."\n";
                                
                                if($objpa_permisos_x_usuarioTO->getInsertar() == "S")
                                    $strhtml .= '<td>SI</td>'."\n";
                                else
                                    $strhtml .= '<td>NO</td>'."\n";
                                
                                if($objpa_permisos_x_usuarioTO->getBorrar() == "S")
                                    $strhtml .= '<td>SI</td>'."\n";
                                else
                                    $strhtml .= '<td>NO</td>'."\n";
                                
                                if($objpa_permisos_x_usuarioTO->getReporte() == "S")
                                    $strhtml .= '<td>SI</td>'."\n";
                                else
                                    $strhtml .= '<td>NO</td>'."\n";
                                
                                if($objpa_permisos_x_usuarioTO->getActualizar() == "S")
                                    $strhtml .= '<td>SI</td>'."\n";
                                else
                                    $strhtml .= '<td>NO</td>'."\n";
                                
                                if($objpa_permisos_x_usuarioTO->getConsultar() == "S")
                                    $strhtml .= '<td>SI</td>'."\n";
                                else
                                    $strhtml .= '<td>NO</td>'."\n";
                                
				//-- IBRAC
				$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="xajax_viewfields('.$objpa_permisos_x_usuarioTO->getPermisos_x_usuario_id().');"><img src="'.MY_URI.'/media/img/actions/view-row.png" alt="ver" title="ver" style="border:0"/></a></td>'."\n";
				if(strlen(strpos($criterio["ibrac"],"A"))>0)
					$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="xajax_loadfields('.$objpa_permisos_x_usuarioTO->getPermisos_x_usuario_id().');"><img src="'.MY_URI.'/media/img/actions/edit-row.png" alt="editar" title="editar" style="border:0"/></a></td>'."\n";
				else
					$strhtml .= '<td>&nbsp;</td>';
				if(strlen(strpos($criterio["ibrac"],"B"))>0)
					$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="if(confirm(\'Esta Seguro?\')){xajax_remove('.$objpa_permisos_x_usuarioTO->getPermisos_x_usuario_id().',xajax.getFormValues(\'formulario\'));}"><img src="'.MY_URI.'/media/img/actions/delete-row.png" alt="eliminar" title="eliminar" style="border:0"/></a></td>'."\n";
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
				$objpa_permisos_x_usuarioDAO = new pa_permisos_x_usuarioDAO();
				$objpa_permisos_x_usuarioTO = new pa_permisos_x_usuarioTO();
				$objpa_permisos_x_usuarioTO->setPermisos_x_usuario_id($aFormValues['txt_permisos_x_usuario_id']);
				$objpa_permisos_x_usuarioTO->setUsuario_id($aFormValues['txt_usuario_id']);
				$objpa_permisos_x_usuarioTO->setArchivo($aFormValues['txt_archivo']);
				$objpa_permisos_x_usuarioTO->setInsertar($aFormValues['txt_insertar']);
				$objpa_permisos_x_usuarioTO->setBorrar($aFormValues['txt_borrar']);
				$objpa_permisos_x_usuarioTO->setReporte($aFormValues['txt_reporte']);
				$objpa_permisos_x_usuarioTO->setActualizar($aFormValues['txt_actualizar']);
				$objpa_permisos_x_usuarioTO->setConsultar($aFormValues['txt_consultar']);
				$objpa_permisos_x_usuarioTO->setObservaciones($aFormValues['txt_observaciones']);

				if($aFormValues['txt_permisos_x_usuario_id'] == '0' )
					$objpa_permisos_x_usuarioDAO->insertpa_permisos_x_usuario($objpa_permisos_x_usuarioTO);
				else
					$objpa_permisos_x_usuarioDAO->updatepa_permisos_x_usuario($objpa_permisos_x_usuarioTO);

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
		$objResponse->assign("txt_permisos_x_usuario_id","value","0");
		$objResponse->assign("txt_usuario_id","value","");
                $objResponse->assign("txt_usuario_nombres","value","");
		$objResponse->assign("txt_archivo","value","");
		$objResponse->assign("txt_insertar","value","S");
		$objResponse->assign("txt_borrar","value","S");
		$objResponse->assign("txt_reporte","value","S");
		$objResponse->assign("txt_actualizar","value","S");
		$objResponse->assign("txt_consultar","value","S");
		$objResponse->assign("txt_observaciones","value","");
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
		$objpa_permisos_x_usuarioDAO = new pa_permisos_x_usuarioDAO();
		$objpa_permisos_x_usuarioTO = new pa_permisos_x_usuarioTO();
		$objpa_permisos_x_usuarioTO->setPermisos_x_usuario_id($key);
		$objpa_permisos_x_usuarioDAO->deletepa_permisos_x_usuario($objpa_permisos_x_usuarioTO);
		return loadtable($aFormValues,0);
	}

	function valid($aFormValues,$objResponse){
		$valid = true;
		$objResponse = clearvalid($objResponse);

                        if(trim($aFormValues['txt_usuario_id']) == ""){
				$objResponse->assign("valid_usuario","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_usuario_nombres']) == ""){
				$objResponse->assign("valid_usuario","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_archivo']) == ""){
				$objResponse->assign("valid_archivo","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			
		return $valid;
	}
	function clearvalid($objResponse){
		$objResponse->assign("valid_permisos_x_usuario_id","innerHTML", "");
		$objResponse->assign("valid_usuario","innerHTML", "");
		$objResponse->assign("valid_archivo","innerHTML", "");
		$objResponse->assign("valid_insertar","innerHTML", "");
		$objResponse->assign("valid_borrar","innerHTML", "");
		$objResponse->assign("valid_reporte","innerHTML", "");
		$objResponse->assign("valid_actualizar","innerHTML", "");
		$objResponse->assign("valid_consultar","innerHTML", "");
		$objResponse->assign("valid_observaciones","innerHTML", "");
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

		$objResponse->script("readonly('formulario','txt_permisos_x_usuario_id',$state)");
		$objResponse->script("readonly('formulario','txt_usuario',$state)");
		$objResponse->script("readonly('formulario','txt_archivo',$state)");
		$objResponse->script("readonly('formulario','txt_insertar',$state)");
		$objResponse->script("readonly('formulario','txt_borrar',$state)");
		$objResponse->script("readonly('formulario','txt_reporte',$state)");
		$objResponse->script("readonly('formulario','txt_actualizar',$state)");
		$objResponse->script("readonly('formulario','txt_consultar',$state)");
		$objResponse->script("readonly('formulario','txt_observaciones',$state)");
                $objResponse->script("readonly('formulario','txt_usuario_nombres',$state)");
		if($state == "false"){
			$objResponse = visibilityButton("savebutton", "visible", $objResponse);
                        $objResponse = visibilityButton("editbutton", "hidden", $objResponse);
                        $objResponse->script("disableField('formulario','btn_link1','');");
                        $objResponse->script("disableField('formulario','btn_link2','');");
                        $objResponse->script("disableField('formulario','txt_insertar','');");
                        $objResponse->script("disableField('formulario','txt_borrar','');");
                        $objResponse->script("disableField('formulario','txt_actualizar','');");
                        $objResponse->script("disableField('formulario','txt_consultar','');");
                        $objResponse->script("disableField('formulario','txt_reporte','');");
                }else{
                    $objResponse->script("disableField('formulario','btn_link1','disabled');");
                    $objResponse->script("disableField('formulario','btn_link2','disabled');");
                    $objResponse->script("disableField('formulario','txt_insertar','disabled');");
                    $objResponse->script("disableField('formulario','txt_borrar','disabled');");
                    $objResponse->script("disableField('formulario','txt_actualizar','disabled');");
                    $objResponse->script("disableField('formulario','txt_consultar','disabled');");
                    $objResponse->script("disableField('formulario','txt_reporte','disabled');");
                }
		return $objResponse;
	}

	function cancel($aFormValues){
		$objResponse = searchfields($aFormValues,0);
		return $objResponse;
	}

	function searchfields($aFormValues,$page_number){
		$criterio = array();
		$objpa_permisos_x_usuarioDAO = new pa_permisos_x_usuarioDAO();
		//-- IBRAC
		if(isset($aFormValues["ibrac"]))
			$criterio["ibrac"] = $aFormValues["ibrac"];
		//-- IBRAC
                
                if(isset($aFormValues["txts_archivo"]) && strlen(trim($aFormValues["txts_archivo"])) > 0)
                    $criterio["archivo"] = $aFormValues["txts_archivo"];
                
                if(isset($aFormValues["txts_usuario_id"]) && strlen(trim($aFormValues["txts_usuario_id"]))>0 && strlen(trim($aFormValues["txts_usuario_nombres"]))>0)
                    $criterio["usuario_id"] = $aFormValues["txts_usuario_id"];
                
		$arraylist = $objpa_permisos_x_usuarioDAO->selectByCriteria_pa_permisos_x_usuario($criterio,$page_number);
		$table_count = $objpa_permisos_x_usuarioDAO->selectCountpa_permisos_x_usuario($criterio);
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
            
            $objResponse->assign($elem, "value", $url);
            return $objResponse;
        }
        
	$xajax->processRequest();

?>