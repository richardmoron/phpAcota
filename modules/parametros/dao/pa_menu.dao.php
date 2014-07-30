<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/cnx/connection.php");
	include_once (dirname(dirname(__FILE__))."/dto/pa_menu.dto.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/logs.php");

	class pa_menuDAO {
		private $connection;
 
		function pa_menuDAO(){
		}

		/**
		* Añade un Registro
		*
		* @param pa_menuTO $elem
		* @return int Filas Afectadas
		*/
		function insertpa_menu(pa_menuTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "INSERT INTO pa_menu (menu_id,nombre,descripcion,link,menu_padre_id,area_id,es_padre,exclusivo,complemento,posicion, tab ) VALUES (
				".Connection::inject($elem->getMenu_id()).",
				'".Connection::inject($elem->getNombre())."',
				'".Connection::inject($elem->getDescripcion())."',
				'".Connection::inject($elem->getLink())."',
				".Connection::inject($elem->getMenu_padre_id()).",
				".Connection::inject($elem->getArea_id()).",
				'".Connection::inject($elem->getEs_padre())."',
				'".Connection::inject($elem->getExclusivo())."',
				'".Connection::inject($elem->getComplemento())."',
				".Connection::inject($elem->getPosicion()).",
                                '".Connection::inject($elem->getTab())."');";

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
		* @param pa_menuTO $elem
		* @return int Filas Afectadas
		*/
		function updatepa_menu(pa_menuTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "UPDATE pa_menu SET  
				nombre = '".Connection::inject($elem->getNombre())."',
				descripcion = '".Connection::inject($elem->getDescripcion())."',
				link = '".Connection::inject($elem->getLink())."',
				menu_padre_id = ".Connection::inject($elem->getMenu_padre_id()).",
				area_id = ".Connection::inject($elem->getArea_id()).",
				es_padre = '".Connection::inject($elem->getEs_padre())."',
				exclusivo = '".Connection::inject($elem->getExclusivo())."',
				complemento = '".Connection::inject($elem->getComplemento())."',
				posicion = ".Connection::inject($elem->getPosicion()).",
                                tab = '".Connection::inject($elem->getTab())."' 
			WHERE menu_id = ". Connection::inject($elem->getMenu_id()).";" ;

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
		* @param pa_menuTO $elem
		* @return int Filas Afectadas
		*/
		function deletepa_menu(pa_menuTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "DELETE FROM pa_menu WHERE menu_id = ". Connection::inject($elem->getMenu_id()).";";

			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
			if($ResultSet)
				return mysql_affected_rows();
			else
				throw new Exception(ERROR_DELETE);

		}

		/**
		* Obtiene un objeto pa_menuTO
		*
		* @return pa_menuTO elem
		*/
		function selectByIdpa_menu($menu_id){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT menu_id, nombre, descripcion, link, menu_padre_id, area_id, es_padre, exclusivo, complemento, posicion, tab, 
                                                (SELECT nombre FROM pa_menu WHERE menu_id = pa_menu_tmp.menu_padre_id) AS menu_padre 
                                                FROM pa_menu AS pa_menu_tmp WHERE menu_id = ".Connection::inject($menu_id)." ;";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$elem = new pa_menuTO();
			while($row = mysql_fetch_array($ResultSet)){
				$elem = new pa_menuTO();
				$elem->setMenu_id($row['menu_id']);
				$elem->setNombre($row['nombre']);
				$elem->setDescripcion($row['descripcion']);
				$elem->setLink($row['link']);
				$elem->setMenu_padre_id($row['menu_padre_id']);
				$elem->setArea_id($row['area_id']);
				$elem->setEs_padre($row['es_padre']);
				$elem->setExclusivo($row['exclusivo']);
				$elem->setComplemento($row['complemento']);
				$elem->setPosicion($row['posicion']);
                                $elem->setMenu_padre($row['menu_padre']);
                                $elem->setTab($row['tab']);
			}
			mysql_free_result($ResultSet);
			return $elem;
		}

		/**
		* Obtiene la cantidad de filas de la tabla
		*
		* @return int $rows
		*/
		function selectCountpa_menu($criterio){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT COUNT(*) AS count FROM pa_menu WHERE menu_id = menu_id ";
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
		* @return ArrayObject pa_menuTO
		* @param array $criterio
		*/
		function selectByCriteria_pa_menu($criterio,$page_number){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT menu_id, nombre, descripcion, link, menu_padre_id, area_id, es_padre, exclusivo, complemento, posicion, tab, 
                                                (SELECT nombre FROM pa_menu WHERE menu_id = pa_menu_tmp.menu_padre_id) AS menu_padre 
						 FROM pa_menu AS pa_menu_tmp WHERE menu_id = menu_id ";

			$PreparedStatement = $this->defineCriterias($criterio,$PreparedStatement);
                        if($page_number != -1)
                            $PreparedStatement .= " ORDER BY menu_id LIMIT ".($page_number*TABLE_ROW_VIEW).",". ($page_number+1)*TABLE_ROW_VIEW."";
                        
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$arrayList = new ArrayObject();
			 while ($row = mysql_fetch_array($ResultSet)) {
				$elem = new pa_menuTO();
				$elem->setMenu_id($row['menu_id']);
				$elem->setNombre($row['nombre']);
				$elem->setDescripcion($row['descripcion']);
				$elem->setLink($row['link']);
				$elem->setMenu_padre_id($row['menu_padre_id']);
				$elem->setArea_id($row['area_id']);
				$elem->setEs_padre($row['es_padre']);
				$elem->setExclusivo($row['exclusivo']);
				$elem->setComplemento($row['complemento']);
				$elem->setPosicion($row['posicion']);
                                $elem->setMenu_padre($row['menu_padre']);
                                $elem->setTab($row['tab']);
                                
				$arrayList->append($elem);
			}
			mysql_free_result($ResultSet);
			return $arrayList;
		}


		/**
		* Define los criterios del Where
		*
		* @return String $PreparedStatement pa_menuTO
		* @param String $PreparedStatement
		* @param array $criterio
		*/
		function defineCriterias($criterio,$PreparedStatement){
			if(isset ($criterio["menu_id"]) && trim($criterio["menu_id"]) != "0"){
				$PreparedStatement .=" AND menu_id = ".Connection::inject($criterio["menu_id"]);
			}
			if(isset ($criterio["nombre"]) && trim($criterio["nombre"]) != "0"){
				$PreparedStatement .=" AND nombre LIKE '%".Connection::inject($criterio["nombre"])."%'";
			}
			if(isset ($criterio["descripcion"]) && trim($criterio["descripcion"]) != "0"){
				$PreparedStatement .=" AND descripcion = ".Connection::inject($criterio["descripcion"]);
			}
			if(isset ($criterio["link"]) && trim($criterio["link"]) != "0"){
				$PreparedStatement .=" AND link = ".Connection::inject($criterio["link"]);
			}
			if(isset ($criterio["menu_padre_id"]) && trim($criterio["menu_padre_id"]) != ""){
				$PreparedStatement .=" AND menu_padre_id = ".Connection::inject($criterio["menu_padre_id"]);
			}
			if(isset ($criterio["area_id"]) && trim($criterio["area_id"]) != "0"){
				$PreparedStatement .=" AND area_id = ".Connection::inject($criterio["area_id"]);
			}
			if(isset ($criterio["es_padre"]) && trim($criterio["es_padre"]) != "0"){
				$PreparedStatement .=" AND es_padre = '".Connection::inject($criterio["es_padre"])."'";
			}
			if(isset ($criterio["exclusivo"]) && trim($criterio["exclusivo"]) != "0"){
				$PreparedStatement .=" AND exclusivo = '".Connection::inject($criterio["exclusivo"])."'";
			}
			if(isset ($criterio["complemento"]) && trim($criterio["complemento"]) != "0"){
				$PreparedStatement .=" AND complemento = ".Connection::inject($criterio["complemento"]);
			}
			if(isset ($criterio["posicion"]) && trim($criterio["posicion"]) != "0"){
				$PreparedStatement .=" AND posicion = ".Connection::inject($criterio["posicion"]);
			}
			return $PreparedStatement;
		}
                
                /**
		* Arma el menú principal de los items padres
		*
		* @return ArrayObject pa_menuTO
		* @param array $criterio
		*/
		function selectMain_pa_menu($criterio,$page_number){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT * FROM pa_menu WHERE menu_padre_id = ".Connection::inject($criterio["menu_padre_id"]); 
                                                if(isset($criterio["es_padre"]) && trim($criterio["es_padre"]) != "")
                                                    $PreparedStatement .= " AND es_padre = '".Connection::inject($criterio["es_padre"])."'";
                        $PreparedStatement .=" AND ".$criterio["pivot"]." IN (
                                                SELECT menu_id FROM pa_menu_accesos_x_area WHERE area_id = (SELECT area_id FROM pa_usuarios WHERE usuario = '".Connection::inject($criterio["usuario"])."') AND exclusivo = 'N' 
                                                UNION ALL
                                                SELECT menu_id FROM pa_menu_accesos_x_usuario WHERE usuario_id = (SELECT usuario_id FROM pa_usuarios WHERE usuario = '".Connection::inject($criterio["usuario"])."')
                                                )";

//			$PreparedStatement = $this->defineCriterias($criterio,$PreparedStatement);
                        $PreparedStatement .= " ORDER BY posicion ";
                        if($page_number != -1)
                            $PreparedStatement .= "  LIMIT ".($page_number*TABLE_ROW_VIEW).",". ($page_number+1)*TABLE_ROW_VIEW."";
                        
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$arrayList = new ArrayObject();
			 while ($row = mysql_fetch_array($ResultSet)) {
				$elem = new pa_menuTO();
				$elem->setMenu_id($row['menu_id']);
				$elem->setNombre($row['nombre']);
				$elem->setDescripcion($row['descripcion']);
				$elem->setLink($row['link']);
				$elem->setMenu_padre_id($row['menu_padre_id']);
				$elem->setArea_id($row['area_id']);
				$elem->setEs_padre($row['es_padre']);
				$elem->setExclusivo($row['exclusivo']);
				$elem->setComplemento($row['complemento']);
				$elem->setPosicion($row['posicion']);
                                $elem->setTab($row['tab']);
                                
				$arrayList->append($elem);
			}
			mysql_free_result($ResultSet);
			return $arrayList;
		}
	}
?>