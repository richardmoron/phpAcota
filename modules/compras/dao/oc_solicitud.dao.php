<?php 
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."\cnx\connection.php");
	include_once (dirname(dirname(__FILE__))."\dto\oc_solicitud.dto.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."\lib\logs.php");

	class oc_solicitudDAO {
		private $connection;
 
		function oc_solicitudDAO(){
		}

		/**
		* Añade un Registro
		*
		* @param oc_solicitudTO $elem
		* @return int Filas Afectadas
		*/
		function insertoc_solicitud(oc_solicitudTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "INSERT INTO oc_solicitud (oc_solicitud_id,cod_empresa,anio,no_solicitud,fecha,referencia,observaciones,num_mes,cod_persona,nombre_persona,cod_proyecto,cod_agencia,cod_seccion,centro_costo,ind_estado,prioridad,adicionado_por,fec_adicion,modificado_por,fec_modificacion ) VALUES (
				".$elem->getOc_solicitud_id().",
				'".$elem->getCod_empresa()."',
				'".$elem->getAnio()."',
				'".$elem->getNo_solicitud()."',
				'".$elem->getFecha()."',
				'".$elem->getReferencia()."',
				'".$elem->getObservaciones()."',
				'".$elem->getNum_mes()."',
				'".$elem->getCod_persona()."',
				'".$elem->getNombre_persona()."',
				'".$elem->getCod_proyecto()."',
				'".$elem->getCod_agencia()."',
				'".$elem->getCod_seccion()."',
				'".$elem->getCentro_costo()."',
				'".$elem->getInd_estado()."',
				'".$elem->getPrioridad()."',
				'".$elem->getAdicionado_por()."',
				'".$elem->getFec_adicion()."',
				'".$elem->getModificado_por()."',
				'".$elem->getFec_modificacion()."'  );";

			$ResultSet = odbc_exec($this->connection, $PreparedStatement);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
			if($ResultSet)
				return odbc_num_rows($ResultSet);
			else
				throw new Exception(ERROR_INSERT);

		}

		/**
		* Actualiza un Registro
		*
		* @param oc_solicitudTO $elem
		* @return int Filas Afectadas
		*/
		function updateoc_solicitud(oc_solicitudTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "UPDATE oc_solicitud SET  
				cod_empresa = '".$elem->getCod_empresa()."',
				anio = '".$elem->getAnio()."',
				no_solicitud = '".$elem->getNo_solicitud()."',
				fecha = '".$elem->getFecha()."',
				referencia = '".$elem->getReferencia()."',
				observaciones = '".$elem->getObservaciones()."',
				num_mes = '".$elem->getNum_mes()."',
				cod_persona = '".$elem->getCod_persona()."',
				nombre_persona = '".$elem->getNombre_persona()."',
				cod_proyecto = '".$elem->getCod_proyecto()."',
				cod_agencia = '".$elem->getCod_agencia()."',
				cod_seccion = '".$elem->getCod_seccion()."',
				centro_costo = '".$elem->getCentro_costo()."',
				ind_estado = '".$elem->getInd_estado()."',
				prioridad = '".$elem->getPrioridad()."',
				adicionado_por = '".$elem->getAdicionado_por()."',
				fec_adicion = '".$elem->getFec_adicion()."',
				modificado_por = '".$elem->getModificado_por()."',
				fec_modificacion = '".$elem->getFec_modificacion()."' 
			WHERE oc_solicitud_id = ". $elem->getOc_solicitud_id().";" ;

			$ResultSet = odbc_exec($this->connection, $PreparedStatement);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
			if($ResultSet)
				return odbc_num_rows($ResultSet);
			else
				throw new Exception(ERROR_UPDATE);

		}

		/**
		* Elimina un Registro
		*
		* @param oc_solicitudTO $elem
		* @return int Filas Afectadas
		*/
		function deleteoc_solicitud(oc_solicitudTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "DELETE FROM oc_solicitud WHERE oc_solicitud_id = ". $elem->getOc_solicitud_id().";";

			$ResultSet = odbc_exec($this->connection, $PreparedStatement);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
			if($ResultSet)
				return odbc_num_rows($ResultSet);
			else
				throw new Exception(ERROR_DELETE);

		}

		/**
		* Obtiene un objeto oc_solicitudTO
		*
		* @return oc_solicitudTO elem
		*/
		function selectByIdoc_solicitud($oc_solicitud_id){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT oc_solicitud_id, cod_empresa, anio, no_solicitud, fecha, referencia, observaciones, num_mes, cod_persona, nombre_persona, cod_proyecto, cod_agencia, cod_seccion, centro_costo, ind_estado, prioridad, adicionado_por, fec_adicion, modificado_por, fec_modificacion   FROM oc_solicitud WHERE oc_solicitud_id = $oc_solicitud_id ;";
			$ResultSet = odbc_exec($this->connection, $PreparedStatement);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$elem = new oc_solicitudTO();
			while($row = odbc_fetch_array($ResultSet)){
				$elem = new oc_solicitudTO();
				$elem->setOc_solicitud_id($row['oc_solicitud_id']);
				$elem->setCod_empresa($row['cod_empresa']);
				$elem->setAnio($row['anio']);
				$elem->setNo_solicitud($row['no_solicitud']);
				$elem->setFecha($row['fecha']);
				$elem->setReferencia($row['referencia']);
				$elem->setObservaciones($row['observaciones']);
				$elem->setNum_mes($row['num_mes']);
				$elem->setCod_persona($row['cod_persona']);
				$elem->setNombre_persona($row['nombre_persona']);
				$elem->setCod_proyecto($row['cod_proyecto']);
				$elem->setCod_agencia($row['cod_agencia']);
				$elem->setCod_seccion($row['cod_seccion']);
				$elem->setCentro_costo($row['centro_costo']);
				$elem->setInd_estado($row['ind_estado']);
				$elem->setPrioridad($row['prioridad']);
				$elem->setAdicionado_por($row['adicionado_por']);
				$elem->setFec_adicion($row['fec_adicion']);
				$elem->setModificado_por($row['modificado_por']);
				$elem->setFec_modificacion($row['fec_modificacion']);

			}
			odbc_free_result($ResultSet);
			return $elem;
		}

		/**
		* Obtiene la cantidad de filas de la tabla
		*
		* @return int $rows
		*/
		function selectCountoc_solicitud($criterio){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT COUNT(*) AS count FROM oc_solicitud WHERE oc_solicitud_id = oc_solicitud_id ";
			if(isset ($criterio["oc_solicitud_id"]) && trim($criterio["oc_solicitud_id"]) != "0"){
				$PreparedStatement .=" AND oc_solicitud_id = ".$criterio["oc_solicitud_id"];
			}
			if(isset ($criterio["cod_empresa"]) && trim($criterio["cod_empresa"]) != "0"){
				$PreparedStatement .=" AND cod_empresa = ".$criterio["cod_empresa"];
			}
			if(isset ($criterio["anio"]) && trim($criterio["anio"]) != "0"){
				$PreparedStatement .=" AND anio = ".$criterio["anio"];
			}
			if(isset ($criterio["no_solicitud"]) && trim($criterio["no_solicitud"]) != "0"){
				$PreparedStatement .=" AND no_solicitud = ".$criterio["no_solicitud"];
			}
			if(isset ($criterio["fecha"]) && trim($criterio["fecha"]) != "0"){
				$PreparedStatement .=" AND fecha = ".$criterio["fecha"];
			}
			if(isset ($criterio["referencia"]) && trim($criterio["referencia"]) != "0"){
				$PreparedStatement .=" AND referencia = ".$criterio["referencia"];
			}
			if(isset ($criterio["observaciones"]) && trim($criterio["observaciones"]) != "0"){
				$PreparedStatement .=" AND observaciones = ".$criterio["observaciones"];
			}
			if(isset ($criterio["num_mes"]) && trim($criterio["num_mes"]) != "0"){
				$PreparedStatement .=" AND num_mes = ".$criterio["num_mes"];
			}
			if(isset ($criterio["cod_persona"]) && trim($criterio["cod_persona"]) != "0"){
				$PreparedStatement .=" AND cod_persona = ".$criterio["cod_persona"];
			}
			if(isset ($criterio["nombre_persona"]) && trim($criterio["nombre_persona"]) != "0"){
				$PreparedStatement .=" AND nombre_persona = ".$criterio["nombre_persona"];
			}
			if(isset ($criterio["cod_proyecto"]) && trim($criterio["cod_proyecto"]) != "0"){
				$PreparedStatement .=" AND cod_proyecto = ".$criterio["cod_proyecto"];
			}
			if(isset ($criterio["cod_agencia"]) && trim($criterio["cod_agencia"]) != "0"){
				$PreparedStatement .=" AND cod_agencia = ".$criterio["cod_agencia"];
			}
			if(isset ($criterio["cod_seccion"]) && trim($criterio["cod_seccion"]) != "0"){
				$PreparedStatement .=" AND cod_seccion = ".$criterio["cod_seccion"];
			}
			if(isset ($criterio["centro_costo"]) && trim($criterio["centro_costo"]) != "0"){
				$PreparedStatement .=" AND centro_costo = ".$criterio["centro_costo"];
			}
			if(isset ($criterio["ind_estado"]) && trim($criterio["ind_estado"]) != "0"){
				$PreparedStatement .=" AND ind_estado = ".$criterio["ind_estado"];
			}
			if(isset ($criterio["prioridad"]) && trim($criterio["prioridad"]) != "0"){
				$PreparedStatement .=" AND prioridad = ".$criterio["prioridad"];
			}
			if(isset ($criterio["adicionado_por"]) && trim($criterio["adicionado_por"]) != "0"){
				$PreparedStatement .=" AND adicionado_por = ".$criterio["adicionado_por"];
			}
			if(isset ($criterio["fec_adicion"]) && trim($criterio["fec_adicion"]) != "0"){
				$PreparedStatement .=" AND fec_adicion = ".$criterio["fec_adicion"];
			}
			if(isset ($criterio["modificado_por"]) && trim($criterio["modificado_por"]) != "0"){
				$PreparedStatement .=" AND modificado_por = ".$criterio["modificado_por"];
			}
			if(isset ($criterio["fec_modificacion"]) && trim($criterio["fec_modificacion"]) != "0"){
				$PreparedStatement .=" AND fec_modificacion = ".$criterio["fec_modificacion"];
			}
			$ResultSet = odbc_exec($this->connection, $PreparedStatement);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$rows = 0;
			while ($row = odbc_fetch_array($ResultSet)) {
				$rows = ceil($row['count'] / TABLE_ROW_VIEW);
			}
			odbc_free_result($ResultSet);
			return $rows;
		}


		/**
		* Obtiene una coleccion de filas de la tabla
		*
		* @return ArrayObject oc_solicitudTO
		* @param array $criterio
		*/
		function selectByCriteria_oc_solicitud($criterio,$page_number){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT oc_solicitud_id, cod_empresa, anio, no_solicitud, fecha, referencia, observaciones, num_mes, cod_persona, nombre_persona, cod_proyecto, cod_agencia, cod_seccion, centro_costo, ind_estado, prioridad, adicionado_por, fec_adicion, modificado_por, fec_modificacion  
						 FROM oc_solicitud WHERE oc_solicitud_id = oc_solicitud_id ";

			if(isset ($criterio["oc_solicitud_id"]) && trim($criterio["oc_solicitud_id"]) != "0"){
				$PreparedStatement .=" AND oc_solicitud_id = ".$criterio["oc_solicitud_id"];
			}
			if(isset ($criterio["cod_empresa"]) && trim($criterio["cod_empresa"]) != "0"){
				$PreparedStatement .=" AND cod_empresa = ".$criterio["cod_empresa"];
			}
			if(isset ($criterio["anio"]) && trim($criterio["anio"]) != "0"){
				$PreparedStatement .=" AND anio = ".$criterio["anio"];
			}
			if(isset ($criterio["no_solicitud"]) && trim($criterio["no_solicitud"]) != "0"){
				$PreparedStatement .=" AND no_solicitud = ".$criterio["no_solicitud"];
			}
			if(isset ($criterio["fecha"]) && trim($criterio["fecha"]) != "0"){
				$PreparedStatement .=" AND fecha = ".$criterio["fecha"];
			}
			if(isset ($criterio["referencia"]) && trim($criterio["referencia"]) != "0"){
				$PreparedStatement .=" AND referencia = ".$criterio["referencia"];
			}
			if(isset ($criterio["observaciones"]) && trim($criterio["observaciones"]) != "0"){
				$PreparedStatement .=" AND observaciones = ".$criterio["observaciones"];
			}
			if(isset ($criterio["num_mes"]) && trim($criterio["num_mes"]) != "0"){
				$PreparedStatement .=" AND num_mes = ".$criterio["num_mes"];
			}
			if(isset ($criterio["cod_persona"]) && trim($criterio["cod_persona"]) != "0"){
				$PreparedStatement .=" AND cod_persona = ".$criterio["cod_persona"];
			}
			if(isset ($criterio["nombre_persona"]) && trim($criterio["nombre_persona"]) != "0"){
				$PreparedStatement .=" AND nombre_persona = ".$criterio["nombre_persona"];
			}
			if(isset ($criterio["cod_proyecto"]) && trim($criterio["cod_proyecto"]) != "0"){
				$PreparedStatement .=" AND cod_proyecto = ".$criterio["cod_proyecto"];
			}
			if(isset ($criterio["cod_agencia"]) && trim($criterio["cod_agencia"]) != "0"){
				$PreparedStatement .=" AND cod_agencia = ".$criterio["cod_agencia"];
			}
			if(isset ($criterio["cod_seccion"]) && trim($criterio["cod_seccion"]) != "0"){
				$PreparedStatement .=" AND cod_seccion = ".$criterio["cod_seccion"];
			}
			if(isset ($criterio["centro_costo"]) && trim($criterio["centro_costo"]) != "0"){
				$PreparedStatement .=" AND centro_costo = ".$criterio["centro_costo"];
			}
			if(isset ($criterio["ind_estado"]) && trim($criterio["ind_estado"]) != "0"){
				$PreparedStatement .=" AND ind_estado = ".$criterio["ind_estado"];
			}
			if(isset ($criterio["prioridad"]) && trim($criterio["prioridad"]) != "0"){
				$PreparedStatement .=" AND prioridad = ".$criterio["prioridad"];
			}
			if(isset ($criterio["adicionado_por"]) && trim($criterio["adicionado_por"]) != "0"){
				$PreparedStatement .=" AND adicionado_por = ".$criterio["adicionado_por"];
			}
			if(isset ($criterio["fec_adicion"]) && trim($criterio["fec_adicion"]) != "0"){
				$PreparedStatement .=" AND fec_adicion = ".$criterio["fec_adicion"];
			}
			if(isset ($criterio["modificado_por"]) && trim($criterio["modificado_por"]) != "0"){
				$PreparedStatement .=" AND modificado_por = ".$criterio["modificado_por"];
			}
			if(isset ($criterio["fec_modificacion"]) && trim($criterio["fec_modificacion"]) != "0"){
				$PreparedStatement .=" AND fec_modificacion = ".$criterio["fec_modificacion"];
			}
			$PreparedStatement .= " ORDER BY oc_solicitud_id LIMIT ".($page_number*TABLE_ROW_VIEW).",". ($page_number+1)*TABLE_ROW_VIEW."";
			$ResultSet = odbc_exec($this->connection, $PreparedStatement);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$arrayList = new ArrayObject();
			 while ($row = odbc_fetch_array($ResultSet)) {
				$elem = new oc_solicitudTO();
				$elem->setOc_solicitud_id($row['oc_solicitud_id']);
				$elem->setCod_empresa($row['cod_empresa']);
				$elem->setAnio($row['anio']);
				$elem->setNo_solicitud($row['no_solicitud']);
				$elem->setFecha($row['fecha']);
				$elem->setReferencia($row['referencia']);
				$elem->setObservaciones($row['observaciones']);
				$elem->setNum_mes($row['num_mes']);
				$elem->setCod_persona($row['cod_persona']);
				$elem->setNombre_persona($row['nombre_persona']);
				$elem->setCod_proyecto($row['cod_proyecto']);
				$elem->setCod_agencia($row['cod_agencia']);
				$elem->setCod_seccion($row['cod_seccion']);
				$elem->setCentro_costo($row['centro_costo']);
				$elem->setInd_estado($row['ind_estado']);
				$elem->setPrioridad($row['prioridad']);
				$elem->setAdicionado_por($row['adicionado_por']);
				$elem->setFec_adicion($row['fec_adicion']);
				$elem->setModificado_por($row['modificado_por']);
				$elem->setFec_modificacion($row['fec_modificacion']);

				$arrayList->append($elem);
			}
			odbc_free_result($ResultSet);
			return $arrayList;
		}

	}
?>
