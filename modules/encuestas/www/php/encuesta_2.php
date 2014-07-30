<?php 
ob_start();
@session_start(); 
require_once dirname(dirname(dirname(__FILE__)))."/dao/ec_encuestas.dao.php"; 
require_once dirname(dirname(dirname(__FILE__)))."/dao/ec_grupos_preguntas.dao.php"; 
require_once dirname(dirname(dirname(__FILE__)))."/dao/ec_preguntas.dao.php"; 
require_once dirname(dirname(dirname(__FILE__)))."/dao/ec_valores_respuesta.dao.php"; 
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
            function saveForm(){
                document.getElementById('loading').style.display = 'block';
                var elem = document.getElementById('formulario').elements;
                for(var i = 0; i < elem.length; i++){if(elem[i].type.trim() != "hidden"){var checked = false;if(elem[i].type.trim() == "radio"){radios = document.getElementsByName(elem[i].name);for(var j = 0; j< radios.length; j++){if(radios[j].checked == true){checked = true;}}}if(elem[i].value != null && elem[i].value.trim() != "" ){checked = true;}if(checked == false){alert('Existen Preguntas sin Responder!');document.getElementById('loading').style.display = 'none';return;}}} document.forms[0].submit();
            }
        </script>
        <script type="text/javascript" src="../../../../media/js/jquery-latest.js" ></script>
        <script type="text/javascript" src="../../../../media/js/jquery.simpleSlide_min.js" ></script>
        <script type="text/javascript">
            $(document).ready( function() {
                   simpleSlide({
                        'set_speed': 300,
                        'status_width': 10,
                        'status_color_outside': '#aaa',
                        'status_color_inside': '#fff',
                        'fullscreen': 'false',
                        'swipe': 'true',
                        'callback': function() { /* function code */
                            document.getElementById('simpleSlide-window').style.height = 'auto';
                        }
                    });

            });
            function changecss(myclass,element,value) {
                    var CSSRules;if (document.all) {CSSRules = 'rules';}else{ if (document.getElementById) {CSSRules = 'cssRules';}}
                    for (var i = 0; i < document.styleSheets[0][CSSRules].length; i++) {if (document.styleSheets[0][CSSRules][i].selectorText == myclass) {document.styleSheets[0][CSSRules][i].style[element] = value}}
            }
            var iPage = 0;
            function clickSlide(dir){
                if(dir == "left"){ iPage--;if((iPage-1) <= (document.getElementById("cant_grupos").value)){document.getElementById("sRight").style.visibility = 'visible';}}
                if(dir == "right"){ iPage++;if((iPage+1) >= (document.getElementById("cant_grupos").value)){document.getElementById("sRight").style.visibility = 'hidden';}}
                if(iPage <= 0){document.getElementById("sLeft").style.visibility = 'hidden';}else{document.getElementById("sLeft").style.visibility = 'visible';}
            }
        </script>
    </head>
    <body>
        <form id="formulario" method="post" action="save.php">
            <div id="loading"><img src="../../../../media/img/loading-bar.gif" alt="Loading..." id="loadingimg"/><br /> Cargando...</div>
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
                                        echo '<div id="tittle_img"><img src="../../../../media/img/logo.png" alt="logo"/></div>';
                                        echo '<div id="tittle">'.$ec_encuestasTO->getNombre().'</div>';
                                        echo '<div id="description">'.$ec_encuestasTO->getDescripcion().'</div>';
                                        echo '<input type="hidden" name="encuesta_id" value="'.$encuesta_id.'"/>';
                                        echo '<input type="hidden" name="encuesta_nombre" value="'.$ec_encuestasTO->getNombre().'"/>';
                                        $ec_grupos_preguntasDAO = new ec_grupos_preguntasDAO();
                                        $criterio = array("encuesta_id"=>$encuesta_id);
                                        $arraylist = $ec_grupos_preguntasDAO->selectByCriteria_ec_grupos_preguntas($criterio, -1);
                                        $iterator = $arraylist->getIterator();
                                        echo '<input type="hidden" id="cant_grupos" value="'.$arraylist->count().'"/>';
                                        echo '<div class="simpleSlide-window" rel="this_particular_slideshow" id="simpleSlide-window">';
                                        echo '<div class="simpleSlide-tray" rel="this_particular_slideshow" id="simpleSlide-tray">';
                                        while($iterator->valid()){
                                            $ec_grupos_preguntasTO = $iterator->current();
                                            echo '<div class="simpleSlide-slide" rel="this_particular_slideshow" ><div class="group_tittle"><a name="groupDiv">'.$ec_grupos_preguntasTO->getNombre().'</a></div>';
                                            echo '<input type="hidden" name="grupo_id" value="'.$ec_grupos_preguntasTO->getGrupo_id().'"/>';
                                            echo '<input type="hidden" name="grupo_nombre" value="'.$ec_grupos_preguntasTO->getNombre().'"/>';

                                            $criterio2 = array("encuesta_id"=>$encuesta_id, "grupo_id"=>$ec_grupos_preguntasTO->getGrupo_id(),"type_order"=>"ASC");
                                            $ec_preguntasDAO = new ec_preguntasDAO();
                                            $arraylist2 = $ec_preguntasDAO->selectByCriteria_ec_preguntas($criterio2, -1);
                                            $iterator2 = $arraylist2->getIterator();
                                            while($iterator2->valid()){
                                                $ec_preguntasTO = $iterator2->current();
                    //                            $br = '<br />';
                    //                            if($ec_preguntasTO->getAlineacion_respuesta()=="H")
                    //                                $br = '';

                                                echo '<div class="question_group">';
                                                if(trim($ec_preguntasTO->getNro_pregunta()) != "")
                                                    $ec_preguntasTO->setNro_pregunta($ec_preguntasTO->getNro_pregunta().". ");

                                                echo '<div class="question"><span class="qnro">'.$ec_preguntasTO->getNro_pregunta().'</span> '.$ec_preguntasTO->getPregunta().'</div>';
                                                echo '<input type="hidden" name="pid'.$ec_preguntasTO->getPregunta_id().'" value="'.$ec_preguntasTO->getPregunta_id().'"/>';
                                                echo '<input type="hidden" name="pno'.$ec_preguntasTO->getPregunta_id().'" value="'.$ec_preguntasTO->getPregunta().'"/>';
                                                switch ($ec_preguntasTO->getTipo_respuesta_html()) {
                                                    case "INPUT":
                                                        echo '<div class="answer"><span class="r">R.&nbsp;</span><input class="textbox" type="text" name="rep'.$ec_preguntasTO->getPregunta_id().'"/></div>';
                                                        break;
                                                    case "TEXTAREA":
                                                        echo '<div class="answer"><span class="r">R.&nbsp;</span><textarea rows="6" cols="5" name="rep'.$ec_preguntasTO->getPregunta_id().'"></textarea></div>';
                                                        break;
                                                    case "SELECT":
                                                        echo '<div class="answer"><span class="r">R.&nbsp;</span><select class="combobox" name="rep'.$ec_preguntasTO->getPregunta_id().'">';
                                                        $criterio3 = array("pregunta_id"=>$ec_preguntasTO->getPregunta_id());
                                                        $ec_valores_respuestaDAO = new ec_valores_respuestaDAO();
                                                        $arraylist3 = $ec_valores_respuestaDAO->selectByCriteria_ec_valores_respuesta($criterio3, -1);
                                                        $iterator3 = $arraylist3->getIterator();
                                                        while($iterator3->valid()){
                                                            $ec_valores_respuestaTO = $iterator3->current();
                                                            echo '<option value="'.$ec_valores_respuestaTO->getValor().'">'.$ec_valores_respuestaTO->getEtiqueta().'</option>';
                                                            $iterator3->next();
                                                        }
                                                        echo '</select></div>';
                                                        break;
                                                    case "RADIOBUTTON":
                                                        echo '<div class="answer"><span class="r">R.&nbsp;</span><br />';
                                                        if($ec_preguntasTO->getAlineacion_respuesta()=="H")
                                                            echo '<label class="label_izq">'.$ec_preguntasTO->getLabel_izq().'&nbsp;</label>';

                                                        $criterio3 = array("pregunta_id"=>$ec_preguntasTO->getPregunta_id());
                                                        $ec_valores_respuestaDAO = new ec_valores_respuestaDAO();
                                                        $arraylist3 = $ec_valores_respuestaDAO->selectByCriteria_ec_valores_respuesta($criterio3, -1);
                                                        $iterator3 = $arraylist3->getIterator();
                                                        while($iterator3->valid()){
                                                            $ec_valores_respuestaTO = $iterator3->current();
                                                            if($ec_preguntasTO->getAlineacion_respuesta()=="H"){
                                                                echo '<label class="lblradio">'.$ec_valores_respuestaTO->getEtiqueta().'</label>';
                                                                echo '<input class="radioh"  name="rep'.$ec_preguntasTO->getPregunta_id().'" type="radio" value="'.$ec_valores_respuestaTO->getValor().'"/> ';
                                                            }else
                                                                echo '<input name="rep'.$ec_preguntasTO->getPregunta_id().'" type="radio" value="'.$ec_valores_respuestaTO->getValor().'"/> '.$ec_valores_respuestaTO->getEtiqueta()."<br />";

                                                            $iterator3->next();
                                                        }
                                                        if($ec_preguntasTO->getAlineacion_respuesta()=="H")
                                                            echo '<label>&nbsp;'.$ec_preguntasTO->getLabel_der().'</label>';

                                                        echo '</div>';
                                                        break;
                                                   case "CHECKBOX":
                                                        echo '<div class="answer"><span class="r">R.&nbsp;</span><br />';
                                                        $criterio3 = array("pregunta_id"=>$ec_preguntasTO->getPregunta_id());
                                                        $ec_valores_respuestaDAO = new ec_valores_respuestaDAO();
                                                        $arraylist3 = $ec_valores_respuestaDAO->selectByCriteria_ec_valores_respuesta($criterio3, -1);
                                                        $iterator3 = $arraylist3->getIterator();
                                                        while($iterator3->valid()){
                                                            $ec_valores_respuestaTO = $iterator3->current();
                                                            echo '<input name="rep'.$ec_preguntasTO->getPregunta_id().'" type="checkbox" value="r'.$ec_valores_respuestaTO->getValor().'"/> '.$ec_valores_respuestaTO->getEtiqueta().'<br />';
                                                            $iterator3->next();
                                                        }
                                                        echo '</div>';
                                                        break;     
                                                }
                                                echo '</div>';

                                                $iterator2->next();
                                            }
                                            echo '</div>';
                                            $iterator->next();
                                            //break;
                                        }
                                        echo '</div></div>';

                                        echo '<div id="bottom">';
                                        echo '<a href="#" onclick="saveForm();" style="width:180px;">Terminar Encuesta</a>';
                                        echo '<a href="#groupDiv">Ir Arriba</a>';
                                        echo '<div id="sLeft" onclick="clickSlide(\'left\');" rel="this_particular_slideshow" class="left-button left" style="display: inline-block;visibility:hidden;">Anterior</div>';
                                        echo '<div id="sRight" onclick="clickSlide(\'right\');" rel="this_particular_slideshow" class="right-button left" style="display: inline-block;">Siguiente</div>';
                                        echo '</div>';
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