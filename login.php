<?php ob_start(); session_start(); include_once ("conf/configure.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="x-ua-compatible" content="IE=8" >
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <link rel="stylesheet" href="media/css/bluedbd.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="media/css/login.css" type="text/css" media="screen" />
        <title>Ingresar al Sistema</title>
        <style type="text/css">
            html{
                height: 100%;
            }
            .alerts{
                display: none;
            }
            .important{
                font-weight: bold;
            }
        </style>
    </head>
    <body class="vega signin-body">
        <div class="signin-wrapper">
            <form action="login.php" method="POST"  enctype="multipart/form-data" class="form-horizontal hide" style="display: block;">
                <div class="panel signin">
                    <h2 class="important"> Iniciar Sesi&oacute;n </h2>
                    <div class="panel-content">
                        <div class="control-group login-control">
                            <label for="username" class="control-label">Usuario:</label>
                            <div class="controls">
                                <input type="text" autofocus="" id="txt_usuario" name="txt_usuario"/>
                            </div>
                        </div>
                        <div class="control-group login-control">
                            <label for="password" class="control-label">Clave:</label>
                            <div class="controls">
                                <input type="password" name="txt_clave" id="txt_clave"/>
                            </div>
                        </div>
                        <div class="alerts" id="alerts">
                            <div class="alert alert-error">
                                Usario o Clave Inv&aacute;lidos
                            </div>
                        </div>
                    </div>
                    <div class="panel-content no-bottom corner-bottom clearfix">
                      <button type="submit" class="btn btn-primary do-signin pull-right">Ingresar</button>
                      <div class="system-name">
                        <?php echo COMPANY_NAME;?>
                      </div>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
<?php 
    session_unset(); 
    session_destroy();
    $_SESSION = array();
    include_once ("modules/parametros/dao/pa_usuarios.dao.php");
    if(isset($_POST["txt_usuario"]) && isset($_POST["txt_clave"])){
        $pa_usuariosDAO = new pa_usuariosDAO();
        $criterio = array();
        $criterio["usuario"] = $_POST["txt_usuario"];
        $criterio["password"] = md5($_POST["txt_clave"]);
        $arraylist = $pa_usuariosDAO->selectByCriteria_pa_usuarios($criterio, 0);
        $iterator = $arraylist->getIterator();
        while($iterator->valid()) {
            $pa_usuariosTO = $iterator->current();
            if(strtoupper($_POST["txt_usuario"])==$pa_usuariosTO->getUsuario() && md5($_POST["txt_clave"]) == $pa_usuariosTO->getPassword()){
                session_start();
                $_SESSION[SESSION_USER] = $_POST["txt_usuario"];
                header("Location:menu.php");
            }
            $iterator->next();
        }
        echo '<script type="text/javascript">document.getElementById(\'alerts\').style.display = \'block\';</script>';
    }
?>