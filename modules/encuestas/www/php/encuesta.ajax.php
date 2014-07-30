<?php
@session_start();
$_GET["encuesta_id"] = $_GET["id"];
echo $_GET["resultado_id"] = $_SESSION["encuesta_user"];
$_GET["usuario"] = $_SESSION["encuesta_user"];
$_GET["grupo_id"] = 0;
require_once dirname(dirname(dirname(__FILE__)))."/dao/ec_grupos_preguntas.dao.php"; 
require_once dirname(dirname(dirname(__FILE__)))."/dao/ec_preguntas.dao.php"; 
require_once dirname(dirname(dirname(__FILE__)))."/dao/ec_valores_respuesta.dao.php"; 
require_once dirname(dirname(dirname(__FILE__)))."/dao/ec_resultados_maestro.dao.php"; 
require_once dirname(dirname(dirname(__FILE__)))."/dao/ec_resultados.dao.php"; 
//require_once dirname(dirname(dirname(__FILE__)))."/dao/ec_encuestas.dao.php"; 
  
    $terminar = false;
    $continuar_busqueda = true;
    $grupo_id = $_GET["grupo_id"];
    $resultado_id = $_GET["resultado_id"];
    $ec_resultados_maestroDAO = new ec_resultados_maestroDAO();
    $arraylist = $ec_resultados_maestroDAO->selectByCriteria_ec_resultados_maestro(array("encuesta_id"=>$_GET["encuesta_id"],"resultado_id"=>$_GET["resultado_id"],"usuario"=>$_GET["usuario"],"estado_encuesta"=>"I"), -1);    
    $iterator = $arraylist->getIterator();
    while($iterator->valid()){
        $ec_resultados_maestroTO = $iterator->current();
        if(trim($_GET["grupo_id"])=="" || trim($_GET["grupo_id"]) == "0")
            $grupo_id = $ec_resultados_maestroTO->getGrupo_id_actual();
        if(trim($_GET["resultado_id"])=="" || trim($_GET["resultado_id"]) == "0")
            $resultado_id = $ec_resultados_maestroTO->getResultados_maestro_id();
        $iterator->next();
        break;
    }
    $ec_resultados_maestroTO = new ec_resultados_maestroTO();
    $ec_resultados_maestroTO->setEncuesta_id($_GET["encuesta_id"]);
    $ec_resultados_maestroTO->setFecha_hora(date(DB_DATETIME_FORMAT));
    $ec_resultados_maestroTO->setUsuario($_GET["usuario"]);
    $ec_resultados_maestroTO->setResultados_maestro_id($resultado_id);
    $ec_resultados_maestroTO->setGrupo_id_actual($grupo_id);
    $ec_resultados_maestroTO->setGrupo_id_siguiente(0);
    $ec_resultados_maestroTO->setEstado_encuesta("I");
    if($arraylist->count() == 0){
        $resultado_id = $ec_resultados_maestroDAO->insertec_resultados_maestro($ec_resultados_maestroTO);
    }else{
        $ec_resultados_maestroDAO->updateec_resultados_maestro($ec_resultados_maestroTO);
    }
    //--
    $criterio = array("encuesta_id"=>$_GET["encuesta_id"]);
    //$criterio["grupo_id"] = $grupo_id;
    $ec_grupos_preguntasDAO = new ec_grupos_preguntasDAO();
    $arraylist = $ec_grupos_preguntasDAO->selectByCriteria_ec_grupos_preguntas($criterio, -1);
    $iterator = $arraylist->getIterator();
    $grupo_id_siguiente = 0;
    while($iterator->valid()){
        $ec_grupos_preguntasTO = $iterator->current();
        if($ec_grupos_preguntasTO->getGrupo_id() == $grupo_id || $grupo_id == 0){
            echo '<input type="hidden" name="grupo_id" id="grupo_id" value="'.$ec_grupos_preguntasTO->getGrupo_id().'"/>';
            echo '<input type="hidden" name="grupo_nombre" id="grupo_nombre" value="'.$ec_grupos_preguntasTO->getNombre().'"/>';

            $criterio2 = array("encuesta_id"=>$_GET["encuesta_id"], "grupo_id"=>$ec_grupos_preguntasTO->getGrupo_id(),"type_order"=>"ASC");
            $ec_preguntasDAO = new ec_preguntasDAO();
            $arraylist2 = $ec_preguntasDAO->selectByCriteria_ec_preguntas($criterio2, -1);
            $iterator2 = $arraylist2->getIterator();
            while($iterator2->valid()){
                $ec_preguntasTO = $iterator2->current();
                if(trim($ec_preguntasTO->getNro_pregunta()) != "")
                    $ec_preguntasTO->setNro_pregunta($ec_preguntasTO->getNro_pregunta().". ");

                echo '<div class="question"><span class="qnro">'.$ec_preguntasTO->getNro_pregunta().'</span> '.$ec_preguntasTO->getPregunta().'</div>';
                echo '<input type="hidden" name="pid'.$ec_preguntasTO->getPregunta_id().'" id="pid'.$ec_preguntasTO->getPregunta_id().'" value="'.$ec_preguntasTO->getPregunta_id().'"/>';
                echo '<input type="hidden" name="pno'.$ec_preguntasTO->getPregunta_id().'" id="pno'.$ec_preguntasTO->getPregunta_id().'" value="'.$ec_preguntasTO->getPregunta().'"/>';
                switch ($ec_preguntasTO->getTipo_respuesta_html()) {
                    case "INPUT":
                        echo '<div class="answer"><span class="r">R.&nbsp;</span><input class="textbox" type="text" name="rep'.$ec_preguntasTO->getPregunta_id().' id="rep'.$ec_preguntasTO->getPregunta_id().'"/></div>';
                        break;
                    case "TEXTAREA":
                        echo '<div class="answer"><span class="r">R.&nbsp;</span><textarea rows="6" cols="5" name="rep'.$ec_preguntasTO->getPregunta_id().'" id="rep'.$ec_preguntasTO->getPregunta_id().'"></textarea></div>';
                        break;
                    case "SELECT":
                        echo '<div class="answer"><span class="r">R.&nbsp;</span><select class="combobox" name="rep'.$ec_preguntasTO->getPregunta_id().' id="rep'.$ec_preguntasTO->getPregunta_id().'">';
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
                                echo '<input class="radioh" name="rep'.$ec_preguntasTO->getPregunta_id().'" id="rep'.$ec_preguntasTO->getPregunta_id().'" type="radio" value="'.$ec_valores_respuestaTO->getValor().'"/> ';
                            }else
                                echo '<input name="rep'.$ec_preguntasTO->getPregunta_id().'" id="rep'.$ec_preguntasTO->getPregunta_id().'" type="radio" value="'.$ec_valores_respuestaTO->getValor().'"/> '.$ec_valores_respuestaTO->getEtiqueta()."<br />";

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
                            echo '<input name="rep'.$ec_preguntasTO->getPregunta_id().'" id="rep'.$ec_preguntasTO->getPregunta_id().'" type="checkbox" value="r'.$ec_valores_respuestaTO->getValor().'"/> '.$ec_valores_respuestaTO->getEtiqueta().'<br />';
                            $iterator3->next();
                        }
                        echo '</div>';
                        break;     
                }
                $iterator2->next();
            }
            $iterator->next();
            if($iterator->valid()){
                $ec_grupos_preguntasTO = $iterator->current();
                $grupo_id_siguiente = $ec_grupos_preguntasTO->getGrupo_id();
            }else{
                if($arraylist->count() > 1 && $grupo_id == 0)
                    $terminar = false;
                else{
                    $terminar = true;
                    $grupo_id_siguiente = true;
                }
            }
            $continuar_busqueda = false;
            break;
        }
        if($continuar_busqueda)
            $iterator->next();
    }
