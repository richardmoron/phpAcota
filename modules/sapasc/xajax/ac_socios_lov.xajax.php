<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/xajax/xajax_core/xajax.inc.php");
	include_once (dirname(dirname(__FILE__))."/dao/ac_socios.dao.php");
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
            
            //--
            $objResponse = searchfields($aFormValues,0);
            //--
            if(isset($_GET["nombres"]) && strlen(trim($_GET["nombres"])) >0 )
                $objResponse->assign("txts_nombres", "value", $_GET["nombres"]);
            
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
		$strhtml .= '<th scope="col">Nombres<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Apellidos<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Ci<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th class="table-action">S</th>'."\n";
		$strhtml .= '</tr>'."\n";
		$strhtml .= '</thead>'."\n";
		$strhtml .= '<tfoot>'."\n";
		$strhtml .= '<tr id="table_footer">'."\n";
		$strhtml .= '<th colspan="'.(count(ac_sociosTO::$FIELDS)+3).'" id="footer_right">'."\n";
		//-- IBRAC
		//-- IBRAC
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
                                
				$objac_sociosTO = $iterator->current();
                                $anchor = '<a href="#" style="text-decoration:none;color:#444444;" target="_self" onclick="terminateLov('.$objac_sociosTO->getSocio_id().',\''.$objac_sociosTO->getNombres()." ".$objac_sociosTO->getApellidos().'\');">';
				$strhtml .= '<td>'.$anchor.$objac_sociosTO->getNombres().'</a></td>'."\n";
				$strhtml .= '<td>'.$anchor.$objac_sociosTO->getApellidos().'</a></td>'."\n";
				$strhtml .= '<td>'.$anchor.$objac_sociosTO->getCi()." ".$objac_sociosTO->getCi_expedido_en().'</td>'."\n";
				$strhtml .= '<td>'.$anchor.'<img src="../../../../media/img/actions/accept16.png" alt="seleccionar" title="seleccionar" style="border:0"/></a></td>'."\n";
				//-- IBRAC
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
                $objac_sociosDAO = new ac_sociosDAO();
                
                if(isset($aFormValues["txts_nombres"]) && strlen(trim($aFormValues["txts_nombres"]))>0)
			$criterio["nombres"] = $aFormValues["txts_nombres"];
                
                if(isset($aFormValues["txts_apellidos"]) && strlen(trim($aFormValues["txts_apellidos"]))>0)
			$criterio["apellidos"] = $aFormValues["txts_apellidos"];
                
                if(isset($aFormValues["txts_ci"]) && strlen(trim($aFormValues["txts_ci"]))>0)
			$criterio["ci"] = $aFormValues["txts_ci"];
                
		$arraylist = $objac_sociosDAO->selectByCriteria_ac_socios($criterio,$page_number);
		$table_count = $objac_sociosDAO->selectCountac_socios($criterio);
		$objResponse = loadtable_default($page_number,$arraylist,$table_count,$criterio);
		return $objResponse;
	}

	$xajax->processRequest();
?>