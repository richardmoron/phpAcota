<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TOCGenerator
 *
 * @author Richard
 */
class HTMLGenerator {
    private $table;
    private $database;
    private $strParamSigns = "";
    private $strFieldNames;
    private $strFieldTypes;
    private $strFieldLength;
    private $strPkField;

    /**
     *
     * @param String $table
     * @param String $database
     */
    function __construct($database,$table) {
        $this->table = $table;
        $this->database = $database;
    }

    /**
     * Genera el script de la clase
     */
    function generateClass(){
        try{
            $this->setTableNameUpper();
            $this->setExtraVariables();
            //Class Definition
            $strClass = '<?php require_once dirname(dirname(dirname(__FILE__)))."/xajax/'.strtolower($this->table).".xajax".'.php"; ?>'."\n";
            $strClass .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
            $strClass .= '<html>'."\n";
            $strClass .= "\t".'<head>'."\n";
            $strClass .= "\t\t".'<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">'."\n";
            $strClass .= "\t\t".'<link rel="stylesheet" href="../../../../media/css/4forms.css" type="text/css" media="screen" />'."\n";
            $strClass .= "\t\t".'<title>'.strtolower($this->table).'</title>'."\n";
            $strClass .= "\t\t".'<?php $xajax->printJavascript(MY_URI."/lib/xajax/"); ?>'."\n";
            $strClass .= "\t\t".'<script type="text/javascript">'."\n";
            $strClass .= "\t\t\t".'xajax.callback.global.onRequest = function() {xajax.$(\'loading\').style.display = \'block\';}'."\n";
            $strClass .= "\t\t\t".'xajax.callback.global.beforeResponseProcessing = function() {xajax.$(\'loading\').style.display=\'none\';}'."\n";
            $strClass .= "\t\t".'</script>'."\n";
            $strClass .= "\t\t".'<script type="text/javascript" src="../../../../media/js/localUse.js" ></script>'."\n";
            $strClass .= "\t\t".'<script type="text/javascript" src="../../../../media/js/jquery-latest.js" ></script>'."\n";
            $strClass .= "\t\t".'<script type="text/javascript" src="../../../../media/js/jquery.tablesorter.js" ></script>'."\n";
            $strClass .= "\t".'</head>'."\n";
            $strClass .= "\t".'<body onload="xajax_preload();">'."\n";
            $strClass .= "\t\t".'<div id="loading"><img src="../../../../media/img/loading-bar.gif" alt="Loading..." id="loadingimg"/><br /> Cargando...</div>'."\n";
            $strClass .= "\t\t".'<!--div id="header">'."\n";
            $strClass .= "\t\t".'<div id="header_title" name="header_title">Nombre de la Empresa</div>'."\n";
            $strClass .= "\t\t\t".'<div id="header_content">&nbsp;</div>'."\n";
            $strClass .= "\t\t\t".'<div id="header_user">'."\n";
            $strClass .= "\t\t\t\t".'<span>Usuario:&nbsp;</span><span id="header_user_data">Nombre de Usuario</span><br />'."\n";
            $strClass .= "\t\t\t\t".'<span>Fecha:&nbsp;</span><span id="header_date_data">21/12/2012</span>'."\n";
            $strClass .= "\t\t\t".'</div>'."\n";
            $strClass .= "\t\t".'</div-->'."\n";
            $strClass .= "\t\t".'<form action="#" method="post" id="formulario">'."\n";
            $strClass .= "\t\t\t".'<div id="header_buttons">'."\n";
            $strClass .= "\t\t\t\t".'<ul>'."\n";
            $strClass .= "\t\t\t\t\t".'<!--li><a id="homebutton" name="homebutton" href="#" class="header_button"><img src="../../../../media/img/actions/home.png" alt="Inicio" title="Inicio" border="0">&nbsp;Inicio</a></li-->'."\n";
            $strClass .= "\t\t\t\t\t".'<li><a id="savebutton" name="savebutton" onclick="xajax_save(xajax.getFormValues(\'formulario\'),0);" href="#" class="header_button"><img src="../../../../media/img/actions/save.png" alt="Guardar" title="Guardar" border="0">&nbsp;Guardar</a></li>'."\n";
            $strClass .= "\t\t\t\t\t".'<li><a id="addbutton" name="addbutton" onclick="xajax_add();" href="#" class="header_button"><img src="../../../../media/img/actions/add_page.png" alt="Nuevo" title="Nuevo" border="0">&nbsp;Nuevo</a></li>'."\n";
            $strClass .= "\t\t\t\t\t".'<li><a id="editbutton" name="editbutton" onclick="xajax_readOnlyfiles(\'false\',null,\'Editar Datos\');" href="#" class="header_button"><img src="../../../../media/img/actions/edit_page.png" alt="Editar" title="Editar" border="0">&nbsp;Editar</a></li>'."\n";
            $strClass .= "\t\t\t\t\t".'<li><a id="searchbutton" name="searchbutton" onclick="xajax_searchfields(xajax.getFormValues(\'formulario\'),0);" href="#" class="header_button"><img src="../../../../media/img/actions/search_page.png" alt="Buscar" title="Buscar" border="0">&nbsp;Buscar</a></li>'."\n";
            $strClass .= "\t\t\t\t\t".'<li><a id="cancelbutton" name="cancelbutton" onclick="xajax_searchfields(xajax.getFormValues(\'formulario\'),0);" href="#" class="header_button"><img src="../../../../media/img/actions/back.png" alt="Cancelar" title="Cancelar" border="0">&nbsp;Cancelar</a></li>'."\n";
            $strClass .= "\t\t\t\t".'</ul>'."\n";
            $strClass .= "\t\t\t".'</div>'."\n";
            
            $strClass .= "\t\t\t".'<div id="content">'."\n";
            $strClass .= "\t\t\t\t".'<div id="searchfields" name="searchfields" class="title_panel">'."\n";
            $strClass .= "\t\t\t\t\t".'<div class="panel_title_label">Buscar Por</div>'."\n";
            $strClass .= "\t\t\t\t\t".'<div class="panel_inputs">'."\n";
            
                    $strClass .= "\t\t\t\t\t\t".'<div class="inputs_tr" >'."\n";
                    $strClass .= "\t\t\t\t\t\t\t".'<div class="inputs_td" >'."\n";
                    $strClass .= "\t\t\t\t\t\t\t\t".'<span class="labels" >Nombre</span>'."\n";
                    $strClass .= "\t\t\t\t\t\t\t\t".'<input type="text" value="" name="txts_nombre" id="txts_nombre" onkeyup="enter(event);"/>'."\n";
                    $strClass .= "\t\t\t\t\t\t\t".'</div>'."\n";
                    $strClass .= "\t\t\t\t\t\t\t".'<div class="inputs_td" >&nbsp;</div>'."\n";
                    $strClass .= "\t\t\t\t\t\t\t".'<div class="inputs_td" >&nbsp;</div>'."\n";
                    $strClass .= "\t\t\t\t\t\t".'</div>'."\n";
                    
            $strClass .= "\t\t\t\t\t".'</div>'."\n";
            $strClass .= "\t\t\t\t".'</div>'."\n";
            $strClass .= "\t\t\t".'<!--//-- IBRAC -->'."\n";
            $strClass .= "\t\t\t".'<input id="ibrac" name="ibrac" type="hidden"/>'."\n";
            $strClass .= "\t\t\t".'<!--//-- IBRAC -->'."\n";
            $strClass .= "\t\t\t".'<div class="tablebox" id="datatable_box" name="datatable_box"></div>'."\n";
            
            
            $strClass .= "\t\t\t".'<div id="fields" name="fields" class="title_panel">'."\n";
            $strClass .= "\t\t\t\t".'<div class="panel_title_label" id="fields_title_panel" name="fields_title_panel"></div>'."\n";
            $strClass .= "\t\t\t\t".'<div class="panel_inputs">'."\n";
            
            $i = 0;
            foreach ($this->strFieldNames as $field){   
                $strClass .= "\t\t\t\t\t".'<div class="inputs_tr" >'."\n";
                $strClass .= "\t\t\t\t\t\t".'<div class="inputs_td" >'."\n";
                $strClass .= "\t\t\t\t\t\t\t".'<span class="labels">'.strtolower($field).'</span>'."\n";
                if(strtolower($field) == strtolower($this->strPkField))
                    $strClass .= "\t\t\t\t\t\t\t".'<input id="txt_'.strtolower($field).'" name="txt_'.strtolower($field).'" type="text" readonly="readonly" maxlength="'.$this->strFieldLength[$i].'" style="width: 250px;"/>'."\n";
                else
                    $strClass .= "\t\t\t\t\t\t\t".'<input id="txt_'.strtolower($field).'" name="txt_'.strtolower($field).'" type="text" maxlength="'.$this->strFieldLength[$i].'" style="width: 250px;"/>'."\n";
                $strClass .= "\t\t\t\t\t\t\t".'<span id="valid_'.strtolower($field).'" name="valid_'.strtolower($field).'" class="validfield"></span>'."\n";
                $strClass .= "\t\t\t\t\t\t".'</div>'."\n";
                $strClass .= "\t\t\t\t\t".'</div>'."\n";
                $i++;
            }
            $strClass .= "\t\t\t\t".'</div>'."\n";
            $strClass .= "\t\t\t".'</div>'."\n";
            $strClass .= "\t\t\t".'</div>'."\n";
            $strClass .= "\t\t".'</form>'."\n";
            $strClass .= "\t".'</body>'."\n";

            $strClass .= '</html>';
            //End Class Definition

            return $strClass;
        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }

    private function setTableNameUpper(){
        $pchar = $this->table[0];
        $this->table[0] = strtoupper($pchar);
    }

    private function setExtraVariables(){
        $conn = Connection::getinstance()->getConn();
        odbc_exec($conn, "USE ".$this->database);

        $this->strPkField = "";
        $this->strFieldTypes = "";
        $this->strFieldNames = array();
        $this->strFieldLength = array();
        $fields = odbc_exec($conn,DESC_TABLE." ".$this->table);
	if($fields){
        $count = 0;
            while ($ResultSet = odbc_fetch_array($fields)) {
                //Define the Field Names
                $field = $ResultSet[COLUMN_NAME];
                $field[0] = strtoupper($field[0]);
                $this->strFieldNames[$count] = $field;
                $this->strFieldLength[$count] = $this->extractLenght($ResultSet[TYPE_NAME]) ;//$ResultSet[COLUMN_LENGTH];
                //Define the Parameter Sign ?
                if($count < count($fields) -1)
                    $this->strParamSigns .= "?, ";
                else
                    $this->strParamSigns .= "?";

                //Define de Field Types

                $type = $ResultSet[TYPE_NAME];
                switch($type[0]){
                    case "i":
                        $this->strFieldTypes .= "i";
                        break;
                    case "v":
                        $this->strFieldTypes .= "s";
                        break;
                }

                // Obtiene el PK de la tabla
                if($ResultSet[PRIMARY_KEY] == PRIMARY_KEY_VALUE)
                    $this->strPkField = $ResultSet[COLUMN_NAME];

                $count++;
            }
        }
        //$fields->close();
    }
    
    private function extractLenght($value){
        $cadena=$value;
        $maximo = strlen($cadena);
        $cadena_comienzo = "(";
        $cadena_fin = ")";
        $total = strpos($cadena,$cadena_comienzo);
        $total2 = strpos($cadena,$cadena_fin);
        
        $final = substr ($cadena,$total,$total2);
        $final = str_replace("(", "", $final);
        $final = str_replace(")", "", $final);
        return $final; 
    }
}
?>