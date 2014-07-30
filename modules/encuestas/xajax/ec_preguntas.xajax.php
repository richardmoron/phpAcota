<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/xajax/xajax_core/xajax.inc.php");
	include_once (dirname(dirname(__FILE__))."/dao/ec_preguntas.dao.php");
        include_once (dirname(dirname(__FILE__))."/dao/ec_grupos_preguntas.dao.php");
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
        $xajax->registerFunction("loadGruposAndNroPregunta"); 

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
                $objResponse->assign("ctns_cbx_tipo_respuesta","innerHTML", loadCbx_Parametros("", true,"TIPO_RESPUESTA"));
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
		$objec_preguntasDAO = new ec_preguntasDAO();
		$objec_preguntasTO = $objec_preguntasDAO->selectByIdec_preguntas($key);
                $objResponse->assign("ctn_cbx_tipo_respuesta","innerHTML", loadCbx_Parametros("_new", false,"TIPO_RESPUESTA"));
                $objResponse = loadGruposAndNroPregunta($objec_preguntasTO->getEncuesta_id(),"_new",$objResponse);
                
		$objResponse->assign("txt_pregunta_id","value",$objec_preguntasTO->getPregunta_id());
		$objResponse->assign("txt_encuesta_id","value",$objec_preguntasTO->getEncuesta_id());
                $objResponse->assign("txt_nombre_encuesta","value",$objec_preguntasTO->getEncuesta());
		$objResponse->assign("cbx_grupo_preguntas_id_new","value",$objec_preguntasTO->getGrupo_id());
		$objResponse->assign("txt_pregunta","value",$objec_preguntasTO->getPregunta());
		$objResponse->assign("cbx_parametro_new","value",$objec_preguntasTO->getTipo_respuesta());
		$objResponse->assign("txt_respuesta","value",$objec_preguntasTO->getRespuesta());
		$objResponse->assign("txt_atributo_extra","value",$objec_preguntasTO->getAtributo_extra());
		$objResponse->assign("txt_nro_pregunta","value",$objec_preguntasTO->getNro_pregunta());
                $objResponse->assign("txt_alineacion_respuesta","value",$objec_preguntasTO->getAlineacion_respuesta());
                $objResponse->assign("txt_label_izq","value",$objec_preguntasTO->getLabel_izq());
                $objResponse->assign("txt_label_der","value",$objec_preguntasTO->getLabel_der());
                
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
		$strhtml .= '<th scope="col" style="width:150px;">Encuesta<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Grupo<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
        $strhtml .= '<th scope="col" style="width:50px;">Nro<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col" style="width:300px;">Pregunta<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col" style="width:100px;">Tipo Resp<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th class="table-action">R</th>'."\n";
                $strhtml .= '<th class="table-action">V</th>'."\n";
		$strhtml .= '<th class="table-action">E</th>'."\n";
		$strhtml .= '<th class="table-action">B</th>'."\n";
		$strhtml .= '</tr>'."\n";
		$strhtml .= '</thead>'."\n";
		$strhtml .= '<tfoot>'."\n";
		$strhtml .= '<tr id="table_footer">'."\n";
		$strhtml .= '<th colspan="'.(count(ec_preguntasTO::$FIELDS)+3).'" id="footer_right">'."\n";
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
				$objec_preguntasTO = $iterator->current();
				$strhtml .= '<td>'.$objec_preguntasTO->getEncuesta().'</td>'."\n";
				$strhtml .= '<td>'.$objec_preguntasTO->getGrupo().'</td>'."\n";
				$strhtml .= '<td>'.$objec_preguntasTO->getNro_pregunta().'</td>'."\n";
                                $strhtml .= '<td>'.$objec_preguntasTO->getPregunta().'</td>'."\n";
				$strhtml .= '<td>'.$objec_preguntasTO->getTipo_respuesta_desc().'</td>'."\n";
				
				
                                if($objec_preguntasTO->getTipo_respuesta() == 15 || $objec_preguntasTO->getTipo_respuesta() == 16 || $objec_preguntasTO->getTipo_respuesta() == 17)
                                    $strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="window.showModalDialog(\'ec_valores_respuesta.php?pregunta_id='.$objec_preguntasTO->getPregunta_id().'\', window,\'dialogWidth:480px;dialogHeight:600px;status:no;resizable:no\');"><img src="'.MY_URI.'/media/img/actions/key.png" alt="ver" title="ver" style="border:0"/></a></td>'."\n";
                                else 
                                    $strhtml .= '<td>&nbsp;</td>';
                                //-- IBRAC
				$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="xajax_viewfields('.$objec_preguntasTO->getPregunta_id().');"><img src="'.MY_URI.'/media/img/actions/view-row.png" alt="ver" title="ver" style="border:0"/></a></td>'."\n";
				if(strlen(strpos($criterio["ibrac"],"A"))>0)
					$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="xajax_loadfields('.$objec_preguntasTO->getPregunta_id().');"><img src="'.MY_URI.'/media/img/actions/edit-row.png" alt="editar" title="editar" style="border:0"/></a></td>'."\n";
				else
					$strhtml .= '<td>&nbsp;</td>';
				if(strlen(strpos($criterio["ibrac"],"B"))>0)
					$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="if(confirm(\'Esta Seguro?\')){xajax_remove('.$objec_preguntasTO->getPregunta_id().',xajax.getFormValues(\'formulario\'));}"><img src="'.MY_URI.'/media/img/actions/delete-row.png" alt="eliminar" title="eliminar" style="border:0"/></a></td>'."\n";
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
				$objec_preguntasDAO = new ec_preguntasDAO();
				$objec_preguntasTO = new ec_preguntasTO();
				$objec_preguntasTO->setPregunta_id($aFormValues['txt_pregunta_id']);
				$objec_preguntasTO->setEncuesta_id($aFormValues['txt_encuesta_id']);
				$objec_preguntasTO->setGrupo_id($aFormValues['cbx_grupo_preguntas_id_new']);
				$objec_preguntasTO->setPregunta($aFormValues['txt_pregunta']);
				$objec_preguntasTO->setTipo_respuesta($aFormValues['cbx_parametro_new']);
