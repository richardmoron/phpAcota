<?php 
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."\cnx\connection.php");
	include_once (dirname(dirname(__FILE__))."\dto\oc_solicitud_detalle.dto.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."\lib\logs.php");

	class oc_solicitud_detalleDAO {
		private $connection;
 
		function oc_solicitud_detalleDAO(){
		}

		/**
		* Añade un Registro
		*
		* @param oc_solicitud_detalleTO $elem
		* @return int Filas Afectadas
		*/
		function insertoc_solicitud_detalle(oc_solicitud_detalleTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "INSERT INTO oc_solicitud_detalle (oc_solicitud_detalle_id,cod_empresa,anio,no_solicitud,no_linea,tipo_solicitud,cod_tipo,cod_grupo,cod_subgrupo,codigo_referencia,nombre_referencia,unidad_medida,cantidad,cantidad_aprobada,cantidad_pendiente,observaciones,no_docto_referencia,adicionado_por,fec_adicion,modificado_por,fec_modificacion ) VALUES (
				".$elem->getOc_solicitud_detalle_id().",
				'".$elem->getCod_empresa()."',
				'".$elem->getAnio()."',
				'".$elem->getNo_solicitud()."',
				'".$elem->getNo_linea()."',
				'".$elem->getTipo_solicitud()."',
				'".$elem->getCod_tipo()."',
				'".$elem->getCod_grupo()."',
				'".$elem->getCod_subgrupo()."',
				'".$elem->getCodigo_referencia()."',
				'".$elem->getNombre_referencia()."',
				'".$elem->getUnidad_medida()."',
				'".$elem->getCantidad()."',
				'".$elem->getCantidad_aprobada()."',
				'".$elem->getCantidad_pendiente()."',
				'".$elem->getObservaciones()."',
				'".$elem->getNo_docto_referencia()."',
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
		* @param oc_solicitud_detalleTO $elem
		* @return int Filas Afectadas
		*/
		function updateoc_solicitud_detalle(oc_solicitud_detalleTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "UPDATE oc_solicitud_detalle SET  
				cod_empresa = '".$elem->getCod_empresa()."',
				anio = '".$elem->getAnio()."',
				no_solicitud = '".$elem->getNo_solicitud()."',
				no_linea = '".$elem->getNo_linea()."',
				tipo_solicitud = '".$elem->getTipo_solicitud()."',
				cod_tipo = '".$elem->getCod_tipo()."',
				cod_grupo = '".$elem->getCod_grupo()."',
				cod_subgrupo = '".$elem->getCod_subgrupo()."',
				codigo_referencia = '".$elem->getCodigo_referencia()."',
				nombre_referencia = '".$elem->getNombre_referencia()."',
				unidad_medida = '".$elem->getUnidad_medida()."',
				cantidad = '".$elem->getCantidad()."',
				cantidad_aprobada = '".$elem->getCantidad_aprobada()."',
				cantidad_pendiente = '".$elem->getCantidad_pendiente()."',
				observaciones = '".$elem->getObservaciones()."',
				no_docto_referencia = '".$elem->getNo_docto_referencia()."',
				adicionado_por = '".$elem->getAdicionado_por()."',
				fec_adicion = '".$elem->getFec_adicion()."',
				modificado_por = '".$elem->getModificado_por()."',
				fec_modificacion = '".$elem->getFec_modificacion()."' 
			WHERE oc_solicitud_detalle_id = ". $elem->getOc_solicitud_detalle_id().";" ;

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
		* @param oc_solicitud_detalleTO $elem
		* @return int Filas Afectadas
		*/
		function deleteoc_solicitud_detalle(oc_solicitud_detalleTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "DELETE FROM oc_solicitud_detalle WHERE oc_solicitud_detalle_id = ". $elem->getOc_solicitud_detalle_id().";";

			$ResultSet = odbc_exec($this->connection, $PreparedStatement);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
			if($ResultSet)
				return odbc_num_rows($ResultSet);
			else
				throw new Exception(ERROR_DELETE);

		}

		/**
		* Obtiene un objeto oc_solicitud_detalleTO
		*
		* @return oc_solicitud_detalleTO elem
		*/
		function selectByIdoc_solicitud_detalle($oc_solicitud_detalle_id){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT oc_solicitud_detalle_id, cod_empresa, anio, no_solicitud, no_linea, tipo_solicitud, cod_tipo, cod_grupo, cod_subgrupo, codigo_referencia, nombre_referencia, unidad_medida, cantidad, cantidad_aprobada, cantidad_pendiente, observaciones, no_docto_referencia, adicionado_por, fec_adicion, modificado_por, fec_modificacion   FROM oc_solicitud_detalle WHERE oc_solicitud_detalle_id = $oc_solicitud_detalle_id ;";
			$ResultSet = odbc_exec($this->connection, $PreparedStatement);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$elem = new oc_solicitud_detalleTO();
			while($row = odbc_fetch_array($ResultSet)){
				$elem = new oc_solicitud_detalleTO();
				$elem->setOc_solicitud_detalle_id($row['oc_solicitud_detalle_id']);
				$elem->setCod_empresa($row['cod_empresa']);
				$elem->setAnio($row['anio']);
				$elem->setNo_solicitud($row['no_solicitud']);
				$elem->setNo_linea($row['no_linea']);
				$elem->setTipo_solicitud($row['tipo_solicitud']);
				$elem->setCod_tipo($row['cod_tipo']);
				$elem->setCod_grupo($row['cod_grupo']);
				$elem->setCod_subgrupo($row['cod_subgrupo']);
				$elem->setCodigo_referencia($row['codigo_referencia']);
				$elem->setNombre_referencia($row['nombre_referencia']);
				$elem->setUnidad_medida($row['unidad_medida']);
				$elem->setCantidad($row['cantidad']);
				$elem->setCantidad_aprobada($row['cantidad_aprobada']);
				$elem->setCantidad_pendiente($row['cantidad_pendiente']);
				$elem->setObservaciones($row['observaciones']);
				$elem->setNo_docto_referencia($row['no_docto_referencia']);
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
		function selectCountoc_solicitud_detalle($criterio){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT COUNT(*) AS count FROM oc_solicitud_detalle WHERE oc_solicitud_detalle_id = oc_solicitud_detalle_id ";
			if(isset ($criterio["oc_solicitud_detalle_id"]) && trim($criterio["oc_solicitud_detalle_id"]) != "0"){
				$PreparedStatement .=" AND oc_solicitud_detalle_id = ".$criterio["oc_solicitud_detalle_id"];
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
			if(isset ($criterio["no_linea"]) && trim($criterio["no_linea"]) != "0"){
				$PreparedStatement .=" AND no_linea = ".$criterio["no_linea"];
			}
			if(isset ($criterio["tipo_solicitud"]) && trim($criterio["tipo_solicitud"]) != "0"){
				$PreparedStatement .=" AND tipo_solicitud = ".$criterio["tipo_solicitud"];
			}
			if(isset ($criterio["cod_tipo"]) && trim($criterio["cod_tipo"]) != "0"){
				$PreparedStatement .=" AND cod_tipo = ".$criterio["cod_tipo"];
			}
			if(isset ($criterio["cod_grupo"]) && trim($criterio["cod_grupo"]) != "0"){
				$PreparedStatement .=" AND cod_grupo = ".$criterio["cod_grupo"];
			}
			if(isset ($criterio["cod_subgrupo"]) && trim($criterio["cod_subgrupo"]) != "0"){
				$PreparedStatement .=" AND cod_subgrupo = ".$criterio["cod_subgrupo"];
			}
			if(isset ($criterio["codigo_referencia"]) && trim($criterio["codigo_referencia"]) != "0"){
				$PreparedStatement .=" AND codigo_referencia = ".$criterio["codigo_referencia"];
			}
			if(isset ($criterio["nombre_referencia"]) && trim($criterio["nombre_referencia"]) != "0"){
				$PreparedStatement .=" AND nombre_referencia = ".$criterio["nombre_referencia"];
			}
			if(isset ($criterio["unidad_medida"]) && trim($criterio["unidad_medida"]) != "0"){
				$PreparedStatement .=" AND unidad_medida = ".$criterio["unidad_medida"];
			}
			if(isset ($criterio["cantidad"]) && trim($criterio["cantidad"]) != "0"){
				$PreparedStatement .=" AND cantidad = ".$criterio["cantidad"];
			}
			if(isset ($criterio["cantidad_aprobada"]) && trim($criterio["cantidad_aprobada"]) != "0"){
				$PreparedStatement .=" AND cantidad_aprobada = ".$criterio["cantidad_aprobada"];
			}
			if(isset ($criterio["cantidad_pendiente"]) && trim($criterio["cantidad_pendiente"]) != "0"){
				$PreparedStatement .=" AND cantidad_pendiente = ".$criterio["cantidad_pendiente"];
			}
			if(isset ($criterio["observaciones"]) && trim($criterio["observaciones"]) != "0"){
				$PreparedStatement .=" AND observaciones = ".$criterio["observaciones"];
			}
			if(isset ($criterio["no_docto_referencia"]) && trim($criterio["no_docto_referencia"]) != "0"){
				$PreparedStatement .=" AND no_docto_referencia = ".$criterio["no_docto_referencia"];
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
		* @return ArrayObject oc_solicitud_detalleTO
		* @param array $criterio
		*/
		function selectByCriteria_oc_solicitud_detalle($criterio,$page_number){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT oc_solicitud_detalle_id, cod_empresa, anio, no_solicitud, no_linea, tipo_solicitud, cod_tipo, cod_grupo, cod_subgrupo, codigo_referencia, nombre_referencia, unidad_medida, cantidad, cantidad_aprobada, cantidad_pendiente, observaciones, no_docto_referencia, adicionado_por, fec_adicion, modificado_por, fec_modificacion  
						 FROM oc_solicitud_detalle WHERE oc_solicitud_detalle_id = oc_solicitud_detalle_id ";

			if(isset ($criterio["oc_solicitud_detalle_id"]) && trim($criterio["oc_solicitud_detalle_id"]) != "0"){
				$PreparedStatement .=" AND oc_solicitud_detalle_id = ".$criterio["oc_solicitud_detalle_id"];
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
			if(isset ($criterio["no_linea"]) && trim($criterio["no_linea"]) != "0"){
				$PreparedStatement .=" AND no_linea = ".$criterio["no_linea"];
			}
			if(isset ($criterio["tipo_solicitud"]) && trim($criterio["tipo_solicitud"]) != "0"){
				$PreparedStatement .=" AND tipo_solicitud = ".$criterio["tipo_solicitud"];
			}
			if(isset ($criterio["cod_tipo"]) && trim($criterio["cod_tipo"]) != "0"){
				$PreparedStatement .=" AND cod_tipo = ".$criterio["cod_tipo"];
			}
			if(isset ($criterio["cod_grupo"]) && trim($criterio["cod_grupo"]) != "0"){
				$PreparedStatement .=" AND cod_grupo = ".$criterio["cod_grupo"];
			}
			if(isset ($criterio["cod_subgrupo"]) && trim($criterio["cod_subgrupo"]) != "0"){
				$PreparedStatement .=" AND cod_subgrupo = ".$criterio["cod_subgrupo"];
			}
			if(isset ($criterio["codigo_referencia"]) && trim($criterio["codigo_referencia"]) != "0"){
				$PreparedStatement .=" AND codigo_referencia = ".$criterio["codigo_referencia"];
			}
			if(isset ($criterio["nombre_referencia"]) && trim($criterio["nombre_referencia"]) != "0"){
				$PreparedStatement .=" AND nombre_referencia = ".$criterio["nombre_referencia"];
			}
			if(isset ($criterio["unidad_medida"]) && trim($criterio["unidad_medida"]) != "0"){
				$PreparedStatement .=" AND unidad_medida = ".$criterio["unidad_medida"];
			}
			if(isset ($criterio["cantidad"]) && trim($criterio["cantidad"]) != "0"){
				$PreparedStatement .=" AND cantidad = ".$criterio["cantidad"];
			}
			if(isset ($criterio["cantidad_aprobada"]) && trim($criterio["cantidad_aprobada"]) != "0"){
				$PreparedStatement .=" AND cantidad_aprobada = ".$criterio["cantidad_aprobada"];
			}
			if(isset ($criterio["cantidad_pendiente"]) && trim($criterio["cantidad_pendiente"]) != "0"){
				$PreparedStatement .=" AND cantidad_pendiente = ".$criterio["cantidad_pendiente"];
			}
			if(isset ($criterio["observaciones"]) && trim($criterio["observaciones"]) != "0"){
				$PreparedStatement .=" AND observaciones = ".$criterio["observaciones"];
			}
			if(isset ($criterio["no_docto_referencia"]) && trim($criterio["no_docto_referencia"]) != "0"){
				$PreparedStatement .=" AND no_docto_referencia = ".$criterio["no_docto_referencia"];
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
			$PreparedStatement .= " ORDER BY oc_solicitud_detalle_id LIMIT ".($page_number*TABLE_ROW_VIEW).",". ($page_number+1)*TABLE_ROW_VIEW."";
			$ResultSet = odbc_exec($this->connection, $PreparedStatement);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$arrayList = new ArrayObject();
			 while ($row = odbc_fetch_array($ResultSet)) {
				$elem = new oc_solicitud_detalleTO();
				$elem->setOc_solicitud_detalle_id($row['oc_solicitud_detalle_id']);
				$elem->setCod_empresa($row['cod_empresa']);
				$elem->setAnio($row['anio']);
				$elem->setNo_solicitud($row['no_solicitud']);
				$elem->setNo_linea($row['no_linea']);
				$elem->setTipo_solicitud($row['tipo_solicitud']);
				$elem->setCod_tipo($row['cod_tipo']);
				$elem->setCod_grupo($row['cod_grupo']);
				$elem->setCod_subgrupo($row['cod_subgrupo']);
				$elem->setCodigo_referencia($row['codigo_referencia']);
				$elem->setNombre_referencia($row['nombre_referencia']);
				$elem->setUnidad_medida($row['unidad_medida']);
				$elem->setCantidad($row['cantidad']);
				$elem->setCantidad_aprobada($row['cantidad_aprobada']);
				$elem->setCantidad_pendiente($row['cantidad_pendiente']);
				$elem->setObservaciones($row['observaciones']);
				$elem->setNo_docto_referencia($row['no_docto_referencia']);
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
