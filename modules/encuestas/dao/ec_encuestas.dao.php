<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/cnx/connection.php");
	include_once (dirname(dirname(__FILE__))."/dto/ec_encuestas.dto.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."/lib/logs.php");

	class ec_encuestasDAO {
		private $connection;
 
		function ec_encuestasDAO(){
		}

		/**
		* Añade un Registro
		*
		* @param ec_encuestasTO $elem
		* @return int Filas Afectadas
		*/
		function insertec_encuestas(ec_encuestasTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "INSERT INTO ec_encuestas (encuesta_id,empresa_id,nombre,descripcion,fecha_inicio,fecha_fin,es_anonimo,acuerdo ) VALUES (
				".Connection::inject($elem->getEncuesta_id()).",
				".Connection::inject($elem->getEmpresa_id()).",
				'".Connection::inject($elem->getNombre())."',
				'".Connection::inject($elem->getDescripcion())."',
				'".Connection::inject($elem->getFecha_inicio())."',
				'".Connection::inject($elem->getFecha_fin())."',
				'".Connection::inject($elem->getEs_anonimo())."',
                                '".Connection::inject($elem->getAcuerdo())."'    );";

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
		* @param ec_encuestasTO $elem
		* @return int Filas Afectadas
		*/
		function updateec_encuestas(ec_encuestasTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "UPDATE ec_encuestas SET  
				empresa_id = ".Connection::inject($elem->getEmpresa_id()).",
				nombre = '".Connection::inject($elem->getNombre())."',
				descripcion = '".Connection::inject($elem->getDescripcion())."',
				fecha_inicio = '".Connection::inject($elem->getFecha_inicio())."',
				fecha_fin = '".Connection::inject($elem->getFecha_fin())."',
				es_anonimo = '".Connection::inject($elem->getEs_anonimo())."',
                                acuerdo = '".Connection::inject($elem->getAcuerdo())."'    
			WHERE encuesta_id = ". Connection::inject($elem->getEncuesta_id()).";" ;

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
		* @param ec_encuestasTO $elem
		* @return int Filas Afectadas
		*/
		function deleteec_encuestas(ec_encuestasTO $elem){
			$this->connection = Connection::getinstance()->getConn();
                        //--
                        $PreparedStatement = "DELETE FROM ec_resultados WHERE encuesta_id = ". Connection::inject($elem->getEncuesta_id()).";";
                        $PreparedStatement .= "DELETE FROM ec_resultados_maestro WHERE encuesta_id = ". Connection::inject($elem->getEncuesta_id()).";";
                        $PreparedStatement .= "DELETE FROM ec_valores_respuesta WHERE pregunta_id IN(SELECT pregunta_id FROM ec_preguntas WHERE encuesta_id = ". Connection::inject($elem->getEncuesta_id()).");";
                        $PreparedStatement .= "DELETE FROM ec_preguntas WHERE encuesta_id = ". Connection::inject($elem->getEncuesta_id()).";";
                        $PreparedStatement .= "DELETE FROM ec_grupos_preguntas WHERE encuesta_id = ". Connection::inject($elem->getEncuesta_id()).";";
                        $PreparedStatement .= "DELETE FROM ec_encuestas WHERE encuesta_id = ". Connection::inject($elem->getEncuesta_id()).";";
                        $ResultSet = mysql_query($PreparedStatement,$this->connection);
                        logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

                        if($ResultSet)
				return mysql_affected_rows();
			else
				throw new Exception(ERROR_DELETE);

		}

		/**
		* Obtiene un objeto ec_encuestasTO
		*
		* @return ec_encuestasTO elem
		*/
		function selectByIdec_encuestas($encuesta_id, $criterio = null){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT encuesta_id, empresa_id, nombre, descripcion, fecha_inicio, fecha_fin, es_anonimo, acuerdo   FROM ec_encuestas WHERE encuesta_id = ".Connection::inject($encuesta_id)." ";
                        if(isset($criterio) && isset($criterio["valid_date"])){
                            $PreparedStatement .= " AND sysdate() BETWEEN fecha_inicio AND fecha_fin;";
                        }
                        
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$elem = new ec_encuestasTO();
			while($row = mysql_fetch_array($ResultSet)){
				$elem = new ec_encuestasTO();
				$elem->setEncuesta_id($row['encuesta_id']);
				$elem->setEmpresa_id($row['empresa_id']);
				$elem->setNombre($row['nombre']);
				$elem->setDescripcion($row['descripcion']);
				$elem->setFecha_inicio($row['fecha_inicio']);
				$elem->setFecha_fin($row['fecha_fin']);
				$elem->setEs_anonimo($row['es_anonimo']);
                                $elem->setAcuerdo($row['acuerdo']);

			}
			mysql_free_result($ResultSet);
			return $elem;
		}
                

		/**
		* Obtiene la cantidad de filas de la tabla
		*
		* @return int $rows
		*/
		function selectCountec_encuestas($criterio){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT COUNT(*) AS count FROM ec_encuestas WHERE encuesta_id = encuesta_id ";
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
		* @return ArrayObject ec_encuestasTO
		* @param array $criterio
		*/
		function selectByCriteria_ec_encuestas($criterio,$page_number){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT encuesta_id, empresa_id, nombre, descripcion, fecha_inicio, fecha_fin, es_anonimo, acuerdo, 
                                                 (SELECT nombre FROM ec_empresas WHERE empresa_id = ec_encuestas.empresa_id) AS empresa 
						 FROM ec_encuestas WHERE encuesta_id = encuesta_id ";

			$PreparedStatement = $this->defineCriterias($criterio,$PreparedStatement);
			$PreparedStatement .= " ORDER BY encuesta_id";
			if($page_number != -1)
				$PreparedStatement .= " LIMIT ".($page_number*TABLE_ROW_VIEW).",". ($page_number+1)*TABLE_ROW_VIEW."";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$arrayList = new ArrayObject();
			 while ($row = mysql_fetch_array($ResultSet)) {
				$elem = new ec_encuestasTO();
				$elem->setEncuesta_id($row['encuesta_id']);
				$elem->setEmpresa_id($row['empresa_id']);
				$elem->setNombre($row['nombre']);
				$elem->setDescripcion($row['descripcion']);
				$elem->setFecha_inicio($row['fecha_inicio']);
				$elem->setFecha_fin($row['fecha_fin']);
				$elem->setEs_anonimo($row['es_anonimo']);
                                $elem->setEmpresa($row['empresa']);
                                $elem->setAcuerdo($row['acuerdo']);
                                
				$arrayList->append($elem);
			}
			mysql_free_result($ResultSet);
			return $arrayList;
		}


		/**
		* Define los criterios del Where
		*
		* @return String $PreparedStatement ec_encuestasTO
		* @param String $PreparedStatement
		* @param array $criterio
		*/
		function defineCriterias($criterio,$PreparedStatement){
			if(isset ($criterio["encuesta_id"]) && trim($criterio["encuesta_id"]) != "0"){
				$PreparedStatement .=" AND encuesta_id = ".Connection::inject($criterio["encuesta_id"]);
			}
			if(isset ($criterio["empresa_id"]) && trim($criterio["empresa_id"]) != "0"){
				$PreparedStatement .=" AND empresa_id = ".Connection::inject($criterio["empresa_id"]);
			}
			if(isset ($criterio["nombre"]) && trim($criterio["nombre"]) != "0"){
				$PreparedStatement .=" AND nombre LIKE '%".Connection::inject($criterio["nombre"])."%'";
			}
			if(isset ($criterio["descripcion"]) && trim($criterio["descripcion"]) != "0"){
				$PreparedStatement .=" AND descripcion = ".Connection::inject($criterio["descripcion"]);
			}
			if(isset ($criterio["fecha_inicio"]) && trim($criterio["fecha_inicio"]) != "0"){
				$PreparedStatement .=" AND fecha_inicio = ".Connection::inject($criterio["fecha_inicio"]);
			}
			if(isset ($criterio["fecha_fin"]) && trim($criterio["fecha_fin"]) != "0"){
				$PreparedStatement .=" AND fecha_fin = ".Connection::inject($criterio["fecha_fin"]);
			}
			if(isset ($criterio["es_anonimo"]) && trim($criterio["es_anonimo"]) != "0"){
				$PreparedStatement .=" AND es_anonimo = ".Connection::inject($criterio["es_anonimo"]);
			}
			return $PreparedStatement;
		}
	}
?>