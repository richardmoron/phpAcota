<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/cnx/connection.php");
	include_once (dirname(dirname(__FILE__))."/dto/pa_noticias.dto.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/logs.php");

	class pa_noticiasDAO {
		private $connection;
 
		function pa_noticiasDAO(){
		}

		/**
		* Añade un Registro
		*
		* @param pa_noticiasTO $elem
		* @return int Filas Afectadas
		*/
		function insertpa_noticias(pa_noticiasTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "INSERT INTO pa_noticias (noticia_id,titulo,descripcion,fecha_registro,fecha_desde,fecha_hasta,registrado_por,tipo_id,area_id ) VALUES (
				".Connection::inject($elem->getNoticia_id()).",
				'".Connection::inject($elem->getTitulo())."',
				'".Connection::inject($elem->getDescripcion())."',
				'".Connection::inject($elem->getFecha_registro())."',
				'".Connection::inject($elem->getFecha_desde())."',
				'".Connection::inject($elem->getFecha_hasta())."',
				".Connection::inject($elem->getRegistrado_por()).",
				".Connection::inject($elem->getTipo_id()).",
				".Connection::inject($elem->getArea_id())."  );";

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
		* @param pa_noticiasTO $elem
		* @return int Filas Afectadas
		*/
		function updatepa_noticias(pa_noticiasTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "UPDATE pa_noticias SET  
				titulo = '".Connection::inject($elem->getTitulo())."',
				descripcion = '".Connection::inject($elem->getDescripcion())."',
				fecha_registro = '".Connection::inject($elem->getFecha_registro())."',
				fecha_desde = '".Connection::inject($elem->getFecha_desde())."',
				fecha_hasta = '".Connection::inject($elem->getFecha_hasta())."',
				registrado_por = ".Connection::inject($elem->getRegistrado_por()).",
				tipo_id = ".Connection::inject($elem->getTipo_id()).",
				area_id = ".Connection::inject($elem->getArea_id())." 
			WHERE noticia_id = ". Connection::inject($elem->getNoticia_id()).";" ;

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
		* @param pa_noticiasTO $elem
		* @return int Filas Afectadas
		*/
		function deletepa_noticias(pa_noticiasTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "DELETE FROM pa_noticias WHERE noticia_id = ". Connection::inject($elem->getNoticia_id()).";";

			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
			if($ResultSet)
				return mysql_affected_rows();
			else
				throw new Exception(ERROR_DELETE);

		}

		/**
		* Obtiene un objeto pa_noticiasTO
		*
		* @return pa_noticiasTO elem
		*/
		function selectByIdpa_noticias($noticia_id){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT noticia_id, titulo, descripcion, fecha_registro, fecha_desde, fecha_hasta, registrado_por, tipo_id, area_id,
                                                (SELECT usuario FROM pa_usuarios WHERE usuario_id = pa_noticias.registrado_por) AS registrado_porstr 
                                                FROM pa_noticias WHERE noticia_id = ".Connection::inject($noticia_id)." ;";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$elem = new pa_noticiasTO();
			while($row = mysql_fetch_array($ResultSet)){
				$elem = new pa_noticiasTO();
				$elem->setNoticia_id($row['noticia_id']);
				$elem->setTitulo($row['titulo']);
				$elem->setDescripcion($row['descripcion']);
				$elem->setFecha_registro($row['fecha_registro']);
				$elem->setFecha_desde($row['fecha_desde']);
				$elem->setFecha_hasta($row['fecha_hasta']);
				$elem->setRegistrado_por($row['registrado_por']);
				$elem->setTipo_id($row['tipo_id']);
				$elem->setArea_id($row['area_id']);
                                $elem->setRegistrado_porstr($row['registrado_porstr']);
			}
			mysql_free_result($ResultSet);
			return $elem;
		}

		/**
		* Obtiene la cantidad de filas de la tabla
		*
		* @return int $rows
		*/
		function selectCountpa_noticias($criterio){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT COUNT(*) AS count FROM pa_noticias WHERE noticia_id = noticia_id ";
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
		* @return ArrayObject pa_noticiasTO
		* @param array $criterio
		*/
		function selectByCriteria_pa_noticias($criterio,$page_number){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT noticia_id, titulo, descripcion, fecha_registro, fecha_desde, fecha_hasta, registrado_por, tipo_id, area_id,
                                                (SELECT valor FROM pa_parametros WHERE parametro_id = pa_noticias.tipo_id AND entidad = 'NOTICIAS') AS tipo,
                                                (SELECT nombre_area FROM pa_areas WHERE area_id = pa_noticias.area_id) AS area 
						 FROM pa_noticias WHERE noticia_id = noticia_id ";

			$PreparedStatement = $this->defineCriterias($criterio,$PreparedStatement);
			$PreparedStatement .= " ORDER BY noticia_id";
			if($page_number != -1)
				$PreparedStatement .= " LIMIT ".($page_number*TABLE_ROW_VIEW).",". ($page_number+1)*TABLE_ROW_VIEW."";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$arrayList = new ArrayObject();
			 while ($row = mysql_fetch_array($ResultSet)) {
				$elem = new pa_noticiasTO();
				$elem->setNoticia_id($row['noticia_id']);
				$elem->setTitulo($row['titulo']);
				$elem->setDescripcion($row['descripcion']);
				$elem->setFecha_registro($row['fecha_registro']);
				$elem->setFecha_desde($row['fecha_desde']);
				$elem->setFecha_hasta($row['fecha_hasta']);
				$elem->setRegistrado_por($row['registrado_por']);
				$elem->setTipo_id($row['tipo_id']);
				$elem->setArea_id($row['area_id']);
                                $elem->setTipo($row['tipo']);
				$elem->setArea($row['area']);

				$arrayList->append($elem);
			}
			mysql_free_result($ResultSet);
			return $arrayList;
		}


		/**
		* Define los criterios del Where
		*
		* @return String $PreparedStatement pa_noticiasTO
		* @param String $PreparedStatement
		* @param array $criterio
		*/
		function defineCriterias($criterio,$PreparedStatement){
			if(isset ($criterio["noticia_id"]) && trim($criterio["noticia_id"]) != "0"){
				$PreparedStatement .=" AND noticia_id = ".Connection::inject($criterio["noticia_id"]);
			}
			if(isset ($criterio["titulo"]) && trim($criterio["titulo"]) != "0"){
				$PreparedStatement .=" AND titulo LIKE '%".Connection::inject($criterio["titulo"])."%'";
			}
			if(isset ($criterio["descripcion"]) && trim($criterio["descripcion"]) != "0"){
				$PreparedStatement .=" AND descripcion = ".Connection::inject($criterio["descripcion"]);
			}
			if(isset ($criterio["fecha_registro"]) && trim($criterio["fecha_registro"]) != "0"){
				$PreparedStatement .=" AND fecha_registro = ".Connection::inject($criterio["fecha_registro"]);
			}
			if(isset ($criterio["fecha_desde"]) && trim($criterio["fecha_desde"]) != "0"){
				$PreparedStatement .=" AND fecha_desde = ".Connection::inject($criterio["fecha_desde"]);
			}
			if(isset ($criterio["fecha_hasta"]) && trim($criterio["fecha_hasta"]) != "0"){
				$PreparedStatement .=" AND fecha_hasta = ".Connection::inject($criterio["fecha_hasta"]);
			}
                        if(isset ($criterio["fecha_desde_hasta"]) && trim($criterio["fecha_desde_hasta"]) != "0"){
				$PreparedStatement .=" AND DATE(NOW()) BETWEEN fecha_desde AND fecha_hasta";
			}
			if(isset ($criterio["registrado_por"]) && trim($criterio["registrado_por"]) != "0"){
				$PreparedStatement .=" AND registrado_por = ".Connection::inject($criterio["registrado_por"]);
			}
			if(isset ($criterio["tipo_id"]) && trim($criterio["tipo_id"]) != "0"){
				$PreparedStatement .=" AND tipo_id = ".Connection::inject($criterio["tipo_id"]);
			}
			if(isset ($criterio["area_id"]) && trim($criterio["area_id"]) != "0"){
				$PreparedStatement .=" AND area_id = ".Connection::inject($criterio["area_id"]);
			}
			return $PreparedStatement;
		}
	}
?>