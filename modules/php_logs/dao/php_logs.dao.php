<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/cnx/connection_logs.php");
	include_once (dirname(dirname(__FILE__))."/dto/php_logs.dto.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/logs.php");

	class php_logsDAO {
		private $connection;
 
		function php_logsDAO(){
		}

		/**
		* Añade un Registro
		*
		* @param php_logsTO $elem
		* @return int Filas Afectadas
		*/
		function insertphp_logs(php_logsTO $elem){
//                        mysql_close(ConnectionLogs::getinstance()->getConn());
			$this->connection = ConnectionLogs::getinstance()->getConn();
                        $PreparedStatement = "INSERT  INTO php_logs (log_id,nom_table,nom_usuario,fecha_hora,accion,det_accion,det_error ) VALUES (
				".Connection::inject($elem->getLog_id()).",
				'".Connection::inject($elem->getNom_table())."',
				'".Connection::inject($elem->getNom_usuario())."',
				'".Connection::inject($elem->getFecha_hora())."',
				'".Connection::inject($elem->getAccion())."',
				'".Connection::inject($elem->getDet_accion())."',
				'".Connection::inject($elem->getDet_error())."'  );";
            
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
//			error_log(mysql_error($this->connection),3,"logsapp.log");
                        if($ResultSet)
				return mysql_affected_rows();
			else
				throw new Exception(ERROR_INSERT);
            
		}

		/**
		* Actualiza un Registro
		*
		* @param php_logsTO $elem
		* @return int Filas Afectadas
		*/
		function updatephp_logs(php_logsTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "UPDATE php_logs SET  
				nom_table = '".Connection::inject($elem->getNom_table())."',
				nom_usuario = '".Connection::inject($elem->getNom_usuario())."',
				fecha_hora = '".Connection::inject($elem->getFecha_hora())."',
				accion = '".Connection::inject($elem->getAccion())."',
				det_accion = '".Connection::inject($elem->getDet_accion())."',
				det_error = '".Connection::inject($elem->getDet_error())."' 
			WHERE log_id = ". Connection::inject($elem->getLog_id()).";" ;

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
		* @param php_logsTO $elem
		* @return int Filas Afectadas
		*/
		function deletephp_logs(php_logsTO $elem){
			$this->connection = ConnectionLogs::getinstance()->getConn();
			$PreparedStatement = "DELETE FROM php_logs WHERE log_id = ". Connection::inject($elem->getLog_id()).";";

			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
			if($ResultSet)
				return mysql_affected_rows();
			else
				throw new Exception(ERROR_DELETE);

		}

		/**
		* Obtiene un objeto php_logsTO
		*
		* @return php_logsTO elem
		*/
		function selectByIdphp_logs($log_id){
			$this->connection = ConnectionLogs::getinstance()->getConn();
			$PreparedStatement = "SELECT log_id, nom_table, nom_usuario, fecha_hora, accion, det_accion, det_error   FROM php_logs WHERE log_id = ".Connection::inject($log_id)." ;";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$elem = new php_logsTO();
			while($row = mysql_fetch_array($ResultSet)){
				$elem = new php_logsTO();
				$elem->setLog_id($row['log_id']);
				$elem->setNom_table($row['nom_table']);
				$elem->setNom_usuario($row['nom_usuario']);
				$elem->setFecha_hora($row['fecha_hora']);
				$elem->setAccion($row['accion']);
				$elem->setDet_accion($row['det_accion']);
				$elem->setDet_error($row['det_error']);

			}
			mysql_free_result($ResultSet);
			return $elem;
		}

		/**
		* Obtiene la cantidad de filas de la tabla
		*
		* @return int $rows
		*/
		function selectCountphp_logs($criterio){
			$this->connection = ConnectionLogs::getinstance()->getConn();
			$PreparedStatement = "SELECT COUNT(*) AS count FROM php_logs WHERE log_id = log_id ";
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
		* @return ArrayObject php_logsTO
		* @param array $criterio
		*/
		function selectByCriteria_php_logs($criterio,$page_number){
			$this->connection = ConnectionLogs::getinstance()->getConn();
			$PreparedStatement = "SELECT log_id, nom_table, nom_usuario, fecha_hora, accion, det_accion, det_error  
						 FROM php_logs WHERE log_id = log_id ";

			$PreparedStatement = $this->defineCriterias($criterio,$PreparedStatement);
			$PreparedStatement .= " ORDER BY log_id ";
                        if($page_number != -1)
				$PreparedStatement .= " LIMIT ".($page_number*TABLE_ROW_VIEW).",". ($page_number+1)*TABLE_ROW_VIEW."";
			
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$arrayList = new ArrayObject();
			 while ($row = mysql_fetch_array($ResultSet)) {
				$elem = new php_logsTO();
				$elem->setLog_id($row['log_id']);
				$elem->setNom_table($row['nom_table']);
				$elem->setNom_usuario($row['nom_usuario']);
				$elem->setFecha_hora($row['fecha_hora']);
				$elem->setAccion($row['accion']);
				$elem->setDet_accion($row['det_accion']);
				$elem->setDet_error($row['det_error']);

				$arrayList->append($elem);
			}
			mysql_free_result($ResultSet);
			return $arrayList;
		}


		/**
		* Define los criterios del Where
		*
		* @return String $PreparedStatement php_logsTO
		* @param String $PreparedStatement
		* @param array $criterio
		*/
		function defineCriterias($criterio,$PreparedStatement){
			if(isset ($criterio["log_id"]) && trim($criterio["log_id"]) != "0"){
				$PreparedStatement .=" AND log_id = ".Connection::inject($criterio["log_id"]);
			}
			if(isset ($criterio["nom_table"]) && trim($criterio["nom_table"]) != "0"){
				$PreparedStatement .=" AND nom_table LIKE '%".Connection::inject($criterio["nom_table"])."%'";
			}
			if(isset ($criterio["nom_usuario"]) && trim($criterio["nom_usuario"]) != "0"){
				$PreparedStatement .=" AND nom_usuario = '".Connection::inject($criterio["nom_usuario"])."'";
			}
			if(isset ($criterio["fecha_hora"]) && trim($criterio["fecha_hora"]) != "0"){
				$PreparedStatement .=" AND DATE_FORMAT(fecha_hora,'%d/%m/%Y') = '".Connection::inject($criterio["fecha_hora"])."'";
			}
			if(isset ($criterio["accion"]) && trim($criterio["accion"]) != "0"){
				$PreparedStatement .=" AND accion LIKE '%".Connection::inject($criterio["accion"])."%'";
			}
			if(isset ($criterio["det_accion"]) && trim($criterio["det_accion"]) != "0"){
				$PreparedStatement .=" AND det_accion LIKE '%".Connection::inject($criterio["det_accion"])."%'";
			}
			if(isset ($criterio["det_error"]) && trim($criterio["det_error"]) != "0"){
				$PreparedStatement .=" AND det_error LIKE '%".Connection::inject($criterio["det_error"])."%'";
			}
			return $PreparedStatement;
		}
	}
?>