//    if($_GET["grupo_id"] != 0)
//        saveData($grupo_id_siguiente, $resultado_id);
    
    
    echo '<div id="bottom">';
    //echo '<a href="#groupDiv">Ir Arriba</a>';
    if($terminar)
        echo '<a href="#" onclick="procesar('.$_GET["encuesta_id"].', '.$resultado_id.', \''.$_GET["usuario"].'\', '.$grupo_id_siguiente.');">Terminar</a>';
    else{    
        echo '<a href="#" onclick="procesar('.$_GET["encuesta_id"].', '.$resultado_id.', \''.$_GET["usuario"].'\', '.$grupo_id_siguiente.');">Guardar</a>';
        echo '<a href="#" onclick="procesar('.$_GET["encuesta_id"].', '.$resultado_id.', \''.$_GET["usuario"].'\', '.$grupo_id_siguiente.');">Siguiente</a>';
    }
    echo '</div>';
    echo '<script type="text/javascript">document.getElementById("loading").style.display = "none";</script>';

function saveData($terminar, $resultado_id){
    $ec_encuestasDAO = new ec_encuestasDAO();
    $ec_resultadosTO = new ec_resultadosTO();
    $ec_resultadosDAO = new ec_resultadosDAO();
    
    $ec_resultadosTO->setResultado_id(0);
    $ec_resultadosTO->setUsuario_id("null");
    //$ec_resultadosTO->setFecha_hora(NULL);
    //--
    $ec_resultadosTO->setEncuesta_id($_GET["encuesta_id"]);
    $ec_resultadosTO->setNombre_encuesta($_GET["encuesta_nombre"]);
    $ec_resultadosTO->setGrupo_id($_GET["grupo_id"]);
    $ec_resultadosTO->setGrupo($_GET["grupo_nombre"]);
    $ec_resultadosTO->setEncuesta_id_nro($resultado_id);
    $ec_encuestasTO =  $ec_encuestasDAO->selectByIdec_encuestas($_GET["encuesta_id"]);
    if($ec_encuestasTO->getEs_anonimo() == "S"){
        setcookie( "encuesta", date("d/m/Y H:i:s"), time()+(60*60*24*30) ); //para registra que realizó
    }else{
        if(isset($_SESSION["encuesta_user"]))
            $ec_resultadosTO->setUsuario($_SESSION["encuesta_user"]);
    }
            
    foreach ($_POST as $key => $value){ 
        if(substr($key,0,3) == "pid"){
            $id = substr($key,3,  strlen($key));
            $ec_resultadosTO->setPregunta_id($_GET["pid$id"]);
            $ec_resultadosTO->setPregunta($_GET["pno$id"]);
            $ec_resultadosTO->setRespuesta($_GET["rep$id"]);
            
            if($ec_encuestasTO->getEncuesta_id()!=null){//insertar
                $ec_resultadosDAO->insertec_resultados($ec_resultadosTO);
//                header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
//                header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
//                header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
//                header("Cache-Control: post-check=0, pre-check=0", false);
//                header("Pragma: no-cache");
                if($terminar){
                    header("Location:gracias.php");
                }
                //header("Location:encuesta.php?id=".$_POST["encuesta_id"]."&gr=".$_POST["grupo_id"]);
            }
        }
    }
}

?>