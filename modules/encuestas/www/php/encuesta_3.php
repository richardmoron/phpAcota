<?php 
ob_start();
@session_start(); 
require_once dirname(dirname(dirname(__FILE__)))."/dao/ec_encuestas.dao.php"; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="x-ua-compatible" content="IE=8" >
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
        <!--base href="http://www.brain.com.bo/" /-->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <style type="text/css">
            #container{background-color: #F3F3F3;border: 2px solid #DAE4E9;margin: 15px;padding: 10px;font-family: Verdana, Arial;font-size: 10pt;}
            #tittle{padding-top: 15px;text-align: center;width: 100%;height: 40px;font-weight: normal;font-size: 15pt;margin-bottom: 20px;color: #FFFFFF;background-color: #444444;}
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
            #bottom a,.left-button, .right-button{width: 100px;height: 37px;display: inline-block;text-decoration: none;color: #FFFFFF;text-align: center;font-weight: bold;font-family: Verdana, Arial;font-size: 11pt;top: 0px;margin: 0px;float: left;padding-top:5px;}
            #bottom a:hover, .left-button:hover, .right-button:hover{width: 100px;height: 35px;display: inline-block;text-decoration: none;color: #333333;background-color: #F3F3F3;}
            #loading {background-image:url(../../../../media/img/loading-bg.png) ;position: absolute;left: 0px;right: 0px;top: 0px;bottom: 0px;width: 100%;height: 500%;margin: 0px;color: #545454;font-weight: 600;font-size: 16px ;text-align: center;font-family: arial;z-index: 50;display: block;}
            #loadingimg{margin-top:20%;}
            .left-button, .right-button {cursor: pointer;}
            .slideshow {position: relative;overflow: auto;}
            .simpleSlide-slide{width: 750px;}
        </style>
        <script type="text/javascript">
            if(typeof String.prototype.trim !== 'function') {String.prototype.trim = function() {return this.replace(/^\s+|\s+$/g, ''); }}
            function validateForm(){
                document.getElementById('loading').style.display = 'block';
                var elem = document.getElementById('formulario').elements;
                for(var i = 0; i < elem.length; i++){
                    if(elem[i].type.trim() != "hidden"){
                        var checked = false;if(elem[i].type.trim() == "radio"){
                            radios = document.getElementsByName(elem[i].name);
                            for(var j = 0; j< radios.length; j++){
                                if(radios[j].checked == true){
                                    checked = true;}}}
                        if(elem[i].value != null && elem[i].value.trim() != "" ){
                            checked = true;
                        }if(checked == false){
                            alert('Existen Preguntas sin Responder!');
                            document.getElementById('loading').style.display = 'none';
                            return false;}}}
                return true;
                //document.forms[0].submit();
            }
            function getXmlHttpObject() {
                //for firefox, opera and safari browswers
                var xmlHttp = new XMLHttpRequest();
                if (window.XMLHttpRequest) {
                    return new XMLHttpRequest();
                } else {
                        try {
                                return new ActiveXObject("Msxml2.XMLHTTP.6.0");
                            }catch (e) {
                                try {
                                    return new ActiveXObject("Msxml2.XMLHTTP.3.0");
                                }catch (e) {
                                    try {
                                        return new ActiveXObject("Msxml2.XMLHTTP");
                                    } catch (e) {
                                        //Microsoft.XMLHTTP points to Msxml2.XMLHTTP.3.0 and is redundant
                                        throw new Error("This browser does not support XMLHttpRequest.");
                                    }
                                }
                            }
                    }
                return xmlHttp;
            }
            function procesar(encuesta_id, resultado_id, usuario, grupo_id) {
                    var xmlHttp = getXmlHttpObject();
                    xmlHttp.onreadystatechange = function() {
                        if (xmlHttp.readyState == 4) {
                        // onSuccess
                            if (xmlHttp.status == 200) {
                                document.getElementById("question_group").innerHTML = (xmlHttp.responseText);
                                document.getElementById('loading').style.display = 'none';
                            }
                        }
                    };
                    xmlHttp.open("GET", "encuesta.ajax.php?encuesta_id="+encuesta_id+"&resultado_id="+resultado_id+"&usuario="+usuario+"&grupo_id="+grupo_id, true);
                    xmlHttp.send(null);
                    return xmlHttp;
            }
        </script>
    </head>
    <body>
        <form id="formulario" method="post" action="save.php">

            <div id="container">
                <?php 
                    //$_SESSION["encuesta_user"] = null;
                    //unset($_SESSION["encuesta_user"]);
                    
                        if(isset($_GET["id"]) && strlen(trim($_GET["id"]))>0){
                            $encuesta_id = $_GET["id"];
                            $ec_encuestasDAO = new ec_encuestasDAO();
                            $criterio_tmp = array("valid_date"=>true);
                            $ec_encuestasTO =  $ec_encuestasDAO->selectByIdec_encuestas($encuesta_id,$criterio_tmp);
                            if($ec_encuestasTO->getEncuesta_id()!=null){
                                if($ec_encuestasTO->getEs_anonimo() == "N" && !isset($_SESSION["encuesta_user"]) ){
                                    header("Location:ec_login.php?ei=$encuesta_id");
                                }else{
                                    if(!isset($_COOKIE["encuesta"]) || (isset($_SESSION["encuesta_user"]) && $ec_encuestasTO->getEs_anonimo() == "N" ) ){
                                        $encuesta_user = "";
                                        if(isset($_SESSION["encuesta_user"]))
                                            $encuesta_user = $_SESSION["encuesta_user"];
                                        
                                        echo '<div id="tittle_img"><img src="../../../../media/img/logo.png" alt="logo"/></div>';
                                        echo '<div id="tittle">'.$ec_encuestasTO->getNombre().'</div>';
                                        echo '<div id="description">'.$ec_encuestasTO->getDescripcion().'</div>';
                                        echo '<input type="hidden" name="encuesta_id" id="encuesta_id" value="'.$encuesta_id.'"/>';
                                        echo '<input type="hidden" name="encuesta_nombre" id="encuesta_nombre" value="'.$ec_encuestasTO->getNombre().'"/>';
                                        echo '<div id="question_group" class="question_group"></div>';
                                        //echo '<script type="text/javascript">procesar('.$encuesta_id.',0,"'.$encuesta_user.'",0);</script>';
                                        include_once 'encuesta.ajax.php';
                                    }  else {
                                        header("Location:realizado.php");
                                    }
                                }
                            }else{
                                header("Location:noexiste.php");
                            }
                        }
                        echo '<script type="text/javascript">document.getElementById("loading").style.display = "none";</script>';
                ?>
            </div>
            <br />
        </form>
    </body>
</html>