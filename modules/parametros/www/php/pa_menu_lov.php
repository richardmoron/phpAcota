<?php require_once dirname(dirname(dirname(__FILE__)))."/xajax/pa_menu_lov.xajax.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="x-ua-compatible" content="IE=8" >
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <link rel="stylesheet" href="../../../../media/css/4forms.css" type="text/css" media="screen" />
            <title>&Aacute;rbol de Men&uacute;s</title>
            <?php $xajax->printJavascript(MY_URI."/lib/xajax/"); ?>
            <script type="text/javascript">
                    xajax.callback.global.onRequest = function() {xajax.$('loading').style.display = 'block';}
                    xajax.callback.global.beforeResponseProcessing = function() {xajax.$('loading').style.display='none';}
            </script>
            <script type="text/javascript">
                function terminate(menu_id,nomre_menu){
                      var o = new Object();
                      o.menu_id = menu_id;
                      o.nomre_menu = nomre_menu;
                      window.returnValue = o;
                      window.close();
                }
            </script>
            <style type="text/css">
                .title_panel{
                    margin-top: 10px;
                    box-shadow: 0 1px 0 rgba(255, 255, 255, 0) inset, 0 1px 2px #000000;
                }
            </style>
            <!--style type="text/css" media="screen">
                h2{
                    background-image: url("../../../../media/img/panel-title-background.png");
                    border-color: #DAE4E9 #DAE4E9 -moz-use-text-color;
                    border-image: none;
                    border-style: solid solid none;
                    border-width: 2px 2px medium;
                    color: #7392A2;
                    font-family: Verdana,Arial;
                    font-size: 10pt;
                    font-weight: bold;
                    height: 25px;
                    margin: 15px 15px 0px 15px;
                    padding-left: 10px;
                    padding-top: 5px;
                    vertical-align: middle;
                    width: 90%;
                }
                #ctn_menus{
                    background-color: #FFFFFF;
                    border-color: #DAE4E9;
                    border-image: none;
                    border-style: none solid solid;
                    border-width: medium 2px 2px;
                    font-family: Verdana,Arial;
                    font-size: 10pt;
                    list-style: none outside none;
                    margin-top: 0;
                    margin-left: 15px;
                    padding-bottom: 10px;
                    padding-left: 10px;
                    padding-top: 15px;
                    width: 90%;
                }
            </style-->
	</head>
	<body onload="xajax_preload();">
		<div id="loading"><img src="../../../../media/img/loading-bar.gif" alt="Loading..." id="loadingimg"/><br /> Cargando...</div>
		<form action="#" method="post" id="formulario">	
                    <div id="" name="" class="title_panel">
                        <div class="panel_title_label" id="fields_title_panel" name="fields_title_panel">&Aacute;rbol de Men&uacute;s</div>
                            <div id="ctn_menus" name="ctn_menus" ></div>
                            <input  type="hidden" id="es_padre" name="es_padre" />
                    </div>
                </form>
	</body>
</html>