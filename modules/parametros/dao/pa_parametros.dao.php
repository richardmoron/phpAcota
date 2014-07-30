<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/cnx/connection.php");
	include_once (dirname(dirname(__FILE__))."/dto/pa_parametros.dto.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/logs.php");

	class pa_parametrosDAO {
		private $connection;
 
		function pa_parametrosDAO(){
		}

		/**
		* Añade un Registro
		*
		* @param pa_parametrosTO $elem
		* @return int Filas Afectadas
		*/
		function insertpa_parametros(pa_parametrosTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "INSERT INTO pa_parametros (parametro_id,entidad,codigo,valor,descripcion ) VALUES (
				".Connection::inject($elem->getParametro_id()).",
				'".Connection::inject($elem->getEntidad())."',
				'".Connection::inject($elem->getCodigo())."',
				'".Connection::inject($elem->getValor())."',
				'".Connection::inject($elem->getDescripcion())."'  );";

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
		* @param pa_parametrosTO $elem
		* @return int Filas Afectadas
		*/
		function updatepa_parametros(pa_parametrosTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "UPDATE pa_parametros SET  
				entidad = '".Connection::inject($elem->getEntidad())."',
				codigo = '".Connection::inject($elem->getCodigo())."',
				valor = '".Connection::inject($elem->getValor())."',
				descripcion = '".Connection::inject($elem->getDescripcion())."' 
			WHERE parametro_id = ". Connection::inject($elem->getParametro_id()).";" ;

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
		* @param pa_parametrosTO $elem
		* @return int Filas Afectadas
		*/
		function deletepa_parametros(pa_parametrosTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "DELETE FROM pa_parametros WHERE parametro_id = ". Connection::inject($elem->getParametro_id()).";";

			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
			if($ResultSet)
				return mysql_affected_rows();
			else
				throw new Exception(ERROR_DELETE);

		}

		/**
		* Obtiene un objeto pa_parametrosTO
		*
		* @return pa_parametrosTO elem
		*/
		function selectByIdpa_parametros($parametro_id){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT parametro_id, entidad, codigo, valor, descripcion   FROM pa_parametros WHERE parametro_id = ".Connection::inject($parametro_id)." ;";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$elem = new pa_parametrosTO();
			while($row = mysql_fetch_array($ResultSet)){
				$elem = new pa_parametrosTO();
				$elem->setParametro_id($row['parametro_id']);
				$elem->setEntidad($row['entidad']);
				$elem->setCodigo($row['codigo']);
				$elem->setValor($row['valor']);
				$elem->setDescripcion($row['descripcion']);

			}
			mysql_free_result($ResultSet);
			return $elem;
		}

		/**
		* Obtiene la cantidad de filas de la tabla
		*
		* @return int $rows
		*/
		function selectCountpa_parametros($criterio){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT COUNT(*) AS count FROM pa_parametros WHERE parametro_id = parametro_id ";
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
		* @return ArrayObject pa_parametrosTO
		* @param array $criterio
		*/
		function selectByCriteria_pa_parametros($criterio,$page_number){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT parametro_id, entidad, codigo, valor, descripcion  
						 FROM pa_parametros WHERE parametro_id = parametro_id ";

			$PreparedStatement = $this->defineCriterias($criterio,$PreparedStatement);
			$PreparedStatement .= " ORDER BY parametro_id LIMIT ".($page_number*TABLE_ROW_VIEW).",". ($page_number+1)*TABLE_ROW_VIEW."";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$arrayList = new ArrayObject();
			 while ($row = mysql_fetch_array($ResultSet)) {
				$elem = new pa_parametrosTO();
				$elem->setParametro_id($row['parametro_id']);
				$elem->setEntidad($row['entidad']);
				$elem->setCodigo($row['codigo']);
				$elem->setValor($row['valor']);
				$elem->setDescripcion($row['descripcion']);

				$arrayList->append($elem);
			}
			mysql_free_result($ResultSet);
			return $arrayList;
		}


		/**
		* Define los criterios del Where
		*
		* @return String $PreparedStatement pa_parametrosTO
		* @param String $PreparedStatement
		* @param array $criterio
		*/
		function defineCriterias($criterio,$PreparedStatement){
			if(isset ($criterio["parametro_id"]) && trim($criterio["parametro_id"]) != "0"){
				$PreparedStatement .=" AND parametro_id = ".Connection::inject($criterio["parametro_id"]);
			}
			if(isset ($criterio["entidad"]) && trim($criterio["entidad"]) != "0"){
				$PreparedStatement .=" AND entidad LIKE '%".Connection::inject($criterio["entidad"])."%'";
			}
			if(isset ($criterio["codigo"]) && trim($criterio["codigo"]) != "0"){
				$PreparedStatement .=" AND codigo = ".Connection::inject($criterio["codigo"]);
			}
			if(isset ($criterio["valor"]) && trim($criterio["valor"]) != "0"){
				$PreparedStatement .=" AND valor LIKE '%".Connection::inject($criterio["valor"])."%'";
			}
			if(isset ($criterio["descripcion"]) && trim($criterio["descripcion"]) != "0"){
				$PreparedStatement .=" AND descripcion = ".Connection::inject($criterio["descripcion"]);
			}
			return $PreparedStatement;
		}
	}
?>