//				$objec_preguntasTO->setRespuesta($aFormValues['txt_respuesta']);
				$objec_preguntasTO->setAtributo_extra($aFormValues['txt_atributo_extra']);
				$objec_preguntasTO->setNro_pregunta($aFormValues['txt_nro_pregunta']);
                                $objec_preguntasTO->setAlineacion_respuesta($aFormValues['txt_alineacion_respuesta']);
                                $objec_preguntasTO->setLabel_izq($aFormValues['txt_label_izq']);
                                $objec_preguntasTO->setLabel_der($aFormValues['txt_label_der']);

				if($aFormValues['txt_pregunta_id'] == '0' )
					$objec_preguntasDAO->insertec_preguntas($objec_preguntasTO);
				else
					$objec_preguntasDAO->updateec_preguntas($objec_preguntasTO);

				return loadtable($aFormValues,0);
			}
		}catch(Exception $ex){
			$objResponse->script("alert('".$ex->getMessage()."')");
		}
		return $objResponse;
	}
        
        function loadGruposAndNroPregunta($encuesta_id, $new="", $objResponse = null){
            if($objResponse == null){
                $objResponse = new xajaxResponse();
                $ec_preguntasDAO = new ec_preguntasDAO();
                $ec_preguntasTO = $ec_preguntasDAO->selectByIdec_preguntasTopNro($encuesta_id);
                $nro_pregunta = $ec_preguntasTO->getNro_pregunta()+1;
                $objResponse->assign("txt_nro_pregunta", "value", $nro_pregunta);
                //--
            }
            
            $html = "<select id='cbx_grupo_preguntas_id".$new."' name='cbx_grupo_preguntas_id".$new."' style='width:250px;'>";
            $ec_grupos_preguntasDAO = new ec_grupos_preguntasDAO();
            $criterio = array("encuesta_id"=>$encuesta_id);
            $arraylist = $ec_grupos_preguntasDAO->selectByCriteria_ec_grupos_preguntas($criterio, -1);
            $iterator = $arraylist->getIterator();
            while($iterator->valid()){
                $ec_grupos_preguntasTO = $iterator->current();
                $html .= "<option value='".$ec_grupos_preguntasTO->getGrupo_id()."'>".$ec_grupos_preguntasTO->getNombre()."/".$ec_grupos_preguntasTO->getTipo_desc()."</option>";  
                $iterator->next();
            }
            $html .= "</select>";
            $objResponse->assign("ctn_cbx_grupo_pregunta", "innerHTML", $html);
            //--
            
            return $objResponse;
        }
        
	function add(){
		$objResponse = new xajaxResponse();
		$objResponse = clearvalid($objResponse);
		$objResponse->assign("txt_pregunta_id","value","0");
		$objResponse->assign("txt_encuesta_id","value","");
                $objResponse->assign("txt_nombre_encuesta","value","");
		$objResponse->assign("txt_grupo_id","value","");
		$objResponse->assign("txt_pregunta","value","");
		$objResponse->assign("txt_tipo_respuesta","value","");
		$objResponse->assign("txt_respuesta","value","");
		$objResponse->assign("txt_atributo_extra","value","");
		$objResponse->assign("txt_nro_pregunta","value","");
                $objResponse->assign("txt_alineacion_respuesta","value","");
                $objResponse->assign("txt_label_izq","value","");
                $objResponse->assign("txt_label_der","value","");
		$objResponse->assign("fields_title_panel","innerHTML","Registrar Datos");
                $objResponse->assign("ctn_cbx_tipo_respuesta","innerHTML", loadCbx_Parametros("_new", false,"TIPO_RESPUESTA"));
                $objResponse->assign("ctn_cbx_grupo_pregunta","innerHTML", '<select style="width: 250px;"></select>');
                
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
		$objec_preguntasDAO = new ec_preguntasDAO();
		$objec_preguntasTO = new ec_preguntasTO();
		$objec_preguntasTO->setPregunta_id($key);
		$objec_preguntasDAO->deleteec_preguntas($objec_preguntasTO);
		return loadtable($aFormValues,0);
	}

	function valid($aFormValues,$objResponse){
		$valid = true;
		$objResponse = clearvalid($objResponse);
			if(trim($aFormValues['txt_pregunta_id']) == ""){
				$objResponse->assign("valid_pregunta_id","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_encuesta_id']) == ""){
				$objResponse->assign("valid_encuesta_id","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['cbx_grupo_preguntas_id_new']) == ""){
				$objResponse->assign("valid_grupo_id","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_pregunta']) == ""){
				$objResponse->assign("valid_pregunta","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['cbx_parametro_new']) == ""){
				$objResponse->assign("valid_tipo_respuesta","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
//			if(trim($aFormValues['txt_respuesta']) == ""){
//				$objResponse->assign("valid_respuesta","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
//				$valid = false;
//			}
//			if(trim($aFormValues['txt_atributo_extra']) == ""){
//				$objResponse->assign("valid_atributo_extra","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
//				$valid = false;
//			}
//			if(trim($aFormValues['txt_nro_pregunta']) == ""){
//				$objResponse->assign("valid_nro_pregunta","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
//				$valid = false;
//			}
		return $valid;
	}
	function clearvalid($objResponse){
		$objResponse->assign("valid_pregunta_id","innerHTML", "");
		$objResponse->assign("valid_encuesta_id","innerHTML", "");
		$objResponse->assign("valid_grupo_id","innerHTML", "");
		$objResponse->assign("valid_pregunta","innerHTML", "");
		$objResponse->assign("valid_tipo_respuesta","innerHTML", "");
		$objResponse->assign("valid_respuesta","innerHTML", "");
		$objResponse->assign("valid_atributo_extra","innerHTML", "");
		$objResponse->assign("valid_nro_pregunta","innerHTML", "");
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

		$objResponse->script("readonly('formulario','txt_pregunta_id',$state)");
		$objResponse->script("readonly('formulario','txt_encuesta_id',$state)");
		$objResponse->script("readonly('formulario','txt_grupo_id',$state)");
		$objResponse->script("readonly('formulario','txt_pregunta',$state)");
		$objResponse->script("readonly('formulario','txt_tipo_respuesta',$state)");
		$objResponse->script("readonly('formulario','txt_respuesta',$state)");
		$objResponse->script("readonly('formulario','txt_atributo_extra',$state)");
		$objResponse->script("readonly('formulario','txt_nro_pregunta',$state)");
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
		$objec_preguntasDAO = new ec_preguntasDAO();
		//-- IBRAC
		if(isset($aFormValues["ibrac"]))
			$criterio["ibrac"] = $aFormValues["ibrac"];
		//-- IBRAC
                if(isset($aFormValues["txts_encuesta_id"]) && strlen(trim($aFormValues["txts_encuesta_id"]))>0 && strlen(trim($aFormValues["txts_nombre_encuesta"]))>0)
			$criterio["encuesta_id"] = $aFormValues["txts_encuesta_id"];
                
                if(isset($aFormValues["txts_pregunta"]) && strlen(trim($aFormValues["txts_pregunta"]))>0 )
			$criterio["pregunta"] = $aFormValues["txts_pregunta"];
                
                if(isset($aFormValues["cbx_parametro"]) && strlen(trim($aFormValues["cbx_parametro"]))>0 )
			$criterio["tipo_respuesta"] = $aFormValues["cbx_parametro"];
                
                $criterio["type_order"] = "DESC";
		$arraylist = $objec_preguntasDAO->selectByCriteria_ec_preguntas($criterio,$page_number);
		$table_count = $objec_preguntasDAO->selectCountec_preguntas($criterio);
		$objResponse = loadtable_default($page_number,$arraylist,$table_count,$criterio);
		return $objResponse;
	}

	$xajax->processRequest();

?>