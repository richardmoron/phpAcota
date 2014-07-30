<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."\cnx\connection.php");
	include_once (dirname(dirname(__FILE__))."\dto\ac_grupos_socios.dto.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."\lib\logs.php");

	class ac_grupos_sociosDAO {
		private $connection;
 
		function ac_grupos_sociosDAO(){
		}

		/**
		* Añade un Registro
		*
		* @param ac_grupos_sociosTO $elem
		* @return int Filas Afectadas
		*/
		function insertac_grupos_socios(ac_grupos_sociosTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "INSERT INTO asapasc.ac_grupos_socios (grupo_id,nombre_grupo,consumo_minimo_permitido,costo_consumo_minimo,costo_consumo_excedido ) VALUES (
				".Connection::inject($elem->getGrupo_id()).",
				'".Connection::inject($elem->getNombre_grupo())."',
				".Connection::inject($elem->getConsumo_minimo_permitido()).",
				'".Connection::inject($elem->getCosto_consumo_minimo())."',
				'".Connection::inject($elem->getCosto_consumo_excedido())."'  );";

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
		* @param ac_grupos_sociosTO $elem
		* @return int Filas Afectadas
		*/
		function updateac_grupos_socios(ac_grupos_sociosTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "UPDATE asapasc.ac_grupos_socios SET  
				nombre_grupo = '".Connection::inject($elem->getNombre_grupo())."',
				consumo_minimo_permitido = ".Connection::inject($elem->getConsumo_minimo_permitido()).",
				costo_consumo_minimo = '".Connection::inject($elem->getCosto_consumo_minimo())."',
				costo_consumo_excedido = '".Connection::inject($elem->getCosto_consumo_excedido())."' 
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
		* @param ac_grupos_sociosTO $elem
		* @return int Filas Afectadas
		*/
		function deleteac_grupos_socios(ac_grupos_sociosTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "DELETE FROM asapasc.ac_grupos_socios WHERE grupo_id = ". Connection::inject($elem->getGrupo_id()).";";

			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
			if($ResultSet)
				return mysql_affected_rows();
			else
				throw new Exception(ERROR_DELETE);

		}

		/**
		* Obtiene un objeto ac_grupos_sociosTO
		*
		* @return ac_grupos_sociosTO elem
		*/
		function selectByIdac_grupos_socios($grupo_id){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT grupo_id, nombre_grupo, consumo_minimo_permitido, costo_consumo_minimo, costo_consumo_excedido   FROM asapasc.ac_grupos_socios WHERE grupo_id = ".Connection::inject($grupo_id)." ;";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$elem = new ac_grupos_sociosTO();
			while($row = mysql_fetch_array($ResultSet)){
				$elem = new ac_grupos_sociosTO();
				$elem->setGrupo_id($row['grupo_id']);
				$elem->setNombre_grupo($row['nombre_grupo']);
				$elem->setConsumo_minimo_permitido($row['consumo_minimo_permitido']);
				$elem->setCosto_consumo_minimo($row['costo_consumo_minimo']);
				$elem->setCosto_consumo_excedido($row['costo_consumo_excedido']);

			}
			mysql_free_result($ResultSet);
			return $elem;
		}

		/**
		* Obtiene la cantidad de filas de la tabla
		*
		* @return int $rows
		*/
		function selectCountac_grupos_socios($criterio){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT COUNT(*) AS count FROM asapasc.ac_grupos_socios WHERE grupo_id = grupo_id ";
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
		* @return ArrayObject ac_grupos_sociosTO
		* @param array $criterio
		*/
		function selectByCriteria_ac_grupos_socios($criterio,$page_number){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT grupo_id, nombre_grupo, consumo_minimo_permitido, costo_consumo_minimo, costo_consumo_excedido  
						 FROM asapasc.ac_grupos_socios WHERE grupo_id = grupo_id ";

			$PreparedStatement = $this->defineCriterias($criterio,$PreparedStatement);
			$PreparedStatement .= " ORDER BY grupo_id";
			if($page_number != -1)
				$PreparedStatement .= " LIMIT ".($page_number*TABLE_ROW_VIEW).",". ($page_number+1)*TABLE_ROW_VIEW."";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$arrayList = new ArrayObject();
			 while ($row = mysql_fetch_array($ResultSet)) {
				$elem = new ac_grupos_sociosTO();
				$elem->setGrupo_id($row['grupo_id']);
				$elem->setNombre_grupo($row['nombre_grupo']);
				$elem->setConsumo_minimo_permitido($row['consumo_minimo_permitido']);
				$elem->setCosto_consumo_minimo($row['costo_consumo_minimo']);
				$elem->setCosto_consumo_excedido($row['costo_consumo_excedido']);

				$arrayList->append($elem);
			}
			mysql_free_result($ResultSet);
			return $arrayList;
		}


		/**
		* Define los criterios del Where
		*
		* @return String $PreparedStatement ac_grupos_sociosTO
		* @param String $PreparedStatement
		* @param array $criterio
		*/
		function defineCriterias($criterio,$PreparedStatement){
			if(isset ($criterio["grupo_id"]) && trim($criterio["grupo_id"]) != "0"){
				$PreparedStatement .=" AND grupo_id = ".Connection::inject($criterio["grupo_id"]);
			}
			if(isset ($criterio["nombre_grupo"]) && trim($criterio["nombre_grupo"]) != "0"){
				$PreparedStatement .=" AND nombre_grupo LIKE '%".Connection::inject($criterio["nombre_grupo"])."%'";
			}
			if(isset ($criterio["consumo_minimo_permitido"]) && trim($criterio["consumo_minimo_permitido"]) != "0"){
				$PreparedStatement .=" AND consumo_minimo_permitido = ".Connection::inject($criterio["consumo_minimo_permitido"]);
			}
			if(isset ($criterio["costo_consumo_minimo"]) && trim($criterio["costo_consumo_minimo"]) != "0"){
				$PreparedStatement .=" AND costo_consumo_minimo = ".Connection::inject($criterio["costo_consumo_minimo"]);
			}
			if(isset ($criterio["costo_consumo_excedido"]) && trim($criterio["costo_consumo_excedido"]) != "0"){
				$PreparedStatement .=" AND costo_consumo_excedido = ".Connection::inject($criterio["costo_consumo_excedido"]);
			}
			return $PreparedStatement;
		}
	}
?>