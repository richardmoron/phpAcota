<?php require_once dirname(dirname(dirname(__FILE__)))."/xajax/encuesta.xajax.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="x-ua-compatible" content="IE=8" >
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Encuesta Brain</title>
        <style type="text/css">
            #container{background-color: #F3F3F3;border: 2px solid #DAE4E9;margin: 15px;padding: 10px;font-family: Verdana, Arial;font-size: 10pt;}
            #tittle{padding-top: 15px;text-align: center;width: 100%;height: 40px;font-weight: normal;font-size: 15pt;margin-bottom: 20px;color: #FFFFFF;background-color: #444444;}
            #tittle_img a{ text-decoration: none; }
            #tittle_img a:visited{ text-decoration: none;}
            #tittle_img img{ border: none;}
            #tittle_img{margin-left: 10px;}
            #description{margin-bottom: 20px;}
            .qnro{font-weight: bold;margin-bottom: 15px;}
            .group_tittle{font-weight: bold;padding-bottom: 15px;font-size: 15pt;}
            .question{font-weight: bold;}
            .question_group{width: 80%;}
            .answer{margin-bottom: 15px;margin-top: 10px;margin-left: 15px;}
            .textbox{width: 500px;}
            .combobox{}
            radio{margin-left: 25px;}
            .lblradio{float: left;margin-top: -15px;margin-left: 10px;}
            .radioh{float: left;margin-left: -10px;}
            .label_izq{float: left;margin-left: 25px;width: 150px;text-align: right;}
            .label_der{width: 150px;text-align: left;}
            .r{font-style: italic;}
            #bottom {width: 100%;position: fixed;bottom: 30px;background-color: #333333;color: #FFFFFF;left: 0px;height: 35px;margin-bottom:-30px;}
            #bottom a,.left-button, .right-button{width: auto;height: 37px;display: inline-block;text-decoration: none;color: #FFFFFF;text-align: center;font-weight: bold;font-family: Verdana, Arial;font-size: 11pt;top: 0px;margin: 0px;float: left;padding-top:5px;padding-left: 10px;padding-right: 10px;}
            #bottom a:hover, .left-button:hover, .right-button:hover{width: auto;height: 35px;display: inline-block;text-decoration: none;color: #333333;background-color: #F3F3F3;}
            #loading {background-image:url(<?php echo MY_URI;?>/media/img/loading-bg.png) ;position: absolute;left: 0px;right: 0px;top: 0px;bottom: 0px;width: 100%;height: 500%;margin: 0px;color: #545454;font-weight: 600;font-size: 16px ;text-align: center;font-family: arial;z-index: 50;display: block;}
            #loadingimg{margin-top:20%;}
        </style>
        <?php $xajax->printJavascript(MY_URI."/lib/xajax/"); ?>
        <script type="text/javascript" src="<?php echo MY_URI;?>/media/js/browserDetect.js" ></script>
        <script type="text/javascript">
            if(typeof String.prototype.trim !== 'function') {String.prototype.trim = function() {return this.replace(/^\s+|\s+$/g, ''); }}
            function validateForm(){document.getElementById('loading').style.display = 'block';var elem = document.getElementById('formulario').elements;for(var i = 0; i < elem.length; i++){if(elem[i].type.trim() != "hidden"){var checked = false;if(elem[i].type.trim() == "radio"){radios = document.getElementsByName(elem[i].name);for(var j = 0; j< radios.length; j++){if(radios[j].checked == true){checked = true;}}}else{if(elem[i].value != null && elem[i].value.trim() != "" ){checked = true;}}if(checked == false){alert('Existen Preguntas sin Responder!');document.getElementById('loading').style.display = 'none';return false;}}} return true;}
            function exitForm(){alert('Su encuesta esta guardada y puede continuarla en otro momento hasta completarla');close();}
            xajax.callback.global.onRequest = function() {xajax.$('loading').style.display = 'block';}
            xajax.callback.global.beforeResponseProcessing = function() {xajax.$('loading').style.display='none';}
            if(BrowserDetect.browser == 'Explorer' && BrowserDetect.version < 7){window.location = 'actualizar_browser.php';}
            if(BrowserDetect.browser == 'Firefox' && BrowserDetect.version < 3){window.location = 'actualizar_browser.php';}
        </script>
    </head>
    <body onload="xajax_preLoad();">
        <div id="loading"><img src="<?php echo MY_URI;?>/media/img/loading-bar.gif" alt="Loading..." id="loadingimg"/><br /> Cargando...</div>
        <form id="formulario" method="post" action="#">
            <div id="container">
                <div id="question_group" class="question_group"></div>
            </div>
            <br />
        </form>
    </body>
</html>