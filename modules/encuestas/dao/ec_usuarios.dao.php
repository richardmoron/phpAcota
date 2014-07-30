<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/cnx/connection.php");
	include_once (dirname(dirname(__FILE__))."/dto/ec_usuarios.dto.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/logs.php");

	class ec_usuariosDAO {
		private $connection;
 
		function ec_usuariosDAO(){
		}

		/**
		* Añade un Registro
		*
		* @param ec_usuariosTO $elem
		* @return int Filas Afectadas
		*/
		function insertec_usuarios(ec_usuariosTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "INSERT INTO ec_usuarios (usuario_id,nombre_usuario,clave_usuario,estado_usuario,fecha_habilitacion ) VALUES (
				".Connection::inject($elem->getUsuario_id()).",
				'".Connection::inject($elem->getNombre_usuario())."',
				'".Connection::inject($elem->getClave_usuario())."',
				'".Connection::inject($elem->getEstado_usuario())."',
				'".Connection::inject($elem->getFecha_habilitacion())."'  );";

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
		* @param ec_usuariosTO $elem
		* @return int Filas Afectadas
		*/
		function updateec_usuarios(ec_usuariosTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "UPDATE ec_usuarios SET  
				nombre_usuario = '".Connection::inject($elem->getNombre_usuario())."',
				clave_usuario = '".Connection::inject($elem->getClave_usuario())."',
				estado_usuario = '".Connection::inject($elem->getEstado_usuario())."',
				fecha_habilitacion = '".Connection::inject($elem->getFecha_habilitacion())."' 
			WHERE usuario_id = ". Connection::inject($elem->getUsuario_id()).";" ;

			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
			if($ResultSet)
				return mysql_affected_rows();
			else
				throw new Exception(ERROR_UPDATE);

		}
                
                function updateEstadoEc_usuarios(ec_usuariosTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "UPDATE ec_usuarios SET  
				estado_usuario = '".Connection::inject($elem->getEstado_usuario())."' 
			WHERE nombre_usuario = '". Connection::inject($elem->getNombre_usuario())."';" ;

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
		* @param ec_usuariosTO $elem
		* @return int Filas Afectadas
		*/
		function deleteec_usuarios(ec_usuariosTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "DELETE FROM ec_usuarios WHERE usuario_id = ". Connection::inject($elem->getUsuario_id()).";";

			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
			if($ResultSet)
				return mysql_affected_rows();
			else
				throw new Exception(ERROR_DELETE);

		}

		/**
		* Obtiene un objeto ec_usuariosTO
		*
		* @return ec_usuariosTO elem
		*/
		function selectByIdec_usuarios($usuario_id){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT usuario_id, nombre_usuario, clave_usuario, estado_usuario, fecha_habilitacion   FROM ec_usuarios WHERE usuario_id = ".Connection::inject($usuario_id)." ;";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$elem = new ec_usuariosTO();
			while($row = mysql_fetch_array($ResultSet)){
				$elem = new ec_usuariosTO();
				$elem->setUsuario_id($row['usuario_id']);
				$elem->setNombre_usuario($row['nombre_usuario']);
				$elem->setClave_usuario($row['clave_usuario']);
				$elem->setEstado_usuario($row['estado_usuario']);
				$elem->setFecha_habilitacion($row['fecha_habilitacion']);

			}
			mysql_free_result($ResultSet);
			return $elem;
		}

		/**
		* Obtiene la cantidad de filas de la tabla
		*
		* @return int $rows
		*/
		function selectCountec_usuarios($criterio){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT COUNT(*) AS count FROM ec_usuarios WHERE usuario_id = usuario_id ";
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
		* @return ArrayObject ec_usuariosTO
		* @param array $criterio
		*/
		function selectByCriteria_ec_usuarios($criterio,$page_number){
    		$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT usuario_id, nombre_usuario, clave_usuario, estado_usuario, fecha_habilitacion  
						 FROM ec_usuarios WHERE usuario_id = usuario_id ";

			$PreparedStatement = $this->defineCriterias($criterio,$PreparedStatement);
			$PreparedStatement .= " ORDER BY estado_usuario";
			if($page_number != -1)
				$PreparedStatement .= " LIMIT ".($page_number*TABLE_ROW_VIEW).",". ($page_number+1)*TABLE_ROW_VIEW."";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$arrayList = new ArrayObject();
			 while ($row = mysql_fetch_array($ResultSet)) {
				$elem = new ec_usuariosTO();
				$elem->setUsuario_id($row['usuario_id']);
				$elem->setNombre_usuario($row['nombre_usuario']);
				$elem->setClave_usuario($row['clave_usuario']);
				$elem->setEstado_usuario($row['estado_usuario']);
				$elem->setFecha_habilitacion($row['fecha_habilitacion']);

				$arrayList->append($elem);
			}
			mysql_free_result($ResultSet);
			return $arrayList;
		}


		/**
		* Define los criterios del Where
		*
		* @return String $PreparedStatement ec_usuariosTO
		* @param String $PreparedStatement
		* @param array $criterio
		*/
		function defineCriterias($criterio,$PreparedStatement){
			if(isset ($criterio["usuario_id"]) && trim($criterio["usuario_id"]) != "0"){
				$PreparedStatement .=" AND usuario_id = ".Connection::inject($criterio["usuario_id"]);
			}
			if(isset ($criterio["nombre_usuario"]) && trim($criterio["nombre_usuario"]) != "0"){
				$PreparedStatement .=" AND nombre_usuario LIKE '%".Connection::inject($criterio["nombre_usuario"])."%'";
			}
                        if(isset ($criterio["nombre_usuario2"]) && trim($criterio["nombre_usuario2"]) != "0"){
				$PreparedStatement .=" AND nombre_usuario = '".Connection::inject($criterio["nombre_usuario2"])."'";
			}
			if(isset ($criterio["clave_usuario"]) && trim($criterio["clave_usuario"]) != "0"){
				$PreparedStatement .=" AND clave_usuario = '".Connection::inject($criterio["clave_usuario"])."'";
			}
			if(isset ($criterio["estado_usuario"]) && trim($criterio["estado_usuario"]) != "0"){
				$PreparedStatement .=" AND estado_usuario = '".Connection::inject($criterio["estado_usuario"])."'";
			}
			if(isset ($criterio["fecha_habilitacion"]) && trim($criterio["fecha_habilitacion"]) != "0"){
				$PreparedStatement .=" AND fecha_habilitacion = ".Connection::inject($criterio["fecha_habilitacion"]);
			}
                        if(isset ($criterio["fecha_habil"]) && trim($criterio["fecha_habil"]) != "0"){
				$PreparedStatement .=" AND DATE(NOW()) <= DATE(fecha_habilitacion) ";
			}
                        
			return $PreparedStatement;
		}
	}
?>