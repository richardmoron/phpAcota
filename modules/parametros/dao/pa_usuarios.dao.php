<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/cnx/connection.php");
	include_once (dirname(dirname(__FILE__))."/dto/pa_usuarios.dto.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/logs.php");

	class pa_usuariosDAO {
		private $connection;
 
		function pa_usuariosDAO(){
		}

		/**
		* Añade un Registro
		*
		* @param pa_usuariosTO $elem
		* @return int Filas Afectadas
		*/
		function insertpa_usuarios(pa_usuariosTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "INSERT INTO pa_usuarios (usuario_id,usuario,password,nombres,apellidos,email,agencia_id,area_id,estado,tipo_usuario_id,persona_id,pregunta_secreta,respuesta_secreta ) VALUES (
				".Connection::inject($elem->getUsuario_id()).",
				'".Connection::inject($elem->getUsuario())."',
				'".Connection::inject($elem->getPassword())."',
				'".Connection::inject($elem->getNombres())."',
				'".Connection::inject($elem->getApellidos())."',
				'".Connection::inject($elem->getEmail())."',
				".Connection::inject($elem->getAgencia_id()).",
				'".Connection::inject($elem->getArea_id())."',
				'".Connection::inject($elem->getEstado())."',
				".Connection::inject($elem->getTipo_usuario_id()).",
				".Connection::inject($elem->getPersona_id()).",
				'".Connection::inject($elem->getPregunta_secreta())."',
				'".Connection::inject($elem->getRespuesta_secreta())."'  );";

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
		* @param pa_usuariosTO $elem
		* @return int Filas Afectadas
		*/
		function updatepa_usuarios(pa_usuariosTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "UPDATE pa_usuarios SET  
				usuario = '".Connection::inject($elem->getUsuario())."',
				password = '".Connection::inject($elem->getPassword())."',
				nombres = '".Connection::inject($elem->getNombres())."',
				apellidos = '".Connection::inject($elem->getApellidos())."',
				email = '".Connection::inject($elem->getEmail())."',
				agencia_id = ".Connection::inject($elem->getAgencia_id()).",
				area_id = '".Connection::inject($elem->getArea_id())."',
				estado = '".Connection::inject($elem->getEstado())."',
				tipo_usuario_id = ".Connection::inject($elem->getTipo_usuario_id()).",
				persona_id = ".Connection::inject($elem->getPersona_id()).",
				pregunta_secreta = '".Connection::inject($elem->getPregunta_secreta())."',
				respuesta_secreta = '".Connection::inject($elem->getRespuesta_secreta())."' 
			WHERE usuario_id = ". Connection::inject($elem->getUsuario_id()).";" ;

			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
			if($ResultSet)
				return mysql_affected_rows();
			else
				throw new Exception(ERROR_UPDATE);

		}
                
                function updatepa_usuariosCambio_Clave(pa_usuariosTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "UPDATE pa_usuarios SET  
				password = '".Connection::inject($elem->getPassword())."' 
			WHERE usuario_id = ". Connection::inject($elem->getUsuario_id())." 
                        AND   password = '".Connection::inject($elem->getUsuario())."';" ; // password actual

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
		* @param pa_usuariosTO $elem
		* @return int Filas Afectadas
		*/
		function deletepa_usuarios(pa_usuariosTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "DELETE FROM pa_usuarios WHERE usuario_id = ". Connection::inject($elem->getUsuario_id()).";";

			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
			if($ResultSet)
				return mysql_affected_rows();
			else
				throw new Exception(ERROR_DELETE);

		}

		/**
		* Obtiene un objeto pa_usuariosTO
		*
		* @return pa_usuariosTO elem
		*/
		function selectByIdpa_usuarios($usuario_id){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT usuario_id, usuario, password, nombres, apellidos, email, agencia_id, area_id, estado, tipo_usuario_id, persona_id, pregunta_secreta, respuesta_secreta,
                                                (SELECT nombre_area FROM pa_areas WHERE area_id = pa_usuarios.area_id) AS area 
                                                FROM pa_usuarios WHERE usuario_id = ".Connection::inject($usuario_id)." ;";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$elem = new pa_usuariosTO();
			while($row = mysql_fetch_array($ResultSet)){
				$elem = new pa_usuariosTO();
				$elem->setUsuario_id($row['usuario_id']);
				$elem->setUsuario($row['usuario']);
				$elem->setPassword($row['password']);
				$elem->setNombres($row['nombres']);
				$elem->setApellidos($row['apellidos']);
				$elem->setEmail($row['email']);
				$elem->setAgencia_id($row['agencia_id']);
				$elem->setArea_id($row['area_id']);
				$elem->setEstado($row['estado']);
				$elem->setTipo_usuario_id($row['tipo_usuario_id']);
				$elem->setPersona_id($row['persona_id']);
				$elem->setPregunta_secreta($row['pregunta_secreta']);
				$elem->setRespuesta_secreta($row['respuesta_secreta']);
                                $elem->setArea($row['area']);
			}
			mysql_free_result($ResultSet);
			return $elem;
		}
                
                function selectByNamepa_usuarios($usuario){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT usuario_id, usuario, password, nombres, apellidos, email, agencia_id, area_id, estado, tipo_usuario_id, persona_id, pregunta_secreta, respuesta_secreta   FROM pa_usuarios WHERE usuario = '".strtoupper(Connection::inject($usuario))."' ;";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$elem = new pa_usuariosTO();
			while($row = mysql_fetch_array($ResultSet)){
				$elem = new pa_usuariosTO();
				$elem->setUsuario_id($row['usuario_id']);
				$elem->setUsuario($row['usuario']);
				$elem->setPassword($row['password']);
				$elem->setNombres($row['nombres']);
				$elem->setApellidos($row['apellidos']);
				$elem->setEmail($row['email']);
				$elem->setAgencia_id($row['agencia_id']);
				$elem->setArea_id($row['area_id']);
				$elem->setEstado($row['estado']);
				$elem->setTipo_usuario_id($row['tipo_usuario_id']);
				$elem->setPersona_id($row['persona_id']);
				$elem->setPregunta_secreta($row['pregunta_secreta']);
				$elem->setRespuesta_secreta($row['respuesta_secreta']);

			}
			mysql_free_result($ResultSet);
			return $elem;
		}
		/**
		* Obtiene la cantidad de filas de la tabla
		*
		* @return int $rows
		*/
		function selectCountpa_usuarios($criterio){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT COUNT(*) AS count FROM pa_usuarios WHERE usuario_id = usuario_id ";
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
		* @return ArrayObject pa_usuariosTO
		* @param array $criterio
		*/
		function selectByCriteria_pa_usuarios($criterio,$page_number){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT usuario_id, usuario, password, nombres, apellidos, email, agencia_id, area_id, estado, tipo_usuario_id, persona_id, pregunta_secreta, respuesta_secreta,
                                                 (SELECT nombre_area FROM pa_areas WHERE area_id = pa_usuarios.area_id) AS area 
						 FROM pa_usuarios WHERE usuario_id = usuario_id ";

			$PreparedStatement = $this->defineCriterias($criterio,$PreparedStatement);
			$PreparedStatement .= " ORDER BY usuario_id LIMIT ".($page_number*TABLE_ROW_VIEW).",". ($page_number+1)*TABLE_ROW_VIEW."";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$arrayList = new ArrayObject();
			 while ($row = mysql_fetch_array($ResultSet)) {
				$elem = new pa_usuariosTO();
				$elem->setUsuario_id($row['usuario_id']);
				$elem->setUsuario($row['usuario']);
				$elem->setPassword($row['password']);
				$elem->setNombres($row['nombres']);
				$elem->setApellidos($row['apellidos']);
				$elem->setEmail($row['email']);
				$elem->setAgencia_id($row['agencia_id']);
				$elem->setArea_id($row['area_id']);
				$elem->setEstado($row['estado']);
				$elem->setTipo_usuario_id($row['tipo_usuario_id']);
				$elem->setPersona_id($row['persona_id']);
				$elem->setPregunta_secreta($row['pregunta_secreta']);
				$elem->setRespuesta_secreta($row['respuesta_secreta']);
                                $elem->setArea($row['area']);
                                
				$arrayList->append($elem);
			}
			mysql_free_result($ResultSet);
			return $arrayList;
		}


		/**
		* Define los criterios del Where
		*
		* @return String $PreparedStatement pa_usuariosTO
		* @param String $PreparedStatement
		* @param array $criterio
		*/
		function defineCriterias($criterio,$PreparedStatement){
			if(isset ($criterio["usuario_id"]) && trim($criterio["usuario_id"]) != "0"){
				$PreparedStatement .=" AND usuario_id = ".Connection::inject($criterio["usuario_id"]);
			}
			if(isset ($criterio["usuario"]) && trim($criterio["usuario"]) != "0"){
				$PreparedStatement .=" AND usuario LIKE '%".Connection::inject($criterio["usuario"])."%'";
			}
			if(isset ($criterio["password"]) && trim($criterio["password"]) != "0"){
				$PreparedStatement .=" AND password = '".Connection::inject($criterio["password"])."'";
			}
			if(isset ($criterio["nombres"]) && trim($criterio["nombres"]) != "0"){
				$PreparedStatement .=" AND nombres LIKE '%".Connection::inject($criterio["nombres"])."%'";
			}
			if(isset ($criterio["apellidos"]) && trim($criterio["apellidos"]) != "0"){
				$PreparedStatement .=" AND apellidos LIKE '%".Connection::inject($criterio["apellidos"])."%'";
			}
			if(isset ($criterio["email"]) && trim($criterio["email"]) != "0"){
				$PreparedStatement .=" AND email = ".Connection::inject($criterio["email"]);
			}
			if(isset ($criterio["agencia_id"]) && trim($criterio["agencia_id"]) != "0"){
				$PreparedStatement .=" AND agencia_id = ".Connection::inject($criterio["agencia_id"]);
			}
			if(isset ($criterio["area_id"]) && trim($criterio["area_id"]) != "0"){
				$PreparedStatement .=" AND area_id = ".Connection::inject($criterio["area_id"]);
			}
			if(isset ($criterio["estado"]) && trim($criterio["estado"]) != "0"){
				$PreparedStatement .=" AND estado = '".Connection::inject($criterio["estado"])."'";
			}
			if(isset ($criterio["tipo_usuario_id"]) && trim($criterio["tipo_usuario_id"]) != "0"){
				$PreparedStatement .=" AND tipo_usuario_id = ".Connection::inject($criterio["tipo_usuario_id"]);
			}
			if(isset ($criterio["persona_id"]) && trim($criterio["persona_id"]) != "0"){
				$PreparedStatement .=" AND persona_id = ".Connection::inject($criterio["persona_id"]);
			}
			if(isset ($criterio["pregunta_secreta"]) && trim($criterio["pregunta_secreta"]) != "0"){
				$PreparedStatement .=" AND pregunta_secreta = ".Connection::inject($criterio["pregunta_secreta"]);
			}
			if(isset ($criterio["respuesta_secreta"]) && trim($criterio["respuesta_secreta"]) != "0"){
				$PreparedStatement .=" AND respuesta_secreta = ".Connection::inject($criterio["respuesta_secreta"]);
			}
			return $PreparedStatement;
		}
	}
?>