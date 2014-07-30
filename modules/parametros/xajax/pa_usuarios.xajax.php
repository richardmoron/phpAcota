<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/xajax/xajax_core/xajax.inc.php");
	include_once (dirname(dirname(__FILE__))."/dao/pa_usuarios.dao.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/parsedate.php");
        include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/comboboxes.php");
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
		$objpa_usuariosDAO = new pa_usuariosDAO();
		$objpa_usuariosTO = $objpa_usuariosDAO->selectByIdpa_usuarios($key);
                $objResponse->assign("ctn_cbx_area","innerHTML",loadCbx_Area("_new",false));
                
		$objResponse->assign("txt_usuario_id","value",$objpa_usuariosTO->getUsuario_id());
		$objResponse->assign("txt_usuario","value",$objpa_usuariosTO->getUsuario());
		$objResponse->assign("txt_password","value",$objpa_usuariosTO->getPassword());
                $objResponse->assign("txt_password1","value",$objpa_usuariosTO->getPassword());
		$objResponse->assign("txt_nombres","value",$objpa_usuariosTO->getNombres());
		$objResponse->assign("txt_apellidos","value",$objpa_usuariosTO->getApellidos());
		$objResponse->assign("txt_email","value",$objpa_usuariosTO->getEmail());
		$objResponse->assign("txt_agencia_id","value",$objpa_usuariosTO->getAgencia_id());
		$objResponse->assign("cbx_area_new","value",$objpa_usuariosTO->getArea_id());
		$objResponse->assign("txt_estado","value",$objpa_usuariosTO->getEstado());
		$objResponse->assign("txt_tipo_usuario_id","value",$objpa_usuariosTO->getTipo_usuario_id());
		$objResponse->assign("txt_persona_id","value",$objpa_usuariosTO->getPersona_id());
		$objResponse->assign("txt_pregunta_secreta","value",$objpa_usuariosTO->getPregunta_secreta());
		$objResponse->assign("txt_respuesta_secreta","value",$objpa_usuariosTO->getRespuesta_secreta());
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
		$strhtml .= '<th scope="col">Nombres<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Apellidos<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Email<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Agencia<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Area<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
                $strhtml .= '<th scope="col">Estado<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th class="table-action">V</th>'."\n";
		$strhtml .= '<th class="table-action">E</th>'."\n";
		$strhtml .= '<th class="table-action">B</th>'."\n";
		$strhtml .= '</tr>'."\n";
		$strhtml .= '</thead>'."\n";
		$strhtml .= '<tfoot>'."\n";
		$strhtml .= '<tr id="table_footer">'."\n";
		$strhtml .= '<th colspan="'.(count(pa_usuariosTO::$FIELDS)+3).'" id="footer_right">'."\n";
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
				$objpa_usuariosTO = $iterator->current();
				$strhtml .= '<td>'.$objpa_usuariosTO->getUsuario().'</td>'."\n";
				$strhtml .= '<td>'.$objpa_usuariosTO->getNombres().'</td>'."\n";
				$strhtml .= '<td>'.$objpa_usuariosTO->getApellidos().'</td>'."\n";
				$strhtml .= '<td>'.$objpa_usuariosTO->getEmail().'</td>'."\n";
				$strhtml .= '<td>'.$objpa_usuariosTO->getAgencia_id().'</td>'."\n";
				$strhtml .= '<td>'.$objpa_usuariosTO->getArea().'</td>'."\n";
                                if($objpa_usuariosTO->getEstado() == "A")
                                    $strhtml .= '<td>ACTIVO</td>'."\n";
                                else{
                                    if($objpa_usuariosTO->getEstado() == "I")
                                        $strhtml .= '<td>INACTIVO</td>'."\n";
                                    else{
                                        if($objpa_usuariosTO->getEstado() == "B")
                                            $strhtml .= '<td>BLOQUEADO</td>'."\n";
                                    }
                                }
				//-- IBRAC
				$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="xajax_viewfields('.$objpa_usuariosTO->getUsuario_id().');"><img src="'.MY_URI.'/media/img/actions/view-row.png" alt="ver" title="ver" style="border:0"/></a></td>'."\n";
				if(strlen(strpos($criterio["ibrac"],"A"))>0)
					$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="xajax_loadfields('.$objpa_usuariosTO->getUsuario_id().');"><img src="'.MY_URI.'/media/img/actions/edit-row.png" alt="editar" title="editar" style="border:0"/></a></td>'."\n";
				else
					$strhtml .= '<td>&nbsp;</td>';
				if(strlen(strpos($criterio["ibrac"],"B"))>0)
					$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="if(confirm(\'Esta Seguro?\')){xajax_remove('.$objpa_usuariosTO->getUsuario_id().',xajax.getFormValues(\'formulario\'));}"><img src="'.MY_URI.'/media/img/actions/delete-row.png" alt="eliminar" title="eliminar" style="border:0"/></a></td>'."\n";
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
				$objpa_usuariosDAO = new pa_usuariosDAO();
				$objpa_usuariosTO = new pa_usuariosTO();
				$objpa_usuariosTO->setUsuario_id($aFormValues['txt_usuario_id']);
				$objpa_usuariosTO->setUsuario($aFormValues['txt_usuario']);
				$objpa_usuariosTO->setPassword(md5($aFormValues['txt_password']));
				$objpa_usuariosTO->setNombres($aFormValues['txt_nombres']);
				$objpa_usuariosTO->setApellidos($aFormValues['txt_apellidos']);
				$objpa_usuariosTO->setEmail($aFormValues['txt_email']);
				$objpa_usuariosTO->setAgencia_id($aFormValues['txt_agencia_id']);
				$objpa_usuariosTO->setArea_id($aFormValues['cbx_area_new']);
				$objpa_usuariosTO->setEstado($aFormValues['txt_estado']);
				$objpa_usuariosTO->setTipo_usuario_id($aFormValues['txt_tipo_usuario_id']);
				$objpa_usuariosTO->setPersona_id($aFormValues['txt_persona_id']);
				$objpa_usuariosTO->setPregunta_secreta($aFormValues['txt_pregunta_secreta']);
				$objpa_usuariosTO->setRespuesta_secreta($aFormValues['txt_respuesta_secreta']);

				if($aFormValues['txt_usuario_id'] == '0' )
					$objpa_usuariosDAO->insertpa_usuarios($objpa_usuariosTO);
				else
					$objpa_usuariosDAO->updatepa_usuarios($objpa_usuariosTO);

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
		$objResponse->assign("txt_usuario_id","value","0");
		$objResponse->assign("txt_usuario","value","");
		$objResponse->assign("txt_password","value","");
                $objResponse->assign("txt_password1","value","");
		$objResponse->assign("txt_nombres","value","");
		$objResponse->assign("txt_apellidos","value","");
		$objResponse->assign("txt_email","value","");
		$objResponse->assign("txt_agencia_id","value","");
		$objResponse->assign("txt_area_id","value","");
		$objResponse->assign("txt_estado","value","");
		$objResponse->assign("txt_tipo_usuario_id","value","");
		$objResponse->assign("txt_persona_id","value","");
		$objResponse->assign("txt_pregunta_secreta","value","");
		$objResponse->assign("txt_respuesta_secreta","value","");
                $objResponse->assign("ctn_cbx_area","innerHTML",loadCbx_Area("_new",false));
                
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
		$objpa_usuariosDAO = new pa_usuariosDAO();
		$objpa_usuariosTO = new pa_usuariosTO();
		$objpa_usuariosTO->setUsuario_id($key);
		$objpa_usuariosDAO->deletepa_usuarios($objpa_usuariosTO);
		return loadtable($aFormValues,0);
	}

	function valid($aFormValues,$objResponse){
		$valid = true;
		$objResponse = clearvalid($objResponse);
			if(trim($aFormValues['txt_usuario']) == ""){
				$objResponse->assign("valid_usuario","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_password']) == ""){
				$objResponse->assign("valid_password","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
                        if(trim($aFormValues['txt_password']) != trim($aFormValues['txt_password1'])){
				$objResponse->assign("valid_password","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
                                $objResponse->assign("valid_password1","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" /> Las claves no coinciden');
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
			if(trim($aFormValues['txt_email']) == ""){
				$objResponse->assign("valid_email","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_agencia_id']) == ""){
				$objResponse->assign("valid_agencia_id","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			
			if(trim($aFormValues['txt_estado']) == ""){
				$objResponse->assign("valid_estado","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_tipo_usuario_id']) == ""){
				$objResponse->assign("valid_tipo_usuario_id","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_persona_id']) == ""){
				$objResponse->assign("valid_persona_id","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
		return $valid;
	}
	function clearvalid($objResponse){
		$objResponse->assign("valid_usuario_id","innerHTML", "");
		$objResponse->assign("valid_usuario","innerHTML", "");
		$objResponse->assign("valid_password","innerHTML", "");
		$objResponse->assign("valid_nombres","innerHTML", "");
		$objResponse->assign("valid_apellidos","innerHTML", "");
		$objResponse->assign("valid_email","innerHTML", "");
		$objResponse->assign("valid_agencia_id","innerHTML", "");
		$objResponse->assign("valid_area_id","innerHTML", "");
		$objResponse->assign("valid_estado","innerHTML", "");
		$objResponse->assign("valid_tipo_usuario_id","innerHTML", "");
		$objResponse->assign("valid_persona_id","innerHTML", "");
		$objResponse->assign("valid_pregunta_secreta","innerHTML", "");
		$objResponse->assign("valid_respuesta_secreta","innerHTML", "");
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

		$objResponse->script("readonly('formulario','txt_usuario_id',$state)");
		$objResponse->script("readonly('formulario','txt_usuario',$state)");
		$objResponse->script("readonly('formulario','txt_password',$state)");
		$objResponse->script("readonly('formulario','txt_nombres',$state)");
		$objResponse->script("readonly('formulario','txt_apellidos',$state)");
		$objResponse->script("readonly('formulario','txt_email',$state)");
		$objResponse->script("readonly('formulario','txt_agencia_id',$state)");
		$objResponse->script("readonly('formulario','txt_area_id',$state)");
		$objResponse->script("readonly('formulario','txt_estado',$state)");
		$objResponse->script("readonly('formulario','txt_tipo_usuario_id',$state)");
		$objResponse->script("readonly('formulario','txt_persona_id',$state)");
		$objResponse->script("readonly('formulario','txt_pregunta_secreta',$state)");
		$objResponse->script("readonly('formulario','txt_respuesta_secreta',$state)");
                $objResponse->script("readonly('formulario','txt_password1',$state)");
		if($state == "false"){
			$objResponse = visibilityButton("savebutton", "visible", $objResponse);
                        $objResponse = visibilityButton("editbutton", "hidden", $objResponse);
                        $objResponse->script("disableField('formulario','cbx_area_new','');");
                        $objResponse->script("disableField('formulario','txt_estado','');");
                }else{
                    $objResponse->script("disableField('formulario','cbx_area_new','disabled');");
                    $objResponse->script("disableField('formulario','txt_estado','disabled');");
                }
		return $objResponse;
	}

	function cancel($aFormValues){
		$objResponse = searchfields($aFormValues,0);
		return $objResponse;
	}

	function searchfields($aFormValues,$page_number){
		$criterio = array();
		$objpa_usuariosDAO = new pa_usuariosDAO();
		//-- IBRAC
		if(isset($aFormValues["ibrac"]))
			$criterio["ibrac"] = $aFormValues["ibrac"];
		//-- IBRAC
                if(isset($aFormValues["txts_usuario"]) && strlen(trim($aFormValues["txts_usuario"]))>0)
                    $criterio["usuario"] = $aFormValues["txts_usuario"];
                
                if(isset($aFormValues["txts_nombres"]) && strlen(trim($aFormValues["txts_nombres"]))>0)
                    $criterio["nombres"] = $aFormValues["txts_nombres"];
                
                if(isset($aFormValues["txts_apellidos"]) && strlen(trim($aFormValues["txts_apellidos"]))>0)
                    $criterio["apellidos"] = $aFormValues["txts_apellidos"];
                
		$arraylist = $objpa_usuariosDAO->selectByCriteria_pa_usuarios($criterio,$page_number);
		$table_count = $objpa_usuariosDAO->selectCountpa_usuarios($criterio);
		$objResponse = loadtable_default($page_number,$arraylist,$table_count,$criterio);
		return $objResponse;
	}

	$xajax->processRequest();

?>