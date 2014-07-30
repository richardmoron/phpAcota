<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	session_start();
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/xajax/xajax_core/xajax.inc.php");
	include_once (dirname(dirname(__FILE__))."/dao/ac_consumos.dao.php");
        include_once (dirname(dirname(__FILE__))."/dao/ac_socios.dao.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/parsedate.php");
	include_once (dirname(dirname(dirname(__FILE__)))."/parametros/dao/pa_usuarios.dao.php");
	//-- IBRAC
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/permisos.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/session.php");
	//-- IBRAC
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
        $xajax->registerFunction("loadMedidoresSocio");
        
	$xajax->registerFunction("readOnlyfiles");
        $xajax->registerFunction("emitirAvisos");

	function preload(){
                
                $aFormValues = array("txts_periodo_mes"=>intval(date("m")),"txts_periodo_anio"=>date("Y"),"txts_estado"=>"L");
		$objResponse = loadtable($aFormValues,0);
                $objResponse->assign("txts_periodo_mes","value",  intval(date("m")));
                $objResponse->assign("txts_periodo_anio","value",date("Y"));
		//$objResponse = loadUserLogged($objResponse);
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
		$objac_consumosDAO = new ac_consumosDAO();
		$objac_consumosTO = $objac_consumosDAO->selectByIdac_consumos($key);
                $objResponse = loadMedidoresSocio($objac_consumosTO->getSocio_id(), "_new", $objResponse);
		$objResponse->assign("txt_consumo_id","value",$objac_consumosTO->getConsumo_id());
		$objResponse->assign("txt_socio_id","value",$objac_consumosTO->getSocio_id());
                $objResponse->assign("txt_nombre_apellido","value",$objac_consumosTO->getSocio());
		$objResponse->assign("cbx_socio_medidores_new","value",$objac_consumosTO->getNro_medidor());
                if($objac_consumosTO->getFecha_lectura()!=null && trim($objac_consumosTO->getFecha_lectura()) != "")
                    $objResponse->assign("txt_fecha_lectura","value",  parsedate::changeDateFormat ($objac_consumosTO->getFecha_lectura(),DB_DATETIME_FORMAT,APP_DATETIME_FORMAT) );
		$objResponse->assign("txt_periodo_mes","value",$objac_consumosTO->getPeriodo_mes());
		$objResponse->assign("txt_periodo_anio","value",$objac_consumosTO->getPeriodo_anio());
		$objResponse->assign("txt_consumo_total_lectura","value",$objac_consumosTO->getConsumo_total_lectura());
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
		$strhtml .= '<th scope="col">Socio<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Nro Medidor<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Fecha Lectura<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Mes<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">A&ntilde;o<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
                $strhtml .= '<th scope="col">Consumo<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
                $strhtml .= '<th scope="col">Estado<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
//		$strhtml .= '<th class="table-action">V</th>'."\n";
//		$strhtml .= '<th class="table-action">E</th>'."\n";
		$strhtml .= '<th class="table-action">B</th>'."\n";
		$strhtml .= '</tr>'."\n";
		$strhtml .= '</thead>'."\n";
		$strhtml .= '<tfoot>'."\n";
		$strhtml .= '<tr id="table_footer">'."\n";
		$strhtml .= '<th colspan="'.(count(ac_consumosTO::$FIELDS)+3).'" id="footer_right">'."\n";
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
				$objac_consumosTO = $iterator->current();
				$strhtml .= '<td>'.$objac_consumosTO->getSocio().'</td>'."\n";
				$strhtml .= '<td>'.$objac_consumosTO->getNro_medidor().'</td>'."\n";
                                if($objac_consumosTO->getFecha_lectura() != null && trim($objac_consumosTO->getFecha_lectura()) != "") 
                                    $strhtml .= '<td>'.  parsedate::changeDateFormat ($objac_consumosTO->getFecha_lectura(),DB_DATETIME_FORMAT,APP_DATETIME_FORMAT).'</td>'."\n";
                                else 
                                    $strhtml .= '<td></td>'."\n";
                                
				$strhtml .= '<td>'.$objac_consumosTO->getPeriodo_mes().'</td>'."\n";
				$strhtml .= '<td>'.$objac_consumosTO->getPeriodo_anio().'</td>'."\n";
				$strhtml .= '<td>'.$objac_consumosTO->getConsumo_total_lectura().'</td>'."\n";
                                switch ($objac_consumosTO->getEstado()) {
                                    case "L":
                                        $strhtml .= '<td>LEIDO</td>'."\n";
                                        break;
                                     case "E":
                                        $strhtml .= '<td>EMITIDO</td>'."\n";
                                        break;
                                    default:
                                        $strhtml .= '<td></td>'."\n";
                                } 
                                
				//-- IBRAC
//				$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="xajax_viewfields('.$objac_consumosTO->getConsumo_id().');"><img src="'.MY_URI.'/media/img/actions/view-row.png" alt="ver" title="ver" style="border:0"/></a></td>'."\n";
//				if(strlen(strpos($criterio["ibrac"],"A"))>0)
//					$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="xajax_loadfields('.$objac_consumosTO->getConsumo_id().');"><img src="'.MY_URI.'/media/img/actions/edit-row.png" alt="editar" title="editar" style="border:0"/></a></td>'."\n";
//				else
//					$strhtml .= '<td>&nbsp;</td>';
				if(strlen(strpos($criterio["ibrac"],"B"))>0)
					$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="if(confirm(\'Esta Seguro?\')){xajax_remove('.$objac_consumosTO->getConsumo_id().',xajax.getFormValues(\'formulario\'));}"><img src="'.MY_URI.'/media/img/actions/delete-row.png" alt="eliminar" title="eliminar" style="border:0"/></a></td>'."\n";
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
				$objac_consumosDAO = new ac_consumosDAO();
				$objac_consumosTO = new ac_consumosTO();
				$objac_consumosTO->setConsumo_id($aFormValues['txt_consumo_id']);
				$objac_consumosTO->setSocio_id($aFormValues['txt_socio_id']);
				$objac_consumosTO->setNro_medidor($aFormValues['cbx_socio_medidores_new']);
				$objac_consumosTO->setFecha_lectura(parsedate::changeDateFormat($aFormValues['txt_fecha_lectura'],APP_DATETIME_FORMAT,DB_DATETIME_FORMAT));
				$objac_consumosTO->setPeriodo_mes($aFormValues['txt_periodo_mes']);
				$objac_consumosTO->setPeriodo_anio($aFormValues['txt_periodo_anio']);
                                $objac_consumosTO->setConsumo_total_lectura($aFormValues['txt_consumo_total_lectura']);
				$objac_consumosTO->setEstado("L");

				if($aFormValues['txt_consumo_id'] == '0' )
					$objac_consumosDAO->insertac_consumosSimple($objac_consumosTO);
				else
					$objac_consumosDAO->updateac_consumos($objac_consumosTO);

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
		$objResponse->assign("txt_consumo_id","value","0");
		$objResponse->assign("txt_socio_id","value","");
                $objResponse->assign("txt_nombre_apellido","value","");
		$objResponse->assign("txt_nro_medidor","value","");
		$objResponse->assign("txt_fecha_lectura","value",  date(APP_DATETIME_FORMAT));
		$objResponse->assign("ctn_cbx_socio_medidores","innerHTML",'<select style="width: 250px;"></select>');
		$objResponse->assign("txt_periodo_mes","value",date("m"));
		$objResponse->assign("txt_periodo_anio","value",date("Y"));
		
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
		$objac_consumosDAO = new ac_consumosDAO();
		$objac_consumosTO = new ac_consumosTO();
		$objac_consumosTO->setConsumo_id($key);
		$objac_consumosDAO->deleteac_consumos($objac_consumosTO);
		return loadtable($aFormValues,0);
	}

	function valid($aFormValues,$objResponse){
		$valid = true;
		$objResponse = clearvalid($objResponse);
			if(trim($aFormValues['txt_consumo_id']) == ""){
				$objResponse->assign("valid_consumo_id","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_socio_id']) == ""){
				$objResponse->assign("valid_socio_id","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['cbx_socio_medidores_new']) == ""){
				$objResponse->assign("valid_nro_medidor","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_fecha_lectura']) == ""){
				$objResponse->assign("valid_fecha_lectura","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			
			if(trim($aFormValues['txt_periodo_mes']) == ""){
				$objResponse->assign("valid_periodo_mes","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_periodo_anio']) == ""){
				$objResponse->assign("valid_periodo_anio","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			
		return $valid;
	}
	function clearvalid($objResponse){
		$objResponse->assign("valid_consumo_id","innerHTML", "");
		$objResponse->assign("valid_socio_id","innerHTML", "");
		$objResponse->assign("valid_nro_medidor","innerHTML", "");
		$objResponse->assign("valid_fecha_lectura","innerHTML", "");
		$objResponse->assign("valid_fecha_emision","innerHTML", "");
		$objResponse->assign("valid_periodo_mes","innerHTML", "");
		$objResponse->assign("valid_periodo_anio","innerHTML", "");
		$objResponse->assign("valid_consumo_total_lectura","innerHTML", "");
		$objResponse->assign("valid_consumo_por_pagar","innerHTML", "");
		$objResponse->assign("valid_costo_consumo_por_pagar","innerHTML", "");
		$objResponse->assign("valid_estado","innerHTML", "");
		$objResponse->assign("valid_fecha_hora_pago","innerHTML", "");
		$objResponse->assign("valid_usuario_pago","innerHTML", "");
		$objResponse->assign("valid_monto_pagado","innerHTML", "");
		$objResponse->assign("valid_pagado_por","innerHTML", "");
		$objResponse->assign("valid_ci_pagado_por","innerHTML", "");
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

		$objResponse->script("readonly('formulario','txt_consumo_id',$state)");
		$objResponse->script("readonly('formulario','txt_socio_id',$state)");
                $objResponse->script("readonly('formulario','txt_socio_nombre',$state)");
		$objResponse->script("readonly('formulario','txt_nro_medidor',$state)");
		$objResponse->script("readonly('formulario','txt_consumo_total_lectura',$state)");
	
		$objResponse->script("readonly('formulario','txt_periodo_mes',$state)");
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
        
        function loadMedidoresSocio($socio_id, $new="", $objResponse = null){
            if($objResponse == null){
                $objResponse = new xajaxResponse();
            }
            
            $html = "<select id='cbx_socio_medidores".$new."' name='cbx_socio_medidores".$new."' style='width:250px;'>";
            $ac_sociosDAO = new ac_sociosDAO();
            $criterio = array("socio_id"=>$socio_id);
            $arraylist = $ac_sociosDAO->selectByCriteria_ac_socios($criterio, -1);
            $iterator = $arraylist->getIterator();
            while($iterator->valid()){
                $ac_sociosTO = $iterator->current();
                $html .= "<option value='".$ac_sociosTO->getNro_medidor()."'>".$ac_sociosTO->getNro_medidor()."</option>";  
                $iterator->next();
            }
            $html .= "</select>";
            $objResponse->assign("ctn_cbx_socio_medidores", "innerHTML", $html);
            //--
            
            return $objResponse;
        }
        
	function searchfields($aFormValues,$page_number){
		$criterio = array();
		$objac_consumosDAO = new ac_consumosDAO();
		//-- IBRAC
		if(isset($aFormValues["ibrac"]))
			$criterio["ibrac"] = $aFormValues["ibrac"];
		//-- IBRAC
                if(isset($aFormValues["txts_nro_medidor"]) && strlen(trim($aFormValues["txts_nro_medidor"]))>0)
			$criterio["nro_medidor"] = $aFormValues["txts_nro_medidor"];
                
                if(isset($aFormValues["txts_socio_id"]) && strlen(trim($aFormValues["txts_socio_id"]))>0)
			$criterio["socio_id"] = $aFormValues["txts_socio_id"];
                
                if(isset($aFormValues["txts_estado"]) && strlen(trim($aFormValues["txts_estado"]))>0)
			$criterio["estado"] = $aFormValues["txts_estado"];
                
                if(isset($aFormValues["txts_periodo_mes"]) && strlen(trim($aFormValues["txts_periodo_mes"]))>0)
			$criterio["periodo_mes"] = $aFormValues["txts_periodo_mes"];
                
                if(isset($aFormValues["txts_periodo_anio"]) && strlen(trim($aFormValues["txts_periodo_anio"]))>0)
			$criterio["periodo_anio"] = $aFormValues["txts_periodo_anio"];
                
		$arraylist = $objac_consumosDAO->selectByCriteria_ac_consumos($criterio,$page_number);
		$table_count = $objac_consumosDAO->selectCountac_consumos($criterio);
		$objResponse = loadtable_default($page_number,$arraylist,$table_count,$criterio);
		return $objResponse;
	}
        
        function emitirAvisos($aFormValues,$page_number){
		$criterio = array();
		$objac_consumosDAO = new ac_consumosDAO();
		//-- IBRAC
		if(isset($aFormValues["ibrac"]))
			$criterio["ibrac"] = $aFormValues["ibrac"];
		//-- IBRAC
                if(isset($aFormValues["txts_nro_medidor"]) && strlen(trim($aFormValues["txts_nro_medidor"]))>0)
			$criterio["nro_medidor"] = $aFormValues["txts_nro_medidor"];
                
                if(isset($aFormValues["txts_socio_id"]) && strlen(trim($aFormValues["txts_socio_id"]))>0)
			$criterio["socio_id"] = $aFormValues["txts_socio_id"];
                
                if(isset($aFormValues["txts_estado"]) && strlen(trim($aFormValues["txts_estado"]))>0)
			$criterio["estado"] = $aFormValues["txts_estado"];
                
                if(isset($aFormValues["txts_periodo_mes"]) && strlen(trim($aFormValues["txts_periodo_mes"]))>0)
			$criterio["periodo_mes"] = $aFormValues["txts_periodo_mes"];
                
                if(isset($aFormValues["txts_periodo_anio"]) && strlen(trim($aFormValues["txts_periodo_anio"]))>0)
			$criterio["periodo_anio"] = $aFormValues["txts_periodo_anio"];
                
                $objac_consumosDAO->emitirAvisos_ac_consumos($criterio,-1);
		$arraylist = $objac_consumosDAO->selectByCriteria_ac_consumos($criterio,$page_number);
		$table_count = $objac_consumosDAO->selectCountac_consumos($criterio);
		$objResponse = loadtable_default($page_number,$arraylist,$table_count,$criterio);
		return $objResponse;
	}
        
	$xajax->processRequest();

?>