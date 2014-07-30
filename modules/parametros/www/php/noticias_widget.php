<?php 
@session_start();
include_once (((dirname(dirname(dirname(__FILE__)))))."/dao/pa_noticias.dao.php");
//--
$criterio = array("fecha_desde_hasta"=>"S");
$objpa_noticiasDAO = new pa_noticiasDAO();
$arraylist = $objpa_noticiasDAO->selectByCriteria_pa_noticias($criterio,-1);
$iterator = $arraylist->getIterator();
$strhtml .= '<br />';
$strhtml .= '<div id="" name="" class="title_panel" style="width:300px;">';
$strhtml .= '<div class="panel_title_label" id="fields_title_panel" name="fields_title_panel">Noticias</div>';
$strhtml .= '<ul class="wn_ul">';
while($iterator->valid()) {
    $objpa_noticiasTO = $iterator->current();
    $strhtml .= '<li class="wn_li"><a href="#">'.$objpa_noticiasTO->getTitulo().'</a></li>'."\n";
    
    $iterator->next();
}
$strhtml .= '</ul>';
$strhtml .= '</div>';
echo $strhtml;
?>