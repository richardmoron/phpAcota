<?php
ob_start();
session_start();
require_once dirname(dirname(dirname(__FILE__)))."/dao/ec_encuestas.dao.php"; 
require_once dirname(dirname(dirname(__FILE__)))."/dao/ec_resultados.dao.php";
//foreach ($_POST as $key => $value) 
//        echo "Key: $key Val: $value ".substr($key,0,3)." ".substr($key,3,  strlen($key))."<br>";


if(isset($_POST["encuesta_id"]) && trim($_POST["encuesta_id"])!=""){
    $ec_encuestasDAO = new ec_encuestasDAO();
    $ec_resultadosTO = new ec_resultadosTO();
    $ec_resultadosDAO = new ec_resultadosDAO();
    
    $ec_resultadosTO->setResultado_id(0);
    $ec_resultadosTO->setUsuario_id("null");
    //$ec_resultadosTO->setFecha_hora(NULL);
    //--
    $ec_resultadosTO->setEncuesta_id($_POST["encuesta_id"]);
    $ec_resultadosTO->setNombre_encuesta($_POST["encuesta_nombre"]);
    $ec_resultadosTO->setGrupo_id($_POST["grupo_id"]);
    $ec_resultadosTO->setGrupo($_POST["grupo_nombre"]);
    $ec_resultadosTO->setEncuesta_id_nro($ec_resultadosDAO->selectMaxEncuesta_id_nro());
    $ec_encuestasTO =  $ec_encuestasDAO->selectByIdec_encuestas($_POST["encuesta_id"]);
    if($ec_encuestasTO->getEs_anonimo() == "S"){
        setcookie( "encuesta", date("d/m/Y H:i:s"), time()+(60*60*24*30) ); //para registra que realizó
    }else{
        if(isset($_SESSION["encuesta_user"]))
            $ec_resultadosTO->setUsuario($_SESSION["encuesta_user"]);
    }
            
    foreach ($_POST as $key => $value){ 
        if(substr($key,0,3) == "pid"){
            $id = substr($key,3,  strlen($key));
            $ec_resultadosTO->setPregunta_id($_POST["pid$id"]);
            $ec_resultadosTO->setPregunta($_POST["pno$id"]);
            $ec_resultadosTO->setRespuesta($_POST["rep$id"]);
            
            if($ec_encuestasTO->getEncuesta_id()!=null){//insertar
                $ec_resultadosDAO->insertec_resultados($ec_resultadosTO);
//                header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
//                header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
//                header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
//                header("Cache-Control: post-check=0, pre-check=0", false);
//                header("Pragma: no-cache");
                header("Location:gracias.php");
                //header("Location:encuesta.php?id=".$_POST["encuesta_id"]."&gr=".$_POST["grupo_id"]);
            }else{//modificar
                $ec_resultadosDAO->updateec_resultados($ec_resultadosTO);
            }
        }
    }
}
?>