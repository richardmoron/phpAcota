<?php 
error_reporting(E_ALL);
error_reporting(-1);
session_start();
include_once (dirname(__FILE__)."/modules/parametros/dao/pa_menu.dao.php");
include_once (dirname(__FILE__)."/modules/parametros/dao/pa_menu_accesos_x_area.dao.php");
include_once (dirname(__FILE__)."/modules/parametros/dao/pa_menu_accesos_x_usuario.dao.php");
include_once (dirname(__FILE__)."/modules/parametros/dao/pa_usuarios.dao.php");
include_once (dirname(__FILE__)."/lib/session.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="x-ua-compatible" content="IE=8" >
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
        <link rel="stylesheet" href="media/css/4forms.css" type="text/css" media="screen" />
        <script type="text/javascript" src="media/js/jquery.min.js"></script>
        <script type="text/javascript" src="media/js/tabs.js"></script>
        <script type="text/javascript" src="media/js/menuhint.js"></script>
        <title><?php echo COMPANY_NAME; ?></title>
    </head>
    <body style="background-color: #FFFFFF;">
        <div id="header">
		<div id="header_title" name="header_title"><?php echo COMPANY_NAME; ?></div>
			<div id="header_content">&nbsp;</div>
			<div id="header_user">
                                <?php 
                                    $pa_usuariosDAO = new pa_usuariosDAO();
                                    $pa_usuariosTO = $pa_usuariosDAO->selectByNamepa_usuarios($_SESSION[SESSION_USER]);
                                ?>
				<span>Usuario:&nbsp;</span><span id="header_user_data"><?php echo $pa_usuariosTO->getNombres()." ".$pa_usuariosTO->getApellidos();?></span><br />
				<span>Fecha:&nbsp;</span><span id="header_date_data"><?php echo date(APP_DATETIME_FORMAT);?></span>
			</div>
		</div>
        <div id="">
            <ul class="pureCssMenu pureCssMenum">
            <!--li class="pureCssMenui"><a onclick="window.location.href='logout.php';return false;" onmouseover="showhint(this, 'OPCI&OACUTE;N DE SALIDA DEL SISTEMA')" href="" class="pureCssMenui" id="menuid19">SALIR</a></li-->
            <?php 
                    $criterio = array();
                    $criterio["usuario"] = $_SESSION[SESSION_USER];
                    $criterio["menu_padre_id"] = 0;
                    $criterio["es_padre"] = "S";
                    $criterio["pivot"] = "menu_id";
                    $html = "";
                    $pa_menuDAO = new pa_menuDAO();
                    $arraylist = $pa_menuDAO->selectMain_pa_menu($criterio, -1);
                    $iterator = $arraylist->getIterator();
                    while($iterator->valid()) {
                        $pa_menuTO = $iterator->current();
                        $link = "menu_id=".$pa_menuTO->getMenu_id();
                        $class = 'class="pureCssMenui"';
                        $endif = "";
                        if($pa_menuTO->getEs_padre() == "N")
                            $html .= '<li '.$class.'><a '.$class.' href="'.$pa_menuTO->getLink().'" onmouseover="showhint(this, \''.$pa_menuTO->getDescripcion().'\')" >'.$pa_menuTO->getNombre().'</a>';
                        else{
                            $html .= '<li '.$class.'><a '.$class.' href="#" onclick="return false;" onmouseover="showhint(this, \''.$pa_menuTO->getDescripcion().'\')" ><span>'.$pa_menuTO->getNombre().'</span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]-->';
                            $html .= '<ul class="pureCssMenum">';
                            $html .= recursiveSubMenu($pa_menuTO->getMenu_id());    
                            $html .= '</ul>';
                            $endif = '<!--[if lte IE 6]></td></tr></table></a><![endif]-->';
                        }
                        $html .= $endif.'</li>';
                        $iterator->next();
                    }
                    echo $html;
            ?>
            <?php 
                function recursiveSubMenu($menu_padre_id){
                    $html = "";
                    $criterio = array();
                    $criterio["usuario"] = $_SESSION[SESSION_USER];
                    $criterio["menu_padre_id"] = $menu_padre_id;
                    $criterio["pivot"] = "menu_padre_id";
                    $pa_menuDAO = new pa_menuDAO();
                    $arraylist = $pa_menuDAO->selectMain_pa_menu($criterio, -1);
                    $iterator = $arraylist->getIterator();
                    while($iterator->valid()) {
                        $pa_menuTO = $iterator->current();
                        if($menu_padre_id != $pa_menuTO->getMenu_id()){
                            $class = 'class="pureCssMenui"';
                            $endif = "";
                            if($pa_menuTO->getEs_padre() == "N"){
                                $tab = 'addtab('.$pa_menuTO->getMenu_id().',\''.$pa_menuTO->getLink().'\',\''.$pa_menuTO->getNombre().'\');return false;';
                                if($pa_menuTO->getTab()=="N")
                                    $tab = 'window.location.href=\''.$pa_menuTO->getLink().'\';return false;';
                                
                                $html .= '<li '.$class.'><a id= "menuid'.$pa_menuTO->getMenu_id().'" '.$class.' href="" onmouseover="showhint(this, \''.$pa_menuTO->getDescripcion().'\')" onclick="'.$tab.'" >'.$pa_menuTO->getNombre().'</a>';
                            }else{
                                $html .= '<li '.$class.'><a '.$class.' href="#" onclick="return false;" onmouseover="showhint(this, \''.$pa_menuTO->getDescripcion().'\')" ><span>'.$pa_menuTO->getNombre().'</span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]-->';
                                $html .= '<ul class="pureCssMenum">';
                                $html .= recursiveSubMenu($pa_menuTO->getMenu_id());    
                                $html .= '</ul>';
                                $endif = '<!--[if lte IE 6]></td></tr></table></a><![endif]-->';
                            }
                            $html .= $endif.'</li>';
                        }
                        $iterator->next();    
                    }
                    return $html;
                }
            ?>
            </ul>
        </div>
        <div style="height: 100%;margin-top: 35px;background-color:#FFFFFF;">
            <ul id="tabul">
                <!--li id="litab" class="ntabs add"><a href="" id="addtab">+</a></li-->
            </ul>
            <div id="tabcontent"></div>
        </div>
    </body>
</html>