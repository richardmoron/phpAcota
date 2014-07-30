<?php 
    /**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/cnx/connection.php");
	include_once (dirname(dirname(__FILE__))."/dto/ec_resultados.dto.php");
        include_once (dirname(dirname(__FILE__))."/dao/ec_preguntas.dao.php");
        include_once (dirname(dirname(__FILE__))."/dao/ec_resultados_maestro.dao.php");
        include_once (dirname(dirname(__FILE__))."/dao/ec_grupos_preguntas.dao.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/logs.php");

	class ec_resultadosDAO {
            private $connection;

            function ec_resultadosDAO(){
            }

            /**
            * Añade un Registro
            *
            * @param ec_resultadosTO $elem
            * @return int Filas Afectadas
            */
            function insertec_resultados(ec_resultadosTO $elem){
                    $this->connection = Connection::getinstance()->getConn();
                    $PreparedStatement = "INSERT INTO ec_resultados (resultado_id,encuesta_id,usuario_id,grupo_id,pregunta_id,nombre_encuesta,pregunta,respuesta,grupo,Encuesta_id_nro,usuario ) VALUES (
                            ".Connection::inject($elem->getResultado_id()).",
                            ".Connection::inject($elem->getEncuesta_id()).",
                            ".Connection::inject($elem->getUsuario_id()).",
                            ".Connection::inject($elem->getGrupo_id()).",
                            ".Connection::inject($elem->getPregunta_id()).",
                            '".Connection::inject($elem->getNombre_encuesta())."',
                            '".Connection::inject($elem->getPregunta())."',
                            '".Connection::inject($elem->getRespuesta())."',
                            '".Connection::inject($elem->getGrupo())."',
                                ".Connection::inject($elem->getEncuesta_id_nro()).",
                            '".Connection::inject($elem->getUsuario())."'     
                                );";

                    $ResultSet = mysql_query($PreparedStatement,$this->connection);
                    logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
                    if($ResultSet)
                            return mysql_affected_rows();
                    else
                            throw new Exception(ERROR_INSERT);

            }

            /**
            * Actualiza un Registro
            *
            * @param ec_resultadosTO $elem
            * @return int Filas Afectadas
            */
            function updateec_resultados(ec_resultadosTO $elem){
                    $this->connection = Connection::getinstance()->getConn();
                    $PreparedStatement = "UPDATE ec_resultados SET  
                            encuesta_id = ".Connection::inject($elem->getEncuesta_id()).",
                            usuario_id = ".Connection::inject($elem->getUsuario_id()).",
                            grupo_id = ".Connection::inject($elem->getGrupo_id()).",
                            pregunta_id = ".Connection::inject($elem->getPregunta_id()).",
                            nombre_encuesta = '".Connection::inject($elem->getNombre_encuesta())."',
                            pregunta = '".Connection::inject($elem->getPregunta())."',
                            respuesta = '".Connection::inject($elem->getRespuesta())."',
                            grupo = '".Connection::inject($elem->getGrupo())."',
                            fecha_hora = '".Connection::inject($elem->getFecha_hora())."' 
                    WHERE resultado_id = ". Connection::inject($elem->getResultado_id()).";" ;

                    $ResultSet = mysql_query($PreparedStatement,$this->connection);
                    logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
                    if($ResultSet)
                            return mysql_affected_rows();
                    else
                            throw new Exception(ERROR_UPDATE);

            }

            /**
            * Elimina un Registro
            *
            * @param ec_resultadosTO $elem
            * @return int Filas Afectadas
            */
            function deleteec_resultados(ec_resultadosTO $elem){
                    $this->connection = Connection::getinstance()->getConn();
                    $PreparedStatement = "DELETE FROM ec_resultados WHERE resultado_id = ". Connection::inject($elem->getResultado_id()).";";

                    $ResultSet = mysql_query($PreparedStatement,$this->connection);
                    logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
                    if($ResultSet)
                            return mysql_affected_rows();
                    else
                            throw new Exception(ERROR_DELETE);

            }

            /**
            * Obtiene un objeto ec_resultadosTO
            *
            * @return ec_resultadosTO elem
            */
            function selectByIdec_resultados($resultado_id){
                    $this->connection = Connection::getinstance()->getConn();
                    $PreparedStatement = "SELECT resultado_id, encuesta_id, usuario_id, grupo_id, pregunta_id, nombre_encuesta, pregunta, respuesta, grupo, fecha_hora   FROM ec_resultados WHERE resultado_id = ".Connection::inject($resultado_id)." ;";
                    $ResultSet = mysql_query($PreparedStatement,$this->connection);
                    logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

                    $elem = new ec_resultadosTO();
                    while($row = mysql_fetch_array($ResultSet)){
                            $elem = new ec_resultadosTO();
                            $elem->setResultado_id($row['resultado_id']);
                            $elem->setEncuesta_id($row['encuesta_id']);
                            $elem->setUsuario_id($row['usuario_id']);
                            $elem->setGrupo_id($row['grupo_id']);
                            $elem->setPregunta_id($row['pregunta_id']);
                            $elem->setNombre_encuesta($row['nombre_encuesta']);
                            $elem->setPregunta($row['pregunta']);
                            $elem->setRespuesta($row['respuesta']);
                            $elem->setGrupo($row['grupo']);
                            $elem->setFecha_hora($row['fecha_hora']);

                    }
                    mysql_free_result($ResultSet);
                    return $elem;
            }
            function selectMaxEncuesta_id_nro(){
                    $this->connection = Connection::getinstance()->getConn();
                    $PreparedStatement = "SELECT MAX(encuesta_id_nro) AS encuesta_id_nro FROM ec_resultados;";
                    $ResultSet = mysql_query($PreparedStatement,$this->connection);
                    logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

                    $encuesta_id_nro = 0;
                    while($row = mysql_fetch_array($ResultSet)){
                            $encuesta_id_nro = ($row['encuesta_id_nro']) + 1;
                    }
                    mysql_free_result($ResultSet);
                    return $encuesta_id_nro;
            }
            /**
            * Obtiene la cantidad de filas de la tabla
            *
            * @return int $rows
            */
            function selectCountec_resultados($criterio){
                    $this->connection = Connection::getinstance()->getConn();
                    $PreparedStatement = "SELECT COUNT(*) AS count FROM ec_resultados WHERE resultado_id = resultado_id ";
                    $PreparedStatement = $this->defineCriterias($criterio,$PreparedStatement);
                    $ResultSet = mysql_query($PreparedStatement,$this->connection);
                    logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

                    $rows = 0;
                    while ($row = mysql_fetch_array($ResultSet)) {
                            $rows = ceil($row['count'] / TABLE_ROW_VIEW);
                    }
                    mysql_free_result($ResultSet);
                    return $rows;
            }


            /**
            * Obtiene una coleccion de filas de la tabla
            *
            * @return ArrayObject ec_resultadosTO
            * @param array $criterio
            */
            function selectByCriteria_ec_resultados($criterio,$page_number){
                    $this->connection = Connection::getinstance()->getConn();
                    $PreparedStatement = "SELECT resultado_id, encuesta_id, usuario_id, grupo_id, pregunta_id, nombre_encuesta, pregunta, respuesta, grupo, fecha_hora  
                                                FROM ec_resultados WHERE resultado_id = resultado_id ";

                    $PreparedStatement = $this->defineCriterias($criterio,$PreparedStatement);
                    $PreparedStatement .= " ORDER BY resultado_id";
                    if($page_number != -1)
                            $PreparedStatement .= " LIMIT ".($page_number*TABLE_ROW_VIEW).",". ($page_number+1)*TABLE_ROW_VIEW."";
                    $ResultSet = mysql_query($PreparedStatement,$this->connection);
                    logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

                    $arrayList = new ArrayObject();
                        while ($row = mysql_fetch_array($ResultSet)) {
                            $elem = new ec_resultadosTO();
                            $elem->setResultado_id($row['resultado_id']);
                            $elem->setEncuesta_id($row['encuesta_id']);
                            $elem->setUsuario_id($row['usuario_id']);
                            $elem->setGrupo_id($row['grupo_id']);
                            $elem->setPregunta_id($row['pregunta_id']);
                            $elem->setNombre_encuesta($row['nombre_encuesta']);
                            $elem->setPregunta($row['pregunta']);
                            $elem->setRespuesta($row['respuesta']);
                            $elem->setGrupo($row['grupo']);
                            $elem->setFecha_hora($row['fecha_hora']);

                            $arrayList->append($elem);
                    }
                    mysql_free_result($ResultSet);
                    return $arrayList;
            }
        
        function selectEncuestaForExcel2($encuesta_id){
			$this->connection = Connection::getinstance()->getConn();
                        $ec_preguntasDAO = new ec_preguntasDAO();
			$criterio = array("encuesta_id"=>$encuesta_id);
                        $arraylist = $ec_preguntasDAO->selectByCriteria_ec_preguntas($criterio, -1);
                        $iterator = $arraylist->getIterator();
                        $select = "SELECT DISTINCT t.encuesta_id_nro, t.usuario,  ";
                        $PreparedStatement = "";
                        $PreparedStatement .= "FROM ec_resultados AS t ";
                        $t = 0;
                        //--
                        $html = "<table border='1'><thead><tr><th>Nro</th><th>Usuario</th>";
                        //--
                        while($iterator->valid()){
                            $ec_preguntasTO = $iterator->current();
                            $html .= "<th style='width:100px;'>".$ec_preguntasTO->getPregunta()."</th>";
                            //--
                            $select .= " t$t.respuesta AS r$t, ";
                            $PreparedStatement .= " LEFT  JOIN (SELECT respuesta,encuesta_id_nro FROM ec_resultados WHERE encuesta_id = $encuesta_id AND pregunta_id = ".$ec_preguntasTO->getPregunta_id()."  ) AS t$t ON t$t.encuesta_id_nro = t.encuesta_id_nro  ";
                            $t++;
                            $iterator->next();
                        }
                        $select = substr($select,0,  strlen($select)-2);
//                        $PreparedStatement = substr($PreparedStatement,0,  strlen($PreparedStatement)-2);
                        $PreparedStatement .= " WHERE t.encuesta_id = $encuesta_id;";
                        $PreparedStatement = $select." ".$PreparedStatement;
                        
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

                        $html .= "</tr></thead><tbody>";
			while ($row = mysql_fetch_array($ResultSet)) {
                            $html .= "<tr>";
                            $i = 0;
                            while($i <= mysql_num_fields($ResultSet)-1){
                                $html.= '<td>'.$row[mysql_field_name($ResultSet,$i)].'</td>';
                                $i++;
                            }
                            $html .= "</tr>";
			}
                        $html .= "</tbody></table>";
			mysql_free_result($ResultSet);
			return $html;
		}
        
        function selectEncuestaForExcel($encuesta_id){
            $this->connection = Connection::getinstance()->getConn();
            $ec_preguntasDAO = new ec_preguntasDAO();
            $ec_grupos_preguntasDAO = new ec_grupos_preguntasDAO();
            $ec_resultados_maestroDAO = new ec_resultados_maestroDAO();

            $table = "<table border='1'>";            
            $criterio = array("encuesta_id"=>$encuesta_id);
            $thead = "<thead><tr><th colspan='3'></th>";
            $thead2 = "";
            $arraylistGp = $ec_grupos_preguntasDAO->selectByCriteria_ec_grupos_preguntas($criterio, -1);
            $iteratorGp = $arraylistGp->getIterator();
            
            while($iteratorGp->valid()){
                $ec_grupos_preguntasTO = $iteratorGp->current();

                $criterio["grupo_id"] = $ec_grupos_preguntasTO->getGrupo_id();
                $arraylistPr = $ec_preguntasDAO->selectByCriteria_ec_preguntas($criterio, -1);
                $iteratorPr = $arraylistPr->getIterator();
                $thead .= "<th colspan='".$arraylistPr->count()."'>".$ec_grupos_preguntasTO->getNombre()."-".$ec_grupos_preguntasTO->getTipo_desc()."</th>";
                $preguntas = array();
                while($iteratorPr->valid()){
                    $ec_preguntasTO = $iteratorPr->current();
                    $thead2 .= "<th>".$ec_preguntasTO->getNro_pregunta().".-".$ec_preguntasTO->getPregunta()."</th>";
                    //--
                    $preguntas["p".$ec_preguntasTO->getPregunta_id()] = $ec_preguntasTO->getPregunta_id();
                    $iteratorPr->next();
                }
                $iteratorGp->next();
            }
            $thead .= "</tr><tr><th>Nro</th><th>Usuario</th><th>Fecha Hora</th>".$thead2."</tr></thead>";
            $tbody = "<tbody>";
            //--
            $arralist0 = $ec_resultados_maestroDAO->selectByCriteria_ec_resultados_maestro(array("encuesta_id"=>$encuesta_id,"estado_encuesta"=>"C"), -1);
            $iterator0 = $arralist0->getIterator();
            $r = 1;
            while($iterator0->valid()){
                $ec_resultados_maestroTO = $iterator0->current();
                $this->connection = Connection::getinstance()->getConn();
                $tbody .= "<tr>";
                $tbody .= "<td>".$r."</td>";
                $tbody .= "<td>".$ec_resultados_maestroTO->getUsuario()."</td>";
                $tbody .= "<td>".$ec_resultados_maestroTO->getFecha_hora()."</td>";
                $ResultSet2 = mysql_query("SELECT respuesta FROM ec_resultados WHERE encuesta_id_nro = ".$ec_resultados_maestroTO->getResultados_maestro_id()." AND encuesta_id = ".$encuesta_id." ORDER BY pregunta_id ",$this->connection);
                while ($row2 = mysql_fetch_array($ResultSet2)) {
                    $tbody .= "<td>".$row2["respuesta"]."</td>";
                }
                $tbody .= "</tr>";
                $r++;
                //--
                mysql_free_result($ResultSet2);
                $iterator0->next();
            }
            $tbody .="</tbody>";
            $table .= $thead.$tbody."</table>";
            return $table;
        }
        /**
        * Define los criterios del Where
        *
        * @return String $PreparedStatement ec_resultadosTO
        * @param String $PreparedStatement
        * @param array $criterio
        */
        function defineCriterias($criterio,$PreparedStatement){
                if(isset ($criterio["resultado_id"]) && trim($criterio["resultado_id"]) != "0"){
                        $PreparedStatement .=" AND resultado_id = ".Connection::inject($criterio["resultado_id"]);
                }
                if(isset ($criterio["encuesta_id"]) && trim($criterio["encuesta_id"]) != "0"){
                        $PreparedStatement .=" AND encuesta_id = ".Connection::inject($criterio["encuesta_id"]);
                }
                if(isset ($criterio["usuario_id"]) && trim($criterio["usuario_id"]) != "0"){
                        $PreparedStatement .=" AND usuario_id = ".Connection::inject($criterio["usuario_id"]);
                }
                if(isset ($criterio["grupo_id"]) && trim($criterio["grupo_id"]) != "0"){
                        $PreparedStatement .=" AND grupo_id = ".Connection::inject($criterio["grupo_id"]);
                }
                if(isset ($criterio["pregunta_id"]) && trim($criterio["pregunta_id"]) != "0"){
                        $PreparedStatement .=" AND pregunta_id = ".Connection::inject($criterio["pregunta_id"]);
                }
                if(isset ($criterio["nombre_encuesta"]) && trim($criterio["nombre_encuesta"]) != "0"){
                        $PreparedStatement .=" AND nombre_encuesta = ".Connection::inject($criterio["nombre_encuesta"]);
                }
                if(isset ($criterio["pregunta"]) && trim($criterio["pregunta"]) != "0"){
                        $PreparedStatement .=" AND pregunta = ".Connection::inject($criterio["pregunta"]);
                }
                if(isset ($criterio["respuesta"]) && trim($criterio["respuesta"]) != "0"){
                        $PreparedStatement .=" AND respuesta = ".Connection::inject($criterio["respuesta"]);
                }
                if(isset ($criterio["grupo"]) && trim($criterio["grupo"]) != "0"){
                        $PreparedStatement .=" AND grupo = ".Connection::inject($criterio["grupo"]);
                }
                if(isset ($criterio["fecha_hora"]) && trim($criterio["fecha_hora"]) != "0"){
                        $PreparedStatement .=" AND fecha_hora = ".Connection::inject($criterio["fecha_hora"]);
                }
                return $PreparedStatement;
        }
    }
?>