<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/cnx/connection.php");
	include_once (dirname(dirname(__FILE__))."/dto/pa_menu_accesos_x_area.dto.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/logs.php");

	class pa_menu_accesos_x_areaDAO {
		private $connection;
 
		function pa_menu_accesos_x_areaDAO(){
		}

		/**
		* Añade un Registro
		*
		* @param pa_menu_accesos_x_areaTO $elem
		* @return int Filas Afectadas
		*/
		function insertpa_menu_accesos_x_area(pa_menu_accesos_x_areaTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "INSERT INTO pa_menu_accesos_x_area (menu_acceso_area_id,area_id,menu_id,observaciones ) VALUES (
				".Connection::inject($elem->getMenu_acceso_area_id()).",
				".Connection::inject($elem->getArea_id()).",
				".Connection::inject($elem->getMenu_id()).",
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
		* @param pa_menu_accesos_x_areaTO $elem
		* @return int Filas Afectadas
		*/
		function updatepa_menu_accesos_x_area(pa_menu_accesos_x_areaTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "UPDATE pa_menu_accesos_x_area SET  
				area_id = ".Connection::inject($elem->getArea_id()).",
				menu_id = ".Connection::inject($elem->getMenu_id()).",
				observaciones = '".Connection::inject($elem->getObservaciones())."' 
			WHERE menu_acceso_area_id = ". Connection::inject($elem->getMenu_acceso_area_id()).";" ;

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
		* @param pa_menu_accesos_x_areaTO $elem
		* @return int Filas Afectadas
		*/
		function deletepa_menu_accesos_x_area(pa_menu_accesos_x_areaTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "DELETE FROM pa_menu_accesos_x_area WHERE menu_acceso_area_id = ". Connection::inject($elem->getMenu_acceso_area_id()).";";

			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
			if($ResultSet)
				return mysql_affected_rows();
			else
				throw new Exception(ERROR_DELETE);

		}

		/**
		* Obtiene un objeto pa_menu_accesos_x_areaTO
		*
		* @return pa_menu_accesos_x_areaTO elem
		*/
		function selectByIdpa_menu_accesos_x_area($menu_acceso_area_id){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT menu_acceso_area_id, area_id, menu_id, observaciones,
                                                    (SELECT nombre FROM pa_menu WHERE menu_id = pa_menu_accesos_x_area.menu_id) AS menu 
                                                    FROM pa_menu_accesos_x_area WHERE menu_acceso_area_id = ".Connection::inject($menu_acceso_area_id)." ;";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$elem = new pa_menu_accesos_x_areaTO();
			while($row = mysql_fetch_array($ResultSet)){
				$elem = new pa_menu_accesos_x_areaTO();
				$elem->setMenu_acceso_area_id($row['menu_acceso_area_id']);
				$elem->setArea_id($row['area_id']);
				$elem->setMenu_id($row['menu_id']);
				$elem->setObservaciones($row['observaciones']);
                                $elem->setMenu($row['menu']);
			}   
			mysql_free_result($ResultSet);
			return $elem;
		}

		/**
		* Obtiene la cantidad de filas de la tabla
		*
		* @return int $rows
		*/
		function selectCountpa_menu_accesos_x_area($criterio){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT COUNT(*) AS count FROM pa_menu_accesos_x_area WHERE menu_acceso_area_id = menu_acceso_area_id ";
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
		* @return ArrayObject pa_menu_accesos_x_areaTO
		* @param array $criterio
		*/
		function selectByCriteria_pa_menu_accesos_x_area($criterio,$page_number){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT menu_acceso_area_id, area_id, menu_id, observaciones,
                                                (SELECT nombre_area FROM pa_areas WHERE area_id = pa_menu_accesos_x_area.area_id) AS area, 
                                                (SELECT nombre FROM pa_menu WHERE menu_id = pa_menu_accesos_x_area.menu_id) AS menu 
						 FROM pa_menu_accesos_x_area WHERE menu_acceso_area_id = menu_acceso_area_id ";

			$PreparedStatement = $this->defineCriterias($criterio,$PreparedStatement);
			$PreparedStatement .= " ORDER BY menu_acceso_area_id LIMIT ".($page_number*TABLE_ROW_VIEW).",". ($page_number+1)*TABLE_ROW_VIEW."";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$arrayList = new ArrayObject();
			 while ($row = mysql_fetch_array($ResultSet)) {
				$elem = new pa_menu_accesos_x_areaTO();
				$elem->setMenu_acceso_area_id($row['menu_acceso_area_id']);
				$elem->setArea_id($row['area_id']);
				$elem->setMenu_id($row['menu_id']);
				$elem->setObservaciones($row['observaciones']);
                                $elem->setArea($row['area']);
				$elem->setMenu($row['menu']);
                                
				$arrayList->append($elem);
			}
			mysql_free_result($ResultSet);
			return $arrayList;
		}


		/**
		* Define los criterios del Where
		*
		* @return String $PreparedStatement pa_menu_accesos_x_areaTO
		* @param String $PreparedStatement
		* @param array $criterio
		*/
		function defineCriterias($criterio,$PreparedStatement){
			if(isset ($criterio["menu_acceso_area_id"]) && trim($criterio["menu_acceso_area_id"]) != "0"){
				$PreparedStatement .=" AND menu_acceso_area_id = ".Connection::inject($criterio["menu_acceso_area_id"]);
			}
			if(isset ($criterio["area_id"]) && trim($criterio["area_id"]) != "0"){
				$PreparedStatement .=" AND area_id = ".Connection::inject($criterio["area_id"]);
			}
			if(isset ($criterio["menu_id"]) && trim($criterio["menu_id"]) != "0"){
				$PreparedStatement .=" AND menu_id = ".Connection::inject($criterio["menu_id"]);
			}
			if(isset ($criterio["observaciones"]) && trim($criterio["observaciones"]) != "0"){
				$PreparedStatement .=" AND observaciones = ".Connection::inject($criterio["observaciones"]);
			}
			return $PreparedStatement;
		}
	}
?>