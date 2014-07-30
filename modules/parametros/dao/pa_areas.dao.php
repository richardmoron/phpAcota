<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/cnx/connection.php");
	include_once (dirname(dirname(__FILE__))."/dto/pa_areas.dto.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/logs.php");

	class pa_areasDAO {
		private $connection;
 
		function pa_areasDAO(){
		}

		/**
		* Añade un Registro
		*
		* @param pa_areasTO $elem
		* @return int Filas Afectadas
		*/
		function insertpa_areas(pa_areasTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "INSERT INTO pa_areas (area_id,nombre_area ) VALUES (
				".Connection::inject($elem->getArea_id()).",
				'".Connection::inject($elem->getNombre_area())."'  );";

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
		* @param pa_areasTO $elem
		* @return int Filas Afectadas
		*/
		function updatepa_areas(pa_areasTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "UPDATE pa_areas SET  
				nombre_area = '".Connection::inject($elem->getNombre_area())."' 
			WHERE area_id = ". Connection::inject($elem->getArea_id()).";" ;

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
		* @param pa_areasTO $elem
		* @return int Filas Afectadas
		*/
		function deletepa_areas(pa_areasTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "DELETE FROM pa_areas WHERE area_id = ". Connection::inject($elem->getArea_id()).";";

			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
			if($ResultSet)
				return mysql_affected_rows();
			else
				throw new Exception(ERROR_DELETE);

		}

		/**
		* Obtiene un objeto pa_areasTO
		*
		* @return pa_areasTO elem
		*/
		function selectByIdpa_areas($area_id){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT area_id, nombre_area   FROM pa_areas WHERE area_id = ".Connection::inject($area_id)." ;";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$elem = new pa_areasTO();
			while($row = mysql_fetch_array($ResultSet)){
				$elem = new pa_areasTO();
				$elem->setArea_id($row['area_id']);
				$elem->setNombre_area($row['nombre_area']);

			}
			mysql_free_result($ResultSet);
			return $elem;
		}

		/**
		* Obtiene la cantidad de filas de la tabla
		*
		* @return int $rows
		*/
		function selectCountpa_areas($criterio){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT COUNT(*) AS count FROM pa_areas WHERE area_id = area_id ";
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
		* @return ArrayObject pa_areasTO
		* @param array $criterio
		*/
		function selectByCriteria_pa_areas($criterio,$page_number){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT area_id, nombre_area  
						 FROM pa_areas WHERE area_id = area_id ";

			$PreparedStatement = $this->defineCriterias($criterio,$PreparedStatement);
			$PreparedStatement .= " ORDER BY area_id LIMIT ".($page_number*TABLE_ROW_VIEW).",". ($page_number+1)*TABLE_ROW_VIEW."";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$arrayList = new ArrayObject();
			 while ($row = mysql_fetch_array($ResultSet)) {
				$elem = new pa_areasTO();
				$elem->setArea_id($row['area_id']);
				$elem->setNombre_area($row['nombre_area']);

				$arrayList->append($elem);
			}
			mysql_free_result($ResultSet);
			return $arrayList;
		}


		/**
		* Define los criterios del Where
		*
		* @return String $PreparedStatement pa_areasTO
		* @param String $PreparedStatement
		* @param array $criterio
		*/
		function defineCriterias($criterio,$PreparedStatement){
			if(isset ($criterio["area_id"]) && trim($criterio["area_id"]) != "0"){
				$PreparedStatement .=" AND area_id = ".Connection::inject($criterio["area_id"]);
			}
			if(isset ($criterio["nombre_area"]) && trim($criterio["nombre_area"]) != "0"){
				$PreparedStatement .=" AND nombre_area LIKE '%".Connection::inject($criterio["nombre_area"])."%'";
			}
			return $PreparedStatement;
		}
	}
?>