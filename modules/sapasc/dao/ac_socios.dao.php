<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."\cnx\connection.php");
	include_once (dirname(dirname(__FILE__))."\dto\ac_socios.dto.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."\lib\logs.php");

	class ac_sociosDAO {
		private $connection;
 
		function ac_sociosDAO(){
		}

		/**
		* Añade un Registro
		*
		* @param ac_sociosTO $elem
		* @return int Filas Afectadas
		*/
		function insertac_socios(ac_sociosTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "INSERT INTO asapasc.ac_socios (socio_id,grupo_id,nro_medidor,marca_medidor,nombres,apellidos,ci,ci_expedido_en,direccion,comunidad_id,zona,registrado_por,fecha_registro ) VALUES (
				".Connection::inject($elem->getSocio_id()).",
				".Connection::inject($elem->getGrupo_id()).",
				'".Connection::inject($elem->getNro_medidor())."',
				'".Connection::inject($elem->getMarca_medidor())."',
				'".Connection::inject($elem->getNombres())."',
				'".Connection::inject($elem->getApellidos())."',
				".Connection::inject($elem->getCi()).",
				'".Connection::inject($elem->getCi_expedido_en())."',
				'".Connection::inject($elem->getDireccion())."',
				".Connection::inject($elem->getComunidad_id()).",
				'".Connection::inject($elem->getZona())."',
				'".Connection::inject($elem->getRegistrado_por())."',
				'".Connection::inject($elem->getFecha_registro())."'  );";

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
		* @param ac_sociosTO $elem
		* @return int Filas Afectadas
		*/
		function updateac_socios(ac_sociosTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "UPDATE asapasc.ac_socios SET  
				grupo_id = ".Connection::inject($elem->getGrupo_id()).",
				nro_medidor = '".Connection::inject($elem->getNro_medidor())."',
				marca_medidor = '".Connection::inject($elem->getMarca_medidor())."',
				nombres = '".Connection::inject($elem->getNombres())."',
				apellidos = '".Connection::inject($elem->getApellidos())."',
				ci = ".Connection::inject($elem->getCi()).",
				ci_expedido_en = '".Connection::inject($elem->getCi_expedido_en())."',
				direccion = '".Connection::inject($elem->getDireccion())."',
				comunidad_id = ".Connection::inject($elem->getComunidad_id()).",
				zona = '".Connection::inject($elem->getZona())."',
				registrado_por = '".Connection::inject($elem->getRegistrado_por())."',
				fecha_registro = '".Connection::inject($elem->getFecha_registro())."' 
			WHERE socio_id = ". Connection::inject($elem->getSocio_id()).";" ;

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
		* @param ac_sociosTO $elem
		* @return int Filas Afectadas
		*/
		function deleteac_socios(ac_sociosTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "DELETE FROM asapasc.ac_socios WHERE socio_id = ". Connection::inject($elem->getSocio_id()).";";

			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
			if($ResultSet)
				return mysql_affected_rows();
			else
				throw new Exception(ERROR_DELETE);

		}

		/**
		* Obtiene un objeto ac_sociosTO
		*
		* @return ac_sociosTO elem
		*/
		function selectByIdac_socios($socio_id){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT socio_id, grupo_id, nro_medidor, marca_medidor, nombres, apellidos, ci, ci_expedido_en, direccion, comunidad_id, zona, registrado_por, fecha_registro   FROM asapasc.ac_socios WHERE socio_id = ".Connection::inject($socio_id)." ;";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$elem = new ac_sociosTO();
			while($row = mysql_fetch_array($ResultSet)){
				$elem = new ac_sociosTO();
				$elem->setSocio_id($row['socio_id']);
				$elem->setGrupo_id($row['grupo_id']);
				$elem->setNro_medidor($row['nro_medidor']);
				$elem->setMarca_medidor($row['marca_medidor']);
				$elem->setNombres($row['nombres']);
				$elem->setApellidos($row['apellidos']);
				$elem->setCi($row['ci']);
				$elem->setCi_expedido_en($row['ci_expedido_en']);
				$elem->setDireccion($row['direccion']);
				$elem->setComunidad_id($row['comunidad_id']);
				$elem->setZona($row['zona']);
				$elem->setRegistrado_por($row['registrado_por']);
				$elem->setFecha_registro($row['fecha_registro']);

			}
			mysql_free_result($ResultSet);
			return $elem;
		}

		/**
		* Obtiene la cantidad de filas de la tabla
		*
		* @return int $rows
		*/
		function selectCountac_socios($criterio){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT COUNT(*) AS count FROM asapasc.ac_socios WHERE socio_id = socio_id ";
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
		* @return ArrayObject ac_sociosTO
		* @param array $criterio
		*/
		function selectByCriteria_ac_socios($criterio,$page_number){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT socio_id, grupo_id, nro_medidor, marca_medidor, nombres, apellidos, ci, ci_expedido_en, direccion, comunidad_id, zona, registrado_por, fecha_registro,
                                                 (SELECT nombre_grupo FROM asapasc.ac_grupos_socios WHERE grupo_id = asapasc.ac_socios.grupo_id) AS grupo, 
                                                 (SELECT valor FROM pa_parametros WHERE entidad = 'AC_COMUNIDAD' AND parametro_id =  asapasc.ac_socios.comunidad_id) AS comunidad 
						 FROM asapasc.ac_socios WHERE socio_id = socio_id ";

			$PreparedStatement = $this->defineCriterias($criterio,$PreparedStatement);
			$PreparedStatement .= " ORDER BY socio_id";
			if($page_number != -1)
				$PreparedStatement .= " LIMIT ".($page_number*TABLE_ROW_VIEW).",". ($page_number+1)*TABLE_ROW_VIEW."";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$arrayList = new ArrayObject();
			 while ($row = mysql_fetch_array($ResultSet)) {
				$elem = new ac_sociosTO();
				$elem->setSocio_id($row['socio_id']);
				$elem->setGrupo_id($row['grupo_id']);
				$elem->setNro_medidor($row['nro_medidor']);
				$elem->setMarca_medidor($row['marca_medidor']);
				$elem->setNombres($row['nombres']);
				$elem->setApellidos($row['apellidos']);
				$elem->setCi($row['ci']);
				$elem->setCi_expedido_en($row['ci_expedido_en']);
				$elem->setDireccion($row['direccion']);
				$elem->setComunidad_id($row['comunidad_id']);
				$elem->setZona($row['zona']);
				$elem->setRegistrado_por($row['registrado_por']);
				$elem->setFecha_registro($row['fecha_registro']);
                                $elem->setComunidad($row['comunidad']);
                                $elem->setGrupo($row['grupo']);
                                
				$arrayList->append($elem);
			}
			mysql_free_result($ResultSet);
			return $arrayList;
		}


		/**
		* Define los criterios del Where
		*
		* @return String $PreparedStatement ac_sociosTO
		* @param String $PreparedStatement
		* @param array $criterio
		*/
		function defineCriterias($criterio,$PreparedStatement){
			if(isset ($criterio["socio_id"]) && trim($criterio["socio_id"]) != "0"){
				$PreparedStatement .=" AND socio_id = ".Connection::inject($criterio["socio_id"]);
			}
			if(isset ($criterio["grupo_id"]) && trim($criterio["grupo_id"]) != "0"){
				$PreparedStatement .=" AND grupo_id = ".Connection::inject($criterio["grupo_id"]);
			}
			if(isset ($criterio["nro_medidor"]) && trim($criterio["nro_medidor"]) != "0"){
				$PreparedStatement .=" AND nro_medidor LIKE '%".Connection::inject($criterio["nro_medidor"])."%'";
			}
			if(isset ($criterio["marca_medidor"]) && trim($criterio["marca_medidor"]) != "0"){
				$PreparedStatement .=" AND marca_medidor = ".Connection::inject($criterio["marca_medidor"]);
			}
			if(isset ($criterio["nombres"]) && trim($criterio["nombres"]) != "0"){
				$PreparedStatement .=" AND nombres LIKE '%".Connection::inject($criterio["nombres"])."%'";
			}
			if(isset ($criterio["apellidos"]) && trim($criterio["apellidos"]) != "0"){
				$PreparedStatement .=" AND apellidos LIKE '%".Connection::inject($criterio["apellidos"])."%'";
			}
			if(isset ($criterio["ci"]) && trim($criterio["ci"]) != "0"){
				$PreparedStatement .=" AND ci = ".Connection::inject($criterio["ci"]);
			}
			if(isset ($criterio["ci_expedido_en"]) && trim($criterio["ci_expedido_en"]) != "0"){
				$PreparedStatement .=" AND ci_expedido_en = ".Connection::inject($criterio["ci_expedido_en"]);
			}
			if(isset ($criterio["direccion"]) && trim($criterio["direccion"]) != "0"){
				$PreparedStatement .=" AND direccion = ".Connection::inject($criterio["direccion"]);
			}
			if(isset ($criterio["comunidad_id"]) && trim($criterio["comunidad_id"]) != "0"){
				$PreparedStatement .=" AND comunidad_id = ".Connection::inject($criterio["comunidad_id"]);
			}
			if(isset ($criterio["zona"]) && trim($criterio["zona"]) != "0"){
				$PreparedStatement .=" AND zona = ".Connection::inject($criterio["zona"]);
			}
			if(isset ($criterio["registrado_por"]) && trim($criterio["registrado_por"]) != "0"){
				$PreparedStatement .=" AND registrado_por = ".Connection::inject($criterio["registrado_por"]);
			}
			if(isset ($criterio["fecha_registro"]) && trim($criterio["fecha_registro"]) != "0"){
				$PreparedStatement .=" AND fecha_registro = ".Connection::inject($criterio["fecha_registro"]);
			}
			return $PreparedStatement;
		}
	}
?>