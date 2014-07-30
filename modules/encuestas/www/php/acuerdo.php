<?php 
    @session_start();
    include_once (dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/conf/configure.php");
    include_once dirname(dirname(dirname(__FILE__)))."/dao/ec_encuestas.dao.php"; 
    include_once dirname(dirname(dirname(__FILE__)))."/dao/ec_resultados_maestro.dao.php"; 
    if(!isset($_SESSION["encuesta_user"])){
        header("Location:/encuesta/login/".$_GET["id"]);
    }
    if(isset($_GET["id"])){
        $ec_resultados_maestroDAO = new ec_resultados_maestroDAO();
        $existe = $ec_resultados_maestroDAO->selectCountec_resultados_maestro(array("encuesta_id"=>$_GET["ei"],"usuario"=>  strtoupper($_SESSION["encuesta_user"]),"estado_usuario"=>"A"));
        if($existe > 0)
            header("Location:/encuesta/e/".$_GET["id"]);
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <title>Aceptaci&oacute;n del Acuerdo</title>
        <style type="text/css">
            html, body{height:  100%;}
            #container{background-color: #F3F3F3;border: 2px solid #DAE4E9;margin: 15px;padding: 10px;font-family: Verdana, Arial;font-size: 16pt;height: 92%;text-align: center;}
            #tittle{padding-top: 15px;text-align: center;width: 100%;height: 40px;font-weight: normal;font-size: 15pt;margin-bottom: 20px;color: #FFFFFF;background-color: #444444;}
            #txt_acuerdo{height: 79%;width: 90%;margin-bottom: 10px;background-color: #ffffff;border: 1px solid #999999;font-size: 11pt;overflow: auto;margin-left: 5%;text-align: left;}
            input {background-color: #444444;border: 1px solid #706F6F;color: #DDDDDD;font-weight: normal;height: 30px;}
        </style>
    </head>
    <body>
        <!--form action="acuerdo.php?a=S"-->
            <div id="container">
                <div id="tittle">TERMINO DE CONFIDENCIALIDAD</div>
                <div id="txt_acuerdo" name="txt_acuerdo" rows="20" cols="50" ><?php
                    if(isset($_GET["id"])){
                        $ec_encuestasDAO = new ec_encuestasDAO();
                        $ec_encuestasTO = $ec_encuestasDAO->selectByIdec_encuestas($_GET["id"]);
                        if($ec_encuestasTO->getAcuerdo() != NULL)
                            echo htmlspecialchars_decode($ec_encuestasTO->getAcuerdo());
                        
                        //echo '<input id="id" name="id" type="hidden" value="'.$_GET["id"].'"/>';
                    }
                ?>
                </div>
                <input type="button" value="ACEPTAR Y CONTINUAR" onclick="location.href='/encuesta/e/<?php if(isset($_GET["id"])) echo $_GET["id"];?>'"/>
            </div>
        <!--/form-->
    </body>
</html>