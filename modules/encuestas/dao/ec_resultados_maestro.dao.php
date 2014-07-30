<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/cnx/connection.php");
	include_once (dirname(dirname(__FILE__))."/dto/ec_resultados_maestro.dto.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/logs.php");

	class ec_resultados_maestroDAO {
		private $connection;
 
		function ec_resultados_maestroDAO(){
		}

		/**
		* Añade un Registro
		*
		* @param ec_resultados_maestroTO $elem
		* @return int Filas Afectadas
		*/
		function insertec_resultados_maestro(ec_resultados_maestroTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "INSERT INTO ec_resultados_maestro (resultados_maestro_id,usuario,grupo_id_actual,grupo_id_siguiente,encuesta_id,estado_usuario,estado_encuesta,fecha_hora ) VALUES (
				".Connection::inject($elem->getResultados_maestro_id()).",
				'".Connection::inject($elem->getUsuario())."',
				".Connection::inject($elem->getGrupo_id_actual()).",
				".Connection::inject($elem->getGrupo_id_siguiente()).",
				".Connection::inject($elem->getEncuesta_id()).",
				'".Connection::inject($elem->getEstado_usuario())."',
				'".Connection::inject($elem->getEstado_encuesta())."',
				'".Connection::inject($elem->getFecha_hora())."'  );";

			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
			if($ResultSet)
				return mysql_insert_id();
			else
				throw new Exception(ERROR_INSERT);

		}

		/**
		* Actualiza un Registro
		*
		* @param ec_resultados_maestroTO $elem
		* @return int Filas Afectadas
		*/
		function updateec_resultados_maestro(ec_resultados_maestroTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "UPDATE ec_resultados_maestro SET  
				usuario = '".Connection::inject($elem->getUsuario())."',
				grupo_id_actual = ".Connection::inject($elem->getGrupo_id_actual()).",
				grupo_id_siguiente = ".Connection::inject($elem->getGrupo_id_siguiente()).",
				encuesta_id = ".Connection::inject($elem->getEncuesta_id()).",
				estado_usuario = '".Connection::inject($elem->getEstado_usuario())."',
				estado_encuesta = '".Connection::inject($elem->getEstado_encuesta())."',
				fecha_hora = '".Connection::inject($elem->getFecha_hora())."' 
			WHERE resultados_maestro_id = ". Connection::inject($elem->getResultados_maestro_id()).";" ;

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
		* @param ec_resultados_maestroTO $elem
		* @return int Filas Afectadas
		*/
		function deleteec_resultados_maestro(ec_resultados_maestroTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "DELETE FROM ec_resultados_maestro WHERE resultados_maestro_id = ". Connection::inject($elem->getResultados_maestro_id()).";";

			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
			if($ResultSet)
				return mysql_affected_rows();
			else
				throw new Exception(ERROR_DELETE);

		}

		/**
		* Obtiene un objeto ec_resultados_maestroTO
		*
		* @return ec_resultados_maestroTO elem
		*/
		function selectByIdec_resultados_maestro($resultados_maestro_id){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT resultados_maestro_id, usuario, grupo_id_actual, grupo_id_siguiente, encuesta_id, estado_usuario, estado_encuesta, fecha_hora   FROM ec_resultados_maestro WHERE resultados_maestro_id = ".Connection::inject($resultados_maestro_id)." ;";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$elem = new ec_resultados_maestroTO();
			while($row = mysql_fetch_array($ResultSet)){
				$elem = new ec_resultados_maestroTO();
				$elem->setResultados_maestro_id($row['resultados_maestro_id']);
				$elem->setUsuario($row['usuario']);
				$elem->setGrupo_id_actual($row['grupo_id_actual']);
				$elem->setGrupo_id_siguiente($row['grupo_id_siguiente']);
				$elem->setEncuesta_id($row['encuesta_id']);
				$elem->setEstado_usuario($row['estado_usuario']);
				$elem->setEstado_encuesta($row['estado_encuesta']);
				$elem->setFecha_hora($row['fecha_hora']);

			}
			mysql_free_result($ResultSet);
			return $elem;
		}

		/**
		* Obtiene la cantidad de filas de la tabla
		*
		* @return int $rows
		*/
		function selectCountec_resultados_maestro($criterio){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT COUNT(*) AS count FROM ec_resultados_maestro WHERE resultados_maestro_id = resultados_maestro_id ";
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
		* @return ArrayObject ec_resultados_maestroTO
		* @param array $criterio
		*/
		function selectByCriteria_ec_resultados_maestro($criterio,$page_number){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT resultados_maestro_id, usuario, grupo_id_actual, grupo_id_siguiente, encuesta_id, estado_usuario, estado_encuesta, fecha_hora  
						 FROM ec_resultados_maestro WHERE resultados_maestro_id = resultados_maestro_id ";

			$PreparedStatement = $this->defineCriterias($criterio,$PreparedStatement);
			$PreparedStatement .= " ORDER BY resultados_maestro_id";
			if($page_number != -1)
				$PreparedStatement .= " LIMIT ".($page_number*TABLE_ROW_VIEW).",". ($page_number+1)*TABLE_ROW_VIEW."";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$arrayList = new ArrayObject();
			 while ($row = mysql_fetch_array($ResultSet)) {
				$elem = new ec_resultados_maestroTO();
				$elem->setResultados_maestro_id($row['resultados_maestro_id']);
				$elem->setUsuario($row['usuario']);
				$elem->setGrupo_id_actual($row['grupo_id_actual']);
				$elem->setGrupo_id_siguiente($row['grupo_id_siguiente']);
				$elem->setEncuesta_id($row['encuesta_id']);
				$elem->setEstado_usuario($row['estado_usuario']);
				$elem->setEstado_encuesta($row['estado_encuesta']);
				$elem->setFecha_hora($row['fecha_hora']);

				$arrayList->append($elem);
			}
			mysql_free_result($ResultSet);
			return $arrayList;
		}


		/**
		* Define los criterios del Where
		*
		* @return String $PreparedStatement ec_resultados_maestroTO
		* @param String $PreparedStatement
		* @param array $criterio
		*/
		function defineCriterias($criterio,$PreparedStatement){
			if(isset ($criterio["resultados_maestro_id"]) && trim($criterio["resultados_maestro_id"]) != "0"){
				$PreparedStatement .=" AND resultados_maestro_id = ".Connection::inject($criterio["resultados_maestro_id"]);
			}
			if(isset ($criterio["usuario"]) && trim($criterio["usuario"]) != "0"){
				$PreparedStatement .=" AND usuario = '".Connection::inject($criterio["usuario"])."'";
			}
			if(isset ($criterio["grupo_id_actual"]) && trim($criterio["grupo_id_actual"]) != "0"){
				$PreparedStatement .=" AND grupo_id_actual = ".Connection::inject($criterio["grupo_id_actual"]);
			}
			if(isset ($criterio["grupo_id_siguiente"]) && trim($criterio["grupo_id_siguiente"]) != "0"){
				$PreparedStatement .=" AND grupo_id_siguiente = ".Connection::inject($criterio["grupo_id_siguiente"]);
			}
			if(isset ($criterio["encuesta_id"]) && trim($criterio["encuesta_id"]) != "0"){
				$PreparedStatement .=" AND encuesta_id = ".Connection::inject($criterio["encuesta_id"]);
			}
			if(isset ($criterio["estado_usuario"]) && trim($criterio["estado_usuario"]) != "0"){
				$PreparedStatement .=" AND estado_usuario = '".Connection::inject($criterio["estado_usuario"])."'";
			}
			if(isset ($criterio["estado_encuesta"]) && trim($criterio["estado_encuesta"]) != "0"){
				$PreparedStatement .=" AND estado_encuesta = '".Connection::inject($criterio["estado_encuesta"])."'";
			}
			if(isset ($criterio["fecha_hora"]) && trim($criterio["fecha_hora"]) != "0"){
				$PreparedStatement .=" AND fecha_hora = ".Connection::inject($criterio["fecha_hora"]);
			}
			return $PreparedStatement;
		}
	}
?>