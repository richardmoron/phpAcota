<?php
session_start();
require_once dirname(dirname(dirname(__FILE__)))."/dao/ec_usuarios.dao.php"; 

    $ec_usuariosDAO = new ec_usuariosDAO();
    $criterio = array();
    $arraylist = $ec_usuariosDAO->selectByCriteria_ec_usuarios($criterio,-1);
    $iterator = $arraylist->getIterator();
    $html = "<table border='1'><thead><tr><th>ID</th><th>NOMBRE</th><th>CLAVE</th><th>ESTADO</th><th>FECHA HABILITADO</th></tr></thead><tbody>";
    while($iterator->valid()){
        $ec_usuariosTO = $iterator->current();
        $html .= "<tr>";
        $html .= "<td>".$ec_usuariosTO->getUsuario_id()."</td>";
        $html .= "<td>".$ec_usuariosTO->getNombre_usuario()."</td>";
        $html .= "<td>".$ec_usuariosTO->getClave_usuario()."</td>";
        $html .= "<td>".$ec_usuariosTO->getEstado_usuario()."</td>";
        $html .= "<td>".$ec_usuariosTO->getFecha_habilitacion()."</td>";
        $html .= "</tr>";
        $iterator->next();
    }
    $html .= "</tbody></table>";
    //--
    header('Content-type: application/vnd.ms-excel;');
    header("Content-Disposition: attachment; filename=usuarios".date("dmy").".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    echo $html;

?>