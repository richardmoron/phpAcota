<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/cnx/connection.php");
	include_once (dirname(dirname(__FILE__))."/dto/ec_valores_respuesta.dto.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/logs.php");

	class ec_valores_respuestaDAO {
		private $connection;
 
		function ec_valores_respuestaDAO(){
		}

		/**
		* Añade un Registro
		*
		* @param ec_valores_respuestaTO $elem
		* @return int Filas Afectadas
		*/
		function insertec_valores_respuesta(ec_valores_respuestaTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "INSERT INTO ec_valores_respuesta (valor_respuesta_id,pregunta_id,valor,etiqueta ) VALUES (
				".Connection::inject($elem->getValor_respuesta_id()).",
				".Connection::inject($elem->getPregunta_id()).",
				'".Connection::inject($elem->getValor())."',
				'".Connection::inject($elem->getEtiqueta())."'  );";

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
		* @param ec_valores_respuestaTO $elem
		* @return int Filas Afectadas
		*/
		function updateec_valores_respuesta(ec_valores_respuestaTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "UPDATE ec_valores_respuesta SET  
				pregunta_id = ".Connection::inject($elem->getPregunta_id()).",
				valor = '".Connection::inject($elem->getValor())."',
				etiqueta = '".Connection::inject($elem->getEtiqueta())."' 
			WHERE valor_respuesta_id = ". Connection::inject($elem->getValor_respuesta_id()).";" ;

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
		* @param ec_valores_respuestaTO $elem
		* @return int Filas Afectadas
		*/
		function deleteec_valores_respuesta(ec_valores_respuestaTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "DELETE FROM ec_valores_respuesta WHERE valor_respuesta_id = ". Connection::inject($elem->getValor_respuesta_id()).";";

			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
			if($ResultSet)
				return mysql_affected_rows();
			else
				throw new Exception(ERROR_DELETE);

		}

		/**
		* Obtiene un objeto ec_valores_respuestaTO
		*
		* @return ec_valores_respuestaTO elem
		*/
		function selectByIdec_valores_respuesta($valor_respuesta_id){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT valor_respuesta_id, pregunta_id, valor, etiqueta   FROM ec_valores_respuesta WHERE valor_respuesta_id = ".Connection::inject($valor_respuesta_id)." ;";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$elem = new ec_valores_respuestaTO();
			while($row = mysql_fetch_array($ResultSet)){
				$elem = new ec_valores_respuestaTO();
				$elem->setValor_respuesta_id($row['valor_respuesta_id']);
				$elem->setPregunta_id($row['pregunta_id']);
				$elem->setValor($row['valor']);
				$elem->setEtiqueta($row['etiqueta']);

			}
			mysql_free_result($ResultSet);
			return $elem;
		}

		/**
		* Obtiene la cantidad de filas de la tabla
		*
		* @return int $rows
		*/
		function selectCountec_valores_respuesta($criterio){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT COUNT(*) AS count FROM ec_valores_respuesta WHERE valor_respuesta_id = valor_respuesta_id ";
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
		* @return ArrayObject ec_valores_respuestaTO
		* @param array $criterio
		*/
		function selectByCriteria_ec_valores_respuesta($criterio,$page_number){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT valor_respuesta_id, pregunta_id, valor, etiqueta  
						 FROM ec_valores_respuesta WHERE valor_respuesta_id = valor_respuesta_id ";

			$PreparedStatement = $this->defineCriterias($criterio,$PreparedStatement);
			$PreparedStatement .= " ORDER BY valor";
			if($page_number != -1)
				$PreparedStatement .= " LIMIT ".($page_number*TABLE_ROW_VIEW).",". ($page_number+1)*TABLE_ROW_VIEW."";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$arrayList = new ArrayObject();
			 while ($row = mysql_fetch_array($ResultSet)) {
				$elem = new ec_valores_respuestaTO();
				$elem->setValor_respuesta_id($row['valor_respuesta_id']);
				$elem->setPregunta_id($row['pregunta_id']);
				$elem->setValor($row['valor']);
				$elem->setEtiqueta($row['etiqueta']);

				$arrayList->append($elem);
			}
			mysql_free_result($ResultSet);
			return $arrayList;
		}


		/**
		* Define los criterios del Where
		*
		* @return String $PreparedStatement ec_valores_respuestaTO
		* @param String $PreparedStatement
		* @param array $criterio
		*/
		function defineCriterias($criterio,$PreparedStatement){
			if(isset ($criterio["valor_respuesta_id"]) && trim($criterio["valor_respuesta_id"]) != "0"){
				$PreparedStatement .=" AND valor_respuesta_id = ".Connection::inject($criterio["valor_respuesta_id"]);
			}
			if(isset ($criterio["pregunta_id"]) && trim($criterio["pregunta_id"]) != "0"){
				$PreparedStatement .=" AND pregunta_id = ".Connection::inject($criterio["pregunta_id"]);
			}
			if(isset ($criterio["valor"]) && trim($criterio["valor"]) != "0"){
				$PreparedStatement .=" AND valor = ".Connection::inject($criterio["valor"]);
			}
			if(isset ($criterio["etiqueta"]) && trim($criterio["etiqueta"]) != "0"){
				$PreparedStatement .=" AND etiqueta = ".Connection::inject($criterio["etiqueta"]);
			}
			return $PreparedStatement;
		}
	}
?>