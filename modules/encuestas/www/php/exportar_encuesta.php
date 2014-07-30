<?php
session_start();
error_reporting(0);
require_once dirname(dirname(dirname(__FILE__)))."/dao/ec_resultados.dao.php"; 

if($_GET["id"]){
    $ec_resultadosDAO = new ec_resultadosDAO();
    $encuesta_id = $_GET["id"];  
    $html = $ec_resultadosDAO->selectEncuestaForExcel($encuesta_id);
    //--
    header('Content-type: application/vnd.ms-excel;');
    header("Content-Disposition: attachment; filename=encuesta".$encuesta_id.".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    echo $html;
}
?>