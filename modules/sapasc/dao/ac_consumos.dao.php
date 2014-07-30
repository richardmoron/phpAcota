<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."\cnx\connection.php");
	include_once (dirname(dirname(__FILE__))."\dto\ac_consumos.dto.php");
	include_once (dirname(dirname(dirname(dirname(__FILE__))))."\lib\logs.php");

	class ac_consumosDAO {
		private $connection;
 
		function ac_consumosDAO(){
		}

		/**
		* Añade un Registro
		*
		* @param ac_consumosTO $elem
		* @return int Filas Afectadas
		*/
		function insertac_consumos(ac_consumosTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "INSERT INTO asapasc.ac_consumos (consumo_id,socio_id,nro_medidor,fecha_lectura,fecha_emision,periodo_mes,periodo_anio,consumo_total_lectura,consumo_por_pagar,costo_consumo_por_pagar,estado,fecha_hora_pago,usuario_pago,monto_pagado,pagado_por,ci_pagado_por ) VALUES (
				".Connection::inject($elem->getConsumo_id()).",
				".Connection::inject($elem->getSocio_id()).",
				'".Connection::inject($elem->getNro_medidor())."',
				'".Connection::inject($elem->getFecha_lectura())."',
				'".Connection::inject($elem->getFecha_emision())."',
				'".Connection::inject($elem->getPeriodo_mes())."',
				'".Connection::inject($elem->getPeriodo_anio())."',
				'".Connection::inject($elem->getConsumo_total_lectura())."',
				'".Connection::inject($elem->getConsumo_por_pagar())."',
				'".Connection::inject($elem->getCosto_consumo_por_pagar())."',
				'".Connection::inject($elem->getEstado())."',
				'".Connection::inject($elem->getFecha_hora_pago())."',
				'".Connection::inject($elem->getUsuario_pago())."',
				'".Connection::inject($elem->getMonto_pagado())."',
				'".Connection::inject($elem->getPagado_por())."',
				'".Connection::inject($elem->getCi_pagado_por())."'  );";

			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
			if($ResultSet)
				return mysql_affected_rows($ResultSet);
			else
				throw new Exception(ERROR_INSERT);

		}
                
                function insertac_consumosSimple(ac_consumosTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "INSERT INTO asapasc.ac_consumos (consumo_id,socio_id,nro_medidor,fecha_lectura,periodo_mes,periodo_anio,consumo_total_lectura,estado) VALUES (
				".Connection::inject($elem->getConsumo_id()).",
				".Connection::inject($elem->getSocio_id()).",
				'".Connection::inject($elem->getNro_medidor())."',
				'".Connection::inject($elem->getFecha_lectura())."',
				'".Connection::inject($elem->getPeriodo_mes())."',
				'".Connection::inject($elem->getPeriodo_anio())."',
				'".Connection::inject($elem->getConsumo_total_lectura())."',
				'".Connection::inject($elem->getEstado())."'  );";

			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
			if($ResultSet)
				return mysql_affected_rows($ResultSet);
			else
				throw new Exception(ERROR_INSERT);

		}
		/**
		* Actualiza un Registro
		*
		* @param ac_consumosTO $elem
		* @return int Filas Afectadas
		*/
		function updateac_consumos(ac_consumosTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "UPDATE asapasc.ac_consumos SET  
				socio_id = ".Connection::inject($elem->getSocio_id()).",
				nro_medidor = ".Connection::inject($elem->getNro_medidor())."',
				fecha_lectura = '".Connection::inject($elem->getFecha_lectura())."',
				fecha_emision = '".Connection::inject($elem->getFecha_emision())."',
				periodo_mes = '".Connection::inject($elem->getPeriodo_mes())."',
				periodo_anio = '".Connection::inject($elem->getPeriodo_anio())."',
				consumo_total_lectura = '".Connection::inject($elem->getConsumo_total_lectura())."',
				consumo_por_pagar = '".Connection::inject($elem->getConsumo_por_pagar())."',
				costo_consumo_por_pagar = '".Connection::inject($elem->getCosto_consumo_por_pagar())."',
				estado = '".Connection::inject($elem->getEstado())."',
				fecha_hora_pago = '".Connection::inject($elem->getFecha_hora_pago())."',
				usuario_pago = '".Connection::inject($elem->getUsuario_pago())."',
				monto_pagado = '".Connection::inject($elem->getMonto_pagado())."',
				pagado_por = '".Connection::inject($elem->getPagado_por())."',
				ci_pagado_por = '".Connection::inject($elem->getCi_pagado_por())."' 
			WHERE consumo_id = ". $elem->getConsumo_id().";" ;

			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
			if($ResultSet)
				return mysql_affected_rows($ResultSet);
			else
				throw new Exception(ERROR_UPDATE);

		}
                
                function updateac_consumosPagar(ac_consumosTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "UPDATE asapasc.ac_consumos SET  
				estado = '".Connection::inject($elem->getEstado())."',
				fecha_hora_pago = '".Connection::inject($elem->getFecha_hora_pago())."',
				usuario_pago = '".Connection::inject($elem->getUsuario_pago())."',
				monto_pagado = '".Connection::inject($elem->getMonto_pagado())."',
				pagado_por = '".Connection::inject($elem->getPagado_por())."',
				ci_pagado_por = '".Connection::inject($elem->getCi_pagado_por())."' 
			WHERE consumo_id = ". $elem->getConsumo_id()." 
                        AND socio_id = ".Connection::inject($elem->getSocio_id()).";" ;

			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
			if($ResultSet)
				return mysql_affected_rows($ResultSet);
			else
				throw new Exception(ERROR_UPDATE);

		}
                
                function updateac_consumosSimple(ac_consumosTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "UPDATE asapasc.ac_consumos SET  
				socio_id = ".Connection::inject($elem->getSocio_id()).",
				nro_medidor = '".Connection::inject($elem->getNro_medidor())."',
				fecha_lectura = '".Connection::inject($elem->getFecha_lectura())."',
				periodo_mes = '".Connection::inject($elem->getPeriodo_mes())."',
				periodo_anio = '".Connection::inject($elem->getPeriodo_anio())."',
				consumo_total_lectura = '".Connection::inject($elem->getConsumo_total_lectura())."',
				estado = '".Connection::inject($elem->getEstado())."' 
			WHERE consumo_id = ". $elem->getConsumo_id().";" ;

			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
			if($ResultSet)
				return mysql_affected_rows($ResultSet);
			else
				throw new Exception(ERROR_UPDATE);

		}
		/**
		* Elimina un Registro
		*
		* @param ac_consumosTO $elem
		* @return int Filas Afectadas
		*/
		function deleteac_consumos(ac_consumosTO $elem){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "DELETE FROM asapasc.ac_consumos WHERE consumo_id = ". Connection::inject($elem->getConsumo_id()).";";

			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
			if($ResultSet)
				return mysql_affected_rows($ResultSet);
			else
				throw new Exception(ERROR_DELETE);

		}

		/**
		* Obtiene un objeto ac_consumosTO
		*
		* @return ac_consumosTO elem
		*/
		function selectByIdac_consumos($consumo_id){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT consumo_id, socio_id, nro_medidor, fecha_lectura, fecha_emision, periodo_mes, periodo_anio, consumo_total_lectura, consumo_por_pagar, costo_consumo_por_pagar, estado, fecha_hora_pago, usuario_pago, monto_pagado, pagado_por, ci_pagado_por,
                                                (SELECT CONCAT(nombres,' ',apellidos) FROM asapasc.ac_socios WHERE socio_id = asapasc.ac_consumos.socio_id) AS socio 
                                                FROM asapasc.ac_consumos WHERE consumo_id = ".Connection::inject($consumo_id)." ;";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$elem = new ac_consumosTO();
			while($row = mysql_fetch_array($ResultSet)){
				$elem = new ac_consumosTO();
				$elem->setConsumo_id($row['consumo_id']);
				$elem->setSocio_id($row['socio_id']);
				$elem->setNro_medidor($row['nro_medidor']);
				$elem->setFecha_lectura($row['fecha_lectura']);
				$elem->setFecha_emision($row['fecha_emision']);
				$elem->setPeriodo_mes($row['periodo_mes']);
				$elem->setPeriodo_anio($row['periodo_anio']);
				$elem->setConsumo_total_lectura($row['consumo_total_lectura']);
				$elem->setConsumo_por_pagar($row['consumo_por_pagar']);
				$elem->setCosto_consumo_por_pagar($row['costo_consumo_por_pagar']);
				$elem->setEstado($row['estado']);
				$elem->setFecha_hora_pago($row['fecha_hora_pago']);
				$elem->setUsuario_pago($row['usuario_pago']);
				$elem->setMonto_pagado($row['monto_pagado']);
				$elem->setPagado_por($row['pagado_por']);
				$elem->setCi_pagado_por($row['ci_pagado_por']);
                                $elem->setSocio($row['socio']);

			}
			mysql_free_result($ResultSet);
			return $elem;
		}

		/**
		* Obtiene la cantidad de filas de la tabla
		*
		* @return int $rows
		*/
		function selectCountac_consumos($criterio){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT COUNT(*) AS count FROM asapasc.ac_consumos WHERE consumo_id = consumo_id ";
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
		* @return ArrayObject ac_consumosTO
		* @param array $criterio
		*/
		function selectByCriteria_ac_consumos($criterio,$page_number){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT consumo_id, socio_id, nro_medidor, fecha_lectura, fecha_emision, periodo_mes, periodo_anio, consumo_total_lectura, consumo_por_pagar, costo_consumo_por_pagar, estado, fecha_hora_pago, usuario_pago, monto_pagado, pagado_por, ci_pagado_por,
                                                 (SELECT CONCAT(nombres,' ',apellidos) FROM asapasc.ac_socios WHERE socio_id = asapasc.ac_consumos.socio_id) AS socio 
						 FROM asapasc.ac_consumos WHERE consumo_id = consumo_id ";

			$PreparedStatement = $this->defineCriterias($criterio,$PreparedStatement);
			$PreparedStatement .= " ORDER BY fecha_lectura DESC";
			if($page_number != -1)
				$PreparedStatement .= " LIMIT ".($page_number*TABLE_ROW_VIEW).",". ($page_number+1)*TABLE_ROW_VIEW."";
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

			$arrayList = new ArrayObject();
			 while ($row = mysql_fetch_array($ResultSet)) {
				$elem = new ac_consumosTO();
				$elem->setConsumo_id($row['consumo_id']);
				$elem->setSocio_id($row['socio_id']);
				$elem->setNro_medidor($row['nro_medidor']);
				$elem->setFecha_lectura($row['fecha_lectura']);
				$elem->setFecha_emision($row['fecha_emision']);
				$elem->setPeriodo_mes($row['periodo_mes']);
				$elem->setPeriodo_anio($row['periodo_anio']);
				$elem->setConsumo_total_lectura($row['consumo_total_lectura']);
				$elem->setConsumo_por_pagar($row['consumo_por_pagar']);
				$elem->setCosto_consumo_por_pagar($row['costo_consumo_por_pagar']);
				$elem->setEstado($row['estado']);
				$elem->setFecha_hora_pago($row['fecha_hora_pago']);
				$elem->setUsuario_pago($row['usuario_pago']);
				$elem->setMonto_pagado($row['monto_pagado']);
				$elem->setPagado_por($row['pagado_por']);
				$elem->setCi_pagado_por($row['ci_pagado_por']);
                                $elem->setSocio($row['socio']);

				$arrayList->append($elem);
			}
			mysql_free_result($ResultSet);
			return $arrayList;
		}


		/**
		* Define los criterios del Where
		*
		* @return String $PreparedStatement ac_consumosTO
		* @param String $PreparedStatement
		* @param array $criterio
		*/
		function defineCriterias($criterio,$PreparedStatement){
			if(isset ($criterio["consumo_id"]) && trim($criterio["consumo_id"]) != "0"){
				$PreparedStatement .=" AND consumo_id = ".Connection::inject($criterio["consumo_id"]);
			}
			if(isset ($criterio["socio_id"]) && trim($criterio["socio_id"]) != "0"){
				$PreparedStatement .=" AND socio_id = ".Connection::inject($criterio["socio_id"]);
			}
			if(isset ($criterio["nro_medidor"]) && trim($criterio["nro_medidor"]) != "0"){
				$PreparedStatement .=" AND nro_medidor LIKE '%".Connection::inject($criterio["nro_medidor"])."%'";
			}
			if(isset ($criterio["fecha_lectura"]) && trim($criterio["fecha_lectura"]) != "0"){
				$PreparedStatement .=" AND fecha_lectura = ".Connection::inject($criterio["fecha_lectura"]);
			}
			if(isset ($criterio["fecha_emision"]) && trim($criterio["fecha_emision"]) != "0"){
				$PreparedStatement .=" AND fecha_emision = ".Connection::inject($criterio["fecha_emision"]);
			}
			if(isset ($criterio["periodo_mes"]) && trim($criterio["periodo_mes"]) != "0"){
				$PreparedStatement .=" AND periodo_mes = ".Connection::inject($criterio["periodo_mes"]);
			}
			if(isset ($criterio["periodo_anio"]) && trim($criterio["periodo_anio"]) != "0"){
				$PreparedStatement .=" AND periodo_anio = ".Connection::inject($criterio["periodo_anio"]);
			}
			if(isset ($criterio["consumo_total_lectura"]) && trim($criterio["consumo_total_lectura"]) != "0"){
				$PreparedStatement .=" AND consumo_total_lectura = ".Connection::inject($criterio["consumo_total_lectura"]);
			}
			if(isset ($criterio["consumo_por_pagar"]) && trim($criterio["consumo_por_pagar"]) != "0"){
				$PreparedStatement .=" AND consumo_por_pagar = ".Connection::inject($criterio["consumo_por_pagar"]);
			}
			if(isset ($criterio["costo_consumo_por_pagar"]) && trim($criterio["costo_consumo_por_pagar"]) != "0"){
				$PreparedStatement .=" AND costo_consumo_por_pagar = ".Connection::inject($criterio["costo_consumo_por_pagar"]);
			}
			if(isset ($criterio["estado"]) && trim($criterio["estado"]) != "0"){
				$PreparedStatement .=" AND estado = '".Connection::inject($criterio["estado"])."'";
			}
			if(isset ($criterio["fecha_hora_pago"]) && trim($criterio["fecha_hora_pago"]) != "0"){
				$PreparedStatement .=" AND fecha_hora_pago = ".Connection::inject($criterio["fecha_hora_pago"]);
			}
			if(isset ($criterio["usuario_pago"]) && trim($criterio["usuario_pago"]) != "0"){
				$PreparedStatement .=" AND usuario_pago = ".Connection::inject($criterio["usuario_pago"]);
			}
			if(isset ($criterio["monto_pagado"]) && trim($criterio["monto_pagado"]) != "0"){
				$PreparedStatement .=" AND monto_pagado = ".Connection::inject($criterio["monto_pagado"]);
			}
			if(isset ($criterio["pagado_por"]) && trim($criterio["pagado_por"]) != "0"){
				$PreparedStatement .=" AND pagado_por = ".Connection::inject($criterio["pagado_por"]);
			}
			if(isset ($criterio["ci_pagado_por"]) && trim($criterio["ci_pagado_por"]) != "0"){
				$PreparedStatement .=" AND ci_pagado_por = ".Connection::inject($criterio["ci_pagado_por"]);
			}
			return $PreparedStatement;
		}
                
                function totalAnterior_ac_consumos($criterio){
			$this->connection = Connection::getinstance()->getConn();
                        $PreparedStatement = "SELECT consumo_total_lectura FROM asapasc.ac_consumos WHERE socio_id = ".Connection::inject($criterio["socio_id"])." AND periodo_mes < ".Connection::inject($criterio["periodo_mes"])." AND periodo_anio <= ".Connection::inject($criterio["periodo_anio"])." ORDER BY fecha_lectura DESC LIMIT 1";
                        $ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);

                        $consumo_total_lectura = 0;
			 while ($row = mysql_fetch_array($ResultSet)) {
                             $consumo_total_lectura = $row["consumo_total_lectura"];
                         }
                         return $consumo_total_lectura;
                }
                
                function emitirAvisos_ac_consumos($criterio,$page_number = -1){
			$this->connection = Connection::getinstance()->getConn();
			$PreparedStatement = "SELECT consumo_id, socio_id, nro_medidor, fecha_lectura, periodo_mes, periodo_anio, consumo_total_lectura,
                                                 (SELECT consumo_total_lectura FROM asapasc.ac_consumos WHERE socio_id = r.socio_id AND fecha_lectura < r.fecha_lectura ORDER BY fecha_lectura DESC LIMIT 1) AS consumo_anterior   
						 FROM asapasc.ac_consumos AS r WHERE consumo_id = consumo_id ";

			$PreparedStatement = $this->defineCriterias($criterio,$PreparedStatement);
			$PreparedStatement .= " ";
			
			$ResultSet = mysql_query($PreparedStatement,$this->connection);
			logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
                        
			 while ($row = mysql_fetch_array($ResultSet)) {
				$row['consumo_id'];
				$row['socio_id'];
                                $consumo_actual = $row['consumo_total_lectura'] - $row['consumo_anterior'];
                                //--
                                $consumo_minimo_permitido = 0;
                                $costo_consumo_minimo = 0;
                                $costo_consumo_excedido = 0;
                                $PreparedStatement2 = "SELECT consumo_minimo_permitido, costo_consumo_minimo, costo_consumo_excedido FROM asapasc.ac_grupos_socios WHERE grupo_id = (SELECT grupo_id FROM asapasc.ac_socios WHERE socio_id = ".$row['socio_id'].")";
                                $ResultSet2 = mysql_query($PreparedStatement2,$this->connection);
                                logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement2);
                                while ($row2 = mysql_fetch_array($ResultSet2)) {
                                    $consumo_minimo_permitido = $row2["consumo_minimo_permitido"];
                                    $costo_consumo_minimo = $row2["costo_consumo_minimo"];
                                    $costo_consumo_excedido = $row2["costo_consumo_excedido"];
                                }
                                $consumo_por_pagar = $consumo_minimo_permitido;
                                $costo_consumo_por_pagar = $costo_consumo_minimo;
                                if(floatval($consumo_actual) > floatval($consumo_minimo_permitido) ){
                                    $consumo_por_pagar = $consumo_actual - $consumo_minimo_permitido;
                                    $costo_consumo_por_pagar = $costo_consumo_minimo + ($consumo_por_pagar * $costo_consumo_excedido);
                                }
                                mysql_free_result($ResultSet2);
                                
                                $PreparedStatement3 = "UPDATE asapasc.ac_consumos SET fecha_emision = CURDATE(), estado = 'E', consumo_por_pagar = ".$consumo_por_pagar.", costo_consumo_por_pagar = ".$costo_consumo_por_pagar." WHERE consumo_id = ".$row['consumo_id'];
                                $ResultSet3 = mysql_query($PreparedStatement3,$this->connection);
                                logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement3);
                                if($ResultSet3 != FALSE)
                                    mysql_free_result($ResultSet3);
			}
			mysql_free_result($ResultSet);
		}
	}
?>