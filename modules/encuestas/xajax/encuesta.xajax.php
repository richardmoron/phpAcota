<?php 
/**
* Acerca del Autor
*
* @author Richard Henry Moron Borda <richardom09@gmail.com>
* @version 1.0
* @copyright Copyright (c) 2012, Richard Henry Moron Borda
*/
@session_start();
include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/xajax/xajax_core/xajax.inc.php");
include_once (dirname(dirname(__FILE__))."/dao/ec_grupos_preguntas.dao.php");
include_once (dirname(dirname(__FILE__))."/dao/ec_preguntas.dao.php");
include_once (dirname(dirname(__FILE__))."/dao/ec_valores_respuesta.dao.php");
include_once (dirname(dirname(__FILE__))."/dao/ec_resultados_maestro.dao.php");
include_once (dirname(dirname(__FILE__))."/dao/ec_resultados.dao.php");
include_once (dirname(dirname(__FILE__))."/dao/ec_encuestas.dao.php");

    $xajax = new xajax();
    
    $xajax->registerFunction("loadData");
    $xajax->registerFunction("preLoad");
    
    function preLoad(){
        $objResponse = new xajaxResponse();
        $html = "";
        if(isset($_GET["id"]) && strlen(trim($_GET["id"]))>0){
            $encuesta_id = $_GET["id"];
            $ec_encuestasDAO = new ec_encuestasDAO();
            $criterio_tmp = array("valid_date"=>true);
            $ec_encuestasTO =  $ec_encuestasDAO->selectByIdec_encuestas($encuesta_id,$criterio_tmp);
            if($ec_encuestasTO->getEncuesta_id()!=null){
                if($ec_encuestasTO->getEs_anonimo() == "N" && !isset($_SESSION["encuesta_user"]) ){
//                  header("Location:ec_login.php?ei=$encuesta_id");
                    $objResponse->redirect("/encuesta/login/$encuesta_id");
                    //$objResponse->script("window.location = 'ec_login.php?ei=$encuesta_id'");
                }else{
                    if(!isset($_COOKIE["encuesta"]) || (isset($_SESSION["encuesta_user"]) && $ec_encuestasTO->getEs_anonimo() == "N" ) ){
                        $encuesta_user = "";
                        if(isset($_SESSION["encuesta_user"]))
                            $encuesta_user = $_SESSION["encuesta_user"];

                        $html .= '<div id="tittle_img"><a href="http://www.brainpersonas.com/brain" target="_blank"><img src="'.MY_URI.'/media/img/logo.png" alt="logo"/></a></div>';
                        $html .= '<div id="tittle">'.$ec_encuestasTO->getNombre().'</div>';
                        $html .= '<div id="description">'.$ec_encuestasTO->getDescripcion().'</div>';
                        $html .= '<input type="hidden" name="encuesta_id" id="encuesta_id" value="'.$encuesta_id.'"/>';
                        $html .= '<input type="hidden" name="encuesta_nombre" id="encuesta_nombre" value="'.$ec_encuestasTO->getNombre().'"/>';
                        $html .= '<div id="question_group" class="question_group"></div>';
                        
                        $objResponse->assign("container", "innerHTML", $html);
                        $objResponse = loadData($_GET["id"],0, 0, null, $objResponse, false);
                    }  else {
                        //header("Location:realizado.php");
                        $objResponse->redirect("/encuesta/realizado");
                    }
                }
            }else{
                //header("Location:noexiste.php");
                $objResponse->redirect("/encuesta/no-existe");
            }
        }
        return $objResponse;
    }
    
    function  loadData($p_encuesta_id ,$p_resultado_id,$p_grupo_id, $aFormValues, $objResponse = null, $concluir = false){
        if($objResponse == null){
            $objResponse = new xajaxResponse();
        }
        $html = "";
        $terminar = false;
        $continuar_busqueda = true;
        $grupo_id = $p_grupo_id;
        $resultado_id = $p_resultado_id;
        $ec_resultados_maestroDAO = new ec_resultados_maestroDAO();
        $arraylist = $ec_resultados_maestroDAO->selectByCriteria_ec_resultados_maestro(array("encuesta_id"=>$p_encuesta_id,"resultado_id"=>$p_resultado_id,"usuario"=>$_SESSION["encuesta_user"],"estado_encuesta"=>"I"), -1);    
        $iterator = $arraylist->getIterator();
        while($iterator->valid()){
            $ec_resultados_maestroTO = $iterator->current();
            if(trim($p_grupo_id)=="" || trim($p_grupo_id) == "0")
                $grupo_id = $ec_resultados_maestroTO->getGrupo_id_actual();
            if(trim($p_resultado_id)=="" || trim($p_resultado_id) == "0")
                $resultado_id = $ec_resultados_maestroTO->getResultados_maestro_id();
            $iterator->next();
            break;
        }
        $ec_resultados_maestroTO = new ec_resultados_maestroTO();
        $ec_resultados_maestroTO->setEncuesta_id($p_encuesta_id);
        $ec_resultados_maestroTO->setFecha_hora(date(DB_DATETIME_FORMAT));
        $ec_resultados_maestroTO->setUsuario($_SESSION["encuesta_user"]);
        $ec_resultados_maestroTO->setResultados_maestro_id($resultado_id);
        $ec_resultados_maestroTO->setGrupo_id_actual($grupo_id);
        $ec_resultados_maestroTO->setGrupo_id_siguiente(0);
        $ec_resultados_maestroTO->setEstado_encuesta("I");
        $ec_resultados_maestroTO->setEstado_usuario("A");
        if($arraylist->count() == 0){
            $resultado_id = $ec_resultados_maestroDAO->insertec_resultados_maestro($ec_resultados_maestroTO);
        }else{
            $ec_resultados_maestroDAO->updateec_resultados_maestro($ec_resultados_maestroTO);
        }
        //--
        $criterio = array("encuesta_id"=>$p_encuesta_id);
        //$criterio["grupo_id"] = $grupo_id;
        $ec_grupos_preguntasDAO = new ec_grupos_preguntasDAO();
        $arraylist = $ec_grupos_preguntasDAO->selectByCriteria_ec_grupos_preguntas($criterio, -1);
        $iterator = $arraylist->getIterator();
        $grupo_id_siguiente = 0;
        while($iterator->valid()){
            $ec_grupos_preguntasTO = $iterator->current();
            if($ec_grupos_preguntasTO->getGrupo_id() == $grupo_id || $grupo_id == 0){
                $html .= '<input type="hidden" name="grupo_id" id="grupo_id" value="'.$ec_grupos_preguntasTO->getGrupo_id().'"/>';
                $html .= '<input type="hidden" name="grupo_nombre" id="grupo_nombre" value="'.$ec_grupos_preguntasTO->getNombre().'"/>';

                $criterio2 = array("encuesta_id"=>$p_encuesta_id, "grupo_id"=>$ec_grupos_preguntasTO->getGrupo_id(),"type_order"=>"ASC");
                $ec_preguntasDAO = new ec_preguntasDAO();
                $arraylist2 = $ec_preguntasDAO->selectByCriteria_ec_preguntas($criterio2, -1);
                $iterator2 = $arraylist2->getIterator();
                while($iterator2->valid()){
                    $ec_preguntasTO = $iterator2->current();
                    if(trim($ec_preguntasTO->getNro_pregunta()) != "")
                        $ec_preguntasTO->setNro_pregunta($ec_preguntasTO->getNro_pregunta().". ");

                    $html .= '<div class="question"><span class="qnro">'.$ec_preguntasTO->getNro_pregunta().'</span> '.$ec_preguntasTO->getPregunta().'</div>';
                    $html .= '<input type="hidden" name="pid'.$ec_preguntasTO->getPregunta_id().'" id="pid'.$ec_preguntasTO->getPregunta_id().'" value="'.$ec_preguntasTO->getPregunta_id().'"/>';
                    $html .= '<input type="hidden" name="pno'.$ec_preguntasTO->getPregunta_id().'" id="pno'.$ec_preguntasTO->getPregunta_id().'" value="'.$ec_preguntasTO->getPregunta().'"/>';
                    switch ($ec_preguntasTO->getTipo_respuesta_html()) {
                        case "INPUT":
                            $html .= '<div class="answer"><span class="r">R.&nbsp;</span><input  maxlength="150" class="textbox" type="text" name="rep'.$ec_preguntasTO->getPregunta_id().'" id="rep'.$ec_preguntasTO->getPregunta_id().'"/></div>';
                            break;
                        case "TEXTAREA":
                            $html .= '<div class="answer"><span class="r">R.&nbsp;</span><textarea rows="6" cols="5" name="rep'.$ec_preguntasTO->getPregunta_id().'" id="rep'.$ec_preguntasTO->getPregunta_id().'"></textarea></div>';
                            break;
                        case "SELECT":
                            $html .= '<div class="answer"><span class="r">R.&nbsp;</span><select class="combobox" name="rep'.$ec_preguntasTO->getPregunta_id().'" id="rep'.$ec_preguntasTO->getPregunta_id().'">';
                            $criterio3 = array("pregunta_id"=>$ec_preguntasTO->getPregunta_id());
                            $ec_valores_respuestaDAO = new ec_valores_respuestaDAO();
                            $arraylist3 = $ec_valores_respuestaDAO->selectByCriteria_ec_valores_respuesta($criterio3, -1);
                            $iterator3 = $arraylist3->getIterator();
                            while($iterator3->valid()){
                                $ec_valores_respuestaTO = $iterator3->current();
                                $html .= '<option value="'.$ec_valores_respuestaTO->getValor().'">'.$ec_valores_respuestaTO->getEtiqueta().'</option>';
                                $iterator3->next();
                            }
                            $html .= '</select></div>';
                            break;
                        case "RADIOBUTTON":
                            $html .= '<div class="answer"><span class="r">R.&nbsp;</span><br />';
                            if($ec_preguntasTO->getAlineacion_respuesta()=="H")
                                $html .= '<label class="label_izq">'.$ec_preguntasTO->getLabel_izq().'&nbsp;</label>';

                            $criterio3 = array("pregunta_id"=>$ec_preguntasTO->getPregunta_id());
                            $ec_valores_respuestaDAO = new ec_valores_respuestaDAO();
                            $arraylist3 = $ec_valores_respuestaDAO->selectByCriteria_ec_valores_respuesta($criterio3, -1);
                            $iterator3 = $arraylist3->getIterator();
                            while($iterator3->valid()){
                                $ec_valores_respuestaTO = $iterator3->current();
                                if($ec_preguntasTO->getAlineacion_respuesta()=="H"){
                                    $html .= '<label class="lblradio">'.$ec_valores_respuestaTO->getEtiqueta().'</label>';
                                    $html .= '<input class="radioh" name="rep'.$ec_preguntasTO->getPregunta_id().'" id="rep'.$ec_preguntasTO->getPregunta_id().'" type="radio" value="'.$ec_valores_respuestaTO->getValor().'"/> ';
                                }else
                                    $html .= '<input name="rep'.$ec_preguntasTO->getPregunta_id().'" id="rep'.$ec_preguntasTO->getPregunta_id().'" type="radio" value="'.$ec_valores_respuestaTO->getValor().'"/> '.$ec_valores_respuestaTO->getEtiqueta()."<br />";

                                $iterator3->next();
                            }
                            if($ec_preguntasTO->getAlineacion_respuesta()=="H")
                                $html .= '<label>&nbsp;'.$ec_preguntasTO->getLabel_der().'</label>';

                            $html .= '</div>';
                            break;
                        case "CHECKBOX":
                            $html .= '<div class="answer"><span class="r">R.&nbsp;</span><br />';
                            $criterio3 = array("pregunta_id"=>$ec_preguntasTO->getPregunta_id());
                            $ec_valores_respuestaDAO = new ec_valores_respuestaDAO();
                            $arraylist3 = $ec_valores_respuestaDAO->selectByCriteria_ec_valores_respuesta($criterio3, -1);
                            $iterator3 = $arraylist3->getIterator();
                            while($iterator3->valid()){
                                $ec_valores_respuestaTO = $iterator3->current();
                                $html .= '<input name="rep'.$ec_preguntasTO->getPregunta_id().'" id="rep'.$ec_preguntasTO->getPregunta_id().'" type="checkbox" value="r'.$ec_valores_respuestaTO->getValor().'"/> '.$ec_valores_respuestaTO->getEtiqueta().'<br />';
                                $iterator3->next();
                            }
                            $html .= '</div>';
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
        saveData($resultado_id, $aFormValues);


        $html .= '<div id="bottom">';
        //$html .= '<a href="#groupDiv">Ir Arriba</a>';
        if($terminar)
            $html .= '<a href="#" onclick="if(validateForm()){xajax_loadData('.$p_encuesta_id.', '.$resultado_id.', '.$grupo_id_siguiente.', xajax.getFormValues(\'formulario\'), null, true);}">Terminar</a>';
        else{    
            $html .= '<a href="#" onclick="exitForm();">Guardar</a>';
            $html .= '<a href="#" onclick="if(validateForm()){xajax_loadData('.$p_encuesta_id.', '.$resultado_id.', '.$grupo_id_siguiente.', xajax.getFormValues(\'formulario\'), null,  false);}">Siguiente</a>';
        }
        $html .= '</div>';
        
        if(!$concluir)
            $objResponse->assign("question_group", "innerHTML", $html);
        else{
            $ec_resultados_maestroTO->setEstado_encuesta("C");
            $ec_resultados_maestroDAO->updateec_resultados_maestro($ec_resultados_maestroTO);
            $objResponse->redirect("/encuesta/gracias");
        }
        return $objResponse;
    }
 
    function saveData($resultado_id, $aFormValues){
        if($aFormValues != null){
//            $ec_encuestasDAO = new ec_encuestasDAO();
            $ec_resultadosTO = new ec_resultadosTO();
            $ec_resultadosDAO = new ec_resultadosDAO();

            $ec_resultadosTO->setResultado_id(0);
            $ec_resultadosTO->setUsuario_id("null");
            //$ec_resultadosTO->setFecha_hora(NULL);
            //--
            $ec_resultadosTO->setEncuesta_id($aFormValues["encuesta_id"]);
            $ec_resultadosTO->setNombre_encuesta($aFormValues["encuesta_nombre"]);
            $ec_resultadosTO->setGrupo_id($aFormValues["grupo_id"]);
            $ec_resultadosTO->setGrupo($aFormValues["grupo_nombre"]);
            $ec_resultadosTO->setEncuesta_id_nro($resultado_id);
            //$ec_encuestasTO =  $ec_encuestasDAO->selectByIdec_encuestas($aFormValues["encuesta_id"]);
            //if($ec_encuestasTO->getEs_anonimo() == "S"){
            //    setcookie( "encuesta", date("d/m/Y H:i:s"), time()+(60*60*24*30) ); //para registra que realizó
            //}else{
            //    if(isset($_SESSION["encuesta_user"]))
                    $ec_resultadosTO->setUsuario($_SESSION["encuesta_user"]);
            //}

            foreach ($aFormValues as $key => $value){ 
                if(substr($key,0,3) == "pid"){
                    $id = substr($key,3,  strlen($key));
                    $ec_resultadosTO->setPregunta_id($aFormValues["pid$id"]);
                    $ec_resultadosTO->setPregunta($aFormValues["pno$id"]);
                    $ec_resultadosTO->setRespuesta($aFormValues["rep$id"]);
                    $ec_resultadosDAO->insertec_resultados($ec_resultadosTO);
                }
            }
        }
    }
    $xajax->processRequest();
?>