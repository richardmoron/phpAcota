<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/cnx/connection.php");
	include_once (dirname(dirname(__FILE__))."/dto/ec_empresas.dto.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/logs.php");

	class ec_empresasDAO {
		private $connection;
 
		function ec_empresasDAO(){
		}

		/**
		* Añade un Registro
		*
		* @param ec_empresasTO $elem
		* @return int Filas Afectadas
		*/
		function insertec_empresas(ec_empresasTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "INSERT INTO ec_empresas (empresa_id,nombre,direccion,telefono,persona_contacto ) VALUES (
				".Connection::inject($elem->getEmpresa_id()).",
				'".Connection::inject($elem->getNombre())."',
				'".Connection::inject($elem->getDireccion())."',
				'".Connection::inject($elem->getTelefono())."',
				'".Connection::inject($elem->getPersona_contacto())."'  );";

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
		* @param ec_empresasTO $elem
		* @return int Filas Afectadas
		*/
		function updateec_empresas(ec_empresasTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "UPDATE ec_empresas SET  
				nombre = '".Connection::inject($elem->getNombre())."',
				direccion = '".Connection::inject($elem->getDireccion())."',
				telefono = '".Connection::inject($elem->getTelefono())."',
				persona_contacto = ".Connection::inject($elem->getPersona_contacto())." 
			WHERE empresa_id = ". Connection::inject($elem->getEmpresa_id()).";" ;

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
		* @param ec_empresasTO $elem
		* @return int Filas Afectadas
		*/
		function deleteec_empresas(ec_empresasTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "DELETE FROM ec_empresas WHERE empresa_id = ". Connection::inject($elem->getEmpresa_id()).";";

			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
			if($ResultSet)
				return mysql_affected_rows();
			else
				throw new Exception(ERROR_DELETE);

		}

		/**
		* Obtiene un objeto ec_empresasTO
		*
		* @return ec_empresasTO elem
		*/
		function selectByIdec_empresas($empresa_id){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT empresa_id, nombre, direccion, telefono, persona_contacto   FROM ec_empresas WHERE empresa_id = ".Connection::inject($empresa_id)." ;";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$elem = new ec_empresasTO();
			while($row = mysql_fetch_array($ResultSet)){
				$elem = new ec_empresasTO();
				$elem->setEmpresa_id($row['empresa_id']);
				$elem->setNombre($row['nombre']);
				$elem->setDireccion($row['direccion']);
				$elem->setTelefono($row['telefono']);
				$elem->setPersona_contacto($row['persona_contacto']);

			}
			mysql_free_result($ResultSet);
			return $elem;
		}

		/**
		* Obtiene la cantidad de filas de la tabla
		*
		* @return int $rows
		*/
		function selectCountec_empresas($criterio){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT COUNT(*) AS count FROM ec_empresas WHERE empresa_id = empresa_id ";
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
		* @return ArrayObject ec_empresasTO
		* @param array $criterio
		*/
		function selectByCriteria_ec_empresas($criterio,$page_number){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT empresa_id, nombre, direccion, telefono, persona_contacto  
						 FROM ec_empresas WHERE empresa_id = empresa_id ";

			$PreparedStatement = $this->defineCriterias($criterio,$PreparedStatement);
			$PreparedStatement .= " ORDER BY empresa_id";
			if($page_number != -1)
				$PreparedStatement .= " LIMIT ".($page_number*TABLE_ROW_VIEW).",". ($page_number+1)*TABLE_ROW_VIEW."";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$arrayList = new ArrayObject();
			 while ($row = mysql_fetch_array($ResultSet)) {
				$elem = new ec_empresasTO();
				$elem->setEmpresa_id($row['empresa_id']);
				$elem->setNombre($row['nombre']);
				$elem->setDireccion($row['direccion']);
				$elem->setTelefono($row['telefono']);
				$elem->setPersona_contacto($row['persona_contacto']);

				$arrayList->append($elem);
			}
			mysql_free_result($ResultSet);
			return $arrayList;
		}


		/**
		* Define los criterios del Where
		*
		* @return String $PreparedStatement ec_empresasTO
		* @param String $PreparedStatement
		* @param array $criterio
		*/
		function defineCriterias($criterio,$PreparedStatement){
			if(isset ($criterio["empresa_id"]) && trim($criterio["empresa_id"]) != "0"){
				$PreparedStatement .=" AND empresa_id = ".Connection::inject($criterio["empresa_id"]);
			}
			if(isset ($criterio["nombre"]) && trim($criterio["nombre"]) != "0"){
				$PreparedStatement .=" AND nombre = ".Connection::inject($criterio["nombre"]);
			}
			if(isset ($criterio["direccion"]) && trim($criterio["direccion"]) != "0"){
				$PreparedStatement .=" AND direccion = ".Connection::inject($criterio["direccion"]);
			}
			if(isset ($criterio["telefono"]) && trim($criterio["telefono"]) != "0"){
				$PreparedStatement .=" AND telefono = ".Connection::inject($criterio["telefono"]);
			}
			if(isset ($criterio["persona_contacto"]) && trim($criterio["persona_contacto"]) != "0"){
				$PreparedStatement .=" AND persona_contacto = ".Connection::inject($criterio["persona_contacto"]);
			}
			return $PreparedStatement;
		}
	}
?>