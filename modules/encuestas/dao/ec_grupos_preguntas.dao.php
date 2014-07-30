<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/cnx/connection.php");
	include_once (dirname(dirname(__FILE__))."/dto/ec_grupos_preguntas.dto.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/logs.php");

	class ec_grupos_preguntasDAO {
		private $connection;
 
		function ec_grupos_preguntasDAO(){
		}

		/**
		* Añade un Registro
		*
		* @param ec_grupos_preguntasTO $elem
		* @return int Filas Afectadas
		*/
		function insertec_grupos_preguntas(ec_grupos_preguntasTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "INSERT INTO ec_grupos_preguntas (grupo_id,encuesta_id,nombre,tipo ) VALUES (
				".Connection::inject($elem->getGrupo_id()).",
				".Connection::inject($elem->getEncuesta_id()).",
				'".Connection::inject($elem->getNombre())."',
				'".Connection::inject($elem->getTipo())."'  );";

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
		* @param ec_grupos_preguntasTO $elem
		* @return int Filas Afectadas
		*/
		function updateec_grupos_preguntas(ec_grupos_preguntasTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "UPDATE ec_grupos_preguntas SET  
				encuesta_id = ".Connection::inject($elem->getEncuesta_id()).",
				nombre = '".Connection::inject($elem->getNombre())."',
				tipo = '".Connection::inject($elem->getTipo())."' 
			WHERE grupo_id = ". Connection::inject($elem->getGrupo_id()).";" ;

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
		* @param ec_grupos_preguntasTO $elem
		* @return int Filas Afectadas
		*/
		function deleteec_grupos_preguntas(ec_grupos_preguntasTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "DELETE FROM ec_grupos_preguntas WHERE grupo_id = ". Connection::inject($elem->getGrupo_id()).";";

			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
			if($ResultSet)
				return mysql_affected_rows();
			else
				throw new Exception(ERROR_DELETE);

		}

		/**
		* Obtiene un objeto ec_grupos_preguntasTO
		*
		* @return ec_grupos_preguntasTO elem
		*/
		function selectByIdec_grupos_preguntas($grupo_id){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT grupo_id, encuesta_id, nombre, tipo, 
                                              (SELECT nombre FROM ec_encuestas WHERE encuesta_id = ec_grupos_preguntas.encuesta_id) AS encuesta 
                                              FROM ec_grupos_preguntas WHERE grupo_id = ".Connection::inject($grupo_id)." ;";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$elem = new ec_grupos_preguntasTO();
			while($row = mysql_fetch_array($ResultSet)){
				$elem = new ec_grupos_preguntasTO();
				$elem->setGrupo_id($row['grupo_id']);
				$elem->setEncuesta_id($row['encuesta_id']);
				$elem->setNombre($row['nombre']);
				$elem->setTipo($row['tipo']);
                                $elem->setEncuesta($row['encuesta']);

			}
			mysql_free_result($ResultSet);
			return $elem;
		}

		/**
		* Obtiene la cantidad de filas de la tabla
		*
		* @return int $rows
		*/
		function selectCountec_grupos_preguntas($criterio){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT COUNT(*) AS count FROM ec_grupos_preguntas WHERE grupo_id = grupo_id ";
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
		* @return ArrayObject ec_grupos_preguntasTO
		* @param array $criterio
		*/
		function selectByCriteria_ec_grupos_preguntas($criterio,$page_number){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT grupo_id, encuesta_id, nombre, tipo,
                                                 (SELECT nombre FROM ec_encuestas WHERE encuesta_id = ec_grupos_preguntas.encuesta_id) AS encuesta, 
                                                 (SELECT valor FROM pa_parametros WHERE entidad = 'GRUPO_ENCUESTA' AND parametro_id = ec_grupos_preguntas.tipo) AS tipo_desc 
						 FROM ec_grupos_preguntas WHERE grupo_id = grupo_id ";

			$PreparedStatement = $this->defineCriterias($criterio,$PreparedStatement);
			$PreparedStatement .= " ORDER BY grupo_id";
			if($page_number != -1)
				$PreparedStatement .= " LIMIT ".($page_number*TABLE_ROW_VIEW).",". ($page_number+1)*TABLE_ROW_VIEW."";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$arrayList = new ArrayObject();
			 while ($row = mysql_fetch_array($ResultSet)) {
				$elem = new ec_grupos_preguntasTO();
				$elem->setGrupo_id($row['grupo_id']);
				$elem->setEncuesta_id($row['encuesta_id']);
				$elem->setNombre($row['nombre']);
				$elem->setTipo($row['tipo']);
                                $elem->setEncuesta($row['encuesta']);
                                $elem->setTipo_desc($row['tipo_desc']);
                                
				$arrayList->append($elem);
			}
			mysql_free_result($ResultSet);
			return $arrayList;
		}


		/**
		* Define los criterios del Where
		*
		* @return String $PreparedStatement ec_grupos_preguntasTO
		* @param String $PreparedStatement
		* @param array $criterio
		*/
		function defineCriterias($criterio,$PreparedStatement){
			if(isset ($criterio["grupo_id"]) && trim($criterio["grupo_id"]) != "0"){
				$PreparedStatement .=" AND grupo_id = ".Connection::inject($criterio["grupo_id"]);
			}
			if(isset ($criterio["encuesta_id"]) && trim($criterio["encuesta_id"]) != "0"){
				$PreparedStatement .=" AND encuesta_id = ".Connection::inject($criterio["encuesta_id"]);
			}
			if(isset ($criterio["nombre"]) && trim($criterio["nombre"]) != "0"){
				$PreparedStatement .=" AND nombre LIKE '%".Connection::inject($criterio["nombre"])."%'";
			}
			if(isset ($criterio["tipo"]) && trim($criterio["tipo"]) != "0"){
				$PreparedStatement .=" AND tipo = ".Connection::inject($criterio["tipo"]);
			}
			return $PreparedStatement;
		}
	}
?>