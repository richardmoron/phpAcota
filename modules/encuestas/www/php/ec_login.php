<?php 
    @session_start();
    $_SESSION["encuesta_user"] = null;
    unset($_SESSION["encuesta_user"]);
    include_once (dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/conf/configure.php");
    include_once (dirname(dirname(dirname(__FILE__)))."/dao/ec_usuarios.dao.php");
    include_once dirname(dirname(dirname(__FILE__)))."/dao/ec_resultados_maestro.dao.php"; 
    if(isset($_POST["txt_usuario"]) && isset($_POST["txt_clave"])){
        $ec_usuariosDAO = new ec_usuariosDAO();
        $criterio = array();
        $criterio["nombre_usuario2"] = $_POST["txt_usuario"];
        $criterio["clave_usuario"] = ($_POST["txt_clave"]);
        $criterio["estado_usuario"] = "A";
        $criterio["fecha_habil"] = "A";
        
        $arraylist = $ec_usuariosDAO->selectByCriteria_ec_usuarios($criterio, 0);
        $iterator = $arraylist->getIterator();
        while($iterator->valid()) {
            $ec_usuariosTO = $iterator->current();
            if(strtoupper($_POST["txt_usuario"])==$ec_usuariosTO->getNombre_usuario() && ($_POST["txt_clave"]) == $ec_usuariosTO->getClave_usuario()){
                $_SESSION["encuesta_user"] = $_POST["txt_usuario"];
                
                $ec_resultados_maestroDAO = new ec_resultados_maestroDAO();
                $existe = $ec_resultados_maestroDAO->selectCountec_resultados_maestro(array("encuesta_id"=>$_GET["ei"],"usuario"=>  strtoupper($_SESSION["encuesta_user"]),"estado_usuario"=>"A"));
                if($existe > 0)
                    header("Location:/encuesta/e/".$_GET["ei"]);
                else
                    header("Location:/encuesta/acuerdo/".$_GET["ei"]);
            }
            $iterator->next();
        }
        echo '<script type="text/javascript">document.getElementById(\'error_msg\').style.visibility = \'visible\';</script>';
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="<?php echo MY_URI;?>/media/css/graybdb.css" type="text/css" media="screen" />
        <script type="text/javascript" src="<?php echo MY_URI;?>/media/js/browserDetect.js" ></script>
        <script type="text/javascript">
            if(BrowserDetect.browser == 'Explorer' && BrowserDetect.version < 7){window.location = 'actualizar_browser.php';}
            if(BrowserDetect.browser == 'Firefox' && BrowserDetect.version < 3){window.location = 'actualizar_browser.php';}
        </script>
        <title>Iniciar Sesi&oacute;n</title>
    </head>
    <body style="background-color: #999999;">
        <form action="<?php echo $_GET["ei"]; ?>" method="POST"  enctype="multipart/form-data">
            <div style="width: 400px;height: 250px;margin-left:30%;margin-right: 30%;margin-top: 10%;border-right: 1px solid #999999;">
                <div id="header">
                    <div id="header_title" style="width: auto;font-size: 16px;">Iniciar Sesi&oacute;n para Empezar la Encuesta</div>
                </div>
                <div id="header_buttons" style="position: relative;height: 100%;background: none;background-color: #E5E5E5;border-right: 1px solid #999999;">
                    <table style="padding-left: 30px;padding-top:50px;" cellpadding="5">
                        <thead></thead>
                        <tbody>
                            <tr>
                                <td style="color:#333333;font-size: 16px;font-family: Verdana;font-weight: bold;width: 75px;text-align: right;">Usuario</td>
                                <td><input type="text" id="txt_usuario" name="txt_usuario" style="height: 25px;width: 200px;font-size: 16px;"/></td>
                            </tr>
                            <tr>
                                <td style="color:#333333;font-size: 16px;font-family: Verdana;font-weight: bold;width: 75px;text-align: right;">Contrase&ntilde;a</td>
                                <td><input type="password" id="txt_clave" name="txt_clave" size="25" style="height: 25px;width: 200px;font-size: 16px;"/></td>
                            </tr>
                            <tr>
                                <td id="error_msg" colspan="2" style="visibility: hidden;color:#FE0000;font-size: 12px;font-family: Verdana;font-weight: bold;text-align: right;">* Usuario o Contrase&ntilde;a Inv&aacute;lidos</td>
                            </tr>
                        </tbody>
                    </table>
                    <div style="width: 100%;border-top: 1px solid #999999;margin-top: 25px;text-align: right;padding-top: 15px;">
                        <input type="submit" value="Ingresar" style="height: 30px;width: 100px;margin-right: 25px;color:#FFFFFF;font-size: 14px;font-family: Verdana;background-color: #444444;font-weight: bold;"/>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>