<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/xajax/xajax_core/xajax.inc.php");
	include_once (dirname(dirname(__FILE__))."/dao/ec_encuestas.dao.php");
        include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/session.php");
        include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/comboboxes.php");
        
//	session_start();
	$xajax = new xajax();

	$xajax->registerFunction("preload"); //Carga las variables iniciales
	$xajax->registerFunction("loadfields"); //Carga los campos del formulario
	$xajax->registerFunction("loadtable"); //Carga los campos de la tabla
        $xajax->registerFunction("searchfields"); //Busca los datos segun el criterio
        
	function preload(){
            //$objResponse = new xajaxResponse();
            $aFormValues = array();
            if(isset($_GET["nombre"]) && strlen(trim($_GET["nombre"])) >0 )
                $aFormValues["txts_nombre"] = $_GET["nombre"];
            
            //--
            $objResponse = searchfields($aFormValues,0);
            //--
            if(isset($_GET["nombre"]) && strlen(trim($_GET["nombre"])) >0 )
                $objResponse->assign("txts_nombre", "value", $_GET["nombre"]);
            
            $objResponse->assign("ctns_cbx_clientes","innerHTML",  loadCbx_EmpresasEncuestas("", true));
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
		$strhtml .= '<th scope="col">Empresa<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
		$strhtml .= '<th scope="col">Nombre<img src="'.MY_URI.'/media/img/tablesorter/bg.gif" alt="ordenar" class="order-img"/></th>'."\n";
                $strhtml .= '<th scope="col">S</th>'."\n";
		$strhtml .= '</tr>'."\n";
		$strhtml .= '</thead>'."\n";
		$strhtml .= '<tfoot>'."\n";
		$strhtml .= '<tr id="table_footer">'."\n";
		$strhtml .= '<th colspan="'.(count(ec_encuestasTO::$FIELDS)+3).'" id="footer_right">'."\n";
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
				$objec_encuestasTO = $iterator->current();
                $anchor = '<a href="#" style="text-decoration:none;color:#444444;" target="_self" onclick="terminateLov('.$objec_encuestasTO->getEncuesta_id().',\''.$objec_encuestasTO->getNombre().'\');">';
				$strhtml .= '<td>'.$anchor.$objec_encuestasTO->getEmpresa().'</a></td>'."\n";
				$strhtml .= '<td>'.$anchor.$objec_encuestasTO->getNombre().'</a></td>'."\n";
                                
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
                $objec_encuestasDAO = new ec_encuestasDAO();
                
                if(isset($aFormValues["txts_nombre"]) && strlen(trim($aFormValues["txts_nombre"]))>0)
			$criterio["nombre"] = $aFormValues["txts_nombre"];
                
                if(isset($aFormValues["cbx_empresas"]) && strlen(trim($aFormValues["cbx_empresas"]))>0)
			$criterio["empresa_id"] = $aFormValues["cbx_empresas"];
                
		$arraylist = $objec_encuestasDAO->selectByCriteria_ec_encuestas($criterio,$page_number);
		$table_count = $objec_encuestasDAO->selectCountec_encuestas($criterio);
		$objResponse = loadtable_default($page_number,$arraylist,$table_count,$criterio);
		return $objResponse;
	}

	$xajax->processRequest();
?>