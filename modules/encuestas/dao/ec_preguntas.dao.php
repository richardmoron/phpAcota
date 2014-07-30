<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/cnx/connection.php");
	include_once (dirname(dirname(__FILE__))."/dto/ec_preguntas.dto.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/logs.php");

	class ec_preguntasDAO {
		private $connection;
 
		function ec_preguntasDAO(){
		}

		/**
		* Añade un Registro
		*
		* @param ec_preguntasTO $elem
		* @return int Filas Afectadas
		*/
		function insertec_preguntas(ec_preguntasTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "INSERT INTO ec_preguntas (pregunta_id,encuesta_id,grupo_id,pregunta,tipo_respuesta,respuesta,atributo_extra,nro_pregunta,alineacion_respuesta, label_izq, label_der ) VALUES (
				".Connection::inject($elem->getPregunta_id()).",
				".Connection::inject($elem->getEncuesta_id()).",
				".Connection::inject($elem->getGrupo_id()).",
				'".Connection::inject($elem->getPregunta())."',
				'".Connection::inject($elem->getTipo_respuesta())."',
				'".Connection::inject($elem->getRespuesta())."',
				'".Connection::inject($elem->getAtributo_extra())."',
				'".Connection::inject($elem->getNro_pregunta())."',
                                '".Connection::inject($elem->getAlineacion_respuesta())."',
                                '".Connection::inject($elem->getLabel_izq())."',
                                '".Connection::inject($elem->getLabel_der())."');";

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
		* @param ec_preguntasTO $elem
		* @return int Filas Afectadas
		*/
		function updateec_preguntas(ec_preguntasTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "UPDATE ec_preguntas SET  
				encuesta_id = ".Connection::inject($elem->getEncuesta_id()).",
				grupo_id = ".Connection::inject($elem->getGrupo_id()).",
				pregunta = '".Connection::inject($elem->getPregunta())."',
				tipo_respuesta = '".Connection::inject($elem->getTipo_respuesta())."',
				respuesta = '".Connection::inject($elem->getRespuesta())."',
				atributo_extra = '".Connection::inject($elem->getAtributo_extra())."',
				nro_pregunta = '".Connection::inject($elem->getNro_pregunta())."',
                                alineacion_respuesta = '".Connection::inject($elem->getAlineacion_respuesta())."',
                                label_izq = '".Connection::inject($elem->getLabel_izq())."', 
                                label_der = '".Connection::inject($elem->getLabel_der())."'  
			WHERE pregunta_id = ". Connection::inject($elem->getPregunta_id()).";" ;

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
		* @param ec_preguntasTO $elem
		* @return int Filas Afectadas
		*/
		function deleteec_preguntas(ec_preguntasTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "DELETE FROM ec_preguntas WHERE pregunta_id = ". Connection::inject($elem->getPregunta_id()).";";

			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
			if($ResultSet)
				return mysql_affected_rows();
			else
				throw new Exception(ERROR_DELETE);

		}

		/**
		* Obtiene un objeto ec_preguntasTO
		*
		* @return ec_preguntasTO elem
		*/
		function selectByIdec_preguntas($pregunta_id){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT pregunta_id, encuesta_id, grupo_id, pregunta, tipo_respuesta, respuesta, atributo_extra, nro_pregunta,alineacion_respuesta, label_izq, label_der, 
                                              (SELECT nombre FROM ec_encuestas WHERE encuesta_id = ec_preguntas.encuesta_id) AS encuesta   
                                              FROM ec_preguntas WHERE pregunta_id = ".Connection::inject($pregunta_id)." ;";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$elem = new ec_preguntasTO();
			while($row = mysql_fetch_array($ResultSet)){
				$elem = new ec_preguntasTO();
				$elem->setPregunta_id($row['pregunta_id']);
				$elem->setEncuesta_id($row['encuesta_id']);
				$elem->setGrupo_id($row['grupo_id']);
				$elem->setPregunta($row['pregunta']);
				$elem->setTipo_respuesta($row['tipo_respuesta']);
				$elem->setRespuesta($row['respuesta']);
				$elem->setAtributo_extra($row['atributo_extra']);
				$elem->setNro_pregunta($row['nro_pregunta']);
                                $elem->setEncuesta($row['encuesta']);
                                $elem->setAlineacion_respuesta($row['alineacion_respuesta']);
                                $elem->setLabel_izq($row['label_izq']);
                                $elem->setLabel_der($row['label_der']);
			}
			mysql_free_result($ResultSet);
			return $elem;
		}

		/**
		* Obtiene la cantidad de filas de la tabla
		*
		* @return int $rows
		*/
		function selectCountec_preguntas($criterio){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT COUNT(*) AS count FROM ec_preguntas WHERE pregunta_id = pregunta_id ";
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
		* @return ArrayObject ec_preguntasTO
		* @param array $criterio
		*/
		function selectByCriteria_ec_preguntas($criterio,$page_number){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT pregunta_id, encuesta_id, grupo_id, pregunta, tipo_respuesta, respuesta, atributo_extra, nro_pregunta,alineacion_respuesta, label_izq, label_der, 
                                                 (SELECT nombre FROM ec_encuestas WHERE encuesta_id = ec_preguntas.encuesta_id) AS encuesta, 
                                                 (SELECT CONCAT(nombre,'/',(SELECT valor FROM pa_parametros WHERE parametro_id = ec_grupos_preguntas.tipo)) AS grupo FROM ec_grupos_preguntas WHERE grupo_id = ec_preguntas.grupo_id) AS grupo,
                                                 (SELECT valor FROM pa_parametros WHERE parametro_id = ec_preguntas.tipo_respuesta) AS tipo_respuesta_desc,
                                                 (SELECT codigo FROM pa_parametros WHERE parametro_id = ec_preguntas.tipo_respuesta) AS tipo_respuesta_html  
						 FROM ec_preguntas WHERE pregunta_id = pregunta_id ";

			$PreparedStatement = $this->defineCriterias($criterio,$PreparedStatement);
			$PreparedStatement .= " ORDER BY pregunta_id ".$criterio["type_order"];
			if($page_number != -1)
				$PreparedStatement .= " LIMIT ".($page_number*TABLE_ROW_VIEW).",". ($page_number+1)*TABLE_ROW_VIEW."";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$arrayList = new ArrayObject();
			 while ($row = mysql_fetch_array($ResultSet)) {
				$elem = new ec_preguntasTO();
				$elem->setPregunta_id($row['pregunta_id']);
				$elem->setEncuesta_id($row['encuesta_id']);
				$elem->setGrupo_id($row['grupo_id']);
				$elem->setPregunta($row['pregunta']);
				$elem->setTipo_respuesta($row['tipo_respuesta']);
				$elem->setRespuesta($row['respuesta']);
				$elem->setAtributo_extra($row['atributo_extra']);
				$elem->setNro_pregunta($row['nro_pregunta']);
                                $elem->setEncuesta($row['encuesta']);
				$elem->setGrupo($row['grupo']);
                                $elem->setTipo_respuesta_desc($row['tipo_respuesta_desc']);
                                $elem->setTipo_respuesta_html($row['tipo_respuesta_html']);
                                $elem->setAlineacion_respuesta($row['alineacion_respuesta']);
                                $elem->setLabel_izq($row['label_izq']);
                                $elem->setLabel_der($row['label_der']);
                                
				$arrayList->append($elem);
			}
			mysql_free_result($ResultSet);
			return $arrayList;
		}
                
        function selectByIdec_preguntasTopNro($encuesta_id){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT MAX(CAST(nro_pregunta AS UNSIGNED)) AS nro_pregunta FROM ec_preguntas WHERE encuesta_id = ".Connection::inject($encuesta_id)." ;";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$elem = new ec_preguntasTO();
			while($row = mysql_fetch_array($ResultSet)){
				$elem = new ec_preguntasTO();
				$elem->setNro_pregunta($row['nro_pregunta']);

			}
			mysql_free_result($ResultSet);
			return $elem;
		}

		/**
		* Define los criterios del Where
		*
		* @return String $PreparedStatement ec_preguntasTO
		* @param String $PreparedStatement
		* @param array $criterio
		*/
		function defineCriterias($criterio,$PreparedStatement){
			if(isset ($criterio["pregunta_id"]) && trim($criterio["pregunta_id"]) != "0"){
				$PreparedStatement .=" AND pregunta_id = ".Connection::inject($criterio["pregunta_id"]);
			}
			if(isset ($criterio["encuesta_id"]) && trim($criterio["encuesta_id"]) != "0"){
				$PreparedStatement .=" AND encuesta_id = ".Connection::inject($criterio["encuesta_id"]);
			}
			if(isset ($criterio["grupo_id"]) && trim($criterio["grupo_id"]) != "0"){
				$PreparedStatement .=" AND grupo_id = ".Connection::inject($criterio["grupo_id"]);
			}
			if(isset ($criterio["pregunta"]) && trim($criterio["pregunta"]) != "0"){
				$PreparedStatement .=" AND pregunta LIKE '%".Connection::inject($criterio["pregunta"])."%'";
			}
			if(isset ($criterio["tipo_respuesta"]) && trim($criterio["tipo_respuesta"]) != "0"){
				$PreparedStatement .=" AND tipo_respuesta = ".Connection::inject($criterio["tipo_respuesta"]);
			}
			if(isset ($criterio["respuesta"]) && trim($criterio["respuesta"]) != "0"){
				$PreparedStatement .=" AND respuesta = ".Connection::inject($criterio["respuesta"]);
			}
			if(isset ($criterio["atributo_extra"]) && trim($criterio["atributo_extra"]) != "0"){
				$PreparedStatement .=" AND atributo_extra = ".Connection::inject($criterio["atributo_extra"]);
			}
			if(isset ($criterio["nro_pregunta"]) && trim($criterio["nro_pregunta"]) != "0"){
				$PreparedStatement .=" AND nro_pregunta = ".Connection::inject($criterio["nro_pregunta"]);
			}
			return $PreparedStatement;
		}
                
	}
?>