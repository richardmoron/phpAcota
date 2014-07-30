<?php 
include_once (dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/conf/configure.php");
include_once (dirname(dirname(dirname(__FILE__)))."/dao/ec_usuarios.dao.php");
session_start();
if(isset($_SESSION["encuesta_user"]) && trim($_SESSION["encuesta_user"])!="" ){
    $ec_usuariosDAO = new ec_usuariosDAO();
    $elem = new ec_usuariosTO();
    $elem->setEstado_usuario("I");
    $elem->setNombre_usuario($_SESSION["encuesta_user"]);
    $ec_usuariosDAO->updateEstadoEc_usuarios($elem);
    $_SESSION["encuesta_user"] = null;
    unset($_SESSION["encuesta_user"]);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="x-ua-compatible" content="IE=8" >
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <style type="text/css">
            #container{background-color: #F3F3F3;border: 2px solid #DAE4E9;margin: 15px;padding: 10px;font-family: Verdana, Arial;font-size: 16pt;height: 150px;text-align: center;padding-top: 100px;}
        </style>
        <script type="text/javascript">
                /*window.onload = function () { Clear(); }
                function Clear() {            
                    var Backlen=history.length;
                    if (Backlen > 0) history.go(-Backlen);

                    if(window.history.forward(1) != null)
                        window.history.forward(1);
                }*/
        </script>
    </head>
    <body onload="">
        <div id="container">
            Muchas Gracias por su Tiempo...
        </div>
    </body>
</html>