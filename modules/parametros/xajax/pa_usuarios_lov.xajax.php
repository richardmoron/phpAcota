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
        include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/session.php");
        
//	session_start();
	$xajax = new xajax();

	$xajax->registerFunction("preload"); //Carga las variables iniciales
	$xajax->registerFunction("loadfields"); //Carga los campos del formulario
	$xajax->registerFunction("loadtable"); //Carga los campos de la tabla
        $xajax->registerFunction("searchfields"); //Busca los datos segun el criterio
        
	function preload(){
            //$objResponse = new xajaxResponse();
            $aFormValues = array();
            if(isset($_GET["nombres"]) && strlen(trim($_GET["nombres"])) >0 )
                $aFormValues["txts_nombres"] = $_GET["nombres"];
            
            if(isset($_GET["apellidos"]) && strlen(trim($_GET["apellidos"])) >0 )
                $aFormValues["txts_apellidos"] = $_GET["apellidos"];
            
            if(isset($_GET["usuario"]) && strlen(trim($_GET["usuario"])) >0 )
                $aFormValues["txts_usuario"] = $_GET["usuario"];
            //--
            $objResponse = searchfields($aFormValues,0);
            //--
            if(isset($_GET["nombres"]) && strlen(trim($_GET["nombres"])) >0 )
                $objResponse->assign("txts_nombres", "value", $_GET["nombres"]);
            
            if(isset($_GET["apellidos"]) && strlen(trim($_GET["apellidos"])) >0 )
                $objResponse->assign("txts_apellidos", "value", $_GET["apellidos"]);
            
            if(isset($_GET["usuario"]) && strlen(trim($_GET["usuario"])) >0 )
                $objResponse->assign("txts_usuario", "value", $_GET["usuario"]);
            
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

		$iterator = $arraylist->getIterator();
		$strhtml = '<table class="datatable" id="myTable">'."\n";
		$strhtml .= '<thead>'."\n";
		$strhtml .= '<tr>'."\n";
		$strhtml .= '<th scope="col">Usuario<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Nombres<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Apellidos<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
                $strhtml .= '<th scope="col">S</th>'."\n";
		$strhtml .= '</tr>'."\n";
		$strhtml .= '</thead>'."\n";
		$strhtml .= '<tfoot>'."\n";
		$strhtml .= '<tr id="table_footer">'."\n";
		$strhtml .= '<th colspan="'.(count(pa_usuariosTO::$FIELDS)+3).'" id="footer_right">'."\n";
                for ($i= 0 ; $i <= $table_count-1 ; $i++) {
                        if($i != $page_number){
                                $strhtml .= '<a href="#" target="_self" onclick="xajax_loadtable(xajax.getFormValues(\'formulario\'),'.($i).')">'.($i+1).'</a>'."\n";
                        }else{
                                $strhtml .= ($i+1)."\n";
                        }
                }
		$strhtml .= '</th>'."\n";
		$strhtml .= '</tr>'."\n";
		$strhtml .= '</tfoot>'."\n";
		$strhtml .= '<tbody>'."\n";
			while($iterator->valid()) {
				if($iterator->key() % 2 == 0){
					$strhtml .= '<tr class="paintedrow">'."\n";
				}else{
					$strhtml .= '<tr>'."\n";
				}
				$objpa_usuariosTO = $iterator->current();
                                $anchor = '<a href="#" style="text-decoration:none;color:#444444;" target="_self" onclick="terminateLov('.$objpa_usuariosTO->getUsuario_id().',\''.$objpa_usuariosTO->getUsuario().', '.$objpa_usuariosTO->getApellidos().' '.$objpa_usuariosTO->getNombres().'\');">';
				$strhtml .= '<td>'.$anchor.$objpa_usuariosTO->getUsuario().'</a></td>'."\n";
				$strhtml .= '<td>'.$anchor.$objpa_usuariosTO->getNombres().'</a></td>'."\n";
				$strhtml .= '<td>'.$anchor.$objpa_usuariosTO->getApellidos().'</a></td>'."\n";
				$strhtml .= '<td>'.$anchor.'<img src="../../../../media/img/actions/accept16.png" alt="seleccionar" title="seleccionar" style="border:0"/></a></td>'."\n";
				$strhtml .= '</tr>'."\n";
				$iterator->next();
			}
		$strhtml .= '</tbody>'."\n";
		$strhtml .= '</table>'."\n";
		$objResponse->assign("datatable_box","innerHTML","$strhtml");
                $objResponse->script('$(document).ready(function(){ $("#myTable").tablesorter(); } );');
		return $objResponse;
	}

	
	function searchfields($aFormValues,$page_number){
                $criterio = array();
                $objpa_usuariosDAO = new pa_usuariosDAO();
                if(isset($aFormValues["txts_usuario"]) && strlen(trim($aFormValues["txts_usuario"]))>0)
                    $criterio["usuario"] = $aFormValues["txts_usuario"];
                
                if(isset($aFormValues["txts_nombres"]) && strlen(trim($aFormValues["txts_nombres"]))>0)
                    $criterio["nombres"] = $aFormValues["txts_nombres"];
                
                if(isset($aFormValues["txts_apellidos"]) && strlen(trim($aFormValues["txts_apellidos"]))>0)
                    $criterio["apellidos"] = $aFormValues["txts_apellidos"];
                
                $criterio["estado"] = "A";
                
		$arraylist = $objpa_usuariosDAO->selectByCriteria_pa_usuarios($criterio,$page_number);
		$table_count = $objpa_usuariosDAO->selectCountpa_usuarios($criterio);
		$objResponse = loadtable_default($page_number,$arraylist,$table_count,$criterio);
		return $objResponse;
	}

	$xajax->processRequest();
?>