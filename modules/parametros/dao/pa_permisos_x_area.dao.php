<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/cnx/connection.php");
	include_once (dirname(dirname(__FILE__))."/dto/pa_permisos_x_area.dto.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/logs.php");

	class pa_permisos_x_areaDAO {
		private $connection;
 
		function pa_permisos_x_areaDAO(){
		}

		/**
		* Añade un Registro
		*
		* @param pa_permisos_x_areaTO $elem
		* @return int Filas Afectadas
		*/
		function insertpa_permisos_x_area(pa_permisos_x_areaTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "INSERT INTO pa_permisos_x_area (permisos_x_area_id,area_id,archivo,insertar,borrar,reporte,actualizar,consultar,observaciones ) VALUES (
				".Connection::inject($elem->getPermisos_x_area_id()).",
				".Connection::inject($elem->getArea_id()).",
				'".Connection::inject($elem->getArchivo())."',
				'".Connection::inject($elem->getInsertar())."',
				'".Connection::inject($elem->getBorrar())."',
				'".Connection::inject($elem->getReporte())."',
				'".Connection::inject($elem->getActualizar())."',
				'".Connection::inject($elem->getConsultar())."',
				'".Connection::inject($elem->getObservaciones())."'  );";

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
		* @param pa_permisos_x_areaTO $elem
		* @return int Filas Afectadas
		*/
		function updatepa_permisos_x_area(pa_permisos_x_areaTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "UPDATE pa_permisos_x_area SET  
				area_id = ".Connection::inject($elem->getArea_id()).",
				archivo = '".Connection::inject($elem->getArchivo())."',
				insertar = '".Connection::inject($elem->getInsertar())."',
				borrar = '".Connection::inject($elem->getBorrar())."',
				reporte = '".Connection::inject($elem->getReporte())."',
				actualizar = '".Connection::inject($elem->getActualizar())."',
				consultar = '".Connection::inject($elem->getConsultar())."',
				observaciones = '".Connection::inject($elem->getObservaciones())."'  
			WHERE permisos_x_area_id = ". Connection::inject($elem->getPermisos_x_area_id()).";" ;

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
		* @param pa_permisos_x_areaTO $elem
		* @return int Filas Afectadas
		*/
		function deletepa_permisos_x_area(pa_permisos_x_areaTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "DELETE FROM pa_permisos_x_area WHERE permisos_x_area_id = ". Connection::inject($elem->getPermisos_x_area_id()).";";

			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
			if($ResultSet)
				return mysql_affected_rows();
			else
				throw new Exception(ERROR_DELETE);

		}

		/**
		* Obtiene un objeto pa_permisos_x_areaTO
		*
		* @return pa_permisos_x_areaTO elem
		*/
		function selectByIdpa_permisos_x_area($permisos_x_area_id){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT permisos_x_area_id, area_id, archivo, insertar, borrar, reporte, actualizar, consultar, observaciones   FROM pa_permisos_x_area WHERE permisos_x_area_id = ".Connection::inject($permisos_x_area_id)." ;";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$elem = new pa_permisos_x_areaTO();
			while($row = mysql_fetch_array($ResultSet)){
				$elem = new pa_permisos_x_areaTO();
				$elem->setPermisos_x_area_id($row['permisos_x_area_id']);
				$elem->setArea_id($row['area_id']);
				$elem->setArchivo($row['archivo']);
				$elem->setInsertar($row['insertar']);
				$elem->setBorrar($row['borrar']);
				$elem->setReporte($row['reporte']);
				$elem->setActualizar($row['actualizar']);
				$elem->setConsultar($row['consultar']);
				$elem->setObservaciones($row['observaciones']);

			}
			mysql_free_result($ResultSet);
			return $elem;
		}

		/**
		* Obtiene la cantidad de filas de la tabla
		*
		* @return int $rows
		*/
		function selectCountpa_permisos_x_area($criterio){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT COUNT(*) AS count FROM pa_permisos_x_area WHERE permisos_x_area_id = permisos_x_area_id ";
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
		* @return ArrayObject pa_permisos_x_areaTO
		* @param array $criterio
		*/
		function selectByCriteria_pa_permisos_x_area($criterio,$page_number){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT permisos_x_area_id, area_id, archivo, insertar, borrar, reporte, actualizar, consultar, observaciones,
                                                 (SELECT nombre_area FROM pa_areas WHERE area_id = pa_permisos_x_area.area_id) AS area 
						 FROM pa_permisos_x_area WHERE permisos_x_area_id = permisos_x_area_id ";

			$PreparedStatement = $this->defineCriterias($criterio,$PreparedStatement);
			$PreparedStatement .= " ORDER BY permisos_x_area_id LIMIT ".($page_number*TABLE_ROW_VIEW).",". ($page_number+1)*TABLE_ROW_VIEW."";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$arrayList = new ArrayObject();
			 while ($row = mysql_fetch_array($ResultSet)) {
				$elem = new pa_permisos_x_areaTO();
				$elem->setPermisos_x_area_id($row['permisos_x_area_id']);
				$elem->setArea_id($row['area_id']);
				$elem->setArchivo($row['archivo']);
				$elem->setInsertar($row['insertar']);
				$elem->setBorrar($row['borrar']);
				$elem->setReporte($row['reporte']);
				$elem->setActualizar($row['actualizar']);
				$elem->setConsultar($row['consultar']);
				$elem->setObservaciones($row['observaciones']);
                                $elem->setArea($row['area']);
                                
				$arrayList->append($elem);
			}
			mysql_free_result($ResultSet);
			return $arrayList;
		}


		/**
		* Define los criterios del Where
		*
		* @return String $PreparedStatement pa_permisos_x_areaTO
		* @param String $PreparedStatement
		* @param array $criterio
		*/
		function defineCriterias($criterio,$PreparedStatement){
			if(isset ($criterio["permisos_x_area_id"]) && trim($criterio["permisos_x_area_id"]) != "0"){
				$PreparedStatement .=" AND permisos_x_area_id = ".Connection::inject($criterio["permisos_x_area_id"]);
			}
			if(isset ($criterio["area_id"]) && trim($criterio["area_id"]) != "0"){
				$PreparedStatement .=" AND area_id = ".Connection::inject($criterio["area_id"]);
			}
			if(isset ($criterio["archivo"]) && trim($criterio["archivo"]) != "0"){
				$PreparedStatement .=" AND archivo LIKE '%".Connection::inject($criterio["archivo"])."%'";
			}
			if(isset ($criterio["insertar"]) && trim($criterio["insertar"]) != "0"){
				$PreparedStatement .=" AND insertar = ".Connection::inject($criterio["insertar"]);
			}
			if(isset ($criterio["borrar"]) && trim($criterio["borrar"]) != "0"){
				$PreparedStatement .=" AND borrar = ".Connection::inject($criterio["borrar"]);
			}
			if(isset ($criterio["reporte"]) && trim($criterio["reporte"]) != "0"){
				$PreparedStatement .=" AND reporte = ".Connection::inject($criterio["reporte"]);
			}
			if(isset ($criterio["actualizar"]) && trim($criterio["actualizar"]) != "0"){
				$PreparedStatement .=" AND actualizar = ".Connection::inject($criterio["actualizar"]);
			}
			if(isset ($criterio["consultar"]) && trim($criterio["consultar"]) != "0"){
				$PreparedStatement .=" AND consultar = ".Connection::inject($criterio["consultar"]);
			}
			if(isset ($criterio["observaciones"]) && trim($criterio["observaciones"]) != "0"){
				$PreparedStatement .=" AND observaciones = ".Connection::inject($criterio["observaciones"]);
			}
			return $PreparedStatement;
		}
	}
?>