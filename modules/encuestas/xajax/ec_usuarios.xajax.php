<?php 
    ob_start();
    session_start();
    error_reporting(0);
    //ini_set('display_errors', '1');
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/xajax/xajax_core/xajax.inc.php");
	include_once (dirname(dirname(__FILE__))."/dao/ec_usuarios.dao.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/parsedate.php");
	include_once (dirname(dirname(dirname(__FILE__)))."/parametros/dao/pa_usuarios.dao.php");
	//-- IBRAC
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/permisos.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/session.php");
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
        $xajax->registerFunction("genUserAndPasswordsRandom");
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
		$objResponse = clearvalid($objResponse);
		$objec_usuariosDAO = new ec_usuariosDAO();
		$objec_usuariosTO = $objec_usuariosDAO->selectByIdec_usuarios($key);

		$objResponse->assign("txt_usuario_id","value",$objec_usuariosTO->getUsuario_id());
		$objResponse->assign("txt_nombre_usuario","value",$objec_usuariosTO->getNombre_usuario());
		$objResponse->assign("txt_clave_usuario","value",$objec_usuariosTO->getClave_usuario());
		$objResponse->assign("txt_estado_usuario","value",$objec_usuariosTO->getEstado_usuario());
		$objResponse->assign("txt_fecha_habilitacion","value",$objec_usuariosTO->getFecha_habilitacion());
		$objResponse->assign("datatable","style.visibility","hidden");
		$objResponse->assign("fields","style.visibility","visible");
                
                if($objec_usuariosTO->getFecha_habilitacion() != "")
                        $objResponse->assign("txt_fecha_habilitacion","value",parsedate::changeDateFormat($objec_usuariosTO->getFecha_habilitacion(),DB_DATETIME_FORMAT, "d/m/Y"));
                
		$objResponse = hidePanel("datatable_box", $objResponse);
		$objResponse = hidePanel("searchfields", $objResponse);
		$objResponse = showPanel("fields", $objResponse);

		$objResponse = visibilityButton("savebutton", "visible", $objResponse);
		$objResponse = visibilityButton("cancelbutton", "visible", $objResponse);
		$objResponse = visibilityButton("addbutton", "visible", $objResponse);
		$objResponse = visibilityButton("editbutton", "hidden", $objResponse);
		$objResponse = visibilityButton("searchbutton", "hidden", $objResponse);
                $objResponse = visibilityButton("generatebutton", "hidden", $objResponse);
                $objResponse = visibilityButton("exportbutton", "hidden", $objResponse);

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
		$strhtml .= '<th scope="col">Estado<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Fecha Habilitaci&oacute;n<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th class="table-action">V</th>'."\n";
		$strhtml .= '<th class="table-action">E</th>'."\n";
		$strhtml .= '<th class="table-action">B</th>'."\n";
		$strhtml .= '</tr>'."\n";
		$strhtml .= '</thead>'."\n";
		$strhtml .= '<tfoot>'."\n";
		$strhtml .= '<tr id="table_footer">'."\n";
		$strhtml .= '<th colspan="'.(count(ec_usuariosTO::$FIELDS)+3).'" id="footer_right">'."\n";
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
				$objec_usuariosTO = $iterator->current();
				$strhtml .= '<td>'.$objec_usuariosTO->getNombre_usuario().'</td>'."\n";
                                if($objec_usuariosTO->getEstado_usuario() == "A")
                                    $strhtml .= '<td>ACTIVO</td>'."\n";
                                else
                                    $strhtml .= '<td>INACTIVO</td>'."\n";
                                
                                if($objec_usuariosTO->getFecha_habilitacion() != "")
                                    $strhtml .= '<td>'.parsedate::changeDateFormat($objec_usuariosTO->getFecha_habilitacion(),DB_DATETIME_FORMAT, "d/m/Y").'</td>'."\n";
				
				//-- IBRAC
				$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="xajax_viewfields('.$objec_usuariosTO->getUsuario_id().');"><img src="'.MY_URI.'/media/img/actions/view-row.png" alt="ver" title="ver" style="border:0"/></a></td>'."\n";
				if(strlen(strpos($criterio["ibrac"],"A"))>0)
					$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="xajax_loadfields('.$objec_usuariosTO->getUsuario_id().');"><img src="'.MY_URI.'/media/img/actions/edit-row.png" alt="editar" title="editar" style="border:0"/></a></td>'."\n";
				else
					$strhtml .= '<td>&nbsp;</td>';
				if(strlen(strpos($criterio["ibrac"],"B"))>0)
					$strhtml .= '<td style="width:5px;"><a href="#" target="_self" onclick="if(confirm(\'Esta Seguro?\')){xajax_remove('.$objec_usuariosTO->getUsuario_id().',xajax.getFormValues(\'formulario\'));}"><img src="'.MY_URI.'/media/img/actions/delete-row.png" alt="eliminar" title="eliminar" style="border:0"/></a></td>'."\n";
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
                $objResponse = visibilityButton("generatebutton", "visible", $objResponse);
                $objResponse = visibilityButton("exportbutton", "visible", $objResponse);
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
				$objec_usuariosDAO = new ec_usuariosDAO();
				$objec_usuariosTO = new ec_usuariosTO();
				$objec_usuariosTO->setUsuario_id($aFormValues['txt_usuario_id']);
				$objec_usuariosTO->setNombre_usuario($aFormValues['txt_nombre_usuario']);
				$objec_usuariosTO->setClave_usuario($aFormValues['txt_clave_usuario']);
				$objec_usuariosTO->setEstado_usuario($aFormValues['txt_estado_usuario']);
                                if($aFormValues['txt_fecha_habilitacion'] != "")
                                    $objec_usuariosTO->setFecha_habilitacion(parsedate::changeDateFormat($aFormValues['txt_fecha_habilitacion']." 01:01:01", "d/m/Y h:i:s", DB_DATETIME_FORMAT ));
                                
				if($aFormValues['txt_usuario_id'] == '0' )
					$objec_usuariosDAO->insertec_usuarios($objec_usuariosTO);
				else
					$objec_usuariosDAO->updateec_usuarios($objec_usuariosTO);

				return loadtable($aFormValues,0);
			}
		}catch(Exception $ex){
			$objResponse->script("alert('".$ex->getMessage()."')");
		}
		return $objResponse;
	}
        
        function genUserAndPasswordsRandom($elem){
            if($elem != null){
                $aFormValues = $elem;//array("cantidad"=>$elem->cantidad, "txt_fecha_habilitacion"=>$elem->fecha);
                $objec_usuariosDAO = new ec_usuariosDAO();
                for ($index = 0; $index < $aFormValues["cantidad"]; $index++) {
                    $objec_usuariosTO = new ec_usuariosTO();
                    $objec_usuariosTO->setUsuario_id(0);
                    $objec_usuariosTO->setNombre_usuario(usuario_aleatorio());
                    $objec_usuariosTO->setClave_usuario(clave_aleatoria());
                    $objec_usuariosTO->setEstado_usuario("A");
                    if($aFormValues['fecha'] != "")
                        $objec_usuariosTO->setFecha_habilitacion(parsedate::changeDateFormat($aFormValues['fecha']." 01:01:01", "d/m/Y h:i:s", DB_DATETIME_FORMAT ));

                    $objec_usuariosDAO->insertec_usuarios($objec_usuariosTO);
                }
                return loadtable($aFormValues,0);
            }
        }
        /***/
        function clave_aleatoria($long=8){ 
            $salt = 'abchefghknpqrstuvwxyz';    
            $salt .= 'ACDEFHKNPRSTUVWXYZ';  
            $salt .= strlen($salt)?'2345679':'0123456789';  
            if (strlen($salt) == 0) {       
                return '';  
            }   
            $i = 0; 
            $str = '';  
            srand((double)microtime()*1000000);     
            while ($i < $long) {     
                $num = rand(0, strlen($salt)-1);        
                $str .= substr($salt, $num, 1);     
                $i++;   
            } 

            return $str;
        }

        /*Nombres o palabras aleatorias*/
        //Palabras entre un mínimo de 4 letras o máximo de 8
        function usuario_aleatorio($min=4, $max=8){
            $vocales = array("a", "e", "i", "o", "u");
            $consonantes = array("b", "c", "d", "f", "g", "j", "l", "m", "n", "p", "r", "s", "t");
            $random_palabras = rand($min, $max);//largo de la palabra
            $random = rand(0,1);//si empieza por vocal o consonante
                for($j=0;$j<$random_palabras;$j++){//palabra
                switch($random){
                    case 0: $random_vocales = rand(0, count($vocales)-1); $nombre.= $vocales[$random_vocales]; 
                        $random = 1; break;
                    case 1: $random_consonantes = rand(0, count($consonantes)-1); $nombre.= $consonantes[$random_consonantes]; $random = 0; break;
                }
            }
            return $nombre;
        }
	function add(){
		$objResponse = new xajaxResponse();
		$objResponse = clearvalid($objResponse);
		$objResponse->assign("txt_usuario_id","value","0");
		$objResponse->assign("txt_nombre_usuario","value","");
		$objResponse->assign("txt_clave_usuario","value","");
		$objResponse->assign("txt_estado_usuario","value","");
		$objResponse->assign("txt_fecha_habilitacion","value","");
		$objResponse->assign("fields_title_panel","innerHTML","Registrar Datos");
		$objResponse = hidePanel("datatable_box", $objResponse);
		$objResponse = hidePanel("searchfields", $objResponse);
		$objResponse = showPanel("fields", $objResponse);

		$objResponse = visibilityButton("savebutton", "visible", $objResponse);
		$objResponse = visibilityButton("cancelbutton", "visible", $objResponse);
		$objResponse = visibilityButton("addbutton", "visible", $objResponse);
		$objResponse = visibilityButton("searchbutton", "hidden", $objResponse);
		$objResponse = visibilityButton("editbutton", "hidden", $objResponse);
                $objResponse = visibilityButton("generatebutton", "hidden", $objResponse);
                $objResponse = visibilityButton("exportbutton", "hidden", $objResponse);

		$objResponse = readOnlyfiles("false",$objResponse);

		return $objResponse;
	}

	function remove($key,$aFormValues){
		$objec_usuariosDAO = new ec_usuariosDAO();
		$objec_usuariosTO = new ec_usuariosTO();
		$objec_usuariosTO->setUsuario_id($key);
		$objec_usuariosDAO->deleteec_usuarios($objec_usuariosTO);
		return loadtable($aFormValues,0);
	}

	function valid($aFormValues,$objResponse){
		$valid = true;
		$objResponse = clearvalid($objResponse);
			if(trim($aFormValues['txt_usuario_id']) == ""){
				$objResponse->assign("valid_usuario_id","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_nombre_usuario']) == ""){
				$objResponse->assign("valid_nombre_usuario","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_clave_usuario']) == ""){
				$objResponse->assign("valid_clave_usuario","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_estado_usuario']) == ""){
				$objResponse->assign("valid_estado_usuario","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
			if(trim($aFormValues['txt_fecha_habilitacion']) == ""){
				$objResponse->assign("valid_fecha_habilitacion","innerHTML", '<img src="../../../../media/img/actions/alert.png" alt="Requerido" title="Requerido" />');
				$valid = false;
			}
		return $valid;
	}
	function clearvalid($objResponse){
		$objResponse->assign("valid_usuario_id","innerHTML", "");
		$objResponse->assign("valid_nombre_usuario","innerHTML", "");
		$objResponse->assign("valid_clave_usuario","innerHTML", "");
		$objResponse->assign("valid_estado_usuario","innerHTML", "");
		$objResponse->assign("valid_fecha_habilitacion","innerHTML", "");
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
		$objResponse->script("readonly('formulario','txt_nombre_usuario',$state)");
		$objResponse->script("readonly('formulario','txt_clave_usuario',$state)");
		$objResponse->script("readonly('formulario','txt_estado_usuario',$state)");
		$objResponse->script("readonly('formulario','txt_fecha_habilitacion',$state)");
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
		$objec_usuariosDAO = new ec_usuariosDAO();
		//-- IBRAC
		if(isset($aFormValues["ibrac"]))
			$criterio["ibrac"] = $aFormValues["ibrac"];
		//-- IBRAC
                if(isset($aFormValues["txts_usuario"]) && strlen(trim($aFormValues["txts_usuario"]))>0)
			$criterio["nombre_usuario"] = $aFormValues["txts_usuario"];
                if(isset($aFormValues["txts_estado_usuario"]) && trim($aFormValues["txts_estado_usuario"])!="0")
			$criterio["estado_usuario"] = $aFormValues["txts_estado_usuario"];
                
		$arraylist = $objec_usuariosDAO->selectByCriteria_ec_usuarios($criterio,$page_number);
		$table_count = $objec_usuariosDAO->selectCountec_usuarios($criterio);
		$objResponse = loadtable_default($page_number,$arraylist,$table_count,$criterio);
		return $objResponse;
	}

	$xajax->processRequest();

?>