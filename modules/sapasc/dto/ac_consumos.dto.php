<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	class ac_consumosTO {

		private $Consumo_id;
		private $Socio_id;
                private $Socio;
		private $Nro_medidor;
		private $Fecha_lectura;
		private $Fecha_emision;
		private $Periodo_mes;
		private $Periodo_anio;
		private $Consumo_total_lectura;
		private $Consumo_por_pagar;
		private $Costo_consumo_por_pagar;
		private $Estado;
		private $Fecha_hora_pago;
		private $Usuario_pago;
		private $Monto_pagado;
		private $Pagado_por;
		private $Ci_pagado_por;
		public static $FIELDS = array('Consumo_id','Socio_id','Nro_medidor','Fecha_lectura','Fecha_emision','Periodo_mes','Periodo_anio','Consumo_total_lectura','Consumo_por_pagar','Costo_consumo_por_pagar','Estado','Fecha_hora_pago','Usuario_pago','Monto_pagado','Pagado_por','Ci_pagado_por' );
		public static $PK_FIELD = 'consumo_id';

		function ac_consumosTO(){
		}

		public function setConsumo_id($Consumo_id){
			$this->Consumo_id = strtoupper(utf8_decode($Consumo_id));
		}

		public function getConsumo_id(){
			return strtoupper(utf8_encode($this->Consumo_id));
		}

		public function setSocio_id($Socio_id){
			$this->Socio_id = strtoupper(utf8_decode($Socio_id));
		}

		public function getSocio_id(){
			return strtoupper(utf8_encode($this->Socio_id));
		}

		public function setNro_medidor($Nro_medidor){
			$this->Nro_medidor = strtoupper(utf8_decode($Nro_medidor));
		}

		public function getNro_medidor(){
			return strtoupper(utf8_encode($this->Nro_medidor));
		}

		public function setFecha_lectura($Fecha_lectura){
			$this->Fecha_lectura = strtoupper(utf8_decode($Fecha_lectura));
		}

		public function getFecha_lectura(){
			return strtoupper(utf8_encode($this->Fecha_lectura));
		}

		public function setFecha_emision($Fecha_emision){
			$this->Fecha_emision = strtoupper(utf8_decode($Fecha_emision));
		}

		public function getFecha_emision(){
			return strtoupper(utf8_encode($this->Fecha_emision));
		}

		public function setPeriodo_mes($Periodo_mes){
			$this->Periodo_mes = strtoupper(utf8_decode($Periodo_mes));
		}

		public function getPeriodo_mes(){
			return strtoupper(utf8_encode($this->Periodo_mes));
		}

		public function setPeriodo_anio($Periodo_anio){
			$this->Periodo_anio = strtoupper(utf8_decode($Periodo_anio));
		}

		public function getPeriodo_anio(){
			return strtoupper(utf8_encode($this->Periodo_anio));
		}

		public function setConsumo_total_lectura($Consumo_total_lectura){
			$this->Consumo_total_lectura = strtoupper(utf8_decode($Consumo_total_lectura));
		}

		public function getConsumo_total_lectura(){
			return strtoupper(utf8_encode($this->Consumo_total_lectura));
		}

		public function setConsumo_por_pagar($Consumo_por_pagar){
			$this->Consumo_por_pagar = strtoupper(utf8_decode($Consumo_por_pagar));
		}

		public function getConsumo_por_pagar(){
			return strtoupper(utf8_encode($this->Consumo_por_pagar));
		}

		public function setCosto_consumo_por_pagar($Costo_consumo_por_pagar){
			$this->Costo_consumo_por_pagar = strtoupper(utf8_decode($Costo_consumo_por_pagar));
		}

		public function getCosto_consumo_por_pagar(){
			return strtoupper(utf8_encode($this->Costo_consumo_por_pagar));
		}

		public function setEstado($Estado){
			$this->Estado = strtoupper(utf8_decode($Estado));
		}

		public function getEstado(){
			return strtoupper(utf8_encode($this->Estado));
		}

		public function setFecha_hora_pago($Fecha_hora_pago){
			$this->Fecha_hora_pago = strtoupper(utf8_decode($Fecha_hora_pago));
		}

		public function getFecha_hora_pago(){
			return strtoupper(utf8_encode($this->Fecha_hora_pago));
		}

		public function setUsuario_pago($Usuario_pago){
			$this->Usuario_pago = strtoupper(utf8_decode($Usuario_pago));
		}

		public function getUsuario_pago(){
			return strtoupper(utf8_encode($this->Usuario_pago));
		}

		public function setMonto_pagado($Monto_pagado){
			$this->Monto_pagado = strtoupper(utf8_decode($Monto_pagado));
		}

		public function getMonto_pagado(){
			return strtoupper(utf8_encode($this->Monto_pagado));
		}

		public function setPagado_por($Pagado_por){
			$this->Pagado_por = strtoupper(utf8_decode($Pagado_por));
		}

		public function getPagado_por(){
			return strtoupper(utf8_encode($this->Pagado_por));
		}

		public function setCi_pagado_por($Ci_pagado_por){
			$this->Ci_pagado_por = strtoupper(utf8_decode($Ci_pagado_por));
		}

		public function getCi_pagado_por(){
			return strtoupper(utf8_encode($this->Ci_pagado_por));
		}
                
                public function setSocio($Socio){
			$this->Socio = strtoupper(utf8_decode($Socio));
		}

		public function getSocio(){
			return strtoupper(utf8_encode($this->Socio));
		}
	}
?